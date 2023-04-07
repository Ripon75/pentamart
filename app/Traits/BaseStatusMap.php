<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait BaseStatusMap
{
    protected $statusMap = [];
    protected bool $haveStatus = true;

    public function initStatusMap(string $modelSlug): void
    {
        $modelSlug = strtolower($modelSlug);
        $this->statusMap = config("status_map.{$modelSlug}");
    }

    /**
     * Return all status or a single status
     *
     * @param string|array|null $slug
     * @return mixed
     */
    public function getStatus(string|array|null $slug = null): mixed
    {
        if ($slug === null) {
            return $this->statusMap;
        }

        if(is_array($slug)) {
            $status = [];
            foreach ($slug as $s) {
                if (array_key_exists($s, $this->statusMap)) {
                    $status[] = $this->statusMap[$s];
                }
            }

            return $status;
        }

        $exist = array_key_exists($slug, $this->statusMap);
        return $exist ? $this->statusMap[$slug] : [];
    }

    /**
     * Is the status is exist
     *
     * @param string $slug
     * @return boolean
     */
    public function existStatus(string $slug): bool
    {
        return $this->getStatus($slug) ? true : false;
    }

    /**
     * Get the default status
     *
     * @return mixed
     */
    public function getDefaultStatus(): mixed
    {
        $defaults = Arr::where($this->statusMap, function ($value, $key) {
            return $value['default'];
        });

        return count($defaults) ? $defaults[0] : false;
    }

    /**
     * Get all next status from a given status
     *
     * @param string|integer $slug
     * @return array
     */
    public function getNextStatus(string|integer $slug): mixed
    {
        if (!is_numeric($slug)) {
            $status = $this->getStatus($slug);
        } else {
            foreach ($this->statusMap as $s) {
                if ($s['id'] == $slug) {
                    $status = $s;
                    break;
                }
            }
        }

        if (!$status) {
            return [];
        }

        $status = $status['to'];
        $status = $this->getStatus($status);

        return count($status) ? $status : [];
    }

    /**
     * Can a model object move from one status to another status
     *
     * @param string $fromSlug
     * @param string $toSlug
     * @return boolean
     */
    public function canMoveStatus(string $fromSlug, string $toSlug): bool
    {
        if ($fromSlug === $toSlug) {
            return false;
        }
        $fromStatus = $this->getStatus($fromSlug);
        $toStatus = $this->getStatus($toSlug);

        if (!$fromStatus || !$toStatus) {
            return false;
        }

        $fromStatusChilds = $fromStatus['to'];

        $exist = in_array($toSlug, $fromStatusChilds);

        return $exist ? true : false;
    }
}

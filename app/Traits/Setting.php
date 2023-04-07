<?php

namespace App\Traits;

use Auth;

trait Setting
{

    public function getValueAttribute($value)
    {
        $valueCastType = $this->attributes['value_cast_type'];

        if ($valueCastType === 'boolean') {
            return (boolean) $value;
        }
        else if ($valueCastType === 'integer') {
            return (int) $value;
        }
        else if ($valueCastType === 'float') {
            return (float) $value;
        }
        else {
            return (string) $value;
        }
    }

    static public function set($key, $value, $group = null, $castType = null, $description = null)
    {
        $group    = $group ?? 'general';
        $castType = $castType ?? 'string';
        $authId   = Auth::id();

        $settingObj = Self::where('key', $key)
            ->where('group', $group)->first();

        if ($settingObj) {
            $settingObj->value           = $value;
            $settingObj->value_cast_type = $castType;
            $settingObj->description     = $description;
            $settingObj->updated_by_id   = $authId;
            $settingObj->save();
        } else {
            $settingObj                  = new Self();
            $settingObj->key             = $key;
            $settingObj->value           = $value;
            $settingObj->value_cast_type = $castType;
            $settingObj->group           = $group;
            $settingObj->description     = $description;
            $settingObj->created_by_id   = $authId;
            $settingObj->save();
        }

        return $settingObj;
    }

    static public function get($key, $group = null)
    {
        $group = $group ?? 'general';

        if ($key) {
            $setting = Self::where('key', $key)->where('group', $group)->first();
            return $setting;
        }

        return false;
    }

    static public function getValue($key, $group = null, $default = null)
    {
        $setting = self::get($key, $group);

        if ($setting) {
            return $setting->value;
        }

        return $default;
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductThumbResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'      => $this->name,
            'mrp'     => $this->mrp,
            'brand' => [
                'id'      => $this->brand->id,
                'slug'    => $this->brand->slug,
                'name'    => $this->brand->name,
                'company' => [
                    'id'   => $this->brand->company->id,
                    'slug' => $this->brand->company->slug,
                    'name' => $this->brand->company->name
                ]
            ],
            'generic' => [
                'id'   => $this->generic->id,
                'slug' => $this->generic->slug,
                'name' => $this->generic->name
            ],
            'dosageForm' => [
                'id'   => $this->dosageForm->id,
                'slug' => $this->dosageForm->slug,
                'name' => $this->dosageForm->name
            ],
            'category' => [
                'id' => $this->id,
                'slug' => $this->slug,
                'name' => $this->name
            ]
        ];
    }
}

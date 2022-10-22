<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'title'           => $this->title,
            'decription'      => $this->description,
            'number_of_rooms' => $this->number_of_rooms,
            'country'         => $this->country->name,
            'address'         => $this->address,
        ];
    }
}

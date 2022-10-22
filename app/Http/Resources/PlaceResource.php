<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlaceResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($place, $key) {									
            return [
                    'title'           => $place->title,
                    'description'     => $place->description,
                    'number_of_rooms' => $place->number_of_rooms,
                    'address'         => $place->address,
                    'country'         => $place->country->name
                ];
            });
    }
}

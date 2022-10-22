<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Http\Traits\ApiResponserTrait;

class PlaceController extends Controller
{
    use ApiResponserTrait;
    
    public function show($placeId)
    {
        $place = Place::with('country')->find($placeId);
    
        if($place) {
            return $this->successResponse(new PlaceResource($place));
        } else {
            return $this->errorResponse('Place not found.');
        }
    }
}

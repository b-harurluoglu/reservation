<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponserTrait;
use App\Http\Requests\Reservation\AvailablePlacesRequest;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;

class ReservationController extends Controller
{
    use ApiResponserTrait;

    public function availablePlaces(AvailablePlacesRequest $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

        if(!$startDate->lessThanOrEqualTo($endDate)) {
            return $this->errorResponse('The end date cannot be greater than the start date.');
        } 

        $places = Place::with('country')->whereDoesntHave('reservations', function (Builder $query) use($startDate, $endDate) {
            
            $query->where( function($query) use ($startDate) {
                $query->where('start_date', '<=', $startDate);
                $query->where('end_date', '>=', $startDate);
            });

            $query->orWhere( function($query) use ($endDate) {
                $query->where('start_date', '<=', $endDate);
                $query->where('end_date', '>=', $endDate);
            });

            $query->orWhere( function($query) use ($startDate, $endDate) {
                $query->where('start_date', '>=', $startDate);
                $query->where('end_date', '<=', $endDate);
            });

            $query->orWhere( function($query) use ($startDate, $endDate){
                $query->where('start_date', '<=', $startDate);
                $query->where('end_date', '>=', $endDate);
            });

        })->get();

        if(count($places) >= 1) {
            return $this->successResponse(new PlaceResource($places));
        } else {
            return $this->errorResponse('No Records Found.');
        }
    }
}

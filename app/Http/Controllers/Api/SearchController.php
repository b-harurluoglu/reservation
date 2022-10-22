<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponserTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Reservation\AvailablePlacesRequest;
use App\Http\Resources\PlaceCollection;

class SearchController extends Controller
{
    use ApiResponserTrait;

    public function index(AvailablePlacesRequest $request)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

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

        return $this->successResponse(new PlaceCollection($places));

    }
}

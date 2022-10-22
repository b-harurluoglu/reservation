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
        $startDate = $request->validated('start_date');
        $endDate = $request->validated('end_date');

        $places = Place::with('country')
            ->whereDoesntHave('reservations', function (Builder $query) use($startDate, $endDate) {
                $query->available($startDate, $endDate);
            })->get();

        return $this->successResponse(new PlaceCollection($places));

    }
}





<?php

namespace Database\Factories;

use Carbon\Carbon;

use App\Models\Place;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $place = Place::all()->pluck('id')->random();

        $dates = $this->generateReservationDates($place);
        
        return [
            'place_id' => $place,
            'start_date' => $dates['startDate'],
            'end_date' => $dates['endDate']
        ];
    }

    public function generateReservationDates($place)
    {
        $startDate = new Carbon($this->faker->dateTimeBetween('-10 days', '+10 days')->format('Y-m-d'));
        $startDate = $startDate->format('Y-m-d');

        $endDate = Carbon::createFromFormat('Y-m-d', $startDate)->addDays(rand(1,5));
        $endDate = $endDate->format('Y-m-d');

        $reservation = Reservation::where('place_id', $place)   
            ->where( function($query) use ($startDate, $endDate){    
                $query->available($startDate, $endDate);
            })->exists();

        if($reservation) {
            return ($this->generateReservationDates($place));
        } else {
            return collect(['startDate' => $startDate, 'endDate' => $endDate]);
        }
    }

}

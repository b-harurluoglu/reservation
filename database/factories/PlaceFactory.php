<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
    protected $model = Place::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => 'Place '.$this->faker->name,
            'description' => $this->faker->text(),
            'number_of_rooms' => $this->faker->randomDigitNotNull(),
            'country_id' => Country::all()->pluck('id')->random(1)->first(),
            'address' => $this->faker->address(),
        ];
    }
}

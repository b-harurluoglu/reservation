<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('places')->truncate();

        Place::factory()->count(5)->create();
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('places')->truncate();

        $this->call([
            CountriesTableSeeder::class,
            PlacesTableSeeder::class,
        ])->command->info('Seeded the database! ');
    }
}
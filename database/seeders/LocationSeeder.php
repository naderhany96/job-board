<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            ['city' => 'New York', 'state' => 'NY', 'country' => 'USA'],
            ['city' => 'London', 'state' => null, 'country' => 'UK'],
            ['city' => 'Toronto', 'state' => 'ON', 'country' => 'Canada'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}

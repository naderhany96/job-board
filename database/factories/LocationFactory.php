<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        return [
            'city' => $this->faker->city,
            'state' => $this->faker->optional()->state,
            'country' => $this->faker->country,
        ];
    }
}

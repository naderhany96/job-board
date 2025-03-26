<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'company_name' => $this->faker->company,
            'salary_min' => $this->faker->randomFloat(2, 2000, 5000),
            'salary_max' => $this->faker->randomFloat(2, 6000, 15000),
            'is_remote' => $this->faker->boolean,
            'job_type' => $this->faker->randomElement(Job::TYPES),
            'status' => 'draft',
            'published_at' => $this->faker->dateTime,
        ];
    }
}

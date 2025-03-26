<?php

namespace Database\Factories;

use App\Models\JobAttributeValue;
use App\Models\Job;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobAttributeValueFactory extends Factory
{
    protected $model = JobAttributeValue::class;

    public function definition()
    {
        return [
            'job_id' => Job::factory(),
            'attribute_id' => Attribute::factory(),
            'value' => $this->faker->word,
        ];
    }
}

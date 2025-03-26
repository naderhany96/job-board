<?php

use App\Models\Job;
use App\Models\Attribute;
use App\Models\JobAttributeValue;
use Illuminate\Database\Seeder;

class JobAttributeValueSeeder extends Seeder
{
    public function run()
    {
        $job = Job::first();
        if (!$job) {
            $job = Job::factory()->create();
        }

        $attribute = Attribute::first();
        if (!$attribute) {
            $attribute = Attribute::factory()->create(['name' => 'Experience Level', 'type' => 'string']);
        }

        JobAttributeValue::create([
            'job_id' => $job->id,
            'attribute_id' => $attribute->id,
            'value' => 'Beginner',
        ]);
    }
}

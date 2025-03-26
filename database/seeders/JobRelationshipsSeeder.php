<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Location;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Job;

class JobRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run()
    {
        $jobs = Job::all();

       
        foreach ($jobs as $job) {
            // Attach languages
            $languages = Language::inRandomOrder()->take(2)->pluck('id');
            $job->languages()->attach($languages);

            $locations = Location::inRandomOrder()->take(1)->pluck('id');
            $job->locations()->attach($locations);

            $categories = Category::inRandomOrder()->take(2)->pluck('id');
            $job->categories()->attach($categories);

            $attributes = Attribute::all();
            foreach ($attributes as $attribute) {
                $value = $attribute->type === 'select'
                    ? json_decode($attribute->options)[rand(0, 2)]
                    : rand(1, 10);

                $job->attributes()->attach($attribute->id, [
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
    
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Language;
use App\Models\Location;
use App\Models\Category;

class JobSeeder extends Seeder
{
    public function run()
    {
        $jobs = [
            [
                'title' => 'Senior PHP Developer',
                'description' => 'Looking for an experienced PHP developer...',
                'company_name' => 'TechCorp',
                'salary_min' => 80000.00,
                'salary_max' => 100000.00,
                'is_remote' => true,
                'job_type' => Job::FULL_TIME,
                'status' => Job::PUBLISHED,
                'published_at' => now(),
            ],
            [
                'title' => 'Frontend Developer',
                'description' => 'Seeking a skilled frontend developer...',
                'company_name' => 'WebSolutions',
                'salary_min' => 60000.00,
                'salary_max' => 80000.00,
                'is_remote' => true,
                'job_type' => Job::PART_TIME,
                'status' => Job::DRAFT,
                'published_at' => null,
            ],
        ];

        foreach ($jobs as $job) {
            Job::create($job);
        }
    }
}

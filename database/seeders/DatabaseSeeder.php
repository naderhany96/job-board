<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use JobAttributeValueSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            JobSeeder::class,
            LanguageSeeder::class,
            LocationSeeder::class,
            CategorySeeder::class,
            AttributeSeeder::class,
            JobRelationshipsSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
            [
                'name' => 'Experience Level',
                'type' => Attribute::SELECT, // Use constant from Attribute::TYPES
                'options' => json_encode(['Junior', 'Mid', 'Senior']),
            ],
            [
                'name' => 'Years of Experience',
                'type' => Attribute::NUMBER, // Use constant from Attribute::TYPES
                'options' => null,
            ],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}

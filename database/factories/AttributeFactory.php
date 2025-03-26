<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    public function definition()
    {

        $type = $this->faker->randomElement(Attribute::TYPES);
        return [
            'name' => $this->faker->word,
            'type' => $type,
            'options' => $type === 'select' ? json_encode(['Option 1', 'Option 2', 'Option 3']) : null,
        ];
    }
}

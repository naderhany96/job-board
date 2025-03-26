<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = ['PHP', 'JS', 'Java', 'Python'];

        foreach ($languages as $language) {
            Language::create(['name' => $language]);
        }
    }
}

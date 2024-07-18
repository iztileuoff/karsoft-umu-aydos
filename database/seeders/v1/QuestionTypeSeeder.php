<?php

namespace Database\Seeders\v1;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuestionType::create(['name' => 'Простой']);
        QuestionType::create(['name' => 'Несколько выборов']);
        QuestionType::create(['name' => 'Последовательность']);
        QuestionType::create(['name' => 'Переносит и соеденить текст']);
        QuestionType::create(['name' => 'Ввод текста']);
    }
}

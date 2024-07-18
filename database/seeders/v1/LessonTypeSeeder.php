<?php

namespace Database\Seeders\v1;

use App\Models\LessonType;
use Illuminate\Database\Seeder;

class LessonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LessonType::create(['name' => 'Content']);
        LessonType::create(['name' => 'Test']);
    }
}

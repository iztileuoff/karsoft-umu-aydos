<?php

namespace Database\Seeders\v1;

use App\Enums\LessonType;
use App\Models\Content;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $module = Module::create([
            'title' => [
                'ltn' => "Beginner",
            ],
            'description' => [
                'ltn' => "Module haqqında maǵlıwmat",
            ],
        ]);

        $module->lessons()->create([
            'position' => 0,
            'title' => [
                'ltn' => 'Inglis álipbesi',
                'cyr' => 'Инглис әлипбеси'
            ],
            'lesson_type_id' => LessonType::CONTENT->value,
            'is_free' => true
        ]);

        $module->lessons()->create([
            'position' => 1,
            'title' => [
                'ltn' => 'Test №. 1',
                'cyr' => 'Тест №. 1'
            ],
            'lesson_type_id' => LessonType::TEST->value,
            'is_free' => true
        ]);

//        Module::factory(10)
//            ->has(Lesson::factory(5))
//            ->create();
    }
}

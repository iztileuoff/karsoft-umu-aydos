<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\v1\LessonTypeSeeder;
use Database\Seeders\v1\ModuleSeeder;
use Database\Seeders\v1\PaymentSeeder;
use Database\Seeders\v1\QuestionSeeder;
use Database\Seeders\v1\QuestionTypeSeeder;
use Database\Seeders\v1\QuizSeeder;
use Database\Seeders\v1\RoleSeeder;
use Database\Seeders\v1\TariffSeeder;
use Database\Seeders\v1\UserSeeder;
use Goodoneuz\PayUz\Database\Seeds\PayUzSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            LessonTypeSeeder::class,
            QuestionTypeSeeder::class,
            TariffSeeder::class,
            PaymentSeeder::class,
            ModuleSeeder::class,
            QuizSeeder::class,
            QuestionSeeder::class,
            PayUzSeeder::class,
        ]);
    }
}

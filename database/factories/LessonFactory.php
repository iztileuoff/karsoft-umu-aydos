<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'lesson_type_id' => $this->faker->numberBetween(1,2),
            'position' => $this->faker->numberBetween(0, 255),
            'title' => [
                'ltn' => $this->faker->word(),
                'cyr' => "Ащзфыоафыг йовшйщцов йцвойцв шзйцщзв лйцзщв лй"
            ],
            'is_free' => $this->faker->boolean,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

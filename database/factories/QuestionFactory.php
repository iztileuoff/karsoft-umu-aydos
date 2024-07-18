<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'question_type_id' => $this->faker->numberBetween(1,5),
            'answer_explanation' => [
                'ltn' => $this->faker->word(),
                'cyr' => "Ащзфыоафыг йовшйщцов йцвойцв шзйцщзв лйцзщв лй"
            ],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

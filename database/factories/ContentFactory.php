<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContentFactory extends Factory
{
    protected $model = Content::class;

    public function definition(): array
    {
        return [
            'title' => [
                'ltn' => $this->faker->word(),
                'cyr' => "Ащзфыоафыг йовшйщцов йцвойцв шзйцщзв лйцзщв лй"
            ],
            'body' => [
                'ltn' => "",
                'cyr' => ""
            ],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ModuleFactory extends Factory
{
    protected $model = Module::class;

    public function definition(): array
    {
        return [
            'title' => [
                'ltn' => $this->faker->word(),
                'cyr' => "Ащзфыоафыг йовшйщцов йцвойцв шзйцщзв лйцзщв лй"
            ],
            'description' => [
                'ltn' => $this->faker->text(),
                'cyr' => "Пщфоы щшфы овщш фоыв зщфыл взщф воцйзщ ойцщзв лйцщз лцйвтшщйц вл йщзцлазхцу"
            ],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

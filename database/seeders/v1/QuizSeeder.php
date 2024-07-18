<?php

namespace Database\Seeders\v1;

use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quiz::create([
            'title' => [
                'ltn' => "Dáslapki test",
                'cyr' => "Дәслапки тест",
            ],
            'description' => [
                'ltn' => 'Keliń, kishigirim test arqalı, dáslep, sizdiń inglis tilin biliw dárejeńizdi anıqlap alayıq',
                'cyr' => 'Келиң, кишигирим тест арқалы, дәслеп, сиздиң инглис тилин билиў дәрежеңизди анықлап алайық'
            ]
        ]);
    }
}

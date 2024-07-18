<?php

namespace Database\Seeders\v1;

use App\Enums\QuestionType;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lesson = Lesson::latest('id')->first();

        // 1 - simple question
        $question = $lesson->questions()->create([
            'title' => [
                'ltn' => '1 - simple question.',
                'cyr' => '1 - simple question.',
            ],
            'question_type_id' => QuestionType::Simple,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'position' => $i,
                'is_correct' => $i == 0
            ]);
        }

        // 2 - multiple chooice question
        $question = $lesson->questions()->create([
            'title' => [
                'ltn' => '2 - multiple chooice question.',
                'cyr' => '2 - multiple chooice question.',
            ],
            'question_type_id' => QuestionType::Multiple_choice,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'position' => $i,
                'is_correct' => $i < 2
            ]);
        }

        // 3 - sequence question
        $question = $lesson->questions()->create([
            'title' => [
                'ltn' => '3 - sequence question.',
                'cyr' => '3 - sequence question.',
            ],
            'question_type_id' => QuestionType::Sequence,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'position' => $i,
            ]);
        }

        // 4 - drag and drop question
        $question = $lesson->questions()->create([
            'title' => [
                'ltn' => '4 - drag and drop question.',
                'cyr' => '4 - drag and drop question.',
            ],
            'question_type_id' => QuestionType::Drag_and_drop,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'drag_text' => 'They',
                'position' => $i,
            ]);
        }

        // 5 - input question
        $question = $lesson->questions()->create([
            'title' => [
                'ltn' => '5 - input question.',
                'cyr' => '5 - input question.',
            ],
            'question_type_id' => QuestionType::Input,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        $question->options()->create([
            'title' => '1-answer',
            'position' => 0,
            'is_correct' => true
        ]);

        $quiz = Quiz::latest('id')->first();

        $question = $quiz->questions()->create([
            'title' => [
                'ltn' => '1 - simple question.',
                'cyr' => '1 - simple question.',
            ],
            'question_type_id' => QuestionType::Simple,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'position' => $i,
                'is_correct' => $i == 0
            ]);
        }

        // 2 - multiple chooice question
        $question = $quiz->questions()->create([
            'title' => [
                'ltn' => '2 - multiple chooice question.',
                'cyr' => '2 - multiple chooice question.',
            ],
            'question_type_id' => QuestionType::Multiple_choice,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'position' => $i,
                'is_correct' => $i < 2
            ]);
        }

        // 3 - sequence question
        $question = $quiz->questions()->create([
            'title' => [
                'ltn' => '3 - sequence question.',
                'cyr' => '3 - sequence question.',
            ],
            'question_type_id' => QuestionType::Sequence,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'position' => $i,
            ]);
        }

        // 4 - drag and drop question
        $question = $quiz->questions()->create([
            'title' => [
                'ltn' => '4 - drag and drop question.',
                'cyr' => '4 - drag and drop question.',
            ],
            'question_type_id' => QuestionType::Drag_and_drop,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        for ($i = 0; $i < 4; $i++) {
            $question->options()->create([
                'title' => ($i+1) . '-answer',
                'drag_text' => 'They',
                'position' => $i,
            ]);
        }

        // 5 - input question
        $question = $quiz->questions()->create([
            'title' => [
                'ltn' => '5 - input question.',
                'cyr' => '5 - input question.',
            ],
            'question_type_id' => QuestionType::Input,
            'answer_explanation' => [
                'ltn' => 'Inglis tilinde seyil mánisinde stroll sózi qollanıladı.',
                'cyr' => 'Инглис тилинде сейил мәнисинде стролл сөзи қолланылады.',
            ],
        ]);

        $question->options()->create([
            'title' => '1-answer',
            'position' => 0,
            'is_correct' => true
        ]);
    }
}

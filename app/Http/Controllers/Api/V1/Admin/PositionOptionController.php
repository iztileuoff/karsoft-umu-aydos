<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdatePositionOptionRequest;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PositionOptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePositionOptionRequest $request, Question $question)
    {
        if(count($request->options) != $question->options()->count()) {
            throw ValidationException::withMessages([
                'options_count' => 'Please, send all option ids.'
            ]);
        }

        $options_count = 0;

        foreach ($request->options as $option_id) {
            Option::where('question_id', $question->id)
                ->where('id', $option_id)
                ->update(['position' => $options_count]);
            $options_count++;
        }

        return response()->ok();
    }
}

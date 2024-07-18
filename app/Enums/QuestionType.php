<?php

namespace App\Enums;

enum QuestionType: int
{
    case Simple = 1;
    case Multiple_choice = 2;
    case Sequence = 3;
    case Drag_and_drop = 4;
    case Input = 5;
}

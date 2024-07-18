<?php

namespace App\Enums;

enum Level: string
{
    case BEGINNER = "Beginner";
    case ELEMENTARY = "Elementary";
    case PRE_INTERMEDIATE = "Per-intermediate";
    case INTERMEDIATE = "Intermediate";
    case UPPER_INTERMEDIATE = "Upper-intermediate";
    case ADVANCED = "Advanced";
}

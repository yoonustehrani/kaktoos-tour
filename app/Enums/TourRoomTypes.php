<?php

namespace App\Enums;

use App\Attributes\TitleFa;
use App\Traits\EnumHelpers;

enum TourRoomTypes: int
{
    use EnumHelpers;

    #[TitleFa('یک تخته')]
    case Single = 1;

    #[TitleFa('دو تخته')]
    case Double = 2;

    #[TitleFa('کودک با تخت')]
    case ChildWithBed    = 3;

    #[TitleFa('کودک بدون تخت')]
    case ChildWithoutBed = 4;

    #[TitleFa('نوزاد')]
    case Infant = 5;

    #[TitleFa('پنت هاوس')]
    case Penthouse = 6;

    #[TitleFa('پرزیدنت')]
    case President = 7;

    #[TitleFa('سه تخته')]
    case Triple = 8;

    #[TitleFa('چهارتخته')]
    case Quadruple  = 9;
}

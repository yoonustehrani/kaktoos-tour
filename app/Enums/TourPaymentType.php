<?php

namespace App\Enums;

use App\Attributes\TitleFa;
use App\Traits\EnumHelpers;

enum TourPaymentType: string
{
    use EnumHelpers;

    #[TitleFa('عادی')]
    case FULL = 'F';

    #[TitleFa('اقساطی')]
    case INSTALLMeNT = 'I';
}

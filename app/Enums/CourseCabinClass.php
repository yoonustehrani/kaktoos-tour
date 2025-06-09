<?php

namespace App\Enums;

use App\Attributes\TitleFa;
use App\Traits\EnumHelpers;

enum CourseCabinClass: int
{
    use EnumHelpers;

    #[TitleFa('اکونومی')]
    case ECONOMY = 1;

    #[TitleFa('پریمیوم اکونومی')]
    case P_ECONOMY = 2;

    #[TitleFa('بیزنس')]
    case BUSINESS = 3;

    #[TitleFa('پریمیوم بیزنس')]
    case P_BUSINESS = 4;

    #[TitleFa('فرست کلاس')]
    case FIRST = 5;

    #[TitleFa('پریمیوم فرست')]
    case P_FIRST = 6;

    // #[TitleFa('عادی')]
    // case TRAIN_NORMAL = 20;

    // #[TitleFa('۴ ستاره')]
    // case TRAIN_4_STARS = 21;

    // #[TitleFa('۵ ستاره')]
    // case TRAIN_5_STARS = 22;

    // #[TitleFa('عادی')]
    // case BUS_NORMAL = 30;

    // #[TitleFa('VIP')]
    // case BUS_VIP = 31;

    // #[TitleFa('شاتل')]
    // case BUS_SHUTTLE = 32;
}

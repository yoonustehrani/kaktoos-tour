<?php

namespace App\Enums;

use App\Attributes\TitleFa;
use App\Traits\EnumHelpers;

enum TransportationType: string
{
    use EnumHelpers;

    #[TitleFa('هوایی')]
    case AIRPLANE = 'A';

    #[TitleFa('دریایی')]
    case SHIP = 'S';

    #[TitleFa('اتوبوس')]
    case BUS = 'B';

    #[TitleFa('قطار')]
    case TRAIN = 'T';
}

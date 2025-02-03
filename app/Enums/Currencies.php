<?php

namespace App\Enums;

use App\Attributes\TitleFa;
use App\Traits\EnumHelpers;

enum Currencies
{
    use EnumHelpers;

    #[TitleFa('تومان')]
    case IRT;
    #[TitleFa('ریال')]
    case IRR;
    #[TitleFa('دلار')]
    case USD;
    #[TitleFa('یورو')]
    case EUR;
}

<?php

namespace App\Enums;

enum TourSearchOrder: string
{
    case BY_START_DATE = 'start_date';
    case BY_PRICE = 'price';
    case BY_HOTEL_STARS = 'hotel_stars';
    case BY_HOTEL_RATES = 'hotel_rates';
}

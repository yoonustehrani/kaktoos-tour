<?php

namespace App\Enums;

enum TourRoomType: int
{
    case Single = 1;
    case Double = 2;
    case ChildWithBed    = 3;
    case ChildWithoutBed = 4;
    case Infant = 5;
    case Penthouse = 6;
    case President = 7;
    case Triple = 8;
    case Quadruple  = 9;
}

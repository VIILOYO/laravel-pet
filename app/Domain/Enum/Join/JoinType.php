<?php

namespace App\Domain\Enum\Join;

enum JoinType: string
{
    case JOIN = 'join';
    case LEFT_JOIN = 'left_join';
    case RIGHT_JOIN = 'right_join';
}

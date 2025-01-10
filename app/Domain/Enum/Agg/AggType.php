<?php

namespace App\Domain\Enum\Agg;

enum AggType: string
{
    case SUM = 'sum';
    case MIN = 'min';
    case MAX = 'max';
    case COUNT = 'count';
    case AVG = 'avg';
}

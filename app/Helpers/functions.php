<?php

use App\Domain\Dto\Agg\AggData;
use App\Domain\Enum\Agg\AggType;

if (! function_exists('groupBy')) {
    /**
     * @param  array{string, mixed}  $data
     * @param  AggData  ...$args
     */
    function groupBy(array $data, ...$args): array
    {
        $calculate = [];

        foreach ($data as $row) {
            $tempCalculate = &$calculate;

            foreach ($args as $arg) {
                if ($arg->isAgg()) {
                    break;
                }

                $rowValue = $row[$arg->name];
                if (! isset($tempCalculate[$rowValue])) {
                    $tempCalculate[$rowValue] = [];
                }
                $tempCalculate = &$tempCalculate[$rowValue];
            }
            $tempCalculate[] = $row;
        }

        $result = [];

        foreach ($calculate as $item) {
            calculate_item($item, $result, ...$args);
        }

        return $result;
    }
}

if (! function_exists('calculate_item')) {
    /**
     * @param  array{string, mixed}  $item
     * @param  AggData  ...$args
     */
    function calculate_item(array $item, array &$result, ...$args): void
    {
        if (! array_is_list($item)) {
            foreach ($item as $i) {
                calculate_item($i, $result, ...$args);
            }
        } else {
            foreach ($item as $i) {
                $calculateRow = [];

                foreach ($args as $arg) {
                    if (! $arg->isAgg()) {
                        $calculateRow[$arg->as ?? $arg->name] = $i[$arg->name];
                    } else {
                        $calculateRow[$arg->as ?? $arg->name] = agg_function($item, $arg);
                    }
                }
                if (! in_array($calculateRow, $result)) {
                    $result[] = $calculateRow;
                }
            }
        }
    }
}

if (! function_exists('agg_function')) {
    /**
     * @param  array{string, mixed}  $data
     */
    function agg_function(array $data, AggData $arg): int|float
    {
        return match ($arg->agg) {
            AggType::SUM->value => array_sum(array_map(function (array $item) use ($arg) {
                return $item[$arg->name];
            }, $data)),
            AggType::AVG->value => array_sum(array_map(function (array $item) use ($arg) {
                return $item[$arg->name];
            }, $data)) / count($data),
            AggType::COUNT->value => count($data),
            AggType::MAX->value => max(array_map(function (array $item) use ($arg) {
                return $item[$arg->name];
            }, $data)),
            AggType::MIN->value => min(array_map(function (array $item) use ($arg) {
                return $item[$arg->name];
            }, $data)),
        };
    }
}

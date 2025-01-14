<?php

use App\Domain\Dto\Agg\AggData;
use App\Domain\Enum\Agg\AggType;
use App\Domain\Enum\Join\JoinType;

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

if (! function_exists('custom_join')) {
    function custom_join(array $mainItems, array $joinItems, string $joinType, array $conditions): array
    {
        $resultArray = [];
        $addedJoinItemIndex = [];
        $addedMainItemIndex = [];

        foreach ($mainItems as $key => $item) {
            foreach ($joinItems as $joinKey => $joinItem) {
                if (custom_join_conditions($item, $joinItem, $conditions)) {
                    $resultArray[] = array_merge($item, rename_exist_key_in_arrays($item, $joinItem));
                    $addedJoinItemIndex[] = $joinKey;
                    $addedMainItemIndex[] = $key;
                }
            }
        }

        if ($joinType === JoinType::LEFT_JOIN->value) {
            foreach ($addedMainItemIndex as $mainIndex) {
                unset($mainItems[$mainIndex]);
            }

            foreach ($mainItems as $mainItem) {
                $resultArray[] = $mainItem;
            }
        }

        if ($joinType === JoinType::RIGHT_JOIN->value) {
            foreach ($addedJoinItemIndex as $joinIndex) {
                unset($joinItems[$joinIndex]);
            }

            foreach ($joinItems as $joinItem) {
                $resultArray[] = $joinItem;
            }
        }


        return $resultArray;
    }
}

if (! function_exists('custom_join_conditions')) {
    function custom_join_conditions(array $mainItem, array $joinItem, array $conditions): bool
    {
        $mainItemValue = $mainItem[$conditions[0]];
        $joinItemValue = $joinItem[$conditions[2] ?? $conditions[1]];
        $condition = isset($conditions[2]) ? $conditions[1] : '===';

        if ($condition === '=') {
            $condition = '===';
        } elseif ($condition === '<>') {
            $condition = '!=';
        }

        return eval("return $mainItemValue $condition $joinItemValue;");
    }
}

if (! function_exists('rename_exist_key_in_arrays')) {
    function rename_exist_key_in_arrays(array $mainItem, array $joinItem): array
    {
        $newJoinItem = [];
        foreach ($joinItem as $key => $value) {
            if (key_exists($key, $mainItem)) {
                $newJoinItem['join_'.$key] = $value;
            } else {
                $newJoinItem[$key] = $value;
            }
        }

        return $newJoinItem;
    }
}

if (! function_exists('rename_exist_key_in_arrays')) {
    function rename_exist_key_in_arrays(array $mainItem, array $joinItem): array
    {
        $newJoinItem = [];
        foreach ($joinItem as $key => $value) {
            if (key_exists($key, $mainItem)) {
                $newJoinItem['join_'.$key] = $value;
            } else {
                $newJoinItem[$key] = $value;
            }
        }

        return $newJoinItem;
    }
}

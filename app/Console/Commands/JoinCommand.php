<?php

namespace App\Console\Commands;

use App\Domain\Enum\Join\JoinType;
use Illuminate\Console\Command;

class JoinCommand extends Command
{
    protected $signature = 'join';

    protected $description = 'Присоединение массива';

    public function handle(): void
    {
        $array1 = [
            [
                'id' => 1,
                'job_id' => 2,
            ],
            [
                'id' => 2,
                'job_id' => 2
            ],
            [
                'id' => 3,
                'job_id' => 3
            ],
            [
                'id' => 4,
                'job_id' => 1,
            ],
            [
                'id' => 4,
                'job_id' => 5,
            ]
        ];

        $jobs = [
            [
                'id' => 1,
                'name' => 'Первая',
            ],
            [
                'id' => 4,
                'name' => 'Четвертая',
            ],
            [
                'id' => 2,
                'name' => 'Вторая',
            ],
            [
                'id' => 3,
                'name' => 'Третья',
            ],
        ];

        dd(custom_join($array1, $jobs, JoinType::RIGHT_JOIN->value, ['job_id', '=', 'id']));
    }
}

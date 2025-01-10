<?php

namespace App\Console\Commands;

use App\Domain\Dto\Agg\AggData;
use Illuminate\Console\Command;

class GroupByCommand extends Command
{
    protected $signature = '
        groupBy
        {--count=20}
        {--countries="Russia,Japan,Kazakhstan,France"}
        {--names="Alexey,Evgeniy,Dmitriy,Alexandr"}
        {--ages="24,21,30,28"}
        {--salaries="100_000,80_000,300_000,250_000"}
    ';

    protected $description = 'Группировка массива';

    protected $help = '
    Параметр "--count" отвечает за количество сгенерированных данных. По умолчанию 15
    Параметр "--countries" отвечает за варианты стран. Указывать через запятую без пробела
    Параметр "--names" отвечает за варианты имен. Указывать через запятую без пробела
    Параметр "--ages" отвечает за варианты возрастов. Указывать через запятую без пробела
    Параметр "--salaries" отвечает за варианты зарплат. Указывать через запятую без пробела
    ';

    public function handle(): void
    {
        dd(
            groupBy(
                $this->makeData(),
                AggData::from(['name' => 'country', 'as' => 'Страна']),
                AggData::from(['name' => 'name', 'as' => 'Имя']),
                AggData::from(['name' => 'id', 'as' => 'Количество', 'agg' => 'count']),
            )
        );
    }

    /**
     * @phpstan-ignore-next-line
     */
    private function makeData(): array
    {
        $countries = explode(',', $this->option('countries'));
        $names = explode(',', $this->option('names'));
        $ages = explode(',', $this->option('ages'));
        $salaries = explode(',', $this->option('salaries'));

        $data = [];
        for ($i = 0; $i < $this->option('count'); $i++) {
            $data[$i]['id'] = $i;
            $data[$i]['country'] = $countries[array_rand($countries)];
            $data[$i]['name'] = $names[array_rand($names)];
            $data[$i]['age'] = (int) $ages[array_rand($ages)];
            $data[$i]['salary'] = (int) $salaries[array_rand($salaries)];
        }

        return $data;
    }
}

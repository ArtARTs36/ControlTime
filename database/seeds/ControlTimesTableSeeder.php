<?php

require_once ('database/seeds/Data/ControlTimesTableSeederData.php');

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ControlTimesTableSeeder extends Seeder
{
    public function run(): void
    {
        dump('...Наполнение данных о посещаемости займет некоторое время ;)');

        $times = ControlTimesTableSeederData::buildArray();
        shuffle($times);

        if (env('DB_CONNECTION') === 'sqlite') {
            $this->insertWithChunk($times);
        } else {
            DB::table('control_times')->insert($times);
        }
    }

    protected function insertWithChunk(array $times): void
    {
        $arrays = array_chunk($times, 300);
        foreach ($arrays as $array) {
            DB::table('control_times')->insert($array);
        }
    }
}


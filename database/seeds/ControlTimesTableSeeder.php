<?php

require_once ('database/seeds/Data/ControlTimesTableSeederData.php');

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ControlTimesTableSeeder extends Seeder
{
    public function run()
    {
        dump('...Наполнение данных о посещаемости займет некоторое время ;)');

        $times = ControlTimesTableSeederData::buildArray();
        shuffle($times);

        DB::table('control_times')->insert($times);
    }
}


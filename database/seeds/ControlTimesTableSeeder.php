<?php

require_once ('database/seeds/Data/ControlTimesTableSeederData.php');

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ControlTimesTableSeeder extends Seeder
{
    public function run()
    {
        $times = ControlTimesTableSeederData::buildArray();

        DB::table('control_times')->insert(ControlTimesTableSeederData::buildArray());
    }
}


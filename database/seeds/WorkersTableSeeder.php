<?php

require_once ('database/seeds/Data/WorkersTableSeederData.php');

use Illuminate\Database\Seeder;
use App\Models\Worker;

class WorkersTableSeeder extends Seeder
{
    private const COUNT_WORKERS = 100;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkersTableSeederData::$countWorkers = self::COUNT_WORKERS;

        factory(Worker::class, self::COUNT_WORKERS)->create();
    }
}

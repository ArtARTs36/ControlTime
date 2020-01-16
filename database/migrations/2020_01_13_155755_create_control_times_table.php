<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlTimesTable extends Migration
{
    private const TABLE = 'control_times';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            // 0000-00-00
            $table->date('start_date');
            $table->date('end_date');

            // 00:00:00
            $table->time('start_time');
            $table->time('end_time');

            $table->unsignedInteger('worker_id');
        });

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_times');
    }
}

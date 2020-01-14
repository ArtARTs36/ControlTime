<?php

use App\Models\Worker;
use Faker\Generator as Faker;

$data = WorkersTableSeederData::buildArray();

$counter = 0;

$factory->define(Worker::class, function (Faker $faker) use ($data, &$counter) {
    $worker = [
        'name' => $data[$counter]['name'],
        'patronymic' => $data[$counter]['patronymic'],
        'family' => $data[$counter]['family'],
        'phone' => $data[$counter]['phone'],
        'hired_date' => $faker->dateTimeInInterval('-6 months', '6 months')
    ];

    $counter++;

    return $worker;
});

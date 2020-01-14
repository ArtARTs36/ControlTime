<?php

use App\Models\Worker;

$data = WorkersTableSeederData::buildArray();

$counter = 0;

$factory->define(Worker::class, function () use ($data, &$counter) {
    $worker = [
        'name' => $data[$counter]['name'],
        'patronymic' => $data[$counter]['patronymic'],
        'family' => $data[$counter]['family'],
        'phone' => $data[$counter]['phone']
    ];

    $counter++;

    return $worker;
});

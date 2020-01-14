<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Worker
 *
 * @property integer $id - Идентификатор
 * @property string $name - Имя
 * @property string $patronymic - Отчество
 * @property string $family - Фамилия
 *
 * @package App
 */
class Worker extends Model
{
    protected $table = 'workers';

    /**
     * Получить все записи о приходах и уходах
     */
    public function controlTimes()
    {
        return $this->hasMany(ControlTime::class);
    }
}

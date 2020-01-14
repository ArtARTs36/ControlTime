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
 * @property string $phone - Номер телефона
 * @property \DateTime $hired_date - Дата принятия на работу
 *
 * @package App
 */
class Worker extends Model
{
    const TABLE = 'workers';

    const REQUIRED_FIELDS = [
        'name', 'patronymic', 'family', 'phone'
    ];

    protected $table = self::TABLE;

    public $fillable = self::REQUIRED_FIELDS;

    /**
     * Получить все записи о приходах и уходах
     */
    public function controlTimes()
    {
        return $this->hasMany(ControlTime::class);
    }
}

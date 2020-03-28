<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

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
 * @mixin Builder
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

    public function getFullName(): string
    {
        return implode(' ', [
            $this->family,
            $this->name,
            $this->patronymic,
        ]);
    }

    public function getSign(): string
    {
        return $this->family . ' ' .
            mb_substr($this->name, 0, 1) . ' '.
            mb_substr($this->patronymic, 0, 1);
    }
}

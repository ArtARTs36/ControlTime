<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class ControlTime
 *
 * @property integer $id - Идентификатор
 *
 * @property \DateTime $start_date - Дата прихода
 * @property \DateTime $start_time - Время прихода
 *
 * @property \DateTime $end_date - Дата ухода
 * @property \DateTime $end_time - Время ухода
 *
 * @property integer $worker_id - Идентификатор работника
 *
 * @package App
 * @mixin Builder
 */
class ControlTime extends Model
{
    const TABLE = 'control_times';

    const REQUIRED_FIELDS = [
        'id',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'worker_id'
    ];

    protected $fillable = self::REQUIRED_FIELDS;

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function setWorker(Worker $worker)
    {
        $this->worker_id = $worker->id;
    }
}

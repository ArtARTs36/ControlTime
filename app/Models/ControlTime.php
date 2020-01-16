<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ControlTime
 *
 * @property integer $id - Идентификатор
 * @property \DateTime $date - Дата прихода
 * @property \DateTime $start_time - Время прихода
 * @property \DateTime $end_time - Время ухода
 * @property integer $worker_id - Идентификатор работника
 *
 * @package App
 */
class ControlTime extends Model
{
    const TABLE = 'control_times';

    const REQUIRED_FIELDS = [
        'id',
        'date',
        'start_time',
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

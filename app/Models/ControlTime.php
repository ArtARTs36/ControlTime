<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ControlTime
 *
 * @property integer $id - Идентификатор
 * @property \DateTime $start_date - Дата прихода
 * @property \DateTime $end_date - Дата ухода
 * @property integer $worker_id - Идентификатор работника
 *
 * @package App
 */
class ControlTime extends Model
{
    protected $fillable = [
        'id',
        'start_date',
        'end_date',
        'worker_id'
    ];

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

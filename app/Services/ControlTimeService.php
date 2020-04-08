<?php

namespace App\Services;

use App\Models\ControlTime;
use App\Models\Worker;
use Illuminate\Support\Collection;

class ControlTimeService
{
    /**
     * Поиск существующей записи за конкретную дату
     *
     * @param \DateTime $startDate
     * @param int $workerId
     * @return mixed
     */
    public static function findExistsTime(\DateTime $startDate, int $workerId)
    {
        return ControlTime::where('start_date', $startDate)
            ->where('worker_id', $workerId)
            ->first();
    }

    /**
     * Проверка дат на НЕкорректность
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return string|null
     */
    public static function isNotCorrectDates(
        \DateTime $startDate,
        \DateTime $endDate,
        \DateTime $startTime,
        \DateTime $endTime
    ): ?string
    {
        $startMonth = $startDate->format('m');
        $startDay = $startDate->format('d');

        $endMonth = $endDate->format('m');
        $endDay = $endDate->format('d');

        // Надеюсь 31 декабря люди не работают ;)
        if ($startDate->format('Y') < $endDate->format('Y')) {
            return __('control_time.save.failed.years');
        }

        if ($startMonth == $endMonth && $endDay < $startDay) {
            return __('control_time.save.failed.days');
        }

        if (
            $startMonth == $endMonth &&
            $startDay == $endDay &&
            $endTime->format('H') < $startTime->format('H')
        ) {
            return __('control_time.save.failed.times');
        }

        return null;
    }

    public static function findByWorker(Worker $worker): Collection
    {
        return ControlTime::where('worker_id', $worker->id)
            ->get();
    }

    /**
     * @param ControlTime[]|Collection $times
     * @return int
     */
    public static function bringLatenessCount(Collection $times): int
    {
        $count = 0;
        foreach ($times as $time) {
            if ($time->isLate()) {
                $count++;
            }
        }

        return $count;
    }

    public static function findAndBringLatenessCount(Worker $worker)
    {
        return self::bringLatenessCount(self::findByWorker($worker));
    }

    /**
     * Подсчитать средние часы пребывания на рабочем месте
     *
     * @param Collection $times
     * @return int
     */
    public static function bringMediumHour(Collection $times): int
    {
        $hoursSum = self::bringAttendHours($times);
        if ($hoursSum === 0) {
            return 0;
        }

        return (int) $hoursSum / $times->count();
    }

    /**
     * Посчитать средний час появления на рабочем месте
     *
     * @param Collection|ControlTime[] $times
     * @return int
     */
    public static function bringMediumStartHour(Collection $times): int
    {
        $hourSum = 0;

        foreach ($times as $time) {
            $hourSum += $time->getStart()->format('h');
        }

        if ($hourSum === 0) {
            return 0;
        }

        return $hourSum / $times->count();
    }

    /**
     * Посчитать средний час ухода с рабочего места
     *
     * @param Collection|ControlTime[] $times
     * @return int
     */
    public static function bringMediumEndHour(Collection $times): int
    {
        $hourSum = 0;

        foreach ($times as $time) {
            $hourSum += $time->getEnd()->format('h');
        }

        if ($hourSum === 0) {
            return 0;
        }

        return $hourSum / $times->count();
    }

    /**
     * Подсчет часов пребывания на рабочем месте
     *
     * @param Collection|ControlTime[] $times
     * @return int|mixed
     */
    public static function bringAttendHours(Collection $times): int
    {
        $hoursSum = 0;

        foreach ($times as $time) {
            $hoursSum += $time->getAttendHours();
        }

        return (int) $hoursSum;
    }
}

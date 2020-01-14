<?php

class ControlTimesTableSeederData
{
    private static $workers;

    /** @var \DateTime */
    private static $currentDate = null;

    private static $count = null;

    public static function buildArray()
    {
        self::$workers = \App\Models\Worker::all();

        $times = [];

        foreach (self::$workers as $worker) {
            $hiredDate = new \DateTime($worker->hired_date);

            // Количество дней, прошедших со времени принятия на работу
            $days = self::getDiffDays($hiredDate);

            for ($i = 1; $i < $days; $i++) {
                $startDate = $hiredDate->modify("+ {$i} days");
                $startDate = self::setTimeComing($startDate);
                $endDate = self::genDateCare($startDate);

                $times[] = [
                  'worker_id' => $worker->id,
                  'start_date' => $startDate->format('Y-m-d H:i:s'),
                  'end_date' => $endDate->format('Y-m-d H:i:s')
                ];
            }
        }

        return $times;
    }

    private static function getDiffDays($hiredDate)
    {
        if (self::$currentDate === null) {
            self::$currentDate = new \DateTime();
        }

        $interval = self::$currentDate->diff($hiredDate);

        return abs($interval->format('%R%a'));
    }

    /**
     * Устанавливаем время прихода на рабочее место
     *
     * @param DateTime $date
     * @return DateTime|false
     */
    private static function setTimeComing(\DateTime $date)
    {
        return $date->setTime(rand(8, 13), rand(0, 60));
    }

    /**
     * Генерируем время ухода с рабочего места
     *
     * @param DateTime $date
     * @return DateTime
     */
    private static function genDateCare(\DateTime $date)
    {
        // Час прихода на рабочее место
        $hourComing = (int) $date->format('H');

        // Сколько часов осталось в дне
        $leftHoursInDay = 24 - $hourComing - 1;

        // Час ухода
        $hourCare = rand(1, $leftHoursInDay);

        $newDate = clone $date;

        return $newDate->modify("+ {$hourCare} hours");
    }
}


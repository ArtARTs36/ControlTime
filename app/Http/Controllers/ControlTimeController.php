<?php

namespace App\Http\Controllers;

use App\Helpers\FrontendResponse;
use App\Helpers\RequestHelper;
use App\Models\ControlTime;
use Illuminate\Http\Request;

class ControlTimeController extends Controller
{
    private const COUNT_WORKERS_IN_ONE_PAGE = 10;

    /**
     * Получить список
     *
     * @param null $page
     * @param string $sortKey
     * @param string $sortDirection
     * @param int $count
     * @param int $workerId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function viewListAction(
        $page = null,
        $sortKey = 'id',
        $sortDirection = 'desc',
        $count = self::COUNT_WORKERS_IN_ONE_PAGE,
        $workerId = null
    )
    {
        $times = ControlTime::with('worker');

        // todo заплатка, при джоине теряю айдишник контролТайм - как поступить элегатнее - пока хз
        $times->selectRaw('*, control_times.id as time_id');

        if ($workerId !== null) {
            $times->where('worker_id', '=', (int) $workerId);
        }

        if ($sortKey == 'date') {
            $times->orderBy('start_date', $sortDirection);
        } elseif ($sortKey == 'worker') {
            $times->join('workers as w', 'control_times.worker_id', '=', 'w.id')
                ->orderBy('w.family', $sortDirection)->orderBy('w.name', $sortDirection);
        }
        else {
            $times->orderBy($sortKey, $sortDirection);
        }

        return $times->paginate($count, ['*'], 'page_times', $page);
    }

    /**
     * Создать запись
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $data = RequestHelper::getEntryData($request, [
            'start_date', 'end_date', 'start_time', 'end_time', 'worker_id'
        ]);

        $workerId = (int) $data['worker_id'];

        $startDate = new \DateTime($data['start_date']);
        $startMonth = $startDate->format('m');
        $startDay = $startDate->format('d');

        $endDate = new \DateTime($data['end_date']);
        $endMonth = $endDate->format('m');
        $endDay = $endDate->format('d');

        $startTime = new \DateTime($data['start_time']);
        $endTime = new \DateTime($data['end_time']);

        // Надеюсь 31 декабря люди не работают ;)
        if ($startDate->format('Y') < $endDate->format('Y')) {
            return new FrontendResponse(false, null, 'Ошибка: не совпадают года!');
        }

        if (
            $startMonth == $endMonth &&
            $endDay < $startDay
        ) {
            return new FrontendResponse(false, null, 'Ошибка: День ухода раньше дня прихода!');
        }

        if (
            $startMonth == $endMonth &&
            $startDay == $endDay &&
            $endTime->format('H') < $startTime->format('H')
        ) {
            return new FrontendResponse(false, null, 'Ошибка: Время ухода раньше, чем время прихода!');
        }

        if (null !== $this->findExistsTime($startDate, $workerId)) {
            return new FrontendResponse(false, null,'Предупреждение: Данные за этот день уже внесены!');
        }

        $time = ControlTime::create([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate,

            'start_time' => $startTime,
            'end_time' => $endTime,

            'worker_id' => $workerId
        ]);

        return new FrontendResponse(true, $time);
    }

    /**
     * Поиск существующей записи за конкретную дату
     *
     * @param \DateTime $startDate
     * @param int $workerId
     * @return mixed
     */
    private function findExistsTime(\DateTime $startDate, $workerId)
    {
        return ControlTime::query()
            ->whereRaw("YEAR(start_date) = :year", ['year' => (int)$startDate->format('Y')])
            ->whereRaw("MONTH(start_date) = :month", ['month' => (int)$startDate->format('m')])
            ->whereRaw("DAY(start_date) = :day", ['day' => (int)$startDate->format('d')])

            ->whereRaw("worker_id = {$workerId}")
            ->get()
            ->first();
    }
}


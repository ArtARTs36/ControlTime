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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function viewListAction(
        $page = null,
        $sortKey = 'id',
        $sortDirection = 'desc',
        $count = self::COUNT_WORKERS_IN_ONE_PAGE
    )
    {
        $times = ControlTime::with('worker');

        // todo заплатка, при джоине теряю айдишник контролТайм - как поступить элегатнее - пока хз
        $times->selectRaw('*, control_times.id as time_id');

        if ($sortKey == 'date') {
            $times->orderBy('date', $sortDirection);
        } elseif ($sortKey == 'worker') {
            $times->join('workers as w', 'control_times.worker_id', '=', 'w.id')
                ->orderBy('w.family', $sortDirection)->orderBy('w.name', $sortDirection);
        }
        else {
            $times->orderBy($sortKey, $sortDirection);
        }

        return $times->paginate($count, ['*'], 'page_workers', $page);
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
            'date', 'start_time', 'end_time', 'worker_id'
        ]);

        $workerId = (int) $data['worker_id'];

        $date = new \DateTime($data['date']);

        $startTime = new \DateTime($data['start_time']);
        $endTime = new \DateTime($data['end_time']);

        if ((int) $endTime->format('H') < (int) $startTime->format('H')) {
            return new FrontendResponse(false, null, 'Время ухода раньше, чем время прихода!');
        }

        $existTime = ControlTime::query()
            ->whereRaw("YEAR(date) = :year", ['year' => (int)$date->format('Y')])
            ->whereRaw("MONTH(date) = :month", ['month' => (int)$date->format('m')])
            ->whereRaw("DAY(date) = :day", ['day' => (int)$date->format('d')])
            ->whereRaw("worker_id = {$workerId}")
            ->get()
            ->first();

        if (null !== $existTime) {
            return new FrontendResponse(false, null,'Данные за этот день уже внесены!');
        }

        $time = ControlTime::create([
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'worker_id' => $workerId
        ]);

        return new FrontendResponse(true, $time);
    }
}


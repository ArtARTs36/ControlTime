<?php

namespace App\Http\Controllers;

use App\Helpers\FrontendResponse;
use App\Helpers\RequestHelper;
use App\Http\Requests\TimeRequest;
use App\Models\ControlTime;
use App\Models\Worker;
use App\Services\ControlTimeService;
use App\Services\Document\DocumentService;
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
            $times->where('worker_id', (int) $workerId);
        }

        if ($sortKey == 'date') {
            $times->orderBy('start_date', $sortDirection);
        } elseif ($sortKey == 'worker') {
            $times->join('workers as w', 'control_times.worker_id', '=', 'w.id')
                ->orderBy('w.family', $sortDirection)
                ->orderBy('w.name', $sortDirection);
        } else {
            $times->orderBy($sortKey, $sortDirection);
        }

        return $times->paginate($count, ['*'], 'page_times', $page);
    }

    /**
     * Создать запись
     *
     * @param TimeRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function createAction(TimeRequest $request)
    {
        $startDate = new \DateTime($request->start_date);
        $endDate = new \DateTime($request->end_date);
        $startTime = new \DateTime($request->start_time);
        $endTime = new \DateTime($request->end_time);

        if ($error = ControlTimeService::isNotCorrectDates($startDate, $endDate, $startTime, $endTime)) {
            return new FrontendResponse(false, null, $error);
        }

        if (null !== ControlTimeService::findExistsTime($startDate, $request->worker_id)) {
            return new FrontendResponse(false, null, __('control_time.save.failed.exists'));
        }

        $time = ControlTime::create([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate,

            'start_time' => $startTime,
            'end_time' => $endTime,

            'worker_id' => $request->worker_id
        ]);

        return new FrontendResponse(true, $time);
    }

    /**
     * Получить отчет о посещаемости сотрудника
     *
     * @param Worker $worker
     */
    public function report(Worker $worker): void
    {
        DocumentService::streamReportTime($worker);
    }
}


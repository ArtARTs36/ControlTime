<?php

namespace App\Http\Controllers;

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
            $times->orderByRaw("DAY(start_date), MONTH(start_date), YEAR(start_date) {$sortDirection}");
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
        $requiredFields = array_merge(ControlTime::REQUIRED_FIELDS, ['worker_id']);
        $data = RequestHelper::getEntryData($request, $requiredFields);

        $startDate = new \DateTime($data['start_date']);
        $endDate = new \DateTime($data['end_date']);

        $startYear = (int)$startDate->format('Y');
        $startMonth = (int)$startDate->format('m');
        $startDay = (int)$startDate->format('d');

        $endYear = (int)$endDate->format('Y');
        $endMonth = (int)$endDate->format('m');
        $endDay = (int)$endDate->format('d');

        if (!($startYear == $endYear && $startMonth == $endMonth && $startDay == $endDay)) {
            throw new \LogicException('С датами что-то не так!');
        }

        $existTime = ControlTime::query()
            ->where('YEAR(hired_date)', '=', $startYear)
            ->where('MONTH(hired_date)', '=', $startMonth)
            ->where('DAY(hired_date)', '=', $startDay);

        if (null !== $existTime) {
            throw new \LogicException('Данные за этот день уже внесены!');
        }

        $time = ControlTime::create([
            $data
        ]);

        return $time;
    }
}


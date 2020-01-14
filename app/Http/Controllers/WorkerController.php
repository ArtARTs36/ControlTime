<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
    private const COUNT_WORKERS_IN_ONE_PAGE = 10;

    /**
     * Получение списка работников
     *
     * @param null $page
     * @param string $sortKey
     * @param string $sortDirection
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function viewListAction($page = null, $sortKey = 'id', $sortDirection = 'desc')
    {
        $workers = DB::table(Worker::TABLE)->orderBy($sortKey, $sortDirection)
            ->paginate(self::COUNT_WORKERS_IN_ONE_PAGE, ['*'], 'page_workers', $page);

        return $workers;
    }

    /**
     * Создать работника
     *
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $entryData = RequestHelper::getEntryData($request, Worker::REQUIRED_FIELDS);

        $worker = Worker::create($entryData);

        return $worker;
    }

    /**
     * Обновление данных о работнике
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateAction($id, Request $request)
    {
        $entryData = RequestHelper::getEntryData($request, Worker::REQUIRED_FIELDS);

        $worker = Worker::find($id);

        foreach (Worker::REQUIRED_FIELDS as $field => $value) {
            $worker->$field = $entryData[$value];
        }

        $worker->save();

        return $worker;
    }

    /**
     * Удаление работника
     *
     * @param integer $id
     * @return bool
     */
    public function deleteAction($id)
    {
        $worker = Worker::find($id);
        if ($worker == null) {
            throw new \LogicException("Работник с id = {$id} не найден!");
        }

        $worker->delete();

        return true;
    }
}


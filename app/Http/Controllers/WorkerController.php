<?php

namespace App\Http\Controllers;

use App\Helpers\FrontendResponse;
use App\Helpers\RequestHelper;
use App\Http\Requests\VacationApplicationRequest;
use App\Http\Requests\WorkerRequest;
use App\Http\Response\DocumentResponse;
use App\Models\Worker;
use App\Services\Document\Document;
use App\Services\Document\DocumentService;
use App\Services\Document\DocxDocumentLoader;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    private const COUNT_WORKERS_IN_ONE_PAGE = 10;

    /**
     * Получение списка работников
     *
     * @param null $page
     * @param string $sortKey
     * @param string $sortDirection
     * @param int $count
     * @return LengthAwarePaginator
     */
    public function index(
        $page = null,
        $sortKey = 'id',
        $sortDirection = 'desc',
        $count = self::COUNT_WORKERS_IN_ONE_PAGE
    )
    {
        return Worker::orderBy($sortKey, $sortDirection)
            ->paginate($count, ['*'], 'page_workers', $page);
    }

    /**
     * Получить информацию о работнике
     *
     * @param Worker $worker
     * @return Worker
     */
    public function show(Worker $worker): Worker
    {
        return $worker;
    }

    /**
     * Создать работника
     *
     * @param WorkerRequest $request
     * @return mixed
     */
    public function store(WorkerRequest $request)
    {
        $worker = Worker::create($request->toArray());

        return new FrontendResponse(true, $worker);
    }

    /**
     * Обновление данных о работнике
     *
     * @param Worker $worker
     * @param WorkerRequest $request
     * @return mixed
     */
    public function update(Worker $worker, WorkerRequest $request): FrontendResponse
    {
        $worker->update($request->toArray());

        return new FrontendResponse(true, $worker);
    }

    /**
     * Удаление работника
     *
     * @param Worker $worker
     * @return array
     */
    public function destroy(Worker $worker): array
    {
        $worker->delete();

        return ['success' => true];
    }

    public function saveVacationApplication(VacationApplicationRequest $request, Worker $worker)
    {
        $path = DocumentService::saveWorkerVacationApplication($worker, $request);

        return new DocumentResponse($path);
    }
}


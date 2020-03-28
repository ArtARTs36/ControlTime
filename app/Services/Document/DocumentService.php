<?php

namespace App\Services\Document;

use App\Http\Requests\VacationApplicationRequest;
use App\Models\Worker;
use App\Services\ControlTimeService;

class DocumentService
{
    public static function streamReportTime(Worker $worker)
    {
        PDFDocumentLoader::stream(Document::TEMPLATE_TIME_REPORT, [
            'times' => ControlTimeService::findByWorker($worker),
            'worker' => $worker,
        ]);
    }

    public static function saveWorkerVacationApplication(Worker $worker, VacationApplicationRequest $request)
    {
        $prepareDate = new \DateTime($request->vacationDate);

        $template = Document::VACATION_APPLICATION_TYPES[$request->type] ??
            Document::TEMPLATE_VACATION_APPLICATION_YEAR;;

        return DocxDocumentLoader::save($template, [
            'variables' => [
                'WORKER_TITLE' => $worker->getFullName(),
                'WORKER_FAMILY' => $worker->family,
                'WORKER_SIGN' => $worker->getSign(),
                'CURRENT_DATE' => date('d.m.Y'),
                'VACATION_DATE' => $prepareDate->format('d.m.Y'),
                'DAYS' => $request->days,
            ]
        ]);
    }
}

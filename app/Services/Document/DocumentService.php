<?php

namespace App\Services\Document;

use App\Models\Worker;
use App\Services\ControlTimeService;

class DocumentService
{
    public static function streamReportTime(Worker $worker)
    {
        PDFDocumentLoader::load(Document::TEMPLATE_TIME_REPORT, [
            'times' => ControlTimeService::findByWorker($worker),
            'worker' => $worker,
        ]);
    }
}

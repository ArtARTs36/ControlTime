<?php

namespace App\Services\Document;

use App\Models\ControlTime;
use App\Models\Worker;

class DocumentService
{
    public static function streamReportTime(Worker $worker)
    {
        $times = ControlTime::where('worker_id', $worker->id)
            ->get();

        PDFDocumentLoader::load(Document::TEMPLATE_TIME_REPORT, [
            'times' => $times,
            'worker' => $worker,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function download(string $timeWithFormat): BinaryFileResponse
    {
        $path = storage_path('docs/'. $timeWithFormat);

        return response()->download($path)->deleteFileAfterSend();
    }
}

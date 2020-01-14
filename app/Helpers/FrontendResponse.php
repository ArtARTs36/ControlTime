<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class FrontendResponse extends JsonResponse
{
    public function __construct($success, $entryData = [], $message = null, $status = 200)
    {
        $data = [
            'success' => $success,
            'entryData' => $entryData,
            'message' => $message
        ];

        parent::__construct($data, $status, [], 0);
    }
}


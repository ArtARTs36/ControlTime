<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class DocumentResponse extends JsonResponse
{
    public function __construct(string $file, $status = 200, $headers = [], $options = 0)
    {
        $parse = explode("/", $file);

        $data = [
            'fileName' => end($parse),
        ];

        parent::__construct($data, $status, $headers, $options);
    }
}

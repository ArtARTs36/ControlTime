<?php

namespace App\Http\Requests;

use App\Models\ControlTime;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TimeRequest
 * @mixin ControlTime
 */
class TimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'int|sometimes',
            'start_date' => 'string|required',
            'start_time' => 'string|required',
            'end_date' => 'string|required',
            'end_time' => 'string|required',
            'worker_id' => 'int|exists:workers,id'
        ];
    }
}

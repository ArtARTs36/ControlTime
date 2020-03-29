<?php

namespace App\Http\Requests;

use App\Models\Worker;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class WorkerRequest
 * @mixin Worker
 */
class WorkerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'sometimes|int',
            'name' => 'required|string',
            'patronymic' => 'required|string',
            'family' => 'required|string',
            'phone' => 'required|string',
            'hired_date' => 'sometimes|string',
        ];
    }
}

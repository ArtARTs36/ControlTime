<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VacationApplicationRequest
 * @property string $vacationDate
 * @property int $type
 * @property int $days
 */
class VacationApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vacationDate' => 'string|required',
            'type' => 'int|required',
            'days' => 'int|required',
        ];
    }
}

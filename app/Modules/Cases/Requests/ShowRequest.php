<?php

namespace App\Modules\Cases\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowRequest
 * @package App\Modules\Cases\Requests
 */
class ShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'nullable|date',
            'ip' => 'nullable|ip'
        ];
    }
}

<?php

namespace App\Modules\Cases\Requests;

use App\Modules\Cases\Enum\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CaseRequest
 * @package App\Modules\Cases\Requests
 */
class CaseRequest extends FormRequest
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
            'word' => 'required|string|regex:/^[А-Яа-яЁё]/u|min:1|max:255',
            'gender' => ['required', Rule::in(GenderEnum::GENDERS)],
            'email' => 'required|email',
            'is_enthusiastic' => 'required|boolean'
        ];
    }
}

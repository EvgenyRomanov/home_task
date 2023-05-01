<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'required|max:250',
            'engineer_id' => 'nullable|exists:engineers,id',
            'status_id' => function ($attribute, $value, $fail) {
                if ((int)$value !== 1) {         // Новая задача всегда в статусе - "Создана"
                    $fail('The '.$attribute.' is invalid.');
                }
            }
        ];
    }
}

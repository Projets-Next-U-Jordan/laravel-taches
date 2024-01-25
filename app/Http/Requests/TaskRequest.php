<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'due_date' => 'required|date_format:Y-m-d\TH:i|after:now',
            'category_id' => 'required|exists:categories,id',
            'content' => 'nullable|string',
            'completed' => 'nullable|boolean'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'unique' => __('validation.task.unique')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('tasks')->ignore($this->task)],
            'description' => 'nullable|max:255',
            'status_id' => 'required|integer|exists:task_statuses,id',
            'assigned_to_id' => 'nullable',
            'labels' => 'nullable'
        ];
    }
}

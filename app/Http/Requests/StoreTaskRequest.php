<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Task::class);
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
            'name' => 'required|unique:tasks',
            'description' => 'nullable|max:255',
            'status_id' => 'integer|required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable',
            'labels' => 'nullable'
        ];
    }
}

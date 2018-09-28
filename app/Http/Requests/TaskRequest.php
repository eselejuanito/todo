<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TaskRequest
 * @package App\Http\Requests
 *
 * @property string name
 * @property string description
 * @property string status
 * @property int todo_id
 */
class TaskRequest extends FormRequest
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
     * Store rules
     * @return array
     */
    private function storeRules()
    {
        return [
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3',
            'status' => 'in:' . implode(',', Task::STATUS),
            'todo_id' => 'required|integer',
        ];
    }

    /**
     * Update rules
     * @return array
     */
    private function updateRules()
    {
        return [
            'title' => 'string|min:3|max:50',
            'description' => 'string|min:3',
            'status' => 'in:' . implode(',', Task::STATUS),
            'todo_id' => 'integer',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->isMethod('post')) {
            $rules = $this->storeRules();
        }

        if ($this->isMethod('put')) {
            $rules = $this->updateRules();
        }

        return $rules;
    }
}

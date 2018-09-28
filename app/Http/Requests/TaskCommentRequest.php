<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TaskCommentRequest
 * @package App\Http\Requests
 */
class TaskCommentRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'task_id' => 'required|integer',
            'comment' => 'required|string|min:3',
        ];
    }

    /**
     * Update rules
     * @return array
     */
    private function updateRules()
    {
        return [
            'user_id' => 'integer',
            'task_id' => 'integer',
            'comment' => 'string|min:3',
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
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TodoRequest
 * @package App\Http\Requests
 *
 * @property string name
 * @property string description
 * @property int user_id
 */
class TodoRequest extends FormRequest
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
            'target_date' => 'required|date',
            'user_id' => 'required|integer',
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
            'target_date' => 'date',
            'user_id' => 'integer',
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

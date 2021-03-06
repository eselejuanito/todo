<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserRequest
 * @package App\Http\Requests
 *
 * @property string name
 * @property string email
 */
class UserRequest extends FormRequest
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
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
        ];
    }

    /**
     * Update rules
     * @return array
     */
    private function updateRules()
    {
        return [
            'name' => 'min:5',
            'email' => 'email|unique:users,email,' . $this->user->id,
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

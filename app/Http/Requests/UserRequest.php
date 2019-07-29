<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:60|unique:users,name',
            'email' => 'required|email|max:60|unique:users,email',
            'password' => 'required|min:5',
            'password_confirmation' => 'required|min:5|same:password',
            'state' => 'required|integer',
            'profile_id' => 'required|integer'
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['name'] .= ',' . $this->id;
            $rules['email'] .= ',' . $this->id;
        }

        return $rules;
    }
}

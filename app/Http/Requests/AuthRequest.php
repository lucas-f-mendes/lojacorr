<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function rules(): array
    {
        $data = array();

        $data["password"] = ["required", "string"];
        $data["login"] = ["required", "string", "min:3", "max:150"];

        return $data;
    }

    public function messages()
    {
        return [
            "login.password" => "campo login é obrigatório",
            "password.required" => "campo senha é obrigatório",
            "login.min" => "mínimo 3 caracteres",
            "login.max" => "máximo 150 caracteres",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    const NOT_REQUIRED = ["PUT", "PATCH"];

    public function rules(): array
    {
        $data = array();

        $data["name"] = ["required", "string", "min:3", "max:150"];
        $data["slug"] = ["string", "min:3", "max:150"];

        if (in_array(request()->method(), self::NOT_REQUIRED) === true) {
            unset($data["name"][0]);
        }

        return $data;
    }

    public function messages(): array
    {
        return [
            "name.required" => "campo nome é obrigatório",
            "name.min" => "mínimo 3 caracteres",
            "name.max" => "máximo 150 caracteres",
            "slug.min" => "mínimo 3 caracteres",
            "slug.max" => "máximo 150 caracteres",
        ];
    }
}

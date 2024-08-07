<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    const NOT_REQUIRED = ["PUT", "PATCH"];

    public function rules(): array
    {
        $data = array();

        $data["name"] = ["required", "string", "min:3", "max:150"];
        $data["price"] = ["required"];
        $data["slug"] = ["min:3", "max:150"];
        $data["description"] = ["string", "nullable", "min:1", "max:1000"];
        $data["category_id"] = ["required"];

        if (in_array(request()->method(), self::NOT_REQUIRED) === true) {
            unset($data["name"][0]);
            unset($data["category_id"][0]);
            unset($data["price"][0]);
        }

        return $data;
    }

    public function messages(): array
    {
        return [
            "name.required" => "campo nome é obrigatório",
            "name.min" => "mínimo 3 caracteres",
            "name.max" => "máximo 150 caracteres",
            "price.required" => "campo preco é obrigatório",
            "slug.min" => "mínimo 3 caracteres",
            "slug.max" => "máximo 150 caracteres",
            "category_id.required" => "campo categoria é obrigatório"
        ];
    }
}

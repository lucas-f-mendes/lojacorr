<?php

namespace App\Http\Manager;

use App\Enum\MessagesEnum;
use Illuminate\Support\Str;
use Exception;

class ProductManager extends AbstractManager
{
    protected function getManager()
    {
        return $this->getInstanceModel("product");
    }

    public function create($request)
    {
        $product = $this->getManager();

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->uuid = Str::uuid();

        $category = $this->getRepository("category")->getCategoryById($request);

        if (is_null($category) === true) {
            return throw new Exception(MessagesEnum::REGISTER_NOT_FOUND);
        }

        $product->category_id = (int) $category->id;

        if (isset($request->price) === true || $request->price === 0) {
            $product->price = $request->price ? (float) $request->price : null;
        }

        if (isset($request->featured) === true || $request->featured === false) {
            $product->featured = $request->featured ? (bool) $request->featured : false;
        }

        if (isset($request->stock) === true || $request->stock === 0) {
            $product->stock = $request->stock ? (int) $request->stock : null;
        }

        if (isset($request->height) === true | $request->height === 0) {
            $product->height = $request->height ? (int) $request->height : null;
        }

        if (isset($request->width) === true | $request->width === 0) {
            $product->width = $request->width ? (int) $request->width : null;
        }

        if (isset($request->weight) === true | $request->weight === 0) {
            $product->weight = $request->weight ? (int) $request->weight : null;
        }

        $product->save();

        return $product;
    }

    public function update($request, $id)
    {
        $product = $this->get($id);

        if (isset($request->name) === true) {
            $product->name = $request->name;
            $product->slug = Str::slug($product->name);
        }

        if (isset($request->category_id) === true) {
            $category = $this->getRepository("category")->getCategoryById($request);

            if (is_null($category) === true) {
                return throw new Exception(MessagesEnum::ERROR_HAS_OCURRED);
            }

            $product->category_id = (int) $category->id;
        }

        if (isset($request->price) === true || $request->price === 0) {
            $product->price = $request->price ? (float) $request->price : null;
        }

        if (isset($request->featured) === true || $request->featured === false) {
            $product->featured = $request->featured ? (bool) $request->featured : false;
        }

        if (isset($request->stock) === true || $request->stock === 0) {
            $product->stock = $request->stock ? (int) $request->stock : null;
        }

        if (isset($request->height) === true | $request->height === 0) {
            $product->height = $request->height ? (int) $request->height : null;
        }

        if (isset($request->width) === true | $request->width === 0) {
            $product->width = $request->width ? (int) $request->width : null;
        }

        if (isset($request->weight) === true | $request->weight === 0) {
            $product->weight = $request->weight ? (int) $request->weight : null;
        }

        if (isset($request->description) === true) {
            $product->description = $request->description;
        }

        $product->save();
    }

    public function remove($id)
    {
        $this->getManager()->find($id)->delete();
    }

    public function get($id)
    {
        return $this->getManager()
            ->where("id", $id)
            ->orWhere("uuid", $id)
            ->with("category:id,name")
            ->first();
    }

    public function fetch($limit, $sortBy = array("products.id" => "DESC"))
    {
        $query = $this->getQueryFilter();

        foreach ($sortBy as $column => $type) {
            $query->orderBy($column, $type);
        }

        $query = $query->paginate($limit);

        return $query;
    }

    private function getQueryFilter()
    {
        $filters = array(
            "nome" => "",
            "preco" => "",
            "altura" => "",
            "largura" => "",
            "estoque" => "",
            "destaque" => "",
            "peso" => "",
            "categoria" => "",
            "busca" => ""
        );

        foreach ($filters as $key => $value) {
            $filter = request()->get($key);

            if ($filter !== "") {
                $filters[$key] = $filter;
            }
        }

        $query = $this->getManager();

        $query = $query
            ->select("products.*")
            ->join("categories", "categories.id", "=", "products.category_id");

        if (isset($filters["nome"]) === true || isset($filters["busca"]) === true) {
            $filter = isset($filters["nome"]) ? $filters["nome"] : $filters["busca"];

            $query = $query
                ->where("products.name", "like", "%" . $filter . "%");
        }

        if (isset($filters["destaque"]) === true) {
            $query = $query
                ->where("products.featured", $filters["destaque"]);
        }

        if (isset($filters["preco"]) === true) {
            $query = $query
                ->where("products.price", $filters["preco"]);
        }

        if (isset($filters["altura"]) === true) {
            $query = $query
                ->where("products.height", (int) $filters["altura"]);
        }

        if (isset($filters["largura"]) === true) {
            $query = $query
                ->where("products.width", (int) $filters["largura"]);
        }

        if (isset($filters["peso"]) === true) {
            $query = $query
                ->where("products.weight", (int) $filters["peso"]);
        }

        if (isset($filters["estoque"]) === true) {
            $query = $query
                ->where("products.stock", (int) $filters["estoque"]);
        }

        if (isset($filters["categoria"]) === true) {
            $query = $query
                ->where("categories.name", "like", "%" . $filters["categoria"] . "%");
        }

        return $query;
    }
}

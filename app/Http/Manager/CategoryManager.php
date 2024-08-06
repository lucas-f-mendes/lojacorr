<?php

namespace App\Http\Manager;

use App\Enum\MessagesEnum;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Response;

class CategoryManager extends AbstractManager
{
    protected function getManager()
    {
        return $this->getInstanceModel("category");
    }

    public function create($request)
    {
        $has_same_slug = $this->getRepository("category")->getCategoryWithSameSlug($request);

        if (is_null($has_same_slug) === false) {
            return throw new Exception(MessagesEnum::SAME_NAME, Response::HTTP_BAD_REQUEST);
        }

        $category = $this->getManager();

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->uuid = Str::uuid();
        $category->featured = (bool) $request->featured;

        $category->save();

        return $category;
    }

    public function update($request, $id)
    {
        $category = $this->get($id);

        if (isset($request->name) === true) {
            $category->name = $request->name;
            $category->slug = Str::slug($category->name);
        }

        if (isset($request->featured) === true) {
            $category->featured = (bool) $request->featured;
        }

        $category->save();
    }

    public function remove($id)
    {
        $this->getManager()
            ->where("id", $id)
            ->orWhere("uuid", $id)
            ->orWhere("parent_category_id", $id)
            ->delete();
    }

    public function get($id)
    {
        return $this->getManager()
            ->where("id", $id)
            ->orWhere("uuid", $id)
            ->with("subcategories")
            ->first();
    }

    public function fetch($limit, $sortBy = array("id" => "DESC"))
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
            "categoria" => "",
            "destaque" => "",
            "subcategoria" => "",
            "busca" => ""
        );

        foreach ($filters as $key => $value) {
            $filter = request()->get($key);

            if ($filter !== "") {
                $filters[$key] = $filter;
            }
        }

        $query = $this->getManager();

        if (isset($filters["nome"]) === true || isset($filters["busca"]) === true) {
            $filter = isset($filters["nome"]) ? $filters["nome"] : $filters["busca"];

            $query = $query
                ->where("name", "like", "%" . $filter . "%");
        }

        if (isset($filters["destaque"]) === true) {
            $query = $query
                ->where("featured", $filters["destaque"]);
        }

        if (isset($filters["subcategoria"]) === true) {
            $query = $query
                ->where("name", "like", "%" . $filters["subcategoria"] . "%");
        } else {
            $query = $query
                ->whereNull("parent_category_id");
        }

        $query = $query
            ->with("subcategories");

        return $query;
    }
}

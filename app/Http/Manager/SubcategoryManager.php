<?php

namespace App\Http\Manager;

use Illuminate\Support\Str;

class SubcategoryManager extends AbstractManager
{
    protected function getManager()
    {
        return $this->getInstanceModel("category");
    }

    public function create($request)
    {
        $category = $this->getManager()
            ->where("id", $request->parent_category_id)
            ->orWhere("uuid", $request->parent_category_id)
            ->first();

        $subcategory = $this->getManager();

        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->uuid = Str::uuid();
        $subcategory->featured = (bool) $request->featured;
        $subcategory->parent_category_id = (int) $category->id;

        $subcategory->save();

        return $subcategory;
    }

    public function update($request, $data)
    {
        $subcategory = $this->get($data);

        if (isset($request->name) === true) {
            $subcategory->name = $request->name;
            $subcategory->slug = Str::slug($subcategory->name);
        }

        if (isset($request->featured) === true) {
            $subcategory->featured = (bool) $request->featured;
        }

        $subcategory->save();
    }

    public function remove($data)
    {
        $this->get($data)->delete();
    }

    public function get($data)
    {
        return $this->getManager()
            ->where("parent_category_id", $data["category"])
            ->where("id", $data["subcategory"])
            ->orWhere("uuid", $data["subcategory"])
            ->first();
    }

    public function fetch($limit, $sortBy = array("id" => "DESC"))
    {
        //
    }
}

<?php

namespace App\Http\Repository;

use App\Http\Manager\CategoryManager;
use Illuminate\Support\Str;

class CategoryRepository extends CategoryManager
{
    public function getCategoryWithSameSlug($category)
    {
        return $this->getManager()
            ->select("id")
            ->where("slug", Str::slug($category->name))
            ->limit(1)
            ->first();
    }

    public function getCategoryById($request)
    {
        return $this->getManager()
            ->select("id")
            ->where("uuid", $request->category_id)
            ->orWhere("id", $request->category_id)
            ->limit(1)
            ->first();
    }
}

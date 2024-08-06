<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Http\Manager\CategoryManager;
use App\Http\Requests\CategoryRequest;
use App\Http\Manager\SubcategoryManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubcategoryController extends BaseApiController
{
    public function __construct(
        private CategoryManager $categoryManager,
        private SubcategoryManager $subcategoryManager
    ) {
        //
    }

    public function create($cat_id, CategoryRequest $request): Response
    {
        try {
            $category = $this->categoryManager->get($cat_id);

            if (is_null($category) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            $subcategory = $this->subcategoryManager->create($request);

            return response()->json($subcategory);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function update($cat_id, $id, CategoryRequest $request): Response
    {
        try {
            $data = array("category" => $cat_id, "subcategory" => $id);

            $subcategory = $this->subcategoryManager->get($data);

            if (is_null($subcategory) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            $this->subcategoryManager->update($request, $data);
            $data = $this->subcategoryManager->get($data);

            return response()->json($subcategory);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function destroy($cat_id, $id, Request $request): Response
    {
        try {
            $data = array("category" => $cat_id, "subcategory" => $id);

            $subcategory = $this->subcategoryManager->get($data);

            if (is_null($subcategory) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            $this->subcategoryManager->remove($data);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }
}

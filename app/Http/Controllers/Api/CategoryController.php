<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Http\Manager\CategoryManager;
use App\Http\Requests\CategoryRequest;
use App\Enum\RequestEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends BaseApiController
{
    public function __construct(private CategoryManager $categoryManager)
    {
        //
    }

    public function index(Request $request): Response
    {
        try {
            $limit = $request->limit ?? RequestEnum::LIMIT;

            $response = $this->categoryManager->fetch(limit: $limit);

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function create(CategoryRequest $request): Response
    {
        try {
            $response = $this->categoryManager->create($request);

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function update($id, CategoryRequest $request): Response
    {
        try {
            $response = $this->categoryManager->get($id);

            if (is_null($response) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            $this->categoryManager->update($request, $id);
            $response = $this->categoryManager->get($id);

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function show($id, Request $request): Response
    {
        try {
            $response = $this->categoryManager->get($id);

            if (is_null($response) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function destroy($id, Request $request): Response
    {
        try {
            $response = $this->categoryManager->get($id);

            if (is_null($response) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            $this->categoryManager->remove($id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }
}

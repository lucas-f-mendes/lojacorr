<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Http\Manager\ProductManager;
use App\Http\Requests\ProductRequest;
use App\Enum\RequestEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends BaseApiController
{
    public function __construct(
        private ProductManager $productManager,
    ) {
        //
    }

    public function index(Request $request,): Response
    {
        try {
            $limit = $request->limit ?? RequestEnum::LIMIT;

            $response = $this->productManager->fetch(limit: $limit);

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function create(ProductRequest $request): Response
    {
        try {
            $response = $this->productManager->create($request);

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function update($id, ProductRequest $request): Response
    {
        try {
            $response = $this->productManager->get($id);

            if (is_null($response) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            $this->productManager->update($request, $id);

            $response = $this->productManager->get($id);

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }

    public function show($id, Request $request): Response
    {
        try {
            $response = $this->productManager->get($id);

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
            $response = $this->productManager->get($id);

            if (is_null($response) === true) {
                $message = $this->getMessage();
                return response()->json($message, Response::HTTP_NOT_FOUND);
            }

            $this->productManager->remove($id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->render($request, $e);
        }
    }
}

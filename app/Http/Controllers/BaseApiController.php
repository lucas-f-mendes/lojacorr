<?php

namespace App\Http\Controllers;

use App\Enum\MessagesEnum;
use App\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BaseApiController extends Controller
{
    public function getMessage($response = null): array
    {
        return array(
            "status" => false,
            "content" => $response ?? MessagesEnum::REGISTER_NOT_FOUND
        );
    }

    public function render($request, Throwable $exception): Response
    {
        return ApiException::renderExpection($exception);
    }
}

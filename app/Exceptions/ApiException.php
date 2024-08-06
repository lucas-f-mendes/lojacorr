<?php

namespace App\Exceptions;

use App\Enum\MessagesEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use BadMethodCallException;
use Exception;
use Throwable;

abstract class ApiException
{
    public static function renderExpection(Throwable $exception): Response
    {
        if (
            $exception instanceof AuthenticationException ||
            $exception instanceof TokenInvalidException
        ) {
            return self::getMessageError(MessagesEnum::INVALID_TOKEN, Response::HTTP_FORBIDDEN);
        }

        if (
            $exception instanceof NotFoundHttpException ||
            $exception instanceof ModelNotFoundException
        ) {
            return self::getMessageError(MessagesEnum::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if (
            $exception instanceof AuthorizationException ||
            $exception instanceof BadMethodCallException
        ) {
            return self::getMessageError(MessagesEnum::FORBIDDEN_OPERATION, Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof Exception) {
            return self::getMessageError($exception->getMessage(), $exception->getCode());
        }


        $message = config("app.env") === "dev" ? $exception->getMessage() : MessagesEnum::ERROR_HAS_OCURRED;

        return self::getMessageError($message, Response::HTTP_BAD_REQUEST);
    }

    private static function getMessageError(string $message, int $code)
    {
        $data = array(
            "status" => false,
            "content" => $message
        );

        return response()->json($data, $code);
    }
}

<?php

namespace App\Http\Middleware;

use App\Enum\MessagesEnum;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    protected function unauthenticated($request, array $guards)
    {
        $data = array(
            "status" => false,
            "content" => MessagesEnum::UNAUTHENTICATED
        );

        abort(response()->json($data, Response::HTTP_UNAUTHORIZED));
    }
}

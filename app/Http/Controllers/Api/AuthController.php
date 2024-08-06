<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AuthRequest;
use App\Enum\AuthEnum;
use App\Enum\MessagesEnum;
use App\Http\Controllers\BaseApiController;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseApiController
{
    public function __construct(private UserRepository $userRepository)
    {
        //
    }

    public function login(AuthRequest $request): Response
    {
        $mode = AuthEnum::ALIAS;
        $ttl = (int) config("auth.ttl");

        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $mode = AuthEnum::EMAIL;
        }

        $user = $this->userRepository->getUserByTypeAccess($mode, $request->login);

        if (is_null($user) === true) {
            $message = $this->getMessage(MessagesEnum::INVALID_CREDENTIALS);
            return response()->json($message, Response::HTTP_BAD_REQUEST);
        }

        $password_verify = password_verify($request->password, $user->password);

        if (!$password_verify) {
            $message = $this->getMessage(MessagesEnum::INVALID_CREDENTIALS);
            return response()->json($message, Response::HTTP_BAD_REQUEST);
        }

        $token = auth()->setTTL($ttl)->login($user, true);

        return response()->json(["token" => $token]);
    }

    public function logout(): Response
    {
        auth()->logout(true);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function me(): Response
    {
        $user = auth()->user();

        if (is_null($user) === true) {
            $message = $this->getMessage();
            return response()->json($message, Response::HTTP_NOT_FOUND);
        }

        return response()->json($user);
    }

    public function validateToken(Request $request): Response
    {
        $token = $request->server->get("REDIRECT_HTTP_AUTHORIZATION");

        if (is_null($token) === true && is_null(auth()->user()) === true) {
            $message = $this->getMessage(MessagesEnum::FORBIDDEN_OPERATION);
            return response()->json($message, Response::HTTP_FORBIDDEN);
        }

        $token = trim(str_replace("Bearer", "", $token));
        $auth_token = auth()->getToken()->get();

        if ($auth_token !== $token) {
            $message = $this->getMessage(MessagesEnum::FORBIDDEN_OPERATION);
            return response()->json($message, Response::HTTP_FORBIDDEN);
        }

        return response()->json(["status" => true]);
    }
}

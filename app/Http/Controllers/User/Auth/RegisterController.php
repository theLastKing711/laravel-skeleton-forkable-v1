<?php

namespace App\Http\Controllers\User\Auth;

use App\Data\Shared\Swagger\Request\JsonRequestBody;
use App\Data\Shared\Swagger\Response\SuccessItemResponse;
use App\Data\User\Auth\RegisterRequestData;
use App\Data\User\Auth\RegisterResponseData;
use App\Http\Controllers\Controller;
use App\Models\User;
use OpenApi\Attributes as OAT;

class RegisterController extends Controller
{
    #[OAT\Post(path: '/users/auth/register', tags: ['usersAuth'])]
    #[JsonRequestBody(RegisterRequestData::class)]
    #[SuccessItemResponse(RegisterResponseData::class)]
    public function __invoke(RegisterRequestData $request)
    {

        $request_phone_number = $request->phone_number;

        $token = User::query()
            ->create([
                'phone_number' => $request_phone_number,
            ])->createToken($request_phone_number);

        return new RegisterResponseData($token->plainTextToken);

    }
}

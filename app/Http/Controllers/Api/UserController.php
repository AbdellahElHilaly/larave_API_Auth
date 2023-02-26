<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Traits\ExceptionHandlerTrait;
use App\Http\Controllers\Traits\ApiResponceTrait;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    use ExceptionHandlerTrait;
    use ApiResponceTrait;

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            // Hash the password before saving
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            return $this->apiResponse(new UserResource($user), Response::HTTP_CREATED, "User created successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function login(LoginRequest $request){

    }
}

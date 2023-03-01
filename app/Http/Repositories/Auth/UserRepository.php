<?php

namespace App\Http\Repositories\Auth;
use App\Http\Repositories\Auth\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Response;
use App\Traits\ResponceHandling\ApiResponceTrait;
use App\Traits\ExceptionHandling\ExceptionHandlerTrait;
use App\Traits\Auth\MailVerificationTrait;
use App\Http\Resources\Auth\UserResource;

class UserRepository implements UserRepositoryInterface
{
    use ExceptionHandlerTrait;
    use ApiResponceTrait;

    public function create($attributes)
    {
        try {
            $attributes['password'] = bcrypt($attributes['password']);
            $user = User::create($attributes);
            return $this->apiResponse(new UserResource($user), Response::HTTP_CREATED, "User created successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function isRegistered($attributes)
    {
        return User::where('email', $attributes['email'])->exists();
    }

    public function isVerified($attributes)
    {
        $user = User::where('email', $attributes['email'])->first();
        return !is_null($user->account_verified_at);
    }



}

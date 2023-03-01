<?php
namespace App\Http\Repositories\Auth;
interface UserRepositoryInterface
{
    public function create($attributes);

    public function isRegistered($attributes);

    public function isVerified($attributes);
}

<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Repositories\Auth\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Auth\UserRepository;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ResponceHandling\ApiResponceTrait;
use App\Traits\Auth\Helper;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponceTrait;
    use Helper;

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {

        return response($this->generateToken());
        $data = $request->validated();
        if ($this->userRepository->isRegistered($data)) {
            return $this->apiResponse(null, Response::HTTP_CONFLICT, 'User already registered.');
        }

        return $this->userRepository->create($data);
    }


    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if ($this->userRepository->isRegistered($data)) {
            if (!$this->userRepository->isVerified($data)) {
                return $this->apiResponse(null, Response::HTTP_UNAUTHORIZED, 'Account not verified.');
            }
            return $this->apiResponse(null, Response::HTTP_CONFLICT, 'User already registered.');
        }
    }
}

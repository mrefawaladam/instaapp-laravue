<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials)
    {
        return $this->userRepository->attemptLogin($credentials);
    }

    public function register(array $data)
    {
        return $this->userRepository->createUser($data);
    }
}
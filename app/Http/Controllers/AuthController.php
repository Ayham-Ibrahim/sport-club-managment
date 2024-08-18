<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected $authService;
    use ApiResponseTrait;
    
    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }


    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request){

        $data = $request->validated();
        $response = $this->authService->register($data);
        return $this->apiResponse(new UserResource($response['user']),$response['token'],'registered successfully',200);

    }

     /**
     * Login a user.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request){

        $credentials = $request->validated();
        $response = $this->authService->login($credentials);
        return $this->apiResponse(new UserResource($response['user']),$response['token'],'logged in successfully',200);

    }

    /**
     * logout a user.
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user and return the generated token.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // TODO: Check why validation errors not returned when using dublicate credentials

        // Validate the request through the RegisterRequest class
        $validated = $request->validated();

        // Use the AuthService to register the user and get the token
        $token = $this->authService->register(
            $validated['name'],
            $validated['email'],
            $validated['password']
        );

        // Return the response with the token
        return response()->json([
            'token' => $token,
        ], 201); // HTTP 201 Created
    }

    public function login(LoginRequest $request): JsonResponse
    {
        // TODO: Check why validation errors not returned when using invalid credentials
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        // Check password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'error' => 'Invalid credentials.'
            ], 401);
        }

        $token = $user->createToken('PsychologistApp')->plainTextToken;

        // Return response
        return response()->json([
            'token' => $token,
        ]);

    }
}

<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Handle the login process and generate a token.
     */
    public function login(string $email, string $password)
    {
        // Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null; // Return null if the credentials are invalid
        }

        // Generate the access token
        $token = $user->createToken('psychologist_api')->plainTextToken;

        return $token;
    }

    /**
     * Handle the registration of a new user and generate a token.
     */
    public function register(string $name, string $email, string $password)
    {
        // Create a new user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password), // Hash the password before saving
        ]);

        // Generate an access token for the new user
        $token = $user->createToken('psychologist_api')->plainTextToken;

        return $token;
    }
}

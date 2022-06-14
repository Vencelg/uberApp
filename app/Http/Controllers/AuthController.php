<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $request->validated();

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender
        ]);
        $user->save();

        return response()->json([
            'user' => $user
        ], 201);
    }

    /**
     * Create a token for the user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user->exists() || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong Credentials',
            ], 401);
        }

        $accessToken = $user->createToken('accessToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'accessToken' => $accessToken
        ], 200);
    }

    /**
     * Delete users access token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->exists()) {
            return response()->json([
                'error' => 'User does not exist'
            ], 403);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out'
        ]);
    }
}

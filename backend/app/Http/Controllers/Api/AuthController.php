<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\JwtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $jwtService = new JwtService();
        $token      = $jwtService->generateToken($user);

        return response()->json([
            'token' => $token,
            'user'  => $user->makeHidden(['password']),
        ]);
    }

    public function logout()
    {
        // Client-side token deletion
        return response()->json(['message' => 'Logged out']);
    }
}

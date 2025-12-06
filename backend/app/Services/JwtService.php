<?php
namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private static string $secret;
    private static string $algo = 'HS256';

    public function __construct()
    {
        self::$secret = env('JWT_SECRET');
    }

    public function generateToken(User $user): string
    {
        $payload = [
            'iss'       => env('APP_URL'), // Issuer
            'sub'       => $user->id,      // Subject
            'iat'       => time(),         // Issued at
            'exp'       => time() + 3600,  // Expiry (1 hour)
            'role'      => $user->role,
            'tenant_id' => $user->tenant_id,
        ];

        return JWT::encode($payload, self::$secret, self::$algo);
    }

    public function validateToken(string $token): ?array
    {
        try {
            return (array) JWT::decode($token, new Key(self::$secret, self::$algo));
        } catch (\Exception $e) {
            return null;
        }
    }
}

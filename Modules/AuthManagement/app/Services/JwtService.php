<?php

namespace Modules\AuthManagement\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Config;
use stdClass;

class JwtService
{
    public static function generateToken(array $payload): string
    {
        return JWT::encode(
            $payload,
            Config::get('jwt.secret'),
            Config::get('jwt.algo', 'HS256')
        );
    }

    public static function decodeToken(string $token): stdClass
    {
        return JWT::decode(
            $token,
            new Key(
                Config::get('jwt.secret'),
                Config::get('jwt.algo', 'HS256')
            )
        );
    }
}


<?php

declare(strict_types=1);

namespace app\helpers;

final class Random {

    public static function generateToken(?string ...$salts) : string {
        $token = base64_encode(openssl_random_pseudo_bytes(32)) . uniqid() . time() . implode($salts);
        return bin2hex(hash('sha256', $token, true) ^ hash('whirlpool', $token, true));
    }
}
?>

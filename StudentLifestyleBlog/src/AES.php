<?php

declare(strict_types=1);

class AES {
    private const ENCRYPTION_KEY = "bic21203webdevproject";
    private const ENCRYPTION_ALGORITHM = "AES-256-CBC";

    public static function encrypt(string $string): string|false {
        $ivLength = openssl_cipher_iv_length(self::ENCRYPTION_ALGORITHM);
        $iv = "";

        for ($i = 0; $i < $ivLength; $i++) {
            $iv .= "0";
        }

        return openssl_encrypt($string, self::ENCRYPTION_ALGORITHM, self::ENCRYPTION_KEY, 0, $iv);
    }

    public static function decrypt(string $cipher): string|false {
        $ivLength = openssl_cipher_iv_length(self::ENCRYPTION_ALGORITHM);
        $iv = "";

        for ($i = 0; $i < $ivLength; $i++) {
            $iv .= "0";
        }

        return openssl_decrypt($cipher, self::ENCRYPTION_ALGORITHM, self::ENCRYPTION_KEY, 0, $iv);
    }
}

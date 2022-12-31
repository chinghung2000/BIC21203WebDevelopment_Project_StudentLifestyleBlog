<?php

declare(strict_types=1);

class Hash {
    public const SHA_224 = "SHA224";
    public const SHA_256 = "SHA256";
    public const SHA_384 = "SHA384";
    public const SHA_512 = "SHA512";
    public const SHA_512_224 = "SHA512/224";
    public const SHA_512_256 = "SHA512/256";
    public const SHA_3_224 = "SHA3-224";
    public const SHA_3_256 = "SHA3-256";
    public const SHA_3_384 = "SHA3-384";
    public const SHA_3_512 = "SHA3-512";

    public static function generateDigest(string $string, string $algorithm) {
        return hash($algorithm, $string);
    }
}

?>
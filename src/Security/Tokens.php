<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Security;

/**
 * Utilitaire unifié de génération de jetons en tout genre
 */
final class Tokens
{
    private const int MAX = 255;
    private const int MIN = 16;
    private const string DEFAULT_ALGO = "sha256";

    /**
     * Returns an hexadecimal string of the specified length.\
     * The returned string will be twice as long.
     * @param int $length number of bytes to generate.
     * * MIN = 12
     * * MAX = 255
     * @return string
     */
    public static function generateHexa(int $length = self::MIN): string
    {
        $length = \min(\max($length, self::MIN), self::MAX);

        return \bin2hex(\random_bytes(\abs($length)));
    }

    /**
     * Returns a hash of the provided string using the specified algorithm.
     * @param string $string the string to hash
     * @param string $algo the hashing algorithm to use (default: sha256)
     * @return string the hashed string
     * @throws \InvalidArgumentException if the algorithm is not supported
     */
    public static function hash(
        #[\SensitiveParameter]
        string $string,
        string $algo = self::DEFAULT_ALGO
    ): string {
        if (!\in_array($algo, Passwords::algos())) {
            $prefix = __METHOD__ . ":" . __LINE__;
            throw new \InvalidArgumentException(
                "$prefix - The provided algorithm `$algo` is not supported.",
                500
            );
        }

        return \hash($algo, $string);
    }

    /**
     * Compares two hashes in a timing attack safe way.
     * @param string $hashFromClient
     * @param string $hashFromServer
     * @return bool
     */
    public static function hashesAreEqual(
        string $hashFromClient,
        string $hashFromServer
    ): bool {
        return \hash_equals($hashFromServer, $hashFromClient);
    }
}
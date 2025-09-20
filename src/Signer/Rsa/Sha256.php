<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Signer\Rsa;

use KaziRayhan\JWT\Signer\Rsa;

use const OPENSSL_ALGO_SHA256;

final readonly class Sha256 extends Rsa
{
    public function algorithmId(): string
    {
        return 'RS256';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA256;
    }
}

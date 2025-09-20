<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Signer\Ecdsa;

use KaziRayhan\JWT\Signer\Ecdsa;

use const OPENSSL_ALGO_SHA384;

final readonly class Sha384 extends Ecdsa
{
    public function algorithmId(): string
    {
        return 'ES384';
    }

    public function algorithm(): int
    {
        return OPENSSL_ALGO_SHA384;
    }

    public function pointLength(): int
    {
        return 96;
    }

    public function expectedKeyLength(): int
    {
        return 384;
    }
}

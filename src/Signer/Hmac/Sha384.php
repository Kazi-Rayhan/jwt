<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Signer\Hmac;

use KaziRayhan\JWT\Signer\Hmac;

final readonly class Sha384 extends Hmac
{
    public function algorithmId(): string
    {
        return 'HS384';
    }

    public function algorithm(): string
    {
        return 'sha384';
    }

    public function minimumBitsLengthForKey(): int
    {
        return 384;
    }
}

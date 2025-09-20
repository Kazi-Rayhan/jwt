<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Signer\Hmac;

use KaziRayhan\JWT\Signer\Hmac;
use KaziRayhan\JWT\Signer\Hmac\Sha384;
use KaziRayhan\JWT\Signer\InvalidKeyProvided;
use KaziRayhan\JWT\Signer\Key\InMemory;
use PHPUnit\Framework\Attributes as PHPUnit;

#[PHPUnit\CoversClass(Hmac::class)]
#[PHPUnit\CoversClass(Sha384::class)]
#[PHPUnit\CoversClass(InvalidKeyProvided::class)]
#[PHPUnit\UsesClass(InMemory::class)]
final class Sha384Test extends HmacTestCase
{
    protected function algorithm(): Hmac
    {
        return new Sha384();
    }

    protected function expectedAlgorithmId(): string
    {
        return 'HS384';
    }

    protected function expectedMinimumBits(): int
    {
        return 384;
    }

    protected function hashAlgorithm(): string
    {
        return 'sha384';
    }
}

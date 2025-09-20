<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Signer\Hmac;

use KaziRayhan\JWT\Signer\Hmac;
use KaziRayhan\JWT\Signer\Hmac\Sha512;
use KaziRayhan\JWT\Signer\InvalidKeyProvided;
use KaziRayhan\JWT\Signer\Key\InMemory;
use PHPUnit\Framework\Attributes as PHPUnit;

#[PHPUnit\CoversClass(Hmac::class)]
#[PHPUnit\CoversClass(Sha512::class)]
#[PHPUnit\CoversClass(InvalidKeyProvided::class)]
#[PHPUnit\UsesClass(InMemory::class)]
final class Sha512Test extends HmacTestCase
{
    protected function algorithm(): Hmac
    {
        return new Sha512();
    }

    protected function expectedAlgorithmId(): string
    {
        return 'HS512';
    }

    protected function expectedMinimumBits(): int
    {
        return 512;
    }

    protected function hashAlgorithm(): string
    {
        return 'sha512';
    }
}

<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Signer\Rsa;

use KaziRayhan\JWT\Signer\InvalidKeyProvided;
use KaziRayhan\JWT\Signer\Key\InMemory;
use KaziRayhan\JWT\Signer\OpenSSL;
use KaziRayhan\JWT\Signer\Rsa;
use KaziRayhan\JWT\Signer\Rsa\Sha512;
use PHPUnit\Framework\Attributes as PHPUnit;

use const OPENSSL_ALGO_SHA512;

#[PHPUnit\CoversClass(Rsa::class)]
#[PHPUnit\CoversClass(Sha512::class)]
#[PHPUnit\CoversClass(OpenSSL::class)]
#[PHPUnit\CoversClass(InvalidKeyProvided::class)]
#[PHPUnit\UsesClass(InMemory::class)]
final class Sha512Test extends RsaTestCase
{
    protected function algorithm(): Rsa
    {
        return new Sha512();
    }

    protected function algorithmId(): string
    {
        return 'RS512';
    }

    protected function signatureAlgorithm(): int
    {
        return OPENSSL_ALGO_SHA512;
    }
}

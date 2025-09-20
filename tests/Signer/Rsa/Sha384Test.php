<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Signer\Rsa;

use KaziRayhan\JWT\Signer\InvalidKeyProvided;
use KaziRayhan\JWT\Signer\Key\InMemory;
use KaziRayhan\JWT\Signer\OpenSSL;
use KaziRayhan\JWT\Signer\Rsa;
use KaziRayhan\JWT\Signer\Rsa\Sha384;
use PHPUnit\Framework\Attributes as PHPUnit;

use const OPENSSL_ALGO_SHA384;

#[PHPUnit\CoversClass(Sha384::class)]
#[PHPUnit\CoversClass(Rsa::class)]
#[PHPUnit\CoversClass(OpenSSL::class)]
#[PHPUnit\CoversClass(InvalidKeyProvided::class)]
#[PHPUnit\UsesClass(InMemory::class)]
final class Sha384Test extends RsaTestCase
{
    protected function algorithm(): Rsa
    {
        return new Sha384();
    }

    protected function algorithmId(): string
    {
        return 'RS384';
    }

    protected function signatureAlgorithm(): int
    {
        return OPENSSL_ALGO_SHA384;
    }
}

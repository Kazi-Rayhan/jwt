<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Signer\Rsa;

use KaziRayhan\JWT\Signer\InvalidKeyProvided;
use KaziRayhan\JWT\Signer\Key\InMemory;
use KaziRayhan\JWT\Signer\OpenSSL;
use KaziRayhan\JWT\Signer\Rsa;
use KaziRayhan\JWT\Signer\Rsa\Sha256;
use PHPUnit\Framework\Attributes as PHPUnit;

use const OPENSSL_ALGO_SHA256;

#[PHPUnit\CoversClass(Sha256::class)]
#[PHPUnit\CoversClass(Rsa::class)]
#[PHPUnit\CoversClass(OpenSSL::class)]
#[PHPUnit\CoversClass(InvalidKeyProvided::class)]
#[PHPUnit\UsesClass(InMemory::class)]
final class Sha256Test extends RsaTestCase
{
    protected function algorithm(): Rsa
    {
        return new Sha256();
    }

    protected function algorithmId(): string
    {
        return 'RS256';
    }

    protected function signatureAlgorithm(): int
    {
        return OPENSSL_ALGO_SHA256;
    }
}

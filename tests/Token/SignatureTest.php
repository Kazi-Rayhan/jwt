<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Token;

use KaziRayhan\JWT\Token\Signature;
use PHPUnit\Framework\Attributes as PHPUnit;
use PHPUnit\Framework\TestCase;

#[PHPUnit\CoversClass(Signature::class)]
final class SignatureTest extends TestCase
{
    #[PHPUnit\Test]
    public function hashShouldReturnTheHash(): void
    {
        $signature = new Signature('test', 'encoded');

        self::assertSame('test', $signature->hash());
        self::assertSame('encoded', $signature->toString());
    }
}

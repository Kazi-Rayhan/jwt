<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Validation\Constraint;

use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\Token\RegisteredClaims;
use KaziRayhan\JWT\Validation\Constraint\IssuedBy;
use KaziRayhan\JWT\Validation\ConstraintViolation;
use PHPUnit\Framework\Attributes as PHPUnit;

#[PHPUnit\CoversClass(ConstraintViolation::class)]
#[PHPUnit\CoversClass(IssuedBy::class)]
#[PHPUnit\UsesClass(Token\DataSet::class)]
#[PHPUnit\UsesClass(Token\Plain::class)]
#[PHPUnit\UsesClass(Token\Signature::class)]
final class IssuedByTest extends ConstraintTestCase
{
    #[PHPUnit\Test]
    public function assertShouldRaiseExceptionWhenIssuerIsNotSet(): void
    {
        $this->expectException(ConstraintViolation::class);
        $this->expectExceptionMessage('The token was not issued by the given issuers');

        $constraint = new IssuedBy('test.com', 'test.net');
        $constraint->assert($this->buildToken());
    }

    #[PHPUnit\Test]
    public function assertShouldRaiseExceptionWhenIssuerValueDoesNotMatch(): void
    {
        $this->expectException(ConstraintViolation::class);
        $this->expectExceptionMessage('The token was not issued by the given issuers');

        $constraint = new IssuedBy('test.com', 'test.net');
        $constraint->assert($this->buildToken([RegisteredClaims::ISSUER => 'example.com']));
    }

    #[PHPUnit\Test]
    public function assertShouldRaiseExceptionWhenIssuerTypeValueDoesNotMatch(): void
    {
        $this->expectException(ConstraintViolation::class);
        $this->expectExceptionMessage('The token was not issued by the given issuers');

        $constraint = new IssuedBy('test.com', '123');
        $constraint->assert($this->buildToken([RegisteredClaims::ISSUER => 123]));
    }

    #[PHPUnit\Test]
    public function assertShouldNotRaiseExceptionWhenIssuerMatches(): void
    {
        $token      = $this->buildToken([RegisteredClaims::ISSUER => 'test.com']);
        $constraint = new IssuedBy('test.com', 'test.net');

        $constraint->assert($token);
        $this->addToAssertionCount(1);
    }
}

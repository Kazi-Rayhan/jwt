<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Validation\Constraint;

use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\Token\RegisteredClaims;
use KaziRayhan\JWT\Validation\Constraint\IdentifiedBy;
use KaziRayhan\JWT\Validation\ConstraintViolation;
use PHPUnit\Framework\Attributes as PHPUnit;

#[PHPUnit\CoversClass(ConstraintViolation::class)]
#[PHPUnit\CoversClass(IdentifiedBy::class)]
#[PHPUnit\UsesClass(Token\DataSet::class)]
#[PHPUnit\UsesClass(Token\Plain::class)]
#[PHPUnit\UsesClass(Token\Signature::class)]
final class IdentifiedByTest extends ConstraintTestCase
{
    #[PHPUnit\Test]
    public function assertShouldRaiseExceptionWhenIdIsNotSet(): void
    {
        $constraint = new IdentifiedBy('123456');

        $this->expectException(ConstraintViolation::class);
        $this->expectExceptionMessage('The token is not identified with the expected ID');

        $constraint->assert($this->buildToken());
    }

    #[PHPUnit\Test]
    public function assertShouldRaiseExceptionWhenIdDoesNotMatch(): void
    {
        $constraint = new IdentifiedBy('123456');

        $this->expectException(ConstraintViolation::class);
        $this->expectExceptionMessage('The token is not identified with the expected ID');

        $constraint->assert($this->buildToken([RegisteredClaims::ID => 15]));
    }

    #[PHPUnit\Test]
    public function assertShouldNotRaiseExceptionWhenIdMatches(): void
    {
        $token = $this->buildToken([RegisteredClaims::ID => '123456']);

        $constraint = new IdentifiedBy('123456');

        $constraint->assert($token);
        $this->addToAssertionCount(1);
    }
}

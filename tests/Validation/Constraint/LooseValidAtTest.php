<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Validation\Constraint;

use DateInterval;
use KaziRayhan\Clock\Clock;
use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\Validation\Constraint;
use KaziRayhan\JWT\Validation\Constraint\LooseValidAt;
use KaziRayhan\JWT\Validation\ConstraintViolation;
use PHPUnit\Framework\Attributes as PHPUnit;

#[PHPUnit\CoversClass(Constraint\LeewayCannotBeNegative::class)]
#[PHPUnit\CoversClass(ConstraintViolation::class)]
#[PHPUnit\CoversClass(LooseValidAt::class)]
#[PHPUnit\UsesClass(Token\DataSet::class)]
#[PHPUnit\UsesClass(Token\Plain::class)]
#[PHPUnit\UsesClass(Token\Signature::class)]
final class LooseValidAtTest extends ValidAtTestCase
{
    protected function buildValidAtConstraint(Clock $clock, ?DateInterval $leeway = null): Constraint
    {
        return new LooseValidAt($clock, $leeway);
    }

    #[PHPUnit\Test]
    public function assertShouldNotRaiseExceptionWhenTokenDoesNotHaveTimeClaims(): void
    {
        $token      = $this->buildToken();
        $constraint = $this->buildValidAtConstraint($this->clock);

        $constraint->assert($token);
        $this->addToAssertionCount(1);
    }
}

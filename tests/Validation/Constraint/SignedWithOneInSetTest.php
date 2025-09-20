<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Validation\Constraint;

use DateTimeImmutable;
use KaziRayhan\Clock\FrozenClock;
use KaziRayhan\JWT\Encoding\ChainedFormatter;
use KaziRayhan\JWT\Encoding\JoseEncoder;
use KaziRayhan\JWT\Encoding\UnifyAudience;
use KaziRayhan\JWT\Encoding\UnixTimestampDates;
use KaziRayhan\JWT\JwtFacade;
use KaziRayhan\JWT\Signer\Key\InMemory;
use KaziRayhan\JWT\SodiumBase64Polyfill;
use KaziRayhan\JWT\Tests\Signer\FakeSigner;
use KaziRayhan\JWT\Token\Builder;
use KaziRayhan\JWT\Token\DataSet;
use KaziRayhan\JWT\Token\Parser;
use KaziRayhan\JWT\Token\Plain;
use KaziRayhan\JWT\Token\Signature;
use KaziRayhan\JWT\Validation\Constraint\SignedWith;
use KaziRayhan\JWT\Validation\Constraint\SignedWithOneInSet;
use KaziRayhan\JWT\Validation\Constraint\SignedWithUntilDate;
use KaziRayhan\JWT\Validation\ConstraintViolation;
use PHPUnit\Framework\Attributes as PHPUnit;

use const PHP_EOL;

#[PHPUnit\CoversClass(SignedWithOneInSet::class)]
#[PHPUnit\CoversClass(SignedWithUntilDate::class)]
#[PHPUnit\CoversClass(SignedWith::class)]
#[PHPUnit\CoversClass(ConstraintViolation::class)]
#[PHPUnit\UsesClass(InMemory::class)]
#[PHPUnit\UsesClass(JwtFacade::class)]
#[PHPUnit\UsesClass(ChainedFormatter::class)]
#[PHPUnit\UsesClass(JoseEncoder::class)]
#[PHPUnit\UsesClass(UnifyAudience::class)]
#[PHPUnit\UsesClass(UnixTimestampDates::class)]
#[PHPUnit\UsesClass(SodiumBase64Polyfill::class)]
#[PHPUnit\UsesClass(Builder::class)]
#[PHPUnit\UsesClass(DataSet::class)]
#[PHPUnit\UsesClass(Plain::class)]
#[PHPUnit\UsesClass(Signature::class)]
#[PHPUnit\UsesClass(Parser::class)]
final class SignedWithOneInSetTest extends ConstraintTestCase
{
    #[PHPUnit\Test]
    public function exceptionShouldBeRaisedWhenSignatureIsNotVerifiedByAllConstraints(): void
    {
        $clock  = new FrozenClock(new DateTimeImmutable('2023-11-19 22:20:00'));
        $signer = new FakeSigner('123');

        $constraint = new SignedWithOneInSet(
            new SignedWithUntilDate($signer, InMemory::plainText('b'), $clock->now(), $clock),
            new SignedWithUntilDate($signer, InMemory::plainText('c'), $clock->now()->modify('-2 minutes'), $clock),
        );

        $this->expectException(ConstraintViolation::class);
        $this->expectExceptionMessage(
            'It was not possible to verify the signature of the token, reasons:'
            . PHP_EOL . '- Token signature mismatch'
            . PHP_EOL . '- This constraint was only usable until 2023-11-19T22:18:00+00:00',
        );

        $token = $this->issueToken($signer, InMemory::plainText('a'));
        $constraint->assert($token);
    }

    #[PHPUnit\Test]
    public function assertShouldNotRaiseExceptionsWhenSignatureIsVerifiedByAtLeastOneConstraint(): void
    {
        $clock  = new FrozenClock(new DateTimeImmutable('2023-11-19 22:20:00'));
        $signer = new FakeSigner('123');

        $constraint = new SignedWithOneInSet(
            new SignedWithUntilDate($signer, InMemory::plainText('b'), $clock->now(), $clock),
            new SignedWithUntilDate($signer, InMemory::plainText('c'), $clock->now()->modify('-2 minutes'), $clock),
            new SignedWithUntilDate($signer, InMemory::plainText('a'), $clock->now(), $clock),
        );

        $token = $this->issueToken($signer, InMemory::plainText('a'));
        $constraint->assert($token);

        $this->addToAssertionCount(1);
    }
}

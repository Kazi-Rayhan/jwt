<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Validation\Constraint;

use Closure;
use KaziRayhan\JWT\Builder;
use KaziRayhan\JWT\JwtFacade;
use KaziRayhan\JWT\Signer;
use KaziRayhan\JWT\Token\DataSet;
use KaziRayhan\JWT\Token\Plain;
use KaziRayhan\JWT\Token\Signature;
use KaziRayhan\JWT\UnencryptedToken;
use PHPUnit\Framework\TestCase;

abstract class ConstraintTestCase extends TestCase
{
    /**
     * @param array<non-empty-string, mixed> $claims
     * @param array<non-empty-string, mixed> $headers
     */
    protected function buildToken(
        array $claims = [],
        array $headers = [],
        ?Signature $signature = null,
    ): Plain {
        return new Plain(
            new DataSet($headers, ''),
            new DataSet($claims, ''),
            $signature ?? new Signature('sig+hash', 'sig+encoded'),
        );
    }

    protected function issueToken(Signer $signer, Signer\Key $key, ?Closure $customization = null): UnencryptedToken
    {
        return (new JwtFacade())->issue(
            $signer,
            $key,
            $customization ?? static fn (Builder $builder) => $builder,
        );
    }
}

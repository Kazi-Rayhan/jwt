<?php
declare(strict_types=1);

namespace KaziRayhan\JWT;

use Closure;
use DateTimeImmutable;
use KaziRayhan\JWT\Encoding\ChainedFormatter;
use KaziRayhan\JWT\Encoding\JoseEncoder;
use KaziRayhan\JWT\Signer\Key;
use KaziRayhan\JWT\Validation\Constraint;
use KaziRayhan\JWT\Validation\SignedWith;
use KaziRayhan\JWT\Validation\ValidAt;
use KaziRayhan\JWT\Validation\Validator;
use Psr\Clock\ClockInterface as Clock;

use function assert;

final readonly class JwtFacade
{
    private Clock $clock;

    public function __construct(
        private Parser $parser = new Token\Parser(new JoseEncoder()),
        ?Clock $clock = null,
    ) {
        $this->clock = $clock ?? new class implements Clock {
            public function now(): DateTimeImmutable
            {
                return new DateTimeImmutable();
            }
        };
    }

    /** @param Closure(Builder, DateTimeImmutable):Builder $customiseBuilder */
    public function issue(
        Signer $signer,
        Key $signingKey,
        Closure $customiseBuilder,
    ): UnencryptedToken {
        $builder = Token\Builder::new(new JoseEncoder(), ChainedFormatter::withUnixTimestampDates());

        $now     = $this->clock->now();
        $builder = $builder
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+5 minutes'));

        return $customiseBuilder($builder, $now)->getToken($signer, $signingKey);
    }

    /** @param non-empty-string $jwt */
    public function parse(
        string $jwt,
        SignedWith $signedWith,
        ValidAt $validAt,
        Constraint ...$constraints,
    ): UnencryptedToken {
        $token = $this->parser->parse($jwt);
        assert($token instanceof UnencryptedToken);

        (new Validator())->assert(
            $token,
            $signedWith,
            $validAt,
            ...$constraints,
        );

        return $token;
    }
}

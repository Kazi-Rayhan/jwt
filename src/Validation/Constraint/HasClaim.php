<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Validation\Constraint;

use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\UnencryptedToken;
use KaziRayhan\JWT\Validation\Constraint;
use KaziRayhan\JWT\Validation\ConstraintViolation;

use function in_array;

final readonly class HasClaim implements Constraint
{
    /** @param non-empty-string $claim */
    public function __construct(private string $claim)
    {
        if (in_array($claim, Token\RegisteredClaims::ALL, true)) {
            throw CannotValidateARegisteredClaim::create($claim);
        }
    }

    public function assert(Token $token): void
    {
        if (! $token instanceof UnencryptedToken) {
            throw ConstraintViolation::error('You should pass a plain token', $this);
        }

        $claims = $token->claims();

        if (! $claims->has($this->claim)) {
            throw ConstraintViolation::error('The token does not have the claim "' . $this->claim . '"', $this);
        }
    }
}

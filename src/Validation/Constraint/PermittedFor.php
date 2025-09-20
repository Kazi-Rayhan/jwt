<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Validation\Constraint;

use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\Validation\Constraint;
use KaziRayhan\JWT\Validation\ConstraintViolation;

final readonly class PermittedFor implements Constraint
{
    /** @param non-empty-string $audience */
    public function __construct(private string $audience)
    {
    }

    public function assert(Token $token): void
    {
        if (! $token->isPermittedFor($this->audience)) {
            throw ConstraintViolation::error(
                'The token is not allowed to be used by this audience',
                $this,
            );
        }
    }
}

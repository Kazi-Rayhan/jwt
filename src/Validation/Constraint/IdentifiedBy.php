<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Validation\Constraint;

use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\Validation\Constraint;
use KaziRayhan\JWT\Validation\ConstraintViolation;

final readonly class IdentifiedBy implements Constraint
{
    /** @param non-empty-string $id */
    public function __construct(private string $id)
    {
    }

    public function assert(Token $token): void
    {
        if (! $token->isIdentifiedBy($this->id)) {
            throw ConstraintViolation::error(
                'The token is not identified with the expected ID',
                $this,
            );
        }
    }
}

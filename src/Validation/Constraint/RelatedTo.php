<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Validation\Constraint;

use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\Validation\Constraint;
use KaziRayhan\JWT\Validation\ConstraintViolation;

final readonly class RelatedTo implements Constraint
{
    /** @param non-empty-string $subject */
    public function __construct(private string $subject)
    {
    }

    public function assert(Token $token): void
    {
        if (! $token->isRelatedTo($this->subject)) {
            throw ConstraintViolation::error(
                'The token is not related to the expected subject',
                $this,
            );
        }
    }
}

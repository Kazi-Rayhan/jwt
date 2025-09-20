<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Validation;

use KaziRayhan\JWT\Token;

interface Constraint
{
    /** @throws ConstraintViolation */
    public function assert(Token $token): void;
}

<?php
declare(strict_types=1);

namespace KaziRayhan\JWT;

use KaziRayhan\JWT\Validation\Constraint;
use KaziRayhan\JWT\Validation\NoConstraintsGiven;
use KaziRayhan\JWT\Validation\RequiredConstraintsViolated;

interface Validator
{
    /**
     * @throws RequiredConstraintsViolated
     * @throws NoConstraintsGiven
     */
    public function assert(Token $token, Constraint ...$constraints): void;

    /** @throws NoConstraintsGiven */
    public function validate(Token $token, Constraint ...$constraints): bool;
}

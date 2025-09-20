<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Validation\Constraint;

use KaziRayhan\JWT\Signer;
use KaziRayhan\JWT\Token;
use KaziRayhan\JWT\UnencryptedToken;
use KaziRayhan\JWT\Validation\ConstraintViolation;
use KaziRayhan\JWT\Validation\SignedWith as SignedWithInterface;

final readonly class SignedWith implements SignedWithInterface
{
    public function __construct(private Signer $signer, private Signer\Key $key)
    {
    }

    public function assert(Token $token): void
    {
        if (! $token instanceof UnencryptedToken) {
            throw ConstraintViolation::error('You should pass a plain token', $this);
        }

        if ($token->headers()->get('alg') !== $this->signer->algorithmId()) {
            throw ConstraintViolation::error('Token signer mismatch', $this);
        }

        if (! $this->signer->verify($token->signature()->hash(), $token->payload(), $this->key)) {
            throw ConstraintViolation::error('Token signature mismatch', $this);
        }
    }
}

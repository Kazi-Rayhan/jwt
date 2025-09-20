<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Signer;

use InvalidArgumentException;
use KaziRayhan\JWT\Exception;

final class CannotSignPayload extends InvalidArgumentException implements Exception
{
    public static function errorHappened(string $error): self
    {
        return new self('There was an error while creating the signature:' . $error);
    }
}

<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Token;

use InvalidArgumentException;
use KaziRayhan\JWT\Exception;

final class UnsupportedHeaderFound extends InvalidArgumentException implements Exception
{
    public static function encryption(): self
    {
        return new self('Encryption is not supported yet');
    }
}

<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Encoding;

use JsonException;
use KaziRayhan\JWT\Exception;
use RuntimeException;

final class CannotEncodeContent extends RuntimeException implements Exception
{
    public static function jsonIssues(JsonException $previous): self
    {
        return new self(message: 'Error while encoding to JSON', previous: $previous);
    }
}

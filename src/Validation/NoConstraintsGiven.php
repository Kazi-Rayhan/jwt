<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Validation;

use KaziRayhan\JWT\Exception;
use RuntimeException;

final class NoConstraintsGiven extends RuntimeException implements Exception
{
}

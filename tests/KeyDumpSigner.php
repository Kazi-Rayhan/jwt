<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests;

use KaziRayhan\JWT\Signer;
use KaziRayhan\JWT\Signer\Key;

final readonly class KeyDumpSigner implements Signer
{
    public function algorithmId(): string
    {
        return 'keydump';
    }

    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function sign(string $payload, Key $key): string
    {
        return $key->contents();
    }

    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function verify(string $expected, string $payload, Key $key): bool
    {
        return $expected === $key->contents();
    }
}

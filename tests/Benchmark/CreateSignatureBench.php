<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Benchmark;

use KaziRayhan\JWT\Signer;
use KaziRayhan\JWT\Signer\Key;
use PhpBench\Attributes as Bench;

#[Bench\BeforeMethods('initialize')]
final class CreateSignatureBench extends AlgorithmsBench
{
    private Signer $algorithm;
    private Key $key;

    /** @param array{algorithm: string} $params */
    public function initialize(array $params): void
    {
        $this->algorithm = $this->resolveAlgorithm($params['algorithm']);
        $this->key       = $this->resolveSigningKey($params['algorithm']);
    }

    protected function runBenchmark(): void
    {
        $this->algorithm->sign(self::PAYLOAD, $this->key);
    }
}

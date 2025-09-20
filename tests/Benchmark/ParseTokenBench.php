<?php
declare(strict_types=1);

namespace KaziRayhan\JWT\Tests\Benchmark;

use KaziRayhan\Clock\SystemClock;
use KaziRayhan\JWT\Builder;
use KaziRayhan\JWT\JwtFacade;
use KaziRayhan\JWT\Signer;
use KaziRayhan\JWT\Signer\Key;
use KaziRayhan\JWT\Validation\Constraint;
use PhpBench\Attributes as Bench;

#[Bench\BeforeMethods('initialize')]
final class ParseTokenBench extends AlgorithmsBench
{
    private Signer $algorithm;
    private Key $key;
    /** @var non-empty-string */
    private string $jwt;

    /** @param array{algorithm: string} $params */
    public function initialize(array $params): void
    {
        $this->algorithm = $this->resolveAlgorithm($params['algorithm']);
        $this->key       = $this->resolveVerificationKey($params['algorithm']);

        $this->jwt = (new JwtFacade())->issue(
            $this->algorithm,
            $this->resolveSigningKey($params['algorithm']),
            static fn (Builder $builder): Builder => $builder
                ->identifiedBy('token-1')
                ->issuedBy('KaziRayhan.jwt.benchmarks')
                ->relatedTo('user-1')
                ->permittedFor('KaziRayhan.jwt'),
        )->toString();
    }

    protected function runBenchmark(): void
    {
        (new JwtFacade())->parse(
            $this->jwt,
            new Constraint\SignedWith($this->algorithm, $this->key),
            new Constraint\StrictValidAt(SystemClock::fromSystemTimezone()),
            new Constraint\IssuedBy('KaziRayhan.jwt.benchmarks'),
            new Constraint\RelatedTo('user-1'),
            new Constraint\PermittedFor('KaziRayhan.jwt'),
            new Constraint\IdentifiedBy('token-1'),
        );
    }
}

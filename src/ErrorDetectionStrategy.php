<?php

declare(strict_types=1);

namespace YucaDoo\BgyNeighborhoodsDiagnostic;

use Bgy\TransientFaultHandling\ErrorDetectionStrategy as BgyErrorDetectionStrategy;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Throwable;

class ErrorDetectionStrategy implements BgyErrorDetectionStrategy
{
    use ThrowableDiagnostic\Builder\Factory\AwareTrait;

    public function isTransient(Throwable $throwable): bool
    {
        try {
            $this->getThrowableDiagnosticBuilderFactory()
                ->create()
                ->build()
                ->diagnose($throwable);
        } catch (DiagnosedInterface $diagnosed) {
            return $diagnosed->isTransient();
        }
        return false;
    }
}

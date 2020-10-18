<?php

declare(strict_types=1);

namespace YucaDoo\BgyNeighborhoodsDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Throwable;

class ErrorDetectionStrategyTest extends \PHPUnit\Framework\TestCase
{
    private $strategy;
    private $throwableDiagnosticMock;

    public function setUp(): void
    {
        $this->strategy = new ErrorDetectionStrategy();
        $this->throwableDiagnosticMock = $this->createMock(ThrowableDiagnosticInterface::class);

        // Inject mocked throwable diagnostics using mocked builder factory
        $throwableDiagnosticBuilderMock = $this->createMock(ThrowableDiagnostic\BuilderInterface::class);
        $throwableDiagnosticBuilderMock->expects($this->atLeastOnce())
            ->method('build')
            ->willReturn($this->throwableDiagnosticMock);
        $throwableDiagnosticBuilderFactoryMock = $this->createMock(ThrowableDiagnostic\Builder\FactoryInterface::class);
        $throwableDiagnosticBuilderFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($throwableDiagnosticBuilderMock);
        $this->strategy->setThrowableDiagnosticBuilderFactory($throwableDiagnosticBuilderFactoryMock);
    }

    /**
     * @dataProvider getTransiency
     */
    public function testDetectsDiagnosedTransiency(bool $transiency)
    {
        $analysedThrowable = $this->createMock(Throwable::class);

        $diagnosisMock = $this->createMock(DiagnosedInterface::class);
        $diagnosisMock->expects($this->atLeastOnce())
            ->method('isTransient')
            ->willReturn($transiency);

        $this->throwableDiagnosticMock
            ->expects($this->atLeastOnce())
            ->method('diagnose')
            ->with($analysedThrowable)
            ->willThrowException($diagnosisMock);

        $detectedTransiency = $this->strategy->isTransient($analysedThrowable);
        $this->assertEquals($transiency, $detectedTransiency);
    }

    public function getTransiency()
    {
        return [
            [true],
            [false],
        ];
    }
}

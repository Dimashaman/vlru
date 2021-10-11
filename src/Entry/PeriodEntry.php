<?php
namespace Dima\Vlrutest\Entry;

use Dima\Vlrutest\Contract\CustomLogEntryInterface;

class PeriodEntry
{
    private string $start;
    private ?string $end;
    private ?float $availability;
    private int $allEntriesCounter;
    private int $failuresCounter;
    private CustomLogEntryInterface $lastFailure;
    private float $lastFailureAvailability;

    public function __construct(CustomLogEntryInterface $logEntry)
    {
        $this->start = $logEntry->getTimestamp();
        $this->end = null;
        $this->availability = null;
        $this->allEntriesCounter = 0;
        $this->failuresCounter = 0;
        $this->lastFailure = $logEntry;
        $this->lastFailureAvailability = 0;
    }

    public function getStart() : string
    {
        return $this->start;
    }

    public function setStart(string $start): PeriodEntry
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?string
    {
        return $this->end;
    }

    public function setEnd(string $end): PeriodEntry
    {
        $this->end = $end;

        return $this;
    }

    public function getAvailability(): ?float
    {
        return $this->availability;
    }

    public function setAvailability(float $availability) : PeriodEntry
    {
        $this->availability = $availability;

        return $this;
    }

    public function getAllEntriesCounter(): int
    {
        return $this->allEntriesCounter;
    }

    public function incrementAllEntriesCounter(): self
    {
        ++$this->allEntriesCounter;

        return $this;
    }

    public function getFailuresCounter(): int
    {
        return $this->failuresCounter;
    }

    public function incrementFailuresCounter(): self
    {
        ++$this->failuresCounter;

        return $this;
    }

    public function updateLastFailure(LogEntry $failureEntry): self
    {
        $this->lastFailure = $failureEntry;
        $this->lastFailureAvailability = $this->calculateAvailability();

        return $this;
    }

    public function calculateAvailability(): float
    {
        return (1 - $this->failuresCounter / $this->allEntriesCounter) * 100;
    }

    public function stop(): self
    {
        $this->setEnd($this->lastFailure->getTimestamp());
        $this->setAvailability($this->lastFailureAvailability);

        return $this;
    }
}

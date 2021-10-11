<?php

namespace Dima\Vlrutest\Service;

use Dima\Vlrutest\Contract\CustomLogEntryInterface;
use Dima\Vlrutest\Entry\LogEntry;
use Dima\Vlrutest\Entry\PeriodEntry;
use Kassner\LogParser\LogParser;
use Kassner\LogParser\LogParser as KassnerLogParser;

class LogAnalyzer
{
    private KassnerLogParser $parser;
    private ?PeriodEntry $currentUnavailabilityPeriod;
    private float $acceptedResponseTime;

    public function __construct(LogParser $parser) 
    {
        $this->parser = $parser;
        $this->currentUnavailabilityPeriod = null;
        $this->acceptedResponseTime = 0;
    }

    /**
     * @param resource $logFileHandler
     * @param float $acceptedAvailabilityPercentage
     * @param float $acceptedResponseTime
     * @return PeriodEntry[]
     * @throws \Kassner\LogParser\FormatException
     */
    public function parse($logFileHandler, float $acceptedAvailabilityPercentage, float $acceptedResponseTime) : array
    {
        $this->currentUnavailabilityPeriod = null;
        $this->acceptedResponseTime = $acceptedResponseTime;

        $unavailabilityPeriods = [];
        while (($line = fgets($logFileHandler)) !== false) {
            /** @var LogEntry $entry */
            $entry = $this->parser->parse(trim($line));

            $currentUnavailabilityPeriod = $this->detectCurrentUnavailabilityPeriod($entry);
            if (!$currentUnavailabilityPeriod) {
                continue;
            }

            $currentUnavailabilityPeriod->incrementAllEntriesCounter();

            if ($this->isEntryAboutFailure($entry)) {
                $currentUnavailabilityPeriod->incrementFailuresCounter();
                $currentUnavailabilityPeriod->updateLastFailure($entry);
            }

            if ($currentUnavailabilityPeriod->calculateAvailability() >= $acceptedAvailabilityPercentage) {
                $currentUnavailabilityPeriod->stop();
                $unavailabilityPeriods[] = $currentUnavailabilityPeriod;
                $this->currentUnavailabilityPeriod = null;
            }
        }

        if (!is_null($this->currentUnavailabilityPeriod)) {
            $this->currentUnavailabilityPeriod->stop();
            $unavailabilityPeriods[] = $this->currentUnavailabilityPeriod;
        }

        return $unavailabilityPeriods;
    }

    private function detectCurrentUnavailabilityPeriod(LogEntry $entry): ?PeriodEntry
    {
        if (!$this->currentUnavailabilityPeriod && $this->isEntryAboutFailure($entry)) {
            $this->currentUnavailabilityPeriod = $this->startNewUnavailabilityPeriod($entry);
        }

        return $this->currentUnavailabilityPeriod;
    }

    private function isEntryAboutFailure(CustomLogEntryInterface $entry): bool
    {
        $httpStatus = (int) $entry->getStatus();

        return ($httpStatus >= 500 && $httpStatus < 600)
            || $entry->getTimeServeRequest() > $this->acceptedResponseTime;
    }

    private function startNewUnavailabilityPeriod(CustomLogEntryInterface $entry): PeriodEntry
    {
        return new PeriodEntry($entry);
    }
}

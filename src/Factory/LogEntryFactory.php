<?php

namespace Dima\Vlrutest\Factory;

use Dima\Vlrutest\Entry\LogEntry;
use Kassner\LogParser\LogEntryFactoryInterface;
use Dima\Vlrutest\Contract\CustomLogEntryInterface;

class LogEntryFactory implements LogEntryFactoryInterface
{
    /**
     * @param string[] $data
     */
    public function create(array $data): CustomLogEntryInterface
    {
        $entry = new LogEntry(
            $data['host'],
            $data['timestamp'],
            $data['request'],
            $data['status'],
            $data['timeServeRequest'],
            $data['serviceName']
        );

        return $entry;
    }
}

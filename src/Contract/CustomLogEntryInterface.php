<?php
namespace Dima\Vlrutest\Contract;

use Kassner\LogParser\LogEntryInterface;

interface CustomLogEntryInterface extends LogEntryInterface
{
    /**
     * Get the value of host
     */
    public function getHost() : string;


    /**
     * Get the value of timestamp
     */
    public function getTimestamp() : string;

    /**
     * Get the value of request
     */
    public function getRequest() : string;

    /**
     * Get the value of status
     */
    public function getStatus() : string;


    /**
     * Get the value of timeServeRequest
     */
    public function getTimeServeRequest() : string;


    /**
     * Get the value of serviceName
     */
    public function getServiceName() : string;
}

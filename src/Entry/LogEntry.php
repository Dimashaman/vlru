<?php

namespace Dima\Vlrutest\Entry;

use Dima\Vlrutest\Contract\CustomLogEntryInterface;

class LogEntry implements CustomLogEntryInterface
{
    private string $host;
    private string $timestamp;
    private string $request;
    private string $status;
    private string $timeServeRequest;
    private string $serviceName;

    public function __construct(string $host, string $timestamp, string $request, string $status, string $timeServeRequest, string $serviceName)
    {
        $this->host = $host;
        $this->timestamp = $timestamp;
        $this->request = $request;
        $this->status = $status;
        $this->timeServeRequest = $timeServeRequest;
        $this->serviceName = $serviceName;
    }

    /**
     * Get the value of host
     */ 
    public function getHost() : string
    {
        return $this->host;
    }

    /**
     * Get the value of timestamp
     */ 
    public function getTimestamp() : string
    {
        return $this->timestamp;
    }

    /**
     * Get the value of request
     */ 
    public function getRequest() : string
    {
        return $this->request;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Get the value of timeServeRequest
     */ 
    public function getTimeServeRequest() : string
    {
        return $this->timeServeRequest;
    }

    /**
     * Get the value of serviceName
     */ 
    public function getServiceName() : string
    {
        return $this->serviceName;
    }
}

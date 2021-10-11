<?php
namespace Dima\Vlrutest\Format;

use Dima\Vlrutest\Contract\CustomFormatInterface;
use Kassner\LogParser\LogParser;

class CustomFormat implements CustomFormatInterface
{
    public function addFormat(LogParser $logParser): LogParser
    {
        $logParser->addPattern('%t', "(?P<timestamp>\[[0-3][0-9]\/(1[0-2]|0[1-9])\/20[0-9]{2}:[0-9]{2}:[0-9]{2}:[0-9]{2} \+\d{4}\])");
        $logParser->addPattern('%M', "(?P<timeServeRequest>[0-9]{2}.[0-9]{6})");
        $logParser->addPattern('%P', "(?P<serviceName>@.+)");
        $logParser->setFormat('%h - - %t "%r" %>s 2 %M "-" "%P" prio:0');

        return $logParser;
    }
}

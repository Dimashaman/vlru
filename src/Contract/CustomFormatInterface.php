<?php
namespace Dima\Vlrutest\Contract;

use Kassner\LogParser\LogParser;

interface CustomFormatInterface
{
    public function addFormat(LogParser $logParser) : LogParser;
}

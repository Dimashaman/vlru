<?php

namespace Dima\Vlrutest\Factory;

use Dima\Vlrutest\Format\CustomFormat;
use Kassner\LogParser\LogParser as KassnerLogParser;

class LogParserFactory
{
    // can be made to create differnet types of parsers
    public function create(): KassnerLogParser
    {
        $logEntryFactory = new LogEntryFactory();
        $formatter = new CustomFormat();
        $parser = new KassnerLogParser(null, $logEntryFactory);
        $parser = $formatter->addFormat($parser);

        return $parser;
    }
}

<?php

use CliArgs\CliArgs;
use Dima\Vlrutest\Factory\LogParserFactory;
use Dima\Vlrutest\Service\LogAnalyzer;

require_once 'vendor/autoload.php';

$cliConfig = [
    'accessibility' => 'u',
    'acceptedResponseTime' => 't',
];

$cliArgs = new CliArgs($cliConfig);

$logParserFactory = new LogParserFactory();
$logParser = $logParserFactory->create();
$logAnalyzer = new LogAnalyzer($logParser);
$periodEntries = $logAnalyzer->parse(STDIN, $cliArgs->getArg('u'), $cliArgs->getArg('t'));


foreach($periodEntries as $period) {
    echo (sprintf("%s %s %.2F %s", $period->getStart(), $period->getEnd(), $period->getAvailability(), PHP_EOL));
}
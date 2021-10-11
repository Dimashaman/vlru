<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Dima\Vlrutest\Service\LogAnalyzer;
use Dima\Vlrutest\Factory\LogParserFactory;

class LogAnalyzerTest extends TestCase
{
    /**
     * @dataProvider getTestLogs
     *
     * @param [type] $log
     * @return void
     */
    public function testLogAnalyzerReturnsArrayOfUnavailabilityPeriods($log, $expectedOutput)
    {
        $logParserFactory = new LogParserFactory();
        $logParser = $logParserFactory->create();
        $logAnalyzer = new LogAnalyzer($logParser);
        $periodEntries = $logAnalyzer->parse($log, '95', '45');


        foreach ($periodEntries as $period) {
            echo(sprintf("%s %s %.2F%s", $period->getStart(), $period->getEnd(), $period->getAvailability(), PHP_EOL));
        }
        $this->expectOutputString($expectedOutput);
    }

    public function getTestLogs()
    {
        return [
            ['OnePeriodTest' => fopen('test/OnePeriodTest.log', 'r'), '[01/06/2017:16:47:02 +1000] [02/07/2017:23:47:02 +1000] 72.73' . PHP_EOL],
            ['ThreePeriodsTest' =>
            fopen('test/ThreeDistinctPeriods.log', 'r'),
            '[04/06/2017:19:47:02 +1000] [04/06/2017:19:47:02 +1000] 81.82' . PHP_EOL .
            '[25/06/2017:23:47:02 +1000] [04/06/2017:19:47:02 +1000] 86.67' . PHP_EOL .
            '[02/07/2017:23:47:02 +1000] [04/06/2017:19:47:02 +1000] 71.43' . PHP_EOL
            ],
            ['NoPeriods' => fopen('test/NoErrors.log', 'r'), '']
        ];
    }
}

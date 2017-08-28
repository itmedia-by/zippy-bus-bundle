<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Tests\Schedule;

use Itmedia\ZippyBusBundle\Schedule\StopTime;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{


    /**
     * @dataProvider dataProvide
     * @param $minutes
     * @param $h
     * @param $m
     */
    public function testFormat(int $minutes, int $h, int $m)
    {
        $time = new StopTime($minutes);

        $this->assertEquals($h, $time->getHour());
        $this->assertEquals($m, $time->getMinute());
    }


    public function dataProvide()
    {
        return [
            [1, 0, 1],
            [376, 6, 16],
            [399, 6, 39],
            [1440, 0, 0],
            [1511, 1, 11],
        ];
    }


    public function testSub()
    {
        $time = new StopTime(1511);
        $this->assertEquals(1, $time->getHour());
        $this->assertEquals(11, $time->getMinute());

        $time = $time->sub(new StopTime(2));
        $this->assertEquals(1, $time->getHour());
        $this->assertEquals(9, $time->getMinute());

        $time = $time->sub(new StopTime(70));
        $this->assertEquals(23, $time->getHour());
        $this->assertEquals(59, $time->getMinute());
    }


}
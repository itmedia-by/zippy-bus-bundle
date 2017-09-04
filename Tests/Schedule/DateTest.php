<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Tests\Schedule;

use Itmedia\ZippyBusBundle\Schedule\ScheduleDate;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     *
     * @param string $dateString
     * @param int $day
     */
    public function testGetWeekDay(string $dateString, int $day)
    {
        $date = new ScheduleDate(new \DateTimeImmutable($dateString));
        $this->assertEquals($day, $date->getWeekDay());
    }


    public function dataProvider()
    {
        return [
            ['28.08.2017 12:00', 1],
            ['28.08.2017 1:00', 7],
            ['28.08.2017 3:35', 7],
            ['27.08.2017 4:35', 7],
            ['29.08.2017 1:35', 1],
            ['29.08.2017 12:35', 2],
        ];
    }


    public function testCreateNow()
    {
        $date = ScheduleDate::createNow();
        $actualDayNumber = (int)date('N');
        if (date('H') < 4) {
            $actualDayNumber = $actualDayNumber === 1 ? 7 : $actualDayNumber - 1;
        }

        $this->assertEquals($actualDayNumber, $date->getWeekDay());
    }


    public function testCreateWeekend()
    {
        $date = ScheduleDate::createWeekend();
        $this->assertEquals(7, $date->getWeekDay());
        $this->assertTrue($date->isWeekend());
    }


    public function testCreateWorkday()
    {
        $date = ScheduleDate::createWorkday();
        $this->assertFalse($date->isWeekend());
    }
}

<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Tests\Schedule;

use Itmedia\ZippyBusBundle\Schedule\Date;
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
        $date = new Date(new \DateTimeImmutable($dateString));
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
}

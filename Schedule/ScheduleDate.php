<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

/**
 * Актальная дата для расписания
 */
class ScheduleDate
{

    /**
     * @var \DateTimeImmutable
     */
    private $datetime;

    const WORKDAY = 'workday';

    const WEEKEND = 'weekend';

    /**
     * Date constructor.
     * @param \DateTimeImmutable $datetime
     */
    public function __construct(\DateTimeImmutable $datetime)
    {
        $this->datetime = $datetime;
    }


    public static function createNow(): ScheduleDate
    {
        return new ScheduleDate(new \DateTimeImmutable('now'));
    }


    public static function createWeekend(): ScheduleDate
    {
        $datetime = new \DateTimeImmutable('now');
        $day = (int)$datetime->format('N');

        if ($day !== 7) {
            $datetime = $datetime->add(
                new \DateInterval(
                    sprintf('P%sD', 7 - $day)
                ));
        }
        return new ScheduleDate($datetime);
    }


    public static function createWorkday(): ScheduleDate
    {
        $datetime = new \DateTimeImmutable('now');
        $day = (int)$datetime->format('N');

        if ($day > 5) {
            $datetime = $datetime->sub(
                new \DateInterval(
                    sprintf('P2D')
                ));
        }
        return new ScheduleDate($datetime);
    }


    /**
     * День недели
     * @return int
     */
    public function getWeekDay(): int
    {
        $day = (int)$this->datetime->format('N');

        if ((int)$this->datetime->format('H') < 4) {
            $day = $day === 1 ? 7 : $day - 1;
        }

        return $day;
    }


    public function getTypeDay(): string
    {
        return in_array($this->getWeekDay(), [6, 7], true) ? self::WEEKEND : self::WORKDAY;
    }
}

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


    /**
     * Date constructor.
     * @param \DateTimeImmutable $datetime
     */
    public function __construct(\DateTimeImmutable $datetime)
    {
        $this->datetime = $datetime;
    }


    /**
     * Текущая дата
     * @return ScheduleDate
     */
    public static function createNow(): ScheduleDate
    {
        return new self(new \DateTimeImmutable('now'));
    }


    /**
     * Выходной день
     * @return ScheduleDate
     * @throws \Exception
     */
    public static function createWeekend(): ScheduleDate
    {
        $datetime = new \DateTimeImmutable('now');
        $day = self::parseDayNumber($datetime);

        if ($day !== 7) {
            $datetime = $datetime->add(
                new \DateInterval(
                    sprintf('P%sD', 7 - $day)
                ));
        }
        return new self($datetime);
    }


    /**
     * Рабочий день
     *
     * @return ScheduleDate
     * @throws \Exception
     */
    public static function createWorkday(): ScheduleDate
    {
        $datetime = new \DateTimeImmutable('now');
        $day = self::parseDayNumber($datetime);

        if ($day > 5) {
            $datetime = $datetime->sub(
                new \DateInterval(
                    sprintf('P2D')
                ));
        }
        return new self($datetime);
    }


    /**
     * День недели
     * @return int
     */
    public function getWeekDay(): int
    {
        return self::parseDayNumber($this->datetime);
    }


    /**
     * Выходной день?
     * @return boolean
     */
    public function isWeekend(): bool
    {
        return in_array($this->getWeekDay(), [6, 7], true);
    }


    /**
     * Определить день недели (для расписания)
     * @param \DateTimeImmutable $datetime
     * @return int
     */
    private static function parseDayNumber(\DateTimeImmutable $datetime): int
    {
        $day = (int)$datetime->format('N');
        if ((int)$datetime->format('H') < 4) {
            $day = $day === 1 ? 7 : $day - 1;
        }
        return $day;
    }

}

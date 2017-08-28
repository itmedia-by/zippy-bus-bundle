<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

/**
 * Актальная дата для расписания
 */
class Date
{

    /**
     * @var \DateTimeImmutable
     */
    private $datetime;

    /**
     * Date constructor.
     * @param \DateTimeImmutable $datetime
     */
    public function __construct(?\DateTimeImmutable $datetime = null)
    {
        if ($datetime === null) {
            $datetime = new \DateTimeImmutable('now');
        }

        $this->datetime = $datetime;
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

}
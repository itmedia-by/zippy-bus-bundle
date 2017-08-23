<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

class Time
{

    /**
     * @var int
     */
    private $time;


    public function __construct(int $time)
    {
        $this->time = $time;
    }


    public static function createNow(): Time
    {
        $date = new \DateTime();
        $hour = (int)$date->format('h');
        $hour = $hour > 3 ?: $hour + 24;
        $minute = (int)$date->format('i');
        return new self($hour * 60 + $minute);
    }


    public function sub(Time $time): Time
    {
        $newTime = $this->time - $time->time;
        return new self($newTime);
    }


    public function getHour(): int
    {
        $hour = (int)floor($this->time / 60);
        return ($hour >= 24) ? $hour - 24 : $hour;
    }


    public function getMinute(): int
    {
        return $this->time % 60;
    }


}
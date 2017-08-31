<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

class StopTime
{

    /**
     * Расписание представлено списком минут, например, 376, 399, 1511,
     * что соответствует времени 6:16, 6:39 и 25:11.
     * Из-за того, что транспорт курсирует в том числе и после полуночи,
     * количество часов в сутках в нашей системе может быть больше 24.
     * Это сделано для того, чтобы мы могли различать рейсы,
     * которые работают рано утром и после полуночи.
     * Таким образом, время 25:11 - это 1:11 утра (25-24=1).
     *
     * @var int
     */
    private $time;

    /**
     * Неполный маршрут
     * @var bool
     */
    private $short;

    /**
     * Заметка
     * @var string
     */
    private $note;


    public function __construct(int $time, bool $short = false, string $note = '')
    {
        $this->time = $time;
        $this->short = $short;
        $this->note = $note;
    }


    public static function createNow(): StopTime
    {
        $date = new \DateTime();
        $hour = (int)$date->format('H');
        $hour = $hour > 3 ? $hour : $hour + 24;
        $minute = (int)$date->format('i');
        return new self($hour * 60 + $minute);
    }


    public function sub(StopTime $time): StopTime
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

    public function isShort(): bool
    {
        return $this->short;
    }


    public function getTimeFormat(): string
    {
        return sprintf('%s:%s',
            $this->getHour(),
            $this->getMinute() < 10 ? '0' . $this->getMinute() : $this->getMinute()
        );
    }

    /**
     * Время в минутах
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    public function getNote(): string
    {
        return $this->note;
    }
}

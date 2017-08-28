<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

/**
 * Остановка
 */
class Stop implements SlugAware
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var StopTime[]
     */
    private $times = [];

    /**
     * Stop constructor.
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param StopTime[] $times
     */
    public function __construct(int $id, string $name, string $slug, array $times)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->times = $times;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return StopTime[]
     */
    public function getTimes(): array
    {
        return $this->times;
    }


    public function getNearStopTime(StopTime $currentTime): ?StopTime
    {
        foreach ($this->times as $time) {
            if ($currentTime->getTime() < $time->getTime()) {
                return $time;
            }
        }

        return null;
    }
}

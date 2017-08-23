<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

/**
 * Остановка
 */
class Stop
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
     * @var Time[]
     */
    private $times = [];

    /**
     * Stop constructor.
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param Time[] $times
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
     * @return Time[]
     */
    public function getTimes(): array
    {
        return $this->times;
    }


}
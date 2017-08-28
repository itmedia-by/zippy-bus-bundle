<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

class Direction
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $name;


    /**
     * @var array
     */
    private $days;

    /**
     * Direction constructor.
     * @param int $id
     * @param string $slug
     * @param string $name
     * @param array $days
     */
    public function __construct(int $id, string $name, string $slug, array $days)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->name = $name;
        $this->days = $days;
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
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getDays(): array
    {
        return $this->days;
    }
}

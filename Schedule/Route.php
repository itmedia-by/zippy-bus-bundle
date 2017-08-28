<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

class Route implements SlugAware
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
     * @var int
     */
    private $version;

    /**
     * @var Direction[]
     */
    private $directions = [];

    /**
     * Route constructor.
     * @param int $id
     * @param string $slug
     * @param string $name
     * @param int $version
     * @param Direction[] $directions
     */
    public function __construct(int $id, string $slug, string $name, int $version, array $directions)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->name = $name;
        $this->version = $version;
        $this->directions = $directions;
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
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @return Direction[]
     */
    public function getDirections(): array
    {
        return $this->directions;
    }
}

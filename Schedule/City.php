<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

class City
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
     * @var int
     */
    private $version;

    /**
     * City constructor.
     * @param int $id
     * @param string $name
     * @param int $version
     */
    public function __construct(int $id, string $name, int $version)
    {
        $this->id = $id;
        $this->name = $name;
        $this->version = $version;
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
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }
}

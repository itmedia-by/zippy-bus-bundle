<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Schedule;

interface SlugAware
{
    public function getSlug(): string;
}
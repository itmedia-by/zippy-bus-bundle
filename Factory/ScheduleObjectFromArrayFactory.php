<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Factory;

use Itmedia\ZippyBusBundle\Schedule\City;
use Itmedia\ZippyBusBundle\Schedule\Date;
use Itmedia\ZippyBusBundle\Schedule\Direction;
use Itmedia\ZippyBusBundle\Schedule\Route;
use Itmedia\ZippyBusBundle\Schedule\Stop;
use Itmedia\ZippyBusBundle\Schedule\StopTime;

class ScheduleObjectFromArrayFactory
{
    public function createCity(array $array): City
    {
        $version = 0;
        if (isset($array['currentVersions'][0])) {
            $version = (int)$array['currentVersions'][0]['id'];
        }

        return new City(
            (int)$array['id'],
            (string)$array['name'], $version
        );
    }


    public function createRoute(array $array, Date $date): Route
    {
        $directions = [];
        foreach ($array['directions'] ?? [] as $directionArray) {
            $direction = new Direction(
                (int)$directionArray['id'],
                (string)$directionArray['name'],
                (string)$directionArray['techName'],
                $directionArray['days']
            );

            if (in_array($date->getWeekDay(), $direction->getDays(), true)) {
                $directions[] = $direction;
            }
        }

        return new Route(
            (int)$array['id'],
            (string)$array['uniqueTechName'],
            (string)$array['name'],
            (int)$array['versionId'],
            $directions
        );
    }


    public function createStop(array $array): Stop
    {
        $times = [];
        foreach ($array['schedule']['minutes'] ?? [] as $minute) {
            $times[] = new StopTime((int)$minute);
        }

        return new Stop(
            (int)$array['id'],
            (string)$array['name'],
            (string)$array['uniqueTechName'],
            $times
        );
    }
}

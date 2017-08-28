<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle;

use Itmedia\ZippyBusBundle\Client\ZippyBusClient;
use Itmedia\ZippyBusBundle\Factory\ScheduleObjectFromArrayFactory;
use Itmedia\ZippyBusBundle\Schedule\City;
use Itmedia\ZippyBusBundle\Schedule\Date;
use Itmedia\ZippyBusBundle\Schedule\Direction;
use Itmedia\ZippyBusBundle\Schedule\Route;
use Itmedia\ZippyBusBundle\Schedule\Stop;

class ZippyBusProvider
{

    /**
     * @var ZippyBusClient
     */
    private $client;

    /**
     * @var ScheduleObjectFromArrayFactory
     */
    private $factory;


    public function __construct(ZippyBusClient $client, ScheduleObjectFromArrayFactory $factory)
    {
        $this->client = $client;
        $this->factory = $factory;
    }


    public function getCity(int $id): City
    {
        $content = $this->client->get('cities/{id}?include=currentVersions', [
            'id' => (string)$id
        ]);

        return $this->factory->createCity($content);
    }


    /**
     * @param City $city
     * @param Date $date
     * @return Route[]
     */
    public function getRoutes(City $city, Date $date): array
    {
        $content = $this->client->get('routes', [], [
            'versionId' => $city->getVersion(),
            'include' => 'directions'
        ]);

        $routes = [];
        foreach ($content['list'] ?? [] as $routeArray) {
            $routes[] = $this->factory->createRoute($routeArray, $date);
        }

        return $routes;
    }


    /**
     * @param Direction $direction
     * @return Stop[]
     */
    public function getDirectionStops(Direction $direction): array
    {
        $content = $this->client->get('stops', [], [
            'directionId' => $direction->getId(),
            'include' => 'schedule',
            'scheduleInclude' => 'partialMinutes'
        ]);


        $stops = [];
        foreach ($content['list'] ?? [] as $stopArray) {
            $stops[] = $this->factory->createStop($stopArray);
        }


        return $stops;
    }
}

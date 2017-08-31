<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle;

use Itmedia\ZippyBusBundle\Client\ZippyBusClient;
use Itmedia\ZippyBusBundle\Factory\ScheduleObjectFromArrayFactory;
use Itmedia\ZippyBusBundle\Schedule\City;
use Itmedia\ZippyBusBundle\Schedule\ScheduleDate;
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
     * @param ScheduleDate $date
     * @return Route[]
     */
    public function getRoutes(City $city, ScheduleDate $date): array
    {

        $content = $this->client->get('routes', [], [
            'query' => [
                'versionId' => $city->getVersion(),
                'include' => 'directions'
            ]
        ]);

        $routes = [];
        foreach ($content['list'] ?? [] as $routeArray) {
            $routes[] = $this->factory->createRoute($routeArray, $date);
        }

        usort($routes, function (Route $routeA, Route $routeB) {
            return strnatcmp($routeA->getName(), $routeB->getName());
        });

        return $routes;
    }


    /**
     * @param Direction $direction
     * @return Stop[]
     */
    public function getDirectionStops(Direction $direction): array
    {
        $content = $this->client->get('stops', [], [
            'query' => [
                'directionId' => $direction->getId(),
                'include' => 'schedule',
                'scheduleInclude' => 'partialMinutes'
            ]
        ]);


        $stops = [];
        foreach ($content['list'] ?? [] as $stopArray) {
            $stops[] = $this->factory->createStop($stopArray);
        }


        return $stops;
    }
}

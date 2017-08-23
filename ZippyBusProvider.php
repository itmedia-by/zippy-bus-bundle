<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle;

use Itmedia\ZippyBusBundle\Client\ZippyBusClient;
use Itmedia\ZippyBusBundle\Schedule\City;
use Itmedia\ZippyBusBundle\Schedule\Direction;
use Itmedia\ZippyBusBundle\Schedule\Route;
use Itmedia\ZippyBusBundle\Schedule\Stop;
use Itmedia\ZippyBusBundle\Schedule\Time;

class ZippyBusProvider
{

    /**
     * @var ZippyBusClient
     */
    private $client;

    /**
     * ZippyBusProvider constructor.
     * @param ZippyBusClient $client
     */
    public function __construct(ZippyBusClient $client)
    {
        $this->client = $client;
    }


    public function getCity(int $id): City
    {
        $content = $this->client->get('cities/{id}?include=currentVersions', [
            'id' => (string)$id
        ]);

        $version = 0;
        if (isset($content['currentVersions'][0])) {
            $version = (int)$content['currentVersions'][0]['id'];
        }

        return new City((int)$content['id'], (string)$content['name'], $version);
    }


    /**
     * @param City $city
     * @return Route[]
     */
    public function getRoutes(City $city, int $dayNumber): array
    {
        $content = $this->client->get('routes', [], [
            'versionId' => $city->getVersion(),
            'include' => 'directions'
        ]);

        $routes = [];

        foreach ($content['list'] as $routeArray) {
            $directions = [];
            foreach ($routeArray['directions'] as $directionArray) {
                $direction = new Direction(
                    (int)$directionArray['id'],
                    (string)$directionArray['name'],
                    (string)$directionArray['techName'],
                    $directionArray['days']
                );

                if (in_array($dayNumber, $direction->getDays(), true)) {
                    $directions[] = $direction;
                }
            }

            $route = new Route(
                (int)$routeArray['id'],
                (string)$routeArray['uniqueTechName'],
                (string)$routeArray['name'],
                (int)$routeArray['versionId'],
                $directions
            );

            $routes[] = $route;
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
        foreach ($content['list'] as $stopArray) {

            $times = [];
            foreach ($stopArray['schedule']['minutes'] as $minute) {
                $times[] = new Time((int)$minute);
            }

            $stop = new Stop(
                (int)$stopArray['id'],
                (string)$stopArray['name'],
                (string)$stopArray['uniqueTechName'],
                $times
            );

            $stops[] = $stop;
        }

        return $stops;
    }


}
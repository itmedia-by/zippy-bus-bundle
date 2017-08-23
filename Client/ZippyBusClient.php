<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Client;

use GuzzleHttp\Client;
use Psr\SimpleCache\CacheInterface;

class ZippyBusClient
{

    /**
     * @var string
     */
    private $apiUrl = 'https://zippybus.com/api/v1/';

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * ZippyBusClient constructor.
     * @param string $token
     * @param CacheInterface $cache
     */
    public function __construct(string $token, CacheInterface $cache = null)
    {
        $this->cache = $cache;

        $this->httpClient = new Client([
            'base_uri' => $this->apiUrl,
            'timeout' => 5,
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $token)
            ]
        ]);
    }


    public function get(string $path, array $params = [], array $options = []): array
    {
        $client = $this->httpClient;

        foreach ($params as $param => $value) {
            $path = str_replace('{' . $param . '}', $value, $path);
        }

        $response = $client->get($path, $options);
        return \GuzzleHttp\json_decode((string)$response->getBody(), true);
    }


}
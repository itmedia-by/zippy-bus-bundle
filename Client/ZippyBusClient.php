<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Itmedia\ZippyBusBundle\Exception\HttpBadRequestException;
use Itmedia\ZippyBusBundle\Exception\HttpForbiddenException;
use Itmedia\ZippyBusBundle\Exception\HttpServerErrorException;
use Itmedia\ZippyBusBundle\Exception\HttpUnauthorizedException;
use Itmedia\ZippyBusBundle\Exception\ZippyBusException;
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

        try {
            $response = $client->get($path, $options);
            return \GuzzleHttp\json_decode((string)$response->getBody(), true);
        } catch (ClientException $exception) {
            switch ($exception->getCode()) {
                case 401:
                    throw new HttpUnauthorizedException('Unauthorized', 401, $exception);
                case 403:
                    throw new HttpForbiddenException('Forbidden', 403, $exception);
                default:
                    throw new HttpBadRequestException($exception->getMessage(), $exception->getCode(), $exception);
            }
        } catch (ServerException $exception) {
            throw new HttpServerErrorException($exception->getMessage(), $exception->getCode(), $exception);
        } catch (\Exception $exception) {
            throw new ZippyBusException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}

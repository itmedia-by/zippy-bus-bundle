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

    private $cacheTtl;


    public function __construct(string $token, CacheInterface $cache, int $cacheTtl = 3600)
    {
        $this->cache = $cache;
        $this->cacheTtl = $cacheTtl;

        $this->httpClient = new Client([
            'base_uri' => $this->apiUrl,
            'timeout' => 5,
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $token)
            ]
        ]);
    }


    /**
     * Запрос к сервису
     *
     * @param string $path Путь к ресурсу (без  `https://zippybus.com/api/v1/`)
     * @param array $params Параметры автоподстановки пути, вида `['id' => 'value']`, путь должен быть вида `/resource/{id}`
     * @param array $options Опции GuzzleClient
     * @return array
     * @throws \Exception
     */
    public function get(string $path, array $params = [], array $options = []): array
    {
        $cacheKey = md5(sprintf('%s.%s.%s', $path, \json_encode($params), \json_encode($options)));

        $content = $this->cache->get($cacheKey);
        if ($content) {
            return $content;
        }

        $client = $this->httpClient;

        foreach ($params as $param => $value) {
            $path = str_replace('{' . $param . '}', $value, $path);
        }

        try {
            $response = $client->get($path, $options);
            $content = \GuzzleHttp\json_decode((string)$response->getBody(), true);
            $this->cache->set($cacheKey, $content, $this->cacheTtl);
            return $content;
        } catch (\Exception $exception) {
            throw $this->handleException($exception);
        }
    }


    public function handleException(\Exception $exception): \Throwable
    {
        if ($exception instanceof ClientException) {
            switch ($exception->getCode()) {
                case 401:
                    return new HttpUnauthorizedException('Unauthorized', 401, $exception);
                case 403:
                    return new HttpForbiddenException('Forbidden', 403, $exception);
                default:
                    return new HttpBadRequestException($exception->getMessage(), $exception->getCode(), $exception);
            }
        }
        if ($exception instanceof ServerException) {
            return new HttpServerErrorException($exception->getMessage(), $exception->getCode(), $exception);
        }
        return new ZippyBusException($exception->getMessage(), $exception->getCode(), $exception);
    }
}

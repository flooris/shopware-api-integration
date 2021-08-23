<?php

namespace Flooris\ShopwareApiIntegration;

use stdClass;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Flooris\ShopwareApiIntegration\Clients\BulkClient;

class Connector
{
    private const HTTP_GET = 'GET';
    private const HTTP_POST = 'POST';
    private const HTTP_PATCH = 'PATCH';
    private const HTTP_DELETE = 'DELETE';

    public function __construct(private ShopwareApi $shopwareApi, private Client $httpClient, private array $instanceClientOptions = [])
    {
    }

    public function bulk(): BulkClient
    {
        return new BulkClient($this);
    }

    private function getShopwareApi(): ShopwareApi
    {
        return $this->shopwareApi;
    }

    public function getHttpRequestOptions(?array $options = null, array $data = []): array
    {
        $defaultOptions = [
            RequestOptions::HEADERS     => [
                'User-Agent'    => config('shopware.instances.default.client-options.user-agent', 'flooris/shopware-api-integration'),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShopwareApi()->getAuthenticator()->getBearerToken(),
            ],
            RequestOptions::SYNCHRONOUS => true,
            RequestOptions::DEBUG       => false,
        ];

        $defaultOptions[RequestOptions::HEADERS] = array_merge($defaultOptions[RequestOptions::HEADERS], $this->instanceClientOptions);

        if (! $options) {
            return $defaultOptions;
        }

        if (isset($options[RequestOptions::HEADERS])) {
            $options[RequestOptions::HEADERS] = array_merge($defaultOptions[RequestOptions::HEADERS], $options[RequestOptions::HEADERS]);
        } else {
            $options[RequestOptions::HEADERS] = $defaultOptions[RequestOptions::HEADERS];
        }

        if (! isset($options[RequestOptions::SYNCHRONOUS])) {
            $options[RequestOptions::SYNCHRONOUS] = true;
        }

        if (! isset($options[RequestOptions::DEBUG])) {
            $options[RequestOptions::DEBUG] = false;
        }

        if (isset($options[RequestOptions::MULTIPART], $options[RequestOptions::HEADERS]['Content-Type'])) {
            unset($options[RequestOptions::HEADERS]['Content-Type']);
        }

        if (! empty($data)) {
            $options[RequestOptions::JSON] = $data;
        }

        return $options;
    }

    public function get(string $uri, array $query = [], array $uriParameters = []): stdClass
    {
        return $this->send(static::HTTP_GET, $this->buildUri($uri, $uriParameters), [], $query);
    }

    public function post(string $uri, array $data, array $uriParameters = [], array $query = [], ?string $body = null, array $headers = []): stdClass
    {
        return $this->send(static::HTTP_POST, $this->buildUri($uri, $uriParameters), $data, $query, $body, $headers);
    }

    public function patch(string $uri, array $data, array $uriParameters, array $query = []): stdClass
    {
        return $this->send(static::HTTP_PATCH, $this->buildUri($uri, $uriParameters), $data, $query);
    }

    public function delete(string $url, array $uriParameters = [], array $query = []): stdClass
    {
        return $this->send(self::HTTP_DELETE, $this->buildUri($url, $uriParameters), null, $query);
    }

    private function buildUri(string $uri, array $uriParameters = []): string
    {
        return vsprintf(ltrim($uri, '/'), $uriParameters);
    }

    private function decodeResponse($response): stdClass
    {
        $response = $response->getBody()->getContents();
        if (! $response) {
            return (object)[];
        }

        return json_decode($response, false, 512, JSON_THROW_ON_ERROR);
    }

    private function send(string $method, string $uri, ?array $data = null, ?array $query = null, ?string $body = null, array $headers = []): stdClass
    {
        if (empty($data)) {
            $data = null;
        }
        $options = $this->getHttpRequestOptions([
            RequestOptions::JSON    => $data,
            RequestOptions::QUERY   => $query,
            RequestOptions::HEADERS => $headers,
            RequestOptions::BODY    => $body,
        ]);

        return $this->decodeResponse($this->httpClient->request($method, $uri, $options));
    }
}

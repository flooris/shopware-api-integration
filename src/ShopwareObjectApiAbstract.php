<?php

namespace Flooris\FloorisShopwareApiIntegration;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

class ShopwareObjectApiAbstract
{
    public $model;

    public function __construct(
        private ShopwareApi $shopwareApi,
        protected string $endpointSlug,
        protected string $modelClass
    )
    {

    }

    public function getShopwareApi(): ShopwareApi
    {
        return $this->shopwareApi;
    }

    public function getHttpRequestOptions(?array $options = null): array
    {
        $defaultOptions = [
            RequestOptions::HEADERS     => [
                'User-Agent'    => config('shopware.client-options.user-agent', 'flooris/ergonode-api'),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'authorization' => "Bearer " . $this->getShopwareApi()->getAuthenticator()->getBearerToken(),
            ],
            RequestOptions::SYNCHRONOUS => true,
            RequestOptions::DEBUG       => false,
        ];

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

        return $options;
    }

    protected function get(string $uri, ?array $options = null): ResponseInterface
    {
        $options = $this->getHttpRequestOptions($options);

        try {
            return $this->getShopwareApi()
                ->getHttpClient()
                ->get($uri, $options);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function patch(string $uri, ?array $options = null): ResponseInterface
    {
        $options = $this->getHttpRequestOptions($options);
        try {
            return $this->getShopwareApi()
                ->getHttpClient()
                ->patch($uri, $options);
        } catch (GuzzleException $e) {
            $error = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
            throw $e;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            throw $e;
        }
    }

    public function delete(string $url, ?array $options = null): ?ResponseInterface
    {
        $options = $this->getHttpRequestOptions($options);
        try {
            return $this->getShopwareApi()
                ->getHttpClient()
                ->delete($url, $options);
        } catch (GuzzleException $e) {
            $error = $e->getMessage();

            return null;
        }
    }

    protected function post(string $uri, ?array $options = null): ResponseInterface
    {
        $options = $this->getHttpRequestOptions($options);

        try {
            return $this->getShopwareApi()
                ->getHttpClient()
                ->post($uri, $options);
        } catch (GuzzleException $e) {
            $error = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
            throw $e;
        }catch (\Exception $e) {
            throw $e;
        }
    }

    public function save(string $id, array $options): bool
    {
        return $this->post("$this->endpointSlug/$id", $options)->getStatusCode() == 204;
    }

    public function find(string $id, ?string $extra = null)
    {
        $url         = $extra ? "$id" : "$id/$extra";
        $this->model = $this->getModel("$this->endpointSlug/$url", $this->modelClass, null, $id);

        return $this->model;
    }

    public function all(): Collection
    {
        return $this->getCollection("$this->endpointSlug", $this->modelClass, null);
    }

    public function update(string $id, array $options): bool
    {
        return $this->patch("$this->endpointSlug/$id", $options)->getStatusCode() == 204;
    }

    public function destroy($id): bool
    {
        $result = $this->delete("$this->endpointSlug/$id");
        if (! $result) return false;

        return $result->getStatusCode() == 204;
    }

    public function getModel(string $uri, string $modelClass, ?array $options = null, ?string $id = null)
    {
        try {
            $response = json_decode($this->get($uri, $options)
                ->getBody()
                ->getContents(), false, 512, JSON_THROW_ON_ERROR);
            $response = isset($response->data) ? $response->data : $response;

            return new $modelClass($this->shopwareApi, $response, $id);
        } catch (GuzzleException $e) {
            return null;
        }
    }

    public function getCollection(string $uri, string $modelClass, ?array $options = null): Collection
    {
        $shopwareApi = $this->getShopwareApi();
        $response    = (array)json_decode($this->get($uri, $options)
            ->getBody()
            ->getContents(), false, 512, JSON_THROW_ON_ERROR);
        $response    = isset($response["data"]) ? collect($response["data"]) : collect($response);

        $response = $response->map(function ($responseItem) use ($modelClass, $shopwareApi) {
            return new $modelClass($shopwareApi, $responseItem);
        });

        return $response;
    }

    public function search(?string $term, int $limit = 25, int $page = 1, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = false, array $associations = []): Collection|\stdClass
    {
        $modelClass  = $this->modelClass;
        $shopwareApi = $this->getShopwareApi();

        $sort = [
            [
                "field"          => $sortField,
                "naturalSorting" => false,
                "order"          => $sortOrder,
            ],
        ];

        $data       = [
            "limit"            => $limit,
            "page"             => $page,
            "term"             => $term,
            "total-count-mode" => 1,
        ];
        $associated = [];
        foreach ($associations as $ass) {
            $associated[$ass] = [
                "total-count-mode" => 1,
            ];
        };
        $data["associations"] = $associated;

        if ($sortField && $sortOrder) {
            $data["sort"] = $sort;
        }

        $options = [
            RequestOptions::JSON => $data,
        ];

        $response   = (array)json_decode($this->post("search/$this->endpointSlug", $options)->getBody()
            ->getContents(), false, 512, JSON_THROW_ON_ERROR);
        $totalItems = $response["total"];
        $response   = isset($response["data"]) ? collect($response["data"]) : collect($response);

        $response = $response->map(function ($responseItem) use ($modelClass, $shopwareApi) {
            return new $modelClass($shopwareApi, $responseItem);
        });

        if ($paginated) {
            return (object)[
                "info"         => [
                    "total" => $totalItems,
                    "page"  => $page,
                    "limit" => $limit,
                ],
                "data"         => $response,
            ];
        }

        return $response;
    }
}

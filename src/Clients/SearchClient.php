<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Connector;
use Flooris\ShopwareApiIntegration\ShopwareApi;
use Flooris\ShopwareApiIntegration\Models\Contracts\Client;

class SearchClient
{
    public ?array $filter = null;

    public function __construct(private ShopwareApi $shopwareApi)
    {
    }

    public function baseuri(): string
    {
        return 'search/%s';
    }

    public function custom(AbstractBaseClient $client, ?string $id = null, ?string $term = null, ?int $limit = null, int $page = 1, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = false): Collection|stdClass
    {
        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $id,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function categories(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->category();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        return $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function products(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass|null
    {
        $client = $this->shopwareApi->product();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        $response = $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );

        return $response;
    }

    public function productVisibility(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->productVisibility();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        return $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function salesChannel(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->salesChannel();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        return $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function productFeatureSet(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->productFeatureSet();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        return $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function productMedia(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->productMedia();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        return $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function mediaFolder(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->mediaFolder();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        return $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function media(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->media();

        $modelClass = ($limit === 1) ? $client->modelClass() : $client->ListModelClass();

        return $this->sendRequest(
            $term,
            $modelClass,
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function properties(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->property();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function currency(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->currency();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function country(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->country();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function order(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->order();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function addFilter(string $field, string $filterType, ?string $value): SearchClient
    {
        if (! $this->filter) {
            $this->filter = [];
        }

        $this->filter[] = [
            'field' => $field,
            'type'  => $filterType,
            'value' => $value,
        ];

        return $this;
    }

    public function addQuery(string $operator, string $filterType, array $queries)
    {
        $this->filter[] = [
            'operator' => $operator,
            'type'     => $filterType,
            'queries'  => $queries,
        ];

        return $this;
    }

    public function propertyGroups(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->propertyGroup();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function customers(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->customer();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function tax(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->tax();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    public function tag(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $client = $this->shopwareApi->tag();

        return $this->sendRequest(
            $term,
            $client->modelClass(),
            $client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
        );
    }

    /**
     * string $type =  $clients->baseUri(),,
     * string $modelClass = $clients->modelClass(),,
     * array $associations = $clients->associations()
     *
     **/

    private function sendRequest(
        ?string $term,
        string  $modelClass,
        Client  $client,
        ?int    $limit = 25,
        int     $page = 1,
        ?string $ids = null,
        ?string $sortField = null,
        ?string $sortOrder = null,
        bool    $paginated = true,
    ): Collection|stdClass
    {
        $data         = $this->createSearchData($limit, $page, $term, $ids, $sortField, $sortOrder);
        $data         = $this->appendAssociations($data, $client->associations());
        $response     = $this->shopwareApi->connector()->post($this->baseuri(), $data, [$client->baseuri()]);
        $totalItems   = $response->total;
        $this->filter = null;

        return $this->createResponse($response, $modelClass, $client, $paginated, $totalItems, $page, $limit);
    }

    private function createSearchData(?int $limit, int $page, ?string $term, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null): array
    {
        $sort = [
            [
                'field'          => $sortField,
                'naturalSorting' => false,
                'order'          => $sortOrder,
            ],
        ];


        return [
            'ids'              => $ids,
            'limit'            => $limit,
            'page'             => $page,
            'term'             => $term,
            'total-count-mode' => 1,
            'sort'             => $sortField && $sortOrder ? $sort : null,
            'filter'           => $this->filter,
        ];
    }

    private function appendAssociations(array &$data, array $associations): array
    {
        if (empty($associations)) {
            return $data;
        }

        $associated = [];
        foreach ($associations as $association) {
            $associated[$association] = [
                'total-count-mode' => 1,
            ];
        }
        $data['associations'] = $associated;

        return $data;
    }

    private function createPaginatedResponse(int $totalItemsCount, ?int $page, ?int $limit, Collection $response): stdClass
    {
        return (object)[
            'total'        => $totalItemsCount,
            'per_page'     => $limit,
            'current_page' => $page,
            'last_page'    => (int)round($totalItemsCount / $limit, 0, PHP_ROUND_HALF_UP),
            'data'         => $response,
        ];
    }

    private function createResponse(stdClass $response, string $modelClass, Client $client, bool $paginated = true, ?int $totalItems = null, int $page = 1, ?int $limit = 25): stdClass|Collection
    {
        $data = isset($response->data) ? collect($response->data) : collect($response);

        $data = $data->map(function ($responseItem) use ($modelClass, $client) {
            return new $modelClass($client, $responseItem);
        });

        if ($paginated) {
            return $this->createPaginatedResponse($totalItems, $page, $limit, $data);
        }

        return $data;
    }
}

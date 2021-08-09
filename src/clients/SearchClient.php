<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use stdClass;
use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\Connector;
use Flooris\FloorisShopwareApiIntegration\ShopwareApi;
use Flooris\FloorisShopwareApiIntegration\models\contracts\Client;

class SearchClient
{
    private ShopwareApi $shopwareApi;
    private ?AbstractBaseClient $client;
    private Connector $connector;
    public ?array $filter;

    public function __construct(ShopwareApi $shopwareApi)
    {
        $this->shopwareApi = $shopwareApi;
        $this->connector   = $this->shopwareApi->connector();
        $this->client      = null;
        $this->filter      = null;
    }

    public function baseuri(): string
    {
        return "search/%s";
    }

    public function custom(AbstractBaseClient $client, ?string $ids = null, ?string $term = null, ?int $limit = null, int $page = 1, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = false): Collection|stdClass
    {
        $this->client = $client;

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $this->client->modelClass(),
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function categories(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->categories();
        $modelClass   = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function products(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass|null
    {
        $this->client = $this->shopwareApi->products();
        $modelClass   = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        $response = $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );

        return $response;
    }

    public function productVisibility(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->productVisibility();
        $modelClass   = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function salesChannel(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->salesChannels();
        $modelClass   = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function productFeatureSet(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->productFeatureSet();
        $modelClass   = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function productMedia(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->media();
        $this->client->setMediaModelAndEndpoint("product-media");
        $modelClass = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function mediaFolder(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->media();
        $this->client->setMediaModelAndEndpoint("media-folder");
        $modelClass = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function media(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->media();
        $this->client->setMediaModelAndEndpoint("media");
        $modelClass = $this->client->ListModelClass();

        if ($limit === 1) {
            $modelClass = $this->client->modelClass();
        }

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $modelClass,
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function properties(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->properties();

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $this->client->modelClass(),
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function currency(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->currency();

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $this->client->modelClass(),
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function country(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->country();

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $this->client->modelClass(),
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function order(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->order();

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $this->client->modelClass(),
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function addFilter(string $field, string $filterType, ?string $value): SearchClient
    {
        if (! $this->filter) {
            $this->filter = [];
        }

        $this->filter[] = [
            "field" => $field,
            "type"  => $filterType,
            "value" => $value,
        ];

        return $this;
    }

    public function addQuery(string $operator, string $filterType,array $queries)
    {
        $this->filter[] = [
            "operator" => $operator,
            "type"  => $filterType,
            "queries" => $queries,
        ];
        return $this;
    }

    public function propertyGroups(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->propertyGroup();

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $this->client->modelClass(),
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    public function customers(?string $term = null, ?int $limit = 25, int $page = 1, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null, bool $paginated = true): Collection|stdClass
    {
        $this->client = $this->shopwareApi->customer();

        return $this->sendRequest(
            $term,
            $this->client->baseUri(),
            $this->client->modelClass(),
            $this->client,
            $limit,
            $page,
            $ids,
            $sortField,
            $sortOrder,
            $paginated,
            $this->client->associations()
        );
    }

    private function sendRequest(
        ?string $term,
        string $type,
        string $modelClass,
        Client $client,
        ?int $limit = 25,
        int $page = 1,
        ?string $ids = null,
        ?string $sortField = null,
        ?string $sortOrder = null,
        bool $paginated = true,
        array $associations = []
    ): Collection|stdClass
    {
        $data         = $this->createSearchData($limit, $page, $term, $ids, $sortField, $sortOrder);
        $data         = $this->appendAssociations($data, $associations);
        $response     = $this->shopwareApi->connector()->post($this->baseuri(), $data, [$type]);
        $totalItems   = $response->total;
        $this->filter = null;

        return $this->createResponse($response, $modelClass, $client, $paginated, $totalItems, $page, $limit);
    }

    private function createSearchData(?int $limit, int $page, ?string $term, ?string $ids = null, ?string $sortField = null, ?string $sortOrder = null): array
    {
        $sort = [
            [
                "field"          => $sortField,
                "naturalSorting" => false,
                "order"          => $sortOrder,
            ],
        ];


        return [
            "ids"              => $ids,
            "limit"            => $limit,
            "page"             => $page,
            "term"             => $term,
            "total-count-mode" => 1,
            "sort"             => $sortField && $sortOrder ? $sort : null,
            "filter"           => $this->filter,
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
                "total-count-mode" => 1,
            ];
        }
        $data["associations"] = $associated;

        return $data;
    }

    private function createPaginatedResponse(string $totalItems, ?int $page, ?int $limit, Collection $response): stdClass
    {
        return (object)[
            "info" => [
                "total" => $totalItems,
                "page"  => $page,
                "limit" => $limit,
            ],
            "data" => $response,
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

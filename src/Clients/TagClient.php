<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\TaxModel;
use Flooris\ShopwareApiIntegration\Models\TagModel;

class TagClient extends AbstractBaseClient
{

    public function modelClass(): string
    {
        return TagModel::class;
    }

    public function listModelClass(): string
    {
        return TagModel::class;
    }

    public function baseUri(): string
    {
        return 'tag';
    }

    public function showUri(): string
    {
        return 'tag/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->tag(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->tag(limit: null, paginated: false);
    }

    public function create(string $name)
    {
        return $this->getShopwareApi()->connector()->post($this->baseUri(), [
            'name' => $name,
        ]);
    }
}

<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\CategoryModel;

class CategoryClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return CategoryModel::class;
    }

    public function listModelClass(): string
    {
        return CategoryModel::class;
    }

    public function baseUri(): string
    {
        return 'category';
    }

    public function showUri(): string
    {
        return 'category/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->categories(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->categories(limit: null, paginated: false);
    }
}

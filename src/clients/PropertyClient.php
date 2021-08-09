<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\models\PropertyModel;

class PropertyClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return PropertyModel::class;
    }

    public function baseUri(): string
    {
        return "property-group";
    }

    public function showUri(): string
    {
        return "property-group/%s";
    }

    public function listModelClass(): string
    {
        return PropertyModel::class;
    }

    public function associations(): ?array
    {
        return ["options"];
    }

    function list($limit = 25, $page = 1): \stdClass
    {
        return $this->getShopwareApi()->search()->properties(limit: $limit, page: $page);
    }

    function all(): Collection
    {
        return $this->getShopwareApi()->search()->properties(limit: null, paginated: false);
    }

    public function findByOption(string $id)
    {
        return $this->getShopwareApi()->search()->addFilter("propertyGroup.options.id", "equalsAny", $id)->propertyGroups();
    }
}

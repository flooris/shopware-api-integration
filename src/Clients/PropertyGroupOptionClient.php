<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\PropertyModel;
use Flooris\ShopwareApiIntegration\Models\PropertyOptionModel;

class PropertyGroupOptionClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return PropertyOptionModel::class;
    }

    public function baseUri(): string
    {
        return 'property-group-option';
    }

    public function showUri(): string
    {
        return 'property-group-option/%s';
    }

    public function createUri(): string
    {
        return 'property-group-option/%s';
    }

    public function listModelClass(): string
    {
        return PropertyOptionModel::class;
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->propertyGroupOptions(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->propertyGroupOptions(limit: null, paginated: false);
    }

    public function update(string $groupId, string $id, array $changes): PropertyModel
    {
        $response = $this->getShopwareApi()
            ->connector()
            ->patch(
                $this->showUri(),
                $changes,
                [$groupId, $id],
                ['_response' => true]
            );

        return new $this->modelClass($response);
    }

    public function create(string $groupId, string $name, ?string $id = null)
    {
        $payload = [
            'groupId' => $groupId,
            'name'    => $name,
        ];

        if ($id) {
            $payload['id'] = $id;
        }

        return $this->getShopwareApi()
            ->connector()
            ->post(
                $this->createUri(),
                $payload,
                [$groupId]
            );
    }
}

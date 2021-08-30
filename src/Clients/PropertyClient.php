<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\PropertyModel;

class PropertyClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return PropertyModel::class;
    }

    public function baseUri(): string
    {
        return 'property-group';
    }

    public function showUri(): string
    {
        return 'property-group/%s/options/%s';
    }

    public function createUri(): string
    {
        return 'property-group/%s/options';
    }

    public function listModelClass(): string
    {
        return PropertyModel::class;
    }

    public function associations(): ?array
    {
        return ['options'];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->properties(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->properties(limit: null, paginated: false);
    }

    public function findByOptionId(string $id): Collection|stdClass
    {
        return $this->getShopwareApi()
            ->search()
            ->addFilter('propertyGroup.options.id', 'equalsAny', $id)
            ->propertyGroups();
    }

    public function update(string $groupId, string $id, array $changes): PropertyModel
    {
        $response = $this->getShopwareApi()
            ->enableLanguage()
            ->connector()
            ->patch(
                $this->showUri(),
                $changes,
                [$groupId, $id],
                ['_response' => true]
            );

        return new $this->modelClass($this, $response);
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
            ->disableLanguage()
            ->connector()
            ->post(
                $this->createUri(),
                $payload,
                [$groupId]
            );
    }
}

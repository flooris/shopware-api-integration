<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Flooris\ShopwareApiIntegration\Connector;

class BulkClient
{
    public function __construct(private Connector $connector)
    {
    }

    public function baseUri()
    {
        return '_action/sync';
    }

    public function update(array $payload, string $entity = 'product'): stdClass
    {
        return $this->connector->post($this->baseUri(), [
            [
                'action'  => 'upsert',
                'entity'  => $entity,
                'payload' => $payload,
            ],
        ]);
    }

    public function delete(array $payload, string $entity = 'product_property'): stdClass
    {
        return $this->connector->post($this->baseUri(), [
            [
                'action'  => 'delete',
                'entity'  => $entity,
                'payload' => $payload,
            ],
        ]);
    }
}

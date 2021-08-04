<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;

use stdClass;
use Flooris\FloorisShopwareApiIntegration\Connector;

class BulkClient
{
    public function __construct(private Connector $connector)
    {
    }

    public function baseUri()
    {
        return "_action/sync";
    }

    public function update(array $payload, string $entity = "product"): stdClass
    {
        return $this->connector->post($this->baseUri(), [
            [
                "action"  => "upsert",
                "entity"  => $entity,
                "payload" => $payload,
            ],
        ]);
    }
}

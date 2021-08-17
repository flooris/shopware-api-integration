<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;
use Flooris\ShopwareApiIntegration\Models\Contracts\Model;
use Flooris\ShopwareApiIntegration\Models\Contracts\Client;

abstract class AbstractModel implements Model
{
    public function __construct(private Client $client, ?stdClass $response = null)
    {
        if ($response) {
            $this->handleResponse($response->data ?? $response);
        }
    }

    abstract public function handleResponse(stdClass $response): void;

    public function clientClass(): string
    {
        return $this->client::class;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function find(string $id): Model
    {
        return $this->client->find($id);
    }

    public function destroy($id): bool
    {
        return $this->client->destroy($id);
    }
}

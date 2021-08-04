<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


use stdClass;
use Flooris\FloorisShopwareApiIntegration\models\contracts\Model;
use Flooris\FloorisShopwareApiIntegration\models\contracts\Client;

abstract class AbstractModel implements Model
{
    protected ?stdClass $response;

    public function __construct(private Client $client, ?stdClass $response = null)
    {
        if ($response) {
            $this->response = $response;
            $this->handleResponse();
        }
    }

    abstract public function handleResponse(): void;

    public function clientClass(): string
    {
        return $this->client::class;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function find(string $id): Model
    {
        return $this->client->find($id);
    }
}

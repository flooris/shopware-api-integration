<?php

namespace App\modules\ShopwareConnector\src;

use GuzzleHttp\Client;
use Flooris\FloorisShopwareApiIntegration\clients\TaxClient;
use Flooris\FloorisShopwareApiIntegration\clients\MediaClient;
use Flooris\FloorisShopwareApiIntegration\clients\OrderClient;
use Flooris\FloorisShopwareApiIntegration\clients\SearchClient;
use Flooris\FloorisShopwareApiIntegration\clients\ProductClient;
use Flooris\FloorisShopwareApiIntegration\clients\CategoryClient;
use Flooris\FloorisShopwareApiIntegration\clients\PropertyClient;
use Flooris\FloorisShopwareApiIntegration\clients\CurrencyClient;
use Flooris\FloorisShopwareApiIntegration\clients\SalesChannelClient;
use Flooris\FloorisShopwareApiIntegration\clients\PropertyGroupClient;
use Flooris\FloorisShopwareApiIntegration\clients\ProductFeaturesClient;
use Flooris\FloorisShopwareApiIntegration\clients\ProductVisibilityClient;

class ShopwareApi
{
    private ClientAuthenticator $clientAuthenticator;
    private Client $httpClient;
    private Connector $connector;

    public function __construct(string $hostname, string $clientId, string $clientSecret, ?array $httpClientConfig = null, bool $forceRenewTokens = false)
    {
        $this->setHttpClient($hostname, $httpClientConfig);
        $this->loginHttpClient($this->httpClient, $clientId, $clientSecret, $forceRenewTokens);
        $this->connector = new Connector($this, $this->httpClient);
    }

    private function setHttpClient(string $hostname, ?array $httpClientConfig = null): void
    {
        if (! $httpClientConfig) {
            $httpClientConfig = [];
        }

        $httpClientConfig['base_uri'] = $hostname;

        $this->httpClient = new Client($httpClientConfig);
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }


    public function getAuthenticator(): ClientAuthenticator
    {
        return $this->clientAuthenticator;
    }

    private function loginHttpClient(Client $client, string $clientId, string $clientSecret, bool $forceRenewTokens): void
    {
        $this->clientAuthenticator = new ClientAuthenticator($client);
        $this->clientAuthenticator->authenticate($clientId, $clientSecret, $forceRenewTokens);
    }

    public function products(): ProductClient
    {
        return new ProductClient($this);
    }

    public function productFeatureSet(): ProductFeaturesClient
    {
        return new ProductFeaturesClient($this);
    }

    public function properties(): PropertyClient
    {
        return new PropertyClient($this);
    }

    public function propertyGroup(): PropertyGroupClient
    {
        return new PropertyGroupClient($this);
    }

    public function productVisibility(): ProductVisibilityClient
    {
        return new ProductVisibilityClient($this);
    }

    public function salesChannels(): SalesChannelClient
    {
        return new SalesChannelClient($this);
    }

    public function categories(): CategoryClient
    {
        return new CategoryClient($this);
    }

    public function media(?string $mediaEndpoint = null): MediaClient
    {
        return new MediaClient($this, $mediaEndpoint);
    }

    public function connector(): Connector
    {
        return $this->connector;
    }

    public function search(): SearchClient
    {
        return new SearchClient($this);
    }

    public function currency(): CurrencyClient
    {
        return new CurrencyClient($this);
    }

    public function tax(): TaxClient
    {
        return new TaxClient($this);
    }

    public function order(): OrderClient
    {
        return new OrderClient($this);
    }
}

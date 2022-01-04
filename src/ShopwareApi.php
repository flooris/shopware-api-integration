<?php

namespace Flooris\ShopwareApiIntegration;

use GuzzleHttp\Client;
use Flooris\ShopwareApiIntegration\Clients\TaxClient;
use Flooris\ShopwareApiIntegration\Clients\TagClient;
use Flooris\ShopwareApiIntegration\Clients\MediaClient;
use Flooris\ShopwareApiIntegration\Clients\OrderClient;
use Flooris\ShopwareApiIntegration\Clients\SearchClient;
use Flooris\ShopwareApiIntegration\Clients\LocaleClient;
use Flooris\ShopwareApiIntegration\Clients\ProductClient;
use Flooris\ShopwareApiIntegration\Clients\CountryClient;
use Flooris\ShopwareApiIntegration\Clients\TaxRuleClient;
use Flooris\ShopwareApiIntegration\Clients\CategoryClient;
use Flooris\ShopwareApiIntegration\Clients\PropertyClient;
use Flooris\ShopwareApiIntegration\Clients\CurrencyClient;
use Flooris\ShopwareApiIntegration\Clients\CustomerClient;
use Flooris\ShopwareApiIntegration\Clients\LanguageClient;
use Flooris\ShopwareApiIntegration\Clients\MediaFolderClient;
use Flooris\ShopwareApiIntegration\Clients\TaxRuleTypeClient;
use Flooris\ShopwareApiIntegration\Clients\SalesChannelClient;
use Flooris\ShopwareApiIntegration\Clients\ProductMediaClient;
use Flooris\ShopwareApiIntegration\Clients\PropertyGroupClient;
use Flooris\ShopwareApiIntegration\Clients\CalculatedTaxClient;
use Flooris\ShopwareApiIntegration\Clients\PaymentMethodClient;
use Flooris\ShopwareApiIntegration\Clients\ProductVisibilityClient;
use Flooris\ShopwareApiIntegration\Clients\ProductFeaturesSetClient;
use Flooris\ShopwareApiIntegration\Clients\PropertyGroupOptionClient;

class ShopwareApi
{
    private ClientAuthenticator $clientAuthenticator;
    private Client $httpClient;
    private Connector $connector;
    public bool $languageEnabled = true;

    public function __construct(public string $hostname, string $accessKeyId, string $secretAccessKey, public string $languageId, array $instanceClientOptions = [], ?array $httpClientConfig = null, bool $forceRenewTokens = false)
    {
        $this->setHttpClient($hostname, $httpClientConfig);
        $this->connector = new Connector($this, $this->httpClient, $instanceClientOptions);
        $this->login($accessKeyId, $secretAccessKey, $forceRenewTokens);
    }

    private function login(string $accessKeyId, string $secretAccessKey, bool $forceRenewTokens): void
    {
        $this->clientAuthenticator = new ClientAuthenticator($this->connector, $accessKeyId);
        $this->clientAuthenticator->authenticate($secretAccessKey, $forceRenewTokens);
    }

    public function product(): ProductClient
    {
        return new ProductClient($this);
    }

    public function productFeatureSet(): ProductFeaturesSetClient
    {
        return new ProductFeaturesSetClient($this);
    }

    public function property(): PropertyClient
    {
        return new PropertyClient($this);
    }

    public function propertyGroup(): PropertyGroupClient
    {
        return new PropertyGroupClient($this);
    }

    public function propertyOption(): PropertyGroupOptionClient
    {
        return new PropertyGroupOptionClient($this);
    }

    public function productVisibility(): ProductVisibilityClient
    {
        return new ProductVisibilityClient($this);
    }

    public function salesChannel(): SalesChannelClient
    {
        return new SalesChannelClient($this);
    }

    public function category(): CategoryClient
    {
        return new CategoryClient($this);
    }

    public function media(): MediaClient
    {
        return new MediaClient($this);
    }

    public function mediaFolder(): MediaFolderClient
    {
        return new MediaFolderClient($this);
    }

    public function productMedia(): ProductMediaClient
    {
        return new ProductMediaClient($this);
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

    public function taxRuleType(): TaxRuleTypeClient
    {
        return new TaxRuleTypeClient($this);
    }

    public function taxRule(): TaxRuleClient
    {
        return new TaxRuleClient($this);
    }

    public function calculatedTax(): CalculatedTaxClient
    {
        return new CalculatedTaxClient(shopwareApi: $this);
    }

    public function order(): OrderClient
    {
        return new OrderClient($this);
    }

    public function customer(): CustomerClient
    {
        return new CustomerClient($this);
    }

    public function country(): CountryClient
    {
        return new CountryClient($this);
    }

    public function tag(): TagClient
    {
        return new TagClient($this);
    }

    public function language(): LanguageClient
    {
        return new LanguageClient($this);
    }

    public function locale(): LocaleClient
    {
        return new LocaleClient($this);
    }

    public function paymentMethod(): PaymentMethodClient
    {
        return new PaymentMethodClient($this);
    }

    public function connector(): Connector
    {
        return $this->connector;
    }

    private function setHttpClient(string $hostname, ?array $httpClientConfig = null): void
    {
        if (! $httpClientConfig) {
            $httpClientConfig = [];
        }

        $httpClientConfig['base_uri'] = $hostname;

        $this->httpClient = new Client($httpClientConfig);
    }

    public function getAuthenticator(): ClientAuthenticator
    {
        return $this->clientAuthenticator;
    }

    public function enableLanguage(): void
    {
        $this->languageEnabled = true;
    }

    public function disableLanguage(): void
    {
        $this->languageEnabled = false;
    }
}

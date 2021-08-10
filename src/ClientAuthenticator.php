<?php

namespace Flooris\ShopwareApiIntegration;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\GuzzleException;

class ClientAuthenticator
{
    const CLIENT_CACHE_KEY_TOKEN_BASE = 'SHOPWARE_API_TOKENS-';

    public function __construct(private Connector $connector, private string $accessKeyId)
    {
    }

    public function authenticate(string $secretAccessKey, bool $forceRenewTokens): void
    {
        if (! $forceRenewTokens && Cache::has($this->getCacheKey())) {
            return;
        }

        $loginDataArray = [
            'grant_type'    => config('shopware.grant_type', 'client_credentials'),
            'client_id'     => $this->accessKeyId,
            'client_secret' => $secretAccessKey,
        ];

        $responseObject = $this->connector->post('oauth/token', $loginDataArray);

        if (! isset($responseObject->access_token)) {
            throw new \Exception('Access token could not be found in the response object: ' .
                                 json_encode($responseObject));
        }

        Cache::set($this->getCacheKey(), $responseObject->access_token, $responseObject->expires_in);
    }

    public function getBearerToken(): ?string
    {
        return Cache::get($this->getCacheKey(), null);
    }

    public function getCacheKey(): string
    {
        return self::CLIENT_CACHE_KEY_TOKEN_BASE . $this->accessKeyId;
    }
}

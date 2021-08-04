<?php

namespace Flooris\FloorisShopwareApiIntegration;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\GuzzleException;

class ClientAuthenticator
{

    private string $cacheKeyTokens = 'SHOPWARE_API_TOKENS';
    private string $bearerToken;

    public function __construct(private Client $httpClient)
    {

    }

    public function authenticate(string $clientId, string $clientSecret, bool $forceRenewTokens): void
    {
        if (Cache::has($this->cacheKeyTokens) && !$forceRenewTokens) {
            $tokens = Cache::get($this->cacheKeyTokens);
            $this->setBearerToken($tokens->access_token);

            return;
        }

        $loginBody = [
            "grant_type"    => "client_credentials",
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
        ];

        $options = [
            RequestOptions::HEADERS     => [
                'User-Agent'   => config('shopware.client-options.user-agent', 'flooris/shopware-api'),
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
            RequestOptions::JSON        => $loginBody,
            RequestOptions::SYNCHRONOUS => true,
            RequestOptions::DEBUG       => true,
            "allow_redirects" => [
                "max" => 5,
            ]
        ];

        try {
            $response = $this->httpClient->request("POST", 'oauth/token', $options);
        } catch (GuzzleException $exception) {
            throw $exception;
        }

        $tokens = json_decode($response->getBody());

        $this->setBearerToken($tokens->access_token);

        $lifeTimeSeconds = (600); // 10 min
        Cache::set($this->cacheKeyTokens, $tokens, $lifeTimeSeconds);
    }

    public function setCacheKeyTokens(string $cacheKeyTokens): void
    {
        $this->cacheKeyTokens = $cacheKeyTokens;
    }

    public function getBearerToken(): string
    {
        return $this->bearerToken;
    }

    public function setBearerToken($bearerToken): void
    {
        $this->bearerToken = $bearerToken;
    }
}

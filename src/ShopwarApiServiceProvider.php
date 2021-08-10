<?php

namespace Flooris\ShopwareApiIntegration;

class ShopwarApiServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/shopware.php' => config_path('shopware.php'),
        ], 'shopware-api-integration');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/shopware.php', 'shopware'
        );
    }

    public function provides(): array
    {
    }
}

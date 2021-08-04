<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;

use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\models\FeatureModel;
use Flooris\FloorisShopwareApiIntegration\models\ProductFeatureSetModel;

class ProductFeaturesClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return ProductFeatureSetModel::class;
    }

    public function listModelClass(): string
    {
        return ProductFeatureSetModel::class;
    }

    public function baseUri(): string
    {
        return "product-feature-set";
    }

    public function showUri(): string
    {
        return "product-feature-set/%s";
    }

    public function associations(): ?array
    {
        return [];
    }

    function list($limit = 25, $page = 1): \stdClass
    {
        return $this->getShopwareApi()->search()->productFeatureSet(limit: $limit, page: $page);
    }

    function all(): Collection
    {
        return $this->getShopwareApi()->search()->productFeatureSet(limit: null, paginated: false);
    }

    public function create(string $name, string $description, array $features)
    {
        return $this->getShopwareApi()->connector()->post($this->baseUri(), [
            "name"        => $name,
            "description" => $description,
            "features"    => $features,
        ]);
    }

    public function feature(string $name, string $type, ?string $id = null, ?int $position = null): FeatureModel
    {
        $data = (object)[
            "name"     => $name,
            "type"     => $type,
            "id"       => $id,
            "position" => $position,
        ];

        return new FeatureModel($data);
    }
}

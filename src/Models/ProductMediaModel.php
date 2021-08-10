<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class ProductMediaModel extends AbstractModel
{
    public string $id;
    public string $productId;
    public string $mediaId;


    public function handleResponse(stdClass $response): void
    {
        $this->id        = $response->id;
        $this->productId = $response->productId;
        $this->mediaId   = $response->mediaId;
    }

    public function setAsCover(): bool
    {
        return (bool)$this->getClient()->getShopwareApi()->product()->update($this->productId, [
            'coverId' => $this->id,
        ]);
    }
}

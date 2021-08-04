<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class ProductMediaModel extends AbstractModel
{
    public string $id;
    public string $productId;
    public string $mediaId;


    function handleResponse(): void
    {
        $response        = isset($this->response->data) ? (array)$this->response->data : (array)$this->response;
        $this->id        = $response["id"];
        $this->productId = $response["productId"];
        $this->mediaId   = $response["mediaId"];
    }

    public function setAsCover(): bool
    {
        return (bool)$this->getClient()->getShopwareApi()->products()->update($this->productId, [
            "coverId" => $this->id,
        ]);
    }
}

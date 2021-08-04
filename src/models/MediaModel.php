<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


use Flooris\FloorisShopwareApiIntegration\ShopwareAbstractModel;

class MediaModel extends AbstractModel
{
    public string $id;
    private string $url;
    private ?string $fileName;
    private ?string $fileExtension;

    function handleResponse(): void
    {
        $response            = (array)$this->response;
        $response            = isset($response["data"]) ? (array)$response['data'] : $response;
        $this->id            = $response["id"];
        $this->url           = $response["url"];
        $this->fileName      = $response["fileName"];
        $this->fileExtension = $response["fileExtension"];
    }
}

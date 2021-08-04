<?php


namespace Flooris\FloorisShopwareApiIntegration\models;

class MediaFolderModel extends AbstractModel
{
    public string $id;
    public string $name;

    function handleResponse(): void
    {
        $response   = (array)$this->response;
        $response   = isset($response["data"]) ? (array)$response['data'] : $response;
        $this->id   = $response["id"];
        $this->name = $response["name"];
    }
}

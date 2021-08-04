<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class PropertyOptionModel extends abstractModel
{
    public string $id;
    public string $name;
    public string $parentId;

    function handleResponse(): void
    {
        $this->id       = $this->response->id;
        $this->name     = $this->response->name;
        $this->parentId = $this->response->groupId;
    }
}

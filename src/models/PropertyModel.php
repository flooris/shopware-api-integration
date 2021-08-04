<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class PropertyModel extends AbstractModel
{
    public string $id;
    public string $name;
    public array $options;
    public PropertyOptionModel $option;

    function handleResponse(): void
    {
        $response      = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id      = $response->id;
        $this->name    = $response->name;
        $this->options = $response->options;
    }
}

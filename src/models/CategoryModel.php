<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class CategoryModel extends AbstractModel
{
    public string $id;
    public string $name;
    public array $breadcrumbs;
    private ?string $parentId;
    private bool $hasChildren;

    function handleResponse(): void
    {
        $this->id          = $this->response->id;
        $this->name        = $this->response->name;
        $this->breadcrumbs = $this->response->breadcrumb;
        $this->parentId    = $this->response->parentId;
        $this->hasChildren = (bool)$this->response->childCount;
    }
}

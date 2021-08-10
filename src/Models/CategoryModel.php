<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class CategoryModel extends AbstractModel
{
    public string $id;
    public string $name;
    public array $breadcrumbs;
    private ?string $parentId;
    private bool $hasChildren;

    public function handleResponse(stdClass $response): void
    {
        $this->id          = $response->id;
        $this->name        = $response->name;
        $this->breadcrumbs = $response->breadcrumb;
        $this->parentId    = $response->parentId;
        $this->hasChildren = (int)$response->childCount > 0;
    }
}

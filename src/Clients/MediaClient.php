<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\MediaModel;

class MediaClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return MediaModel::class;
    }

    public function listModelClass(): string
    {
        return MediaModel::class;
    }

    public function baseUri(): string
    {
        return 'media';
    }

    public function showUri(): string
    {
        return 'media/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->media(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->media(limit: null, paginated: false);
    }

    //todo improve upload function
    public function upload(string $mediaId, string $image, string $fileName): stdClass
    {
        $name      = explode('.', $fileName)[0];
        $extension = explode('.', $fileName)[1];

        return $this->getShopwareApi()
            ->connector()
            ->post('_action/media/%s/upload', [], [$mediaId], [
                'extension' => $extension,
                'fileName'  => $name,
                '_response' => true,
            ], $image, [
                'Content-Type' => "image/{$fileName[1]}",
            ]);
    }

    public function createMediaItem(string $mediaFolderId, ?string $mediaId = null): MediaModel
    {
        $json = $mediaId ? [
            'mediaFolderId' => $mediaFolderId,
            'id'            => $mediaId,
        ] : [
            'mediaFolderId' => $mediaFolderId,
        ];

        return new $this->modelClass(
            $this->getShopwareApi()->connector()->post($this->baseUri(), $json, [], ['_response' => true,])->data,
        );
    }

    public function findByName(string $name)
    {
        return $this->all()->filter(function ($item) use ($name) {
            return str_contains(strtolower($item->name), strtolower($name));
        })->first();
    }

}

<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Exception;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\MediaFolderModel;

class MediaFolderClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return MediaFolderModel::class;
    }

    public function listModelClass(): string
    {
        return MediaFolderModel::class;
    }

    public function baseUri(): string
    {
        return 'media-folder';
    }

    public function showUri(): string
    {
        return 'media-folder/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->mediaFolder(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->mediaFolder(limit: null, paginated: false);
    }

    //todo improve addImageToMediaFolder
    public function addImageToMediaFolder(string $folderId, ?string $filename = null, ?string $image = null, ?string $url = null, ?string $id = null)
    {
        if (! $filename && ! $image && ! $url) {
            throw new Exception('at least provide a image with a filename or provide a valid image url');
        }

        if (! $image && $url) {
            $filename = time() . image_type_to_extension(exif_imagetype($url));
            $image    = file_get_contents($url);
        }

        $foundMedia = $this->getShopwareApi()->search()->media(term: (string)$filename, paginated: false)->first();

        if ($foundMedia && $foundMedia->fileName === str_replace(".{$foundMedia->fileExtension}", '', $filename)) {
            throw new Exception('filename is already in use', 500);
        }


        ! $id
            ? $mediaItem = $this->getShopwareApi()->media()->createMediaItem($folderId)
            : $mediaItem = $this->getShopwareApi()->media()->createMediaItem($folderId, $id);


        $this->getShopwareApi()->media()->upload($mediaItem->id, $image, $filename);

        return $mediaItem;
    }

    public function findByName(string $name)
    {
        return $this->all()->filter(function ($item) use ($name) {
            return str_contains(strtolower($item->name), strtolower($name));
        })->first();
    }
}

<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;

use stdClass;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Flooris\FloorisShopwareApiIntegration\ShopwareApi;
use Flooris\FloorisShopwareApiIntegration\models\MediaModel;
use Flooris\FloorisShopwareApiIntegration\models\MediaFolderModel;
use Flooris\FloorisShopwareApiIntegration\models\ProductMediaModel;

class MediaClient extends AbstractBaseClient
{
    protected string $endpoint;

    protected string $modelClass;

    public function __construct(ShopwareApi $shopwareApi, ?string $modelClass = null, ?string $modelListClass = null)
    {
        $this->setMediaModelAndEndpoint(null);
        parent::__construct($shopwareApi, $modelClass, $modelListClass);
    }

    public function modelClass(): string
    {
        return $this->modelClass;
    }

    public function listModelClass(): string
    {
        return $this->listModelClass;
    }

    public function baseUri(): string
    {
        return $this->endpoint;
    }

    public function showUri(): string
    {
        return "$this->endpoint/%s";
    }

    public function associations(): ?array
    {
        return [];
    }

    function list(int $limit = 25, int $page = 1): stdClass
    {
        return match ($this->endpoint) {
            "product-media" => $this->getShopwareApi()->search()->productMedia(limit: $limit, page: $page),
            "media-folder" => $this->getShopwareApi()->search()->mediaFolder(limit: $limit, page: $page),
            default => $this->getShopwareApi()->search()->media(limit: $limit, page: $page),
        };
    }

    function all(): Collection
    {
        return match ($this->endpoint) {
            "product-media" => $this->getShopwareApi()->search()->productMedia(limit: null, paginated: false),
            "media-folder" => $this->getShopwareApi()->search()->mediaFolder(limit: null, paginated: false),
            default => $this->getShopwareApi()->search()->media(limit: null, paginated: false),
        };
    }

    public function setMediaModelAndEndpoint(?string $endpoint): void
    {
        switch ($endpoint) {
            case "product-media":
                $this->modelClass     = ProductMediaModel::class;
                $this->listModelClass = ProductMediaModel::class;
                $this->endpoint       = "product-media";
                break;
            case "media-folder":
                $this->modelClass     = MediaFolderModel::class;
                $this->listModelClass = MediaFolderModel::class;
                $this->endpoint       = "media-folder";
                break;
            default:
                $this->modelClass     = MediaModel::class;
                $this->listModelClass = MediaModel::class;
                $this->endpoint       = "media";
                break;
        }
    }

    public function addProductImage(string $productId, string $mediaId): ProductMediaModel
    {
        $productMedia = $this->getShopwareApi()->media();
        $productMedia->setMediaModelAndEndpoint("product-media");
        $response = $this->getShopwareApi()->connector()->post($productMedia->baseUri(), [
            "productId" => $productId,
            "mediaId"   => $mediaId,
        ], [], ["_response" => true]);

        return new $productMedia->modelClass($this, $response);
    }

    public function addImageToMediaFolder(string $folderId, bool $localImage = true, ?string $filename = null, ?string $url = null)
    {
        if ($filename) {
            $image = Storage::get("public/images/$filename");
        } else if (! $localImage) {
            $filename = strval(time() . image_type_to_extension(exif_imagetype($url)));
            $image    = file_get_contents($url);
        } else {
            throw new Exception("either you have a local image with a filename, or a url to an image");
        }

        $this->setMediaModelAndEndpoint(null);
        $mediaItem = new $this->modelClass(
            $this,
            $this->getShopwareApi()->connector()->post("$this->endpoint", [
                "mediaFolderId" => $folderId,
            ], [], ["_response" => true,]
            ),
        );
        $this->upload($mediaItem->id, $image, $filename);

        return $mediaItem;
    }

    public function upload(string $mediaId, string $image, string $fileName): stdClass
    {
        $name      = explode(".", $fileName)[0];
        $extension = explode(".", $fileName)[1];

        return $this->getShopwareApi()
            ->connector()
            ->post("_action/media/%s/upload", [], [$mediaId], [
                "extension" => $extension,
                "fileName"  => $name,
                "_response" => true,
            ], $image, [
                "Accept"       => "application/vnd.api+json",
                "Content-Type" => "image/$fileName[1]",
            ]);

    }

    public function findByName(string $name)
    {
        return $this->all()->filter(function ($item) use ($name) {
            return str_contains(strtolower($item->name), strtolower($name));
        })->first();
    }

}

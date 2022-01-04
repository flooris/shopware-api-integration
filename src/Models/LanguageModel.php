<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class LanguageModel extends AbstractModel
{
    public string $id;
    public string $localeId;
    public string $translationCodeId;
    public string $name;
    public ?LocaleModel $locale;

    public function handleResponse(stdClass $response): void
    {
        $this->id                = $response->id;
        $this->localeId          = $response->localeId;
        $this->translationCodeId = $response->translationCodeId;
        $this->name              = $response->name;
        $this->locale            = isset($response->locale)
            ? new LocaleModel($response->locale)
            : null;
    }
}

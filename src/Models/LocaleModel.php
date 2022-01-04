<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class LocaleModel extends AbstractModel
{
    public string $id;
    public string $code;
    public string $territory;
    public string $name;
    public array $language;

    public function handleResponse(stdClass $response): void
    {
        $this->id        = $response->id;
        $this->code      = $response->code;
        $this->territory = $response->territory;
        $this->language  = collect($response->languages)
                               ->map(fn (stdClass $res): LanguageModel => new LanguageModel($res))
                               ->toArray() ?? [];
    }
}

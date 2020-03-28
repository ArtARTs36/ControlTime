<?php

namespace App\Services\Document;

interface DocumentLoaderInterface
{
    public static function stream(string $templateAlias, array $templateData);
}

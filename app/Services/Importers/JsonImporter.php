<?php

namespace App\Services\Importers;

class JsonImporter extends Importer
{
    public function import(string $filePath): array
    {
        $json = file_get_contents($filePath);
        return json_decode($json, true) ?? [];
    }
}

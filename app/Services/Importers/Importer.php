<?php

namespace App\Services\Importers;

abstract class Importer
{
    abstract public function import(string $filePath): array;
}

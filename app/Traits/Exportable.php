<?php

namespace App\Traits;

use App\Services\Exporters\CsvExporter;
use App\Services\Exporters\JsonExporter;
use App\Services\Exporters\XmlExporter;

trait Exportable
{
    public function exportData(string $format): string
    {
        $data = $this->all()->toArray();

        return match ($format) {
            'csv' => (new CsvExporter())->export($data),
            'json' => (new JsonExporter())->export($data),
            'xml' => (new XmlExporter())->export($data),
            default => throw new \InvalidArgumentException("Unsupported format: $format"),
        };
    }
}

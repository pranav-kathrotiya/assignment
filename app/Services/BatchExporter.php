<?php

namespace App\Services;

use App\Services\Exporters\CsvExporter;
use App\Services\Exporters\JsonExporter;
use App\Services\Exporters\XmlExporter;
use Illuminate\Support\Facades\Storage;

class BatchExporter
{
    public function exportAll(array $data, array $formats): array
    {
        $results = [];

        foreach ($formats as $format) {
            $exporter = match ($format) {
                'csv' => new CsvExporter(),
                'json' => new JsonExporter(),
                'xml' => new XmlExporter(),
                default => throw new \InvalidArgumentException("Unsupported format: $format"),
            };

            $content = $exporter->export($data);

            $filename = "users_" . time() . ".$format";
            Storage::disk('exports')->put($filename, $content);

            $results[$format] = $filename;
        }

        return $results;
    }
}

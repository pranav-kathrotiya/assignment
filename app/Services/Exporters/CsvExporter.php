<?php

namespace App\Services\Exporters;

class CsvExporter extends Exporter
{
    public function export(array $data): string
    {
        $handle = fopen('php://temp', 'r+');

        if (!empty($data)) {
            fputcsv($handle, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
        }

        rewind($handle);
        return stream_get_contents($handle);
    }
}

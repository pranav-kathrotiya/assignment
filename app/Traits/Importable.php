<?php

namespace App\Traits;

use App\Services\Importers\CsvImporter;
use App\Services\Importers\JsonImporter;
use Illuminate\Support\Facades\Hash;

trait Importable
{
    public function importData(string $filePath, string $format): int
    {
        $importer = match ($format) {
            'csv' => new CsvImporter(),
            'json' => new JsonImporter(),
            default => throw new \InvalidArgumentException("Unsupported format: $format"),
        };

        $data = $importer->import($filePath);

        foreach ($data as $row) {
            // ✅ If this is the User model, hash password automatically
            if ($this instanceof \App\Models\User && isset($row['password'])) {
                $row['password'] = Hash::make($row['password']);
            }

            $this->create($row);
        }

        return count($data);
    }
}

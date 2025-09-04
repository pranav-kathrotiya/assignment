<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DataImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $filePath;
    protected string $format;

    public function __construct(string $filePath, string $format)
    {
        $this->filePath = $filePath;
        $this->format = $format;
    }

    public function handle(): void
    {
        $model = new User();
        $model->importData($this->filePath, $this->format);
    }
}

<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DataExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $format;

    public function __construct(string $format)
    {
        $this->format = $format;
    }

    public function handle(): void
    {
        $data = User::all()->toArray();

        $model = new User();
        $content = $model->exportData($this->format);

        $filename = "users_" . time() . "." . $this->format;
        Storage::disk('exports')->put($filename, $content);
    }
}

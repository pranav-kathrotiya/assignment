<?php

namespace App\Http\Controllers;

use App\Jobs\DataExport;
use App\Jobs\DataImport;
use App\Models\User;
use App\Services\BatchExporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:csv,json,xml',
        ]);

        try {
            DataExport::dispatch($request->format);
            return back()->with('success', 'Export started! Check storage/exports/');
        } catch (\Exception $e) {
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'format' => 'required|in:csv,json',
        ]);

        // 🔎 Check file extension against selected format
        $extension = strtolower($request->file('file')->getClientOriginalExtension());
        $selectedFormat = strtolower($request->input('format'));

        if ($extension !== $selectedFormat) {
            return back()->with('error', "Uploaded file format ($extension) does not match selected format ($selectedFormat).");
        }


        try {
            $path = $request->file('file')->store('imports');
            DataImport::dispatch(storage_path("app/private/{$path}"), $request->format);
            return back()->with('success', 'Import started successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function batchExport(Request $request, BatchExporter $batchExporter)
    {
        $request->validate([
            'formats' => 'required|array',
            'formats.*' => 'in:csv,json,xml',
        ]);

        $data = User::all()->toArray();

        $files = $batchExporter->exportAll($data, $request->formats);

        return back()->with('success', 'Batch export completed! Files saved: ' . implode(', ', $files));
    }

    public function downloadTemplate($type)
    {
        $path = storage_path("app/public/import/template.$type");

        if (!file_exists($path)) {
            abort(404, 'Template not found');
        }

        return response()->download($path, "template.$type");
    }
}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <title>Assignment</title>
</head>

<body>
    <div class="container py-5">

        {{-- ✅ Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ❌ Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <h2 class="mb-4">📤 Data Export</h2>

        <form method="POST" action="{{ url('data/export') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Format</label>
                <select name="format" class="form-select" required>
                    <option value="">Select Format</option>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                    <option value="xml">XML</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Start Export</button>
        </form>

        <hr class="my-5">

        <h2 class="mb-4">📦 Batch Export (Multiple Formats)</h2>

        <form method="POST" action="{{ url('data/batch-export') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Select Formats</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="formats[]" value="csv" id="formatCsv">
                    <label class="form-check-label" for="formatCsv">CSV</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="formats[]" value="json" id="formatJson">
                    <label class="form-check-label" for="formatJson">JSON</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="formats[]" value="xml" id="formatXml">
                    <label class="form-check-label" for="formatXml">XML</label>
                </div>
            </div>

            <button type="submit" class="btn btn-dark">Start Batch Export</button>
        </form>

        <hr class="my-5">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">📥 Data Import</h2>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ url('download/template/json') }}" class="btn btn-warning btn-sm">Download JSON Template</a>
                <a href="{{ url('download/template/csv') }}" class="btn btn-success btn-sm">Download CSV Template</a>
            </div>
        </div>

        <form method="POST" action="{{ url('/data/import') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">File</label>
                <input type="file" class="form-control" name="file" required>
                <small class="text-muted">Supported: CSV, JSON</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Format</label>
                <select name="format" class="form-select" required>
                    <option value="">Select Format</option>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Start Import</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(() => {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000); // Auto close after 5 seconds
    </script>
</body>

</html>

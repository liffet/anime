<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-danger">
        <h4 class="alert-heading">Terjadi Kesalahan</h4>
        <p>{{ $message }}</p>
        @if(isset($error_detail))
            <hr>
            <p class="mb-0"><strong>Detail:</strong> {{ $error_detail }}</p>
        @endif
    </div>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali</a>
</div>
</body>
</html>

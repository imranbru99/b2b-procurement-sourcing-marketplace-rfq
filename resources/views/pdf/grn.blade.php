<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GRN {{ $number ?? '' }}</title>
</head>
<body>
    <h1>Goods Receipt Note</h1>
    <p><strong>Number:</strong> {{ $number ?? '—' }}</p>
    <p><strong>Status:</strong> {{ $status ?? 'draft' }}</p>
</body>
</html>

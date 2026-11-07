<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Purchase Order {{ $number ?? '' }}</title>
</head>
<body>
    <h1>Purchase Order</h1>
    <p><strong>Number:</strong> {{ $number ?? '—' }}</p>
    <p><strong>Total:</strong> {{ $currency ?? 'USD' }} {{ number_format((float) ($total ?? 0), 2) }}</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $number ?? '' }}</title>
</head>
<body>
    <h1>Invoice</h1>
    <p><strong>Number:</strong> {{ $number ?? '—' }}</p>
    <p><strong>Tax ({{ $tax_type ?? 'VAT' }}):</strong> {{ number_format((float) ($tax_total ?? 0), 2) }}</p>
    <p><strong>Total:</strong> {{ $currency ?? 'USD' }} {{ number_format((float) ($total ?? 0), 2) }}</p>
</body>
</html>

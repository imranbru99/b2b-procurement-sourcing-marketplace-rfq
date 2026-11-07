<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <title>Document</title>
</head>
<body>
    {!! $letterhead ?? '' !!}
    {!! $body_html ?? '' !!}
</body>
</html>

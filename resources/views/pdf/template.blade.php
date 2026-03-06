<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Document' }}</title>
    <style>
        body { font-family: sans-serif; }
        h1   { color: #2563EB; }
        p    { font-size: 0.95rem; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $content }}</p>
    {{-- add additional markup as needed --}}
</body>
</html>

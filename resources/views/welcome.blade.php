<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NetPulse - NOC Dashboard</title>
    <style>
        body { background-color: #f8fafc; margin: 0; padding: 0; font-family: system-ui, -apple-system, sans-serif; }
    </style>
    @livewireStyles
</head>
<body>

    <!-- استدعاء سستم المراقبة التفاعلي محلياً ليظهر في المتصفح -->
    @livewire('device-monitor')

    @livewireScripts
</body>
</html>

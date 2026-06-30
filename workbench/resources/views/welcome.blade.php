<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Livewire Tables — Workbench</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="h-full text-gray-900 antialiased">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-8">
            <h1 class="text-2xl font-bold">Laravel Livewire Tables — Workbench</h1>
            <p class="mt-1 text-sm text-gray-600">
                v4.0 demo app (Laravel 13 + Livewire 4). Use this to visually QA every column,
                filter, and feature. Expand under milestone <strong>M2</strong>.
            </p>
        </header>

        <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold">Demo: Pets table</h2>
            <livewire:demo-pets-table />
        </section>
    </div>

    @livewireScripts
</body>
</html>

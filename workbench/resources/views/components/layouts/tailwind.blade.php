@props(['title' => 'Tailwind theme'])

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Livewire Tables Workbench</title>

    {{-- Inline the Tailwind-ONLY build (no Flux) so this page is isolated. --}}
    @php
        $wbManifest = \Orchestra\Testbench\workbench_path('public/build/manifest.json');
        $wbCss = null;
        if (is_file($wbManifest)) {
            $entry = json_decode(file_get_contents($wbManifest), true)['workbench/resources/css/app-tailwind.css']['file'] ?? null;
            $built = $entry ? \Orchestra\Testbench\workbench_path('public/build/'.$entry) : null;
            $wbCss = ($built && is_file($built)) ? file_get_contents($built) : null;
        }
    @endphp
    @if ($wbCss)
        <style>{!! $wbCss !!}</style>
    @else
        <div style="background:#fee;color:#900;padding:8px;font-family:monospace">Run <code>npm run build</code> to build the workbench CSS.</div>
    @endif
    @livewireStyles
</head>
<body class="min-h-full bg-gray-50 text-gray-800 antialiased dark:bg-gray-900 dark:text-gray-100">
    <header class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-4">
                {{-- Plain links (full page loads) keep each theme's assets isolated — no wire:navigate. --}}
                <a href="/" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">← Workbench</a>
                <span class="text-gray-300 dark:text-gray-600">/</span>
                <h1 class="text-lg font-semibold">{{ $title }}</h1>
            </div>
            <nav class="flex items-center gap-3 text-sm">
                <a href="/themes/flux" target="_blank" class="inline-flex items-center gap-1 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"><x-workbench::icons.flux class="h-4 w-4" /> Flux</a>
                <a href="/themes/tailwind" class="inline-flex items-center gap-1 font-semibold text-indigo-600 dark:text-indigo-400"><x-workbench::icons.tailwind class="h-4 w-4" /> Tailwind</a>
                <a href="/themes/bootstrap" target="_blank" class="inline-flex items-center gap-1 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"><x-workbench::icons.bootstrap class="h-4 w-4" /> Bootstrap</a>
                <button
                    type="button"
                    onclick="document.documentElement.classList.toggle('dark')"
                    class="ml-2 rounded-md border border-gray-300 px-2 py-1 text-gray-600 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                    aria-label="Toggle dark mode"
                >☾</button>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-10">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
</body>
</html>

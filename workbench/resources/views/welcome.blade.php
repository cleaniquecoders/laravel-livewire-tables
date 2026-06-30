<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Livewire Tables — Workbench</title>

    {{--
        Inline the Vite-built Tailwind + Flux CSS. Testbench's serve docroot
        lives in vendor/, so a static @vite/<link> can't reach workbench/public;
        inlining the (dev-only) build is the reliable approach. Run `npm run build`.
    --}}
    @php
        $wbManifest = \Orchestra\Testbench\workbench_path('public/build/manifest.json');
        $wbCss = null;
        if (is_file($wbManifest)) {
            $entry = json_decode(file_get_contents($wbManifest), true)['workbench/resources/css/app.css']['file'] ?? null;
            $built = $entry ? \Orchestra\Testbench\workbench_path('public/build/'.$entry) : null;
            $wbCss = ($built && is_file($built)) ? file_get_contents($built) : null;
        }
    @endphp
    @if ($wbCss)
        <style>{!! $wbCss !!}</style>
    @else
        <div style="background:#fee;color:#900;padding:8px;font-family:monospace">Run <code>npm install &amp;&amp; npm run build</code> to build the workbench CSS.</div>
    @endif
    @fluxAppearance
    @livewireStyles
</head>
<body class="min-h-full bg-zinc-50 text-zinc-800 antialiased dark:bg-zinc-900 dark:text-zinc-200">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-8 flex items-start justify-between gap-4">
            <div>
                <flux:heading size="xl">Laravel Livewire Tables — Workbench</flux:heading>
                <flux:text class="mt-2">
                    v4.0 demo app (Laravel 13 · Livewire 4 · Flux UI). Toggle light/dark to
                    preview the table's dark-mode styling.
                </flux:text>
            </div>

            {{-- Flux's built-in appearance system manages the .dark class + persistence. --}}
            <flux:button
                x-data
                x-on:click="$flux.dark = ! $flux.dark"
                icon="moon"
                variant="subtle"
                aria-label="Toggle dark mode"
            />
        </header>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
            <flux:heading size="lg" class="mb-4">Demo: Pets table</flux:heading>

            <livewire:demo-pets-table />
        </div>
    </div>

    @fluxScripts
    @livewireScripts
</body>
</html>

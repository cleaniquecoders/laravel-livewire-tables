@props(['title' => 'Workbench', 'current' => 'overview', 'description' => null])

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Livewire Tables Workbench</title>

    {{--
        Inline the Vite-built Tailwind + Flux CSS. Testbench's serve docroot
        lives in vendor/, so a static @vite/<link> can't reach workbench/public;
        inlining the build is the reliable approach. Run `npm run build`.
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

    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="/" name="Livewire Tables" class="px-2" />

        <flux:navlist variant="outline">
            <flux:navlist.group heading="Demos" class="mt-4">
                <flux:navlist.item icon="home" href="/" :current="$current === 'overview'" wire:navigate>Overview</flux:navlist.item>
                <flux:navlist.item icon="table-cells" href="/columns" :current="$current === 'columns'" wire:navigate>Column types</flux:navlist.item>
                <flux:navlist.item icon="funnel" href="/filters" :current="$current === 'filters'" wire:navigate>Filter types</flux:navlist.item>
                <flux:navlist.item icon="sparkles" href="/features" :current="$current === 'features'" wire:navigate>Features</flux:navlist.item>
                <flux:navlist.item icon="chevron-double-right" href="/pagination" :current="$current === 'pagination'" wire:navigate>Pagination</flux:navlist.item>
                <flux:navlist.item icon="inbox" href="/empty" :current="$current === 'empty'" wire:navigate>Empty state</flux:navlist.item>
            </flux:navlist.group>

            {{-- Each theme page loads only its own CSS/JS, so Tailwind/Bootstrap
                 open in a new tab (full page load) rather than wire:navigate —
                 handy for comparing themes side by side. --}}
            <flux:navlist.group heading="Themes" expandable :expanded="$current === 'themes'" class="mt-4">
                <flux:navlist.item href="/themes/flux" :current="$current === 'themes'" wire:navigate>
                    <x-slot:icon><x-workbench::icons.flux /></x-slot:icon>
                    Flux
                </flux:navlist.item>
                <flux:navlist.item href="/themes/tailwind" target="_blank">
                    <x-slot:icon><x-workbench::icons.tailwind /></x-slot:icon>
                    Tailwind
                </flux:navlist.item>
                <flux:navlist.item href="/themes/bootstrap" target="_blank">
                    <x-slot:icon><x-workbench::icons.bootstrap /></x-slot:icon>
                    Bootstrap
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="arrow-top-right-on-square" href="https://rappasoft.com/docs/laravel-livewire-tables" target="_blank">Documentation</flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>

    <flux:header class="lg:hidden border-b border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
    </flux:header>

    <flux:main>
        <div class="mx-auto max-w-7xl">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <flux:heading size="xl">{{ $title }}</flux:heading>
                    @isset($description)
                        <flux:text class="mt-2">{{ $description }}</flux:text>
                    @endisset
                </div>
                <flux:button class="hidden lg:inline-flex" x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
            </div>

            {{ $slot }}
        </div>
    </flux:main>

    @fluxScripts
    @livewireScripts
</body>
</html>

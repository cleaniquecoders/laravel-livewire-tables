<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Livewire Tables — Workbench</title>

    {{-- Apply the stored/preferred theme before paint to avoid a flash. --}}
    <script>
        (function () {
            const stored = localStorage.getItem('workbench-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' };</script>

    @livewireStyles
</head>
<body class="h-full text-gray-900 dark:text-gray-100 antialiased">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-8 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold dark:text-white">Laravel Livewire Tables — Workbench</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    v4.0 demo app (Laravel 13 + Livewire 4). Toggle light/dark to preview the
                    component's dark-mode styling. Expanded under milestone <strong>M2</strong>.
                </p>
            </div>

            <button
                type="button"
                onclick="toggleWorkbenchTheme()"
                aria-label="Toggle light and dark mode"
                class="shrink-0 inline-flex items-center gap-1.5 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
            >
                <span class="dark:hidden">🌙 Dark</span>
                <span class="hidden dark:inline">☀️ Light</span>
            </button>
        </header>

        <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h2 class="mb-4 text-lg font-semibold dark:text-white">Demo: Pets table</h2>
            <livewire:demo-pets-table />
        </section>
    </div>

    <script>
        function toggleWorkbenchTheme() {
            const el = document.documentElement;
            el.classList.toggle('dark');
            localStorage.setItem('workbench-theme', el.classList.contains('dark') ? 'dark' : 'light');
        }
    </script>

    @livewireScripts
</body>
</html>

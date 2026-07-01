@props(['title' => 'Bootstrap theme'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Livewire Tables Workbench</title>

    {{-- Bootstrap 5 ONLY — no Tailwind, no Flux — so this page is isolated. --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body>
    <nav class="navbar navbar-expand bg-body-tertiary border-bottom">
        <div class="container-xxl">
            <a class="navbar-brand" href="/">← Workbench</a>
            <span class="navbar-text me-auto fw-semibold">{{ $title }}</span>
            <ul class="navbar-nav align-items-center gap-2">
                {{-- Cross-theme links open in a new tab so assets stay isolated. --}}
                <li class="nav-item"><a class="nav-link d-inline-flex align-items-center gap-1" href="/themes/flux" target="_blank"><x-workbench::icons.flux class="w-4 h-4" /> Flux</a></li>
                <li class="nav-item"><a class="nav-link d-inline-flex align-items-center gap-1" href="/themes/tailwind" target="_blank"><x-workbench::icons.tailwind class="w-4 h-4" /> Tailwind</a></li>
                <li class="nav-item"><a class="nav-link active fw-semibold d-inline-flex align-items-center gap-1" href="/themes/bootstrap"><x-workbench::icons.bootstrap class="w-4 h-4" /> Bootstrap</a></li>
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                        onclick="const h=document.documentElement; h.setAttribute('data-bs-theme', h.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');"
                        aria-label="Toggle dark mode">☾</button>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container-xxl py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>

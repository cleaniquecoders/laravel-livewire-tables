@props(['title' => 'Bootstrap 4 theme'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Livewire Tables Workbench</title>

    {{-- Bootstrap 4 ONLY — no Tailwind, no Flux, no Bootstrap 5 — so this page is isolated. --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body>
    <nav class="navbar navbar-expand bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="/">← Workbench</a>
            <span class="navbar-text mr-auto font-weight-bold">{{ $title }}</span>
            <ul class="navbar-nav align-items-center">
                {{-- Cross-theme links open in a new tab so assets stay isolated. --}}
                <li class="nav-item"><a class="nav-link d-inline-flex align-items-center" href="/themes/flux" target="_blank"><x-workbench::icons.flux class="mr-1" style="width:1rem;height:1rem" /> Flux</a></li>
                <li class="nav-item"><a class="nav-link d-inline-flex align-items-center" href="/themes/tailwind" target="_blank"><x-workbench::icons.tailwind class="mr-1" style="width:1rem;height:1rem" /> Tailwind</a></li>
                <li class="nav-item"><a class="nav-link active font-weight-bold d-inline-flex align-items-center" href="/themes/bootstrap4"><x-workbench::icons.bootstrap class="mr-1" style="width:1rem;height:1rem" /> Bootstrap 4</a></li>
                <li class="nav-item"><a class="nav-link d-inline-flex align-items-center" href="/themes/bootstrap" target="_blank"><x-workbench::icons.bootstrap class="mr-1" style="width:1rem;height:1rem" /> Bootstrap 5</a></li>
            </ul>
        </div>
    </nav>

    <main class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>

# Workbench — Livewire Tables demo app

An Orchestra Testbench [workbench](https://packages.tools/testbench/the-workbench) that runs this package as a real Laravel app so you can visually QA every column, filter, and feature. It is the QA harness for milestones M3 (bugs) and M5 (UX/UI).

The dev-harness chrome (page layout, dark-mode toggle) uses **Flux UI**; the page CSS is built with **Vite + Tailwind v4** (Flux + the package's own utility classes). The package's data-table keeps its own Tailwind/Bootstrap markup.

## Run it

> `livewire/flux` and the front-end toolchain are dev-only (`require-dev` / `devDependencies`) — they do not ship with the package.

```bash
composer install        # PHP deps (incl. livewire/flux, dev only)
npm install             # front-end deps (vite, tailwindcss v4, @tailwindcss/vite)
npm run build           # build workbench CSS -> workbench/public/build (gitignored)
composer build          # create + migrate + seed the demo SQLite DB
composer serve          # start the dev server (http://127.0.0.1:8000) — Ctrl+C to stop
```

Open the served URL. You'll see the demo `DemoPetsTable` with a 🌙/☀️ light/dark toggle (Flux appearance). Re-run `npm run build` after changing `workbench/resources/css/app.css`.

> Note: `php artisan serve` can print a harmless `file_put_contents(): ... Broken pipe` notice when the browser cancels a request — it can be ignored.

## Layout

```
workbench/
  app/
    Livewire/DemoPetsTable.php        # reference demo table (columns + filters)
    Models/{Pet,Owner,Species,Breed}.php
    Providers/WorkbenchServiceProvider.php
  database/
    migrations/                       # owners, species, breeds, pets
    seeders/DatabaseSeeder.php
  resources/
    css/app.css                       # Tailwind v4 + Flux (built by Vite)
    js/app.js
    views/welcome.blade.php           # Flux chrome + dark toggle + <livewire:demo-pets-table />
  routes/web.php
vite.config.js                        # builds workbench assets into workbench/public/build
```

## Extending (milestone M2)

Add one demo component per column type (17), filter type (12), and feature
(bulk actions, reordering, secondary header, collapsible, lazy load, …), each
registered in `WorkbenchServiceProvider` and linked from a showcase index, with
a Tailwind / Bootstrap 4 / Bootstrap 5 theme switcher. See the
`v4.x — Post-4.0 Follow-ups` milestone (#9, #10).

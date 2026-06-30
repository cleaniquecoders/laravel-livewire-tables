# Workbench — Livewire Tables demo app

An Orchestra Testbench [workbench](https://packages.tools/testbench/the-workbench) that runs this package as a real Laravel app so you can visually QA every column, filter, and feature. It is the QA harness for milestones M3 (bugs) and M5 (UX/UI).

## Run it

> Activates after the v4 upgrade (milestone M1) and `composer install`. The current `composer.json` still targets Livewire 3 constraints, so install will resolve those until M1 lands.

```bash
composer install
composer build      # vendor/bin/testbench workbench:build  (migrate:fresh --seed, publish assets)
composer serve      # vendor/bin/testbench serve
```

Then open the served URL (default `http://127.0.0.1:8000`).

## Layout

```
workbench/
  app/
    Livewire/DemoPetsTable.php        # reference demo table (columns + filters)
    Models/{Pet,Owner,Species,Breed}.php
    Providers/WorkbenchServiceProvider.php
  database/
    migrations/                       # owners, species, breeds, pets
    seeders/DatabaseSeeder.php        # Pet/Owner/Species/Breed fixtures
  resources/views/welcome.blade.php   # landing page (Tailwind via CDN)
  routes/web.php
```

## Extending (milestone M2)

Add one demo component per column type (17), filter type (12), and feature
(bulk actions, reordering, secondary header, collapsible, lazy load, …), each
registered in `WorkbenchServiceProvider` and linked from a showcase index, with
a Tailwind / Bootstrap 4 / Bootstrap 5 theme switcher. See GitHub milestone
**M2: Testbench & Demo Workbench**.

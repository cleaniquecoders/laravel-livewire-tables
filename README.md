[![Latest Tag](https://img.shields.io/github/v/tag/cleaniquecoders/laravel-livewire-tables?style=flat-square&sort=semver&label=release)](https://github.com/cleaniquecoders/laravel-livewire-tables/tags) [![License](https://img.shields.io/github/license/cleaniquecoders/laravel-livewire-tables?style=flat-square)](LICENSE.md) ![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white) ![Laravel](https://img.shields.io/badge/Laravel-12%20%7C%2013-FF2D20?style=flat-square&logo=laravel&logoColor=white) ![Livewire](https://img.shields.io/badge/Livewire-4-FB70A9?style=flat-square) [![Styling](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/php-cs-fixer.yml) [![Tests](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/run-tests.yml/badge.svg)](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/run-tests.yml) ![PHPStan Level 6](https://img.shields.io/badge/PHPStan-level%206-brightgreen.svg?style=flat-square)

A dynamic Laravel Livewire component for data tables.

> **This is the `cleaniquecoders/laravel-livewire-tables` fork (v4.0).** It targets **Laravel 12/13 + Livewire 4** and **drops Livewire 3** — created because upstream declined Livewire 4 support ([rappasoft#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315), `wontfix`). See [docs/05-support/02-upgrading.md](docs/05-support/02-upgrading.md) to upgrade. All credit for the original package goes to [@rappasoft](https://github.com/rappasoft) and its contributors.
>
> **Requirements:** PHP 8.2+ · Laravel 12 or 13 · Livewire 4.

v4.0 adds a **Flux theme** that renders the table and every control with native
[Flux UI](https://fluxui.dev) components, in light and dark mode:

![Flux theme — Overview table in light mode](docs/assets/screenshots/flux-overview-light.png)

![Flux theme — the same table in dark mode](docs/assets/screenshots/flux-overview-dark.png)

A runnable local demo of every column, filter, feature, and theme lives in the workbench — see
[Development · Workbench](docs/02-development/02-workbench.md).

## Quick Start

> [!IMPORTANT]
> This fork is **not published to Packagist**. A plain `composer require rappasoft/laravel-livewire-tables`
> would install the upstream **v3** from Packagist instead. To use this **v4** fork you must add it as a
> Composer **VCS repository** first (step 1). The package name and the `Rappasoft\LaravelLivewireTables\`
> namespace are unchanged, so your existing code needs no edits.

**1. Point Composer at this fork.** Add to your application's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/cleaniquecoders/laravel-livewire-tables"
        }
    ]
}
```

**2. Require the `4.0` branch** (the release is not tagged yet, so use the dev branch):

```bash
composer require rappasoft/laravel-livewire-tables:dev-4.0
```

Livewire 4 bundles Alpine.js, so no separate Alpine install is needed.

**3. Generate a table** for one of your models:

```bash
php artisan make:datatable UsersTable User
```

**4. Render it** in any Blade view:

```blade
<livewire:users-table />
```

You now have a sortable, searchable, paginated table. To use the Flux theme, call `->setTheme('flux')`
in the component's `configure()` method (requires the free `livewire/flux` package).

For the full details see the [installation guide](docs/04-reference/01-getting-started/installation.md)
and [creating components](docs/04-reference/02-usage/creating-components.md).

## Documentation and Usage Instructions

Start with the [project documentation](docs/README.md) in this repository — it covers the v4 fork, the
Flux theme, the workbench demo, testing, and the upgrade guide. The original end-user reference is also
mirrored at [rappasoft.com/docs/laravel-livewire-tables](https://rappasoft.com/docs/laravel-livewire-tables).

To upgrade from v3, see the [migration guide](docs/05-support/02-upgrading.md).

## Basic Example

```php
<?php

namespace App\Http\Livewire\Admin\User;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Name')
                ->sortable(),
        ];
    }
}

```

### [See advanced example](https://rappasoft.com/docs/laravel-livewire-tables/v2/examples/advanced-example)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please e-mail anthony@rappasoft.com to report any security vulnerabilities instead of the issue tracker.

## Credits

- [Anthony Rappa](https://github.com/rappasoft)
- [Joe McElwee](https://github.com/lrljoe)
- [All Contributors](./CONTRIBUTORS.md)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

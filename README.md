![Package Logo](https://banners.beyondco.de/Laravel%20Livewire%20Tables.png?theme=light&packageName=rappasoft%2Flaravel-livewire-tables&pattern=hideout&style=style_1&description=A+dynamic+table+component+for+Laravel+Livewire&md=1&fontSize=100px&images=table)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rappasoft/laravel-livewire-tables.svg?style=flat-square)](https://packagist.org/packages/rappasoft/laravel-livewire-tables)
[![License](https://img.shields.io/github/license/cleaniquecoders/laravel-livewire-tables?style=flat-square)](LICENSE.md)
[![Styling](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/php-cs-fixer.yml)
[![Tests](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/run-tests.yml/badge.svg)](https://github.com/cleaniquecoders/laravel-livewire-tables/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/rappasoft/laravel-livewire-tables.svg?style=flat-square)](https://packagist.org/packages/rappasoft/laravel-livewire-tables)
![PHP Stan Level 6](https://img.shields.io/badge/PHPStan-level%206-brightgreen.svg?style=flat)

### Enjoying this package? [Buy me a beer 🍺](https://www.buymeacoffee.com/rappasoft)

A dynamic Laravel Livewire component for data tables.

> **This is the `cleaniquecoders/laravel-livewire-tables` fork (v4.0).** It targets **Laravel 12/13 + Livewire 4** and **drops Livewire 3** — created because upstream declined Livewire 4 support ([rappasoft#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315), `wontfix`). See [docs/v4/MIGRATION.md](docs/v4/MIGRATION.md) to upgrade. All credit for the original package goes to [@rappasoft](https://github.com/rappasoft) and its contributors.
>
> **Requirements:** PHP 8.2+ · Laravel 12 or 13 · Livewire 4.

v4.0 adds a **Flux theme** that renders the table and every control with native
[Flux UI](https://fluxui.dev) components, in light and dark mode:

![Flux theme — Overview table in light mode](docs/assets/screenshots/flux-overview-light.png)

![Flux theme — the same table in dark mode](docs/assets/screenshots/flux-overview-dark.png)

A runnable local demo of every column, filter, feature, and theme lives in the workbench — see
[Development · Workbench](docs/02-development/02-workbench.md).

### [Bootstrap 4 Demo](https://tables.laravel-boilerplate.com/bootstrap-4) | [Bootstrap 5 Demo](https://tables.laravel-boilerplate.com/bootstrap-5) | [Tailwind Demo](https://tables.laravel-boilerplate.com/tailwind) | [Demo Repository](https://github.com/rappasoft/laravel-livewire-tables-demo)

## Installation

You can install the package via composer:

``` bash
composer require cleaniquecoders/laravel-livewire-tables:^4.0
```

Livewire 4 bundles Alpine.js, so no separate Alpine install is required.

## Documentation and Usage Instructions

Start with the [project documentation](docs/README.md) in this repository — it covers the v4 fork, the
Flux theme, the workbench demo, testing, and the upgrade guide. The original end-user reference is also
mirrored at [rappasoft.com/docs/laravel-livewire-tables](https://rappasoft.com/docs/laravel-livewire-tables).

To upgrade from v3, see the [migration guide](docs/v4/MIGRATION.md).

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

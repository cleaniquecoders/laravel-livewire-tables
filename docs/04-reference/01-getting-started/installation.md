# Installation

This is the `cleaniquecoders/laravel-livewire-tables` fork (v4.0). It keeps the original Composer
package name, `rappasoft/laravel-livewire-tables`, and is **not published to Packagist** — so you
install it by pointing Composer at the fork's Git repository with a VCS repository entry.

## 1. Add the fork as a VCS repository

Add a `repositories` entry to your application's `composer.json`:

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

Because the fork's own `composer.json` uses the same package name, Composer resolves
`rappasoft/laravel-livewire-tables` from this repository instead of Packagist.

You can also add it from the command line:

```bash
composer config repositories.livewire-tables vcs https://github.com/cleaniquecoders/laravel-livewire-tables
```

## 2. Require the 4.0 branch

The v4.0 release is not tagged yet, so require the `4.0` branch as a dev version:

```bash
composer require rappasoft/laravel-livewire-tables:dev-4.0
```

Your `composer.json` will then contain:

```json
{
    "require": {
        "rappasoft/laravel-livewire-tables": "dev-4.0"
    }
}
```

If Composer refuses to install the dev version, add the stability flags to your `composer.json`
(requiring `dev-4.0` explicitly usually already carries its own stability flag, so this is only needed
if you see a stability error):

```json
{
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

## 3. Nothing else changes

The PHP namespace is unchanged — it is still `Rappasoft\LaravelLivewireTables\` — so your tables,
columns, and filters keep working without any `use`-statement changes. Livewire 4 bundles Alpine.js,
so no separate Alpine install is required.

## Updating

Pull the latest commits on the `4.0` branch with:

```bash
composer update rappasoft/laravel-livewire-tables
```

## Once v4.0 is tagged

When a `v4.0.0` tag is published on the fork you can switch from the branch to a version constraint;
keep the VCS repository entry in place and only change the constraint:

```bash
composer require rappasoft/laravel-livewire-tables:^4.0
```

See [Requirements](requirements.md) for the supported PHP, Laravel, and Livewire versions.

# Getting started

This is the `cleaniquecoders/laravel-livewire-tables` fork, targeting **v4.0**. It runs on **Laravel 12
or 13** with **Livewire 4** and **drops Livewire 3 entirely**. The fork exists because upstream declined
Livewire 4 support ([rappasoft#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315),
marked `wontfix`) and had not shipped Laravel 13 support.

The Composer package name is still `rappasoft/laravel-livewire-tables` (the rebrand is deferred to
milestone M6), so the namespace remains `Rappasoft\LaravelLivewireTables\`.

## Installation

The fork keeps the `rappasoft/laravel-livewire-tables` package name and is not published to Packagist,
so add it as a VCS repository in your application's `composer.json` and require the `4.0` branch:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/cleaniquecoders/laravel-livewire-tables" }
    ]
}
```

```bash
composer require rappasoft/laravel-livewire-tables:dev-4.0
```

Livewire 4 bundles Alpine.js, so there is **no separate Alpine install** required. See the
[installation guide](../04-reference/01-getting-started/installation.md) for the full details.

## Requirements

| Dependency          | Version         |
| ------------------- | --------------- |
| PHP                 | `^8.2`          |
| Laravel             | `^12` or `^13`  |
| Livewire            | `^4`            |
| Orchestra Testbench | `^10` or `^11`  |

The test suite runs on **Pest 4** (PHPUnit 12 under the hood). Code style is enforced with **Pint**, and
static analysis uses **Larastan / PHPStan (level 6)** plus **Psalm**.

## Local development setup

Clone the repository and install the development dependencies:

```bash
composer install
```

Run the test suite (Pest):

```bash
composer test
```

Format the codebase with Pint:

```bash
composer format
```

Run static analysis with PHPStan / Larastan:

```bash
vendor/bin/phpstan analyse
```

## Release status

The v4.0 release is **held** — there is no `v4.0.0` tag or Packagist publish yet, pending a maintainer
decision. The full suite currently passes at **1535 tests**.

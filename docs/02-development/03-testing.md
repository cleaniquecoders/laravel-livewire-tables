# Testing

The package is tested with **Pest 4** running on **Orchestra Testbench 11** (PHPUnit 12 under the hood).
The full suite currently passes at **1535 tests**.

## The self-seeding TestCase

The base `tests/TestCase.php` extends `Orchestra\Testbench\TestCase` and self-seeds an SQLite database.
On the first run it includes the migration stub at
`database/migrations/create_test_tables.php.stub`, tears the tables down and back up, then inserts the
Owner, Species, Breed, Pet, Veterinary, and pivot fixtures inside `setUp()`. When
`tests/../database/database.sqlite` exists it is used; otherwise the connection falls back to an
in-memory database.

Each helper (`setupBasicTable()`, `setupBreedsTable()`, `setupSpeciesTable()`, and so on) instantiates a
table component from `tests/Http/Livewire/` and calls `bootAll()` so the traits initialise before
assertions run.

## Why the TestCase registers Flux

`getPackageProviders()` registers `Flux\FluxServiceProvider` alongside the Livewire, Blade Icons,
Heroicons, and package providers:

```php
protected function getPackageProviders($app): array
{
    return [
        TestServiceProvider::class,
        LivewireServiceProvider::class,
        LaravelLivewireTablesServiceProvider::class,
        BladeIconsServiceProvider::class,
        BladeHeroiconsServiceProvider::class,
        // Registered so the Flux theme's <flux:*> component tags compile as
        // real components under test (otherwise they are left as literal
        // text and Flux-specific compile errors only surface at runtime).
        FluxServiceProvider::class,
    ];
}
```

Without this provider, `<flux:*>` tags would be left as literal text during compilation, and any
Flux-specific compile error would only surface at runtime instead of failing the suite.

## Flux test coverage

The Flux theme — the v4 headline feature — has dedicated coverage:

| Test                                        | What it verifies                                                     |
| ------------------------------------------- | -------------------------------------------------------------------- |
| `tests/Unit/Traits/Core/HasThemeTest.php`   | `isFlux()` detection and the `useFluxTable()` fallback gates         |
| `tests/Feature/FluxThemeRenderTest.php`     | Rendered `data-flux-*` markers and `flux:badge` filter/sorting pills |
| `tests/Http/Livewire/FluxPetsTable.php`     | A table component fixture wired to the flux theme                    |

## Commands

Run the Pest suite:

```bash
composer test
```

Format the codebase with Pint:

```bash
composer format
```

Run static analysis with PHPStan / Larastan (level 6):

```bash
vendor/bin/phpstan analyse
```

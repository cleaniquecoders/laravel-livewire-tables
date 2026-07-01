# Release process

This page documents how a v4.0 release is cut for this fork
([`cleaniquecoders/laravel-livewire-tables`](https://github.com/cleaniquecoders/laravel-livewire-tables)).

## Current status: HELD

The release is intentionally **held**. There is **no `v4.0.0` tag and no Packagist publish yet** — this is a maintainer
decision. All v4.0 work sits under the `[Unreleased] - v4.0 (cleaniquecoders fork)` heading in `CHANGELOG.md` until the
release is approved. Do not tag or publish until a maintainer explicitly signs off.

## Release readiness at a glance

| Item | Target |
|---|---|
| Test suite | 1535 tests passing (Pest 4, PHPUnit 12 under the hood) |
| Static analysis | Larastan / PHPStan level 6 green; Psalm green |
| Code style | Pint clean |
| Composer package name | `rappasoft/laravel-livewire-tables` (rebrand deferred to M6) |
| Requirements | PHP `^8.2`, Laravel `^12 | ^13`, Livewire `^4`, Testbench `^10 | ^11` |

## Pre-release checklist

Complete every item before proceeding to the tagging steps.

- Tests pass: `composer test` is green (full suite, all 1535 tests).
- Pint clean: `composer format` reports no changes.
- PHPStan clean: `vendor/bin/phpstan analyse` is green at level 6 (and Psalm is green).
- CHANGELOG updated: the `[Unreleased]` block is renamed to `v4.0.0` with the release date.
- Docs updated: install, upgrade, and theme docs reflect the shipped API.

## Intended release steps (once approved)

Run these only after a maintainer approves the release.

1. Confirm a green suite and green CI on the release branch.

   ```bash
   composer test
   composer format
   vendor/bin/phpstan analyse
   ```

2. Update `CHANGELOG.md`: rename the `[Unreleased] - v4.0 (cleaniquecoders fork)` heading to `[v4.0.0]` and add the
   release date. Keep the deferred-work note that points at `docs/v4/`.

3. Commit the changelog and docs updates on the release branch and merge to `master`.

4. Tag the release and push the tag.

   ```bash
   git tag -a v4.0.0 -m "v4.0.0"
   git push origin v4.0.0
   ```

5. Publish to Packagist. The composer package name is still **`rappasoft/laravel-livewire-tables`** — the M6 rebrand is
   deferred and needs maintainer sign-off, so the published package keeps the existing name until that decision lands.

6. Create the GitHub release from the `v4.0.0` tag using the changelog entry as the release notes.

## Notes

- Frontend assets are committed raw and pre-minified, so no build artifact needs to be produced at release time; the
  Vite pipeline is workbench-only (package-dev) and is not shipped.
- The `workbench/` demo app is package-dev only and is excluded from the published package.

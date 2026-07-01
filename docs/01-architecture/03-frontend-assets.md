# Frontend assets

The package needs a small amount of CSS and JavaScript in the browser to drive interactions such as reordering,
dropdowns, and range sliders (built on Alpine.js, which Livewire 4 bundles for you). This document explains how
those assets reach the page: the runtime auto-injection mechanism, the config toggles that control it, and the
workbench-only Vite pipeline used during package development.

Assets ship in two forms in the repository: raw source files and pre-minified builds, both committed under
`resources/`. There is no separate install step for the shipped assets.

## Building the shipped assets

The minified `*.min.js` / `*.min.css` files are produced from their sources by [esbuild](https://esbuild.github.io)
(the minifier Vite is built on), via `build-assets.mjs`:

```bash
npm run build:assets
```

Because the core scripts are standalone Alpine registrations and the CSS is plain (not ES modules), esbuild
**minifies** them without bundling, which preserves their runtime behaviour. This replaces the old hand-rolled
`minifyJs` shell script. CI runs `npm run build:assets` on every push to verify the build succeeds. The committed
`*.min` files are kept as the shipped assets — regenerate and commit them (and QA in a browser) when the sources
change.

## Runtime auto-injection

By default the package injects its assets automatically, so you do not add `<script>` or `<link>` tags by hand.
Two pieces cooperate:

- `src/Mechanisms/RappasoftFrontendAssets` — the mechanism that registers and boots the package's frontend assets
  (core and third-party) and knows how to emit them.
- `src/Features/AutoInjectRappasoftAssets` — a Livewire `ComponentHook` that hooks into the component lifecycle and
  injects the required assets into the response when a data table is present on the page.

The service provider wires these up. In `register()`, when any asset or directive toggle is enabled, it calls
`(new RappasoftFrontendAssets)->register()` and registers the component hook:

```php
public function register(): void
{
    $this->mergeConfigFrom(__DIR__.'/../config/livewire-tables.php', 'livewire-tables');

    if (config('livewire-tables.inject_core_assets_enabled')
        || config('livewire-tables.inject_third_party_assets_enabled')
        || config('livewire-tables.enable_blade_directives')) {
        (new RappasoftFrontendAssets)->register();
        ComponentHookRegistry::register(AutoInjectRappasoftAssets::class);
    }
}
```

In `boot()`, under the same condition, it boots the assets mechanism:

```php
if (config('livewire-tables.inject_core_assets_enabled')
    || config('livewire-tables.inject_third_party_assets_enabled')
    || config('livewire-tables.enable_blade_directives')) {
    (new RappasoftFrontendAssets)->boot();
}
```

Because the assets are injected at runtime, a standard install needs no bundler and no manual asset publishing. If
you prefer to serve the compiled files yourself, publish them with the `livewire-tables-public` tag, which copies
the CSS and JS into your application's public path.

## Config toggles

Asset behaviour is controlled by keys in `config/livewire-tables.php`:

| Config key                          | Default | Effect                                                          |
| ----------------------------------- | ------- | -------------------------------------------------------------- |
| `inject_core_assets_enabled`        | `true`  | Auto-inject the package's own core CSS/JS                       |
| `inject_third_party_assets_enabled` | `true`  | Auto-inject the bundled third-party assets                     |
| `enable_blade_directives`           | `false` | Enable manual Blade directives instead of relying on injection |
| `cache_assets`                      | `false` | Cache the injected assets rather than reading them each request|
| `script_base_path`                  | —       | Base path used when serving the scripts and styles             |

If you switch off auto-injection (for example to manage assets through your own bundler), enable
`enable_blade_directives` so you can place the package's script and style directives manually. Any one of
`inject_core_assets_enabled`, `inject_third_party_assets_enabled`, or `enable_blade_directives` being truthy is
enough for the service provider to register and boot the asset machinery.

## Workbench Vite pipeline (development only)

The workbench demo app under `workbench/` uses a Vite pipeline to compile its own CSS (Tailwind for the Tailwind
and Flux demos, with Bootstrap loaded from a CDN on the Bootstrap demo page). This pipeline exists purely for
package development and is **not** part of what ships to consuming applications — production apps rely on the
runtime auto-injection described above.

Build the workbench CSS once with:

```bash
npm run build
```

Or run the demo with the CSS build watching for changes:

```bash
composer serve
```

`composer serve` runs `testbench serve` (port 8000) and `vite build --watch` concurrently, so edits to the
workbench styles recompile as you browse the demo pages.

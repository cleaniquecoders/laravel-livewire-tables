# Recommended

While the package is very customisable, and supports a number of different approaches.  The below is the recommended approach, that gives the best performance for the tables:

## Installation

This fork is not published to Packagist. Add it as a VCS repository and require the `4.0` branch —
see [Installation](installation.md) for the full `composer.json` `repositories` entry:

```
composer require rappasoft/laravel-livewire-tables:dev-4.0
```

## Publish the Tables Config
```
php artisan vendor:publish --tag="livewire-tables-config"
```

## Livewire Tables Config Updates
Update the published Livewire Tables Config (config/livewire-tables.php) and set the following to false:
```php
    /**
     * Cache Rappasoft Frontend Assets
     */
    'cache_assets' => false,

    /**
     * Enable or Disable automatic injection of core assets
     */
    'inject_core_assets_enabled' => false,

    /**
     * Enable or Disable automatic injection of third-party assets
     */
    'inject_third_party_assets_enabled' => false,

    /**
     * Enable Blade Directives (Not required if automatically injecting or using bundler approaches)
     */
    'enable_blade_directives' => false,
```

## Bundling the Assets
As you have now told the package not to inject the assets, add the following to your resources/js/app.js file:

```js
import '../../vendor/rappasoft/laravel-livewire-tables/resources/imports/laravel-livewire-tables-all.js';
```

## Update Layouts
Ensure that your layouts do not reference any of the following blade directives, as these are not required with the above approach
```html
    <!-- Adds the Core Table Styles -->
    @rappasoftTableStyles
    
    <!-- Adds any relevant Third-Party Styles (Used for DateRangeFilter (Flatpickr) and NumberRangeFilter) -->
    @rappasoftTableThirdPartyStyles

    <!-- Adds the Core Table Scripts -->
    @rappasoftTableScripts

    <!-- Adds any relevant Third-Party Scripts (e.g. Flatpickr) -->
    @rappasoftTableThirdPartyScripts
```

## Tailwind Specific

The package's Blade views must be scanned by Tailwind so its core classes are included in your build.

**Tailwind 4** (CSS-based config) — add `@source` directives to your CSS entrypoint (e.g. `resources/css/app.css`):

```css
@source '../../vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php';
@source '../../app/Livewire/**/*.php';
```

**Tailwind 3** (`tailwind.config.js`) — add the same paths to the `content` array:

```js
    './vendor/rappasoft/laravel-livewire-tables/resources/views/*.blade.php',
    './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',
    './app/Livewire/*.php',
    './app/Livewire/**/*.php',
```

Including your Livewire component paths ensures classes used in `setTdAttributes` (and similar) are picked up.

## Run your build process
```
npm run build
```

## Clear Cached Views
```
php artisan view:clear
```

You may of course run view:cache at this point.
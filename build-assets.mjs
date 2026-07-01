// Builds the package's shipped, minified frontend assets from their sources
// using esbuild (the minifier Vite is built on). These are standalone Alpine
// scripts and plain CSS — not ES modules — so they are minified, NOT bundled,
// which preserves their runtime behaviour. Replaces the hand-rolled `minifyJs`
// shell script. Run with: npm run build:assets
import { readFileSync, writeFileSync } from 'node:fs';
import { transform } from 'esbuild';

const jsFiles = [
    'resources/js/laravel-livewire-tables.js',
    'resources/js/laravel-livewire-tables-thirdparty.js',
    'resources/js/partials/filter-boolean.js',
    'resources/js/partials/filter-date-range.js',
    'resources/js/partials/filter-number-range.js',
    'resources/js/partials/reorder.js',
    'resources/js/partials/tableWrapper.js',
];

const cssFiles = [
    'resources/css/laravel-livewire-tables.css',
    'resources/css/laravel-livewire-tables-thirdparty.css',
    'resources/css/bootstrap-custom.css',
];

async function minify(file, loader) {
    const source = readFileSync(file, 'utf8');
    const { code } = await transform(source, { minify: true, loader, legalComments: 'none' });
    const out = file.replace(new RegExp(`\\.${loader}$`), `.min.${loader}`);
    writeFileSync(out, code);
    console.log(`  ${file} -> ${out} (${code.length} bytes)`);
}

console.log('Building package frontend assets with esbuild...');
for (const file of jsFiles) {
    await minify(file, 'js');
}
for (const file of cssFiles) {
    await minify(file, 'css');
}
console.log('Done.');

<?php

/*
|--------------------------------------------------------------------------
| Architecture tests (Pest)
|--------------------------------------------------------------------------
|
| Guardrails for the v4 codebase. Kept conservative so they pass today and
| catch regressions going forward.
|
*/

arch('source ships no debug statements')
    ->expect('Rappasoft\LaravelLivewireTables')
    ->not->toUse(['dd', 'dump', 'ray', 'var_dump']);

arch('no Livewire 3 console internals are referenced')
    ->expect('Rappasoft\LaravelLivewireTables')
    ->not->toUse([
        'Livewire\Features\SupportConsoleCommands\Commands\ComponentParser',
        'Livewire\Features\SupportConsoleCommands\Commands\MakeCommand',
    ]);

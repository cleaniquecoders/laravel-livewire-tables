<?php

use Illuminate\Support\Facades\Route;

/*
| Workbench demo routes. Each page wraps the shared Flux sidebar layout and
| embeds one or more demo table components.
*/

Route::view('/', 'workbench::pages.overview')->name('workbench.home');
Route::view('/columns', 'workbench::pages.columns')->name('workbench.columns');
Route::view('/filters', 'workbench::pages.filters')->name('workbench.filters');
Route::view('/features', 'workbench::pages.features')->name('workbench.features');
Route::view('/pagination', 'workbench::pages.pagination')->name('workbench.pagination');
Route::view('/empty', 'workbench::pages.empty')->name('workbench.empty');
Route::view('/multi-table', 'workbench::pages.multi-table')->name('workbench.multi-table');
Route::view('/responsive', 'workbench::pages.responsive')->name('workbench.responsive');

// Themes get separate pages so each loads only its own CSS/JS (Bootstrap's
// global styles would otherwise collide with Tailwind/Flux on a shared page).
Route::redirect('/themes', '/themes/flux');
Route::view('/themes/flux', 'workbench::pages.themes.flux')->name('workbench.themes.flux');
Route::view('/themes/tailwind', 'workbench::pages.themes.tailwind')->name('workbench.themes.tailwind');
Route::view('/themes/bootstrap4', 'workbench::pages.themes.bootstrap4')->name('workbench.themes.bootstrap4');
Route::view('/themes/bootstrap', 'workbench::pages.themes.bootstrap')->name('workbench.themes.bootstrap');

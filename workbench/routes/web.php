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
Route::view('/themes', 'workbench::pages.themes')->name('workbench.themes');

<?php

use Rappasoft\LaravelLivewireTables\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Bind the package TestCase (Orchestra Testbench) to Pest's functional test
| files. Existing class-based PHPUnit tests continue to run unchanged via
| Pest's PHPUnit interoperability; new tests should be written Pest-native
| (it()/test()/expect()) in the directories below.
|
*/

uses(TestCase::class)->in('Unit', 'Visuals', 'Feature');

<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Unit\Traits\Core;

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;
use Rappasoft\LaravelLivewireTables\Tests\TestCase;
use Rappasoft\LaravelLivewireTables\Views\Column;

final class HasThemeTest extends TestCase
{
    public function test_is_flux_is_true_when_theme_is_flux(): void
    {
        $mock = new class extends PetsTable
        {
            public function configure(): void
            {
                $this->setPrimaryKey('id')->setTheme('flux');
            }

            public function columns(): array
            {
                return [Column::make('ID', 'id')->sortable()];
            }
        };

        $mock->bootAll();

        $this->assertTrue($mock->isFlux());
        // The flux theme is Tailwind-based, so isTailwind() must stay true.
        $this->assertTrue($mock->isTailwind());
    }

    public function test_is_flux_is_false_for_other_themes(): void
    {
        $mock = new class extends PetsTable
        {
            public function configure(): void
            {
                $this->setPrimaryKey('id');
            }

            public function columns(): array
            {
                return [Column::make('ID', 'id')->sortable()];
            }
        };

        $mock->bootAll();

        $this->assertFalse($mock->isFlux());
    }

    public function test_use_flux_table_is_true_for_a_plain_flux_table(): void
    {
        $mock = new class extends PetsTable
        {
            public function configure(): void
            {
                $this->setPrimaryKey('id')->setTheme('flux');
            }

            public function columns(): array
            {
                return [
                    Column::make('ID', 'id')->sortable(),
                    Column::make('Name')->sortable()->searchable(),
                ];
            }
        };

        $mock->bootAll();

        $this->assertTrue($mock->useFluxTable());
    }

    public function test_use_flux_table_is_false_when_theme_is_not_flux(): void
    {
        $mock = new class extends PetsTable
        {
            public function configure(): void
            {
                $this->setPrimaryKey('id');
            }

            public function columns(): array
            {
                return [Column::make('ID', 'id')->sortable()];
            }
        };

        $mock->bootAll();

        $this->assertFalse($mock->useFluxTable());
    }

    public function test_use_flux_table_is_false_when_reordering_is_enabled(): void
    {
        $mock = new class extends PetsTable
        {
            public function configure(): void
            {
                $this->setPrimaryKey('id')
                    ->setTheme('flux')
                    ->setReorderStatus(true);
            }

            public function columns(): array
            {
                return [Column::make('ID', 'id')->sortable()];
            }
        };

        $mock->bootAll();

        $this->assertTrue($mock->isFlux());
        $this->assertFalse($mock->useFluxTable());
    }

    public function test_use_flux_table_is_false_when_a_column_has_a_footer(): void
    {
        // The footer status flag defaults to true, so the gate must additionally
        // require at least one column configured with a footer before falling back.
        $mock = new class extends PetsTable
        {
            public function configure(): void
            {
                $this->setPrimaryKey('id')->setTheme('flux');
            }

            public function columns(): array
            {
                return [
                    Column::make('ID', 'id')->sortable(),
                    Column::make('Name')->footer(fn ($rows) => 'Total'),
                ];
            }
        };

        $mock->bootAll();

        $this->assertTrue($mock->isFlux());
        $this->assertTrue($mock->hasColumnsWithFooter());
        $this->assertFalse($mock->useFluxTable());
    }
}

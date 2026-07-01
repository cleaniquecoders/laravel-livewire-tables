<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Rappasoft\LaravelLivewireTables\Exceptions\DataTableConfigurationException;
use Rappasoft\LaravelLivewireTables\Traits\Core\Component\{HandlesComputedProperties,HandlesEmptyMessage, HandlesFingerprint, HandlesOfflineIndicator,HandlesTableName};

trait ComponentUtilities
{
    use HandlesTableName, HandlesFingerprint, HandlesEmptyMessage, HandlesComputedProperties, HandlesOfflineIndicator;

    public array $table = [];

    protected $model;

    protected bool $hasRunConfigure = false;

    /**
     * Set any configuration options
     */
    abstract public function configure(): void;

    /**
     * Sets the Theme if not set on first mount
     */
    public function mountComponentUtilities(): void
    {
        // Sets the Theme - tailwind/bootstrap
        if (! isset($this->theme) || is_null($this->theme)) {
            $this->setTheme(config('livewire-tables.theme', 'tailwind'));
        }
        $this->generateDataTableFingerprint();

    }

    /**
     * Runs configure() with Lifecycle Hooks on each Lifecycle
     */
    public function bootedComponentUtilities(): void
    {
        $this->runCoreConfiguration();

        // Make sure a primary key is set
        if (! $this->hasPrimaryKey()) {
            throw new DataTableConfigurationException('You must set a primary key using setPrimaryKey in the configure method, or configuring/configured lifecycle hooks');
        }

    }

    protected function runCoreConfiguration(): void
    {
        if (! $this->hasRunConfigure) {
            // Fire Lifecycle Hooks for configuring
            $this->callHook('configuring');
            $this->callTraitHook('configuring');

            // Call the configure() method
            $this->configure();

            // Fire Lifecycle Hooks for configured
            $this->callHook('configured');
            $this->callTraitHook('configured');

            $this->hasRunConfigure = true;

        }
    }

    /**
     * 1. After the sorting method is hit we need to tell the table to go back into reordering mode
     */
    public function hydrate(): void
    {
        $this->restartReorderingIfNecessary();
    }

    // --- merged from ComponentConfiguration (#28) ---

    // --- merged from ComponentHelpers (#28) ---

    public function hasModel(): bool
    {
        return $this->model !== null;
    }

    /**
     * Whether to render the table body with real flux:table components.
     * flux:table cannot preserve reorder drag, clickable-row navigation,
     * responsive column collapsing, bulk-action columns, the loading
     * placeholder row, or the secondary header / footer rows, so fall back to
     * the (Flux-styled) raw table whenever any of those actually renders.
     * The secondary-header / footer status flags default to true, so they are
     * gated on the same condition the datatable view uses to emit those rows
     * (status enabled AND at least one column configured for them).
     */
    #[Computed]
    public function useFluxTable(): bool
    {
        return $this->isFlux()
            && ! $this->reorderIsEnabled()
            && ! $this->hasTableRowUrl()
            && ! $this->showBulkActionsSections()
            && ! $this->showCollapsingColumnSections()
            && ! $this->hasDisplayLoadingPlaceholder()
            && ! ($this->secondaryHeaderIsEnabled() && $this->hasColumnsWithSecondaryHeader())
            && ! ($this->footerIsEnabled() && $this->hasColumnsWithFooter());
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    #[Computed]
    public function getTableId(): string
    {
        return $this->getTableAttributes()['id'] ?? 'table-'.$this->getTableName();
    }
}

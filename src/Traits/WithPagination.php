<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\View\ComponentAttributeBag;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\WithPagination as LivewirePagination;
use Rappasoft\LaravelLivewireTables\Exceptions\DataTableConfigurationException;

trait WithPagination
{
    use LivewirePagination;

    public ?string $pageName = null;

    public ?int $perPage;

    #[Locked]
    public int $defaultPerPage = 10;

    #[Locked]
    public array $perPageAccepted = [10, 25, 50];

    #[Locked]
    public string $paginationTheme = 'tailwind';

    #[Locked]
    public bool $paginationStatus = true;

    #[Locked]
    public bool $paginationVisibilityStatus = true;

    #[Locked]
    public bool $perPageVisibilityStatus = true;

    // Entangled in JS
    public array $paginationCurrentItems = [];

    // Entangled in JS
    public int $paginationCurrentCount = 0;

    // Entangled in JS
    public ?int $paginationTotalItemCount = null;

    public array $numberOfPaginatorsRendered = [];

    // standard, simple, cursor
    protected string $paginationMethod = 'standard';

    protected bool $shouldShowPaginationDetails = true;

    protected bool $shouldRetrieveTotalItemCount = true;

    public function mountWithPagination(): void
    {
        // Restore a previously persisted per-page value, if one exists and is
        // valid. Do NOT fall back to the framework default here: configure()
        // (and any setDefaultPerPage() within it) has not run yet during the
        // mount phase, so the configured default is resolved later in
        // setupPagination() (#2050). A value hydrated from the query string is
        // left untouched.
        $sessionKey = $this->getPerPagePaginationSessionKey();

        if (session()->has($sessionKey)) {
            $sessionPerPage = (int) session()->get($sessionKey);

            if (in_array($sessionPerPage, $this->getPerPageAccepted(), false)) {
                $this->setPerPage($sessionPerPage);
            }
        }
    }

    // TODO: Test
    public function updatedPerPage(int|string $value): void
    {
        if (! in_array((int) $value, $this->getPerPageAccepted(), false)) {
            $value = $this->getDefaultPerPage();
        }

        if (in_array(session($this->getPerPagePaginationSessionKey(), (int) $value), $this->getPerPageAccepted(), true)) {
            session()->put($this->getPerPagePaginationSessionKey(), (int) $value);
        } else {
            session()->put($this->getPerPagePaginationSessionKey(), $this->getPerPageAccepted()[0] ?? 10);
        }
        $this->setPerPage($value);
        $this->resetPage($this->getComputedPageName());

    }

    protected function queryStringWithPagination(): array
    {

        if ($this->queryStringIsEnabled()) {
            return [
                'perPage' => ['except' => null, 'history' => false, 'keep' => false, 'as' => $this->getQueryStringAlias().'perPage'],
            ];
        }

        return [];
    }

    public function renderingWithPagination(): void
    {
        $this->setupPagination();
    }

    // --- merged from PaginationConfiguration (#28) ---

    public function setPageName(string $name): self
    {
        $this->pageName = $name;

        return $this;
    }

    public function setPaginationTheme(string $theme): self
    {
        $this->paginationTheme = $theme;

        return $this;
    }

    public function setPaginationStatus(bool $status): self
    {
        $this->paginationStatus = $status;

        return $this;
    }

    public function setPaginationEnabled(): self
    {
        $this->setPaginationStatus(true);

        return $this;
    }

    public function setPaginationDisabled(): self
    {
        $this->setPaginationStatus(false);

        return $this;
    }

    public function setPaginationVisibilityStatus(bool $status): self
    {
        $this->paginationVisibilityStatus = $status;

        return $this;
    }

    public function setPaginationVisibilityEnabled(): self
    {
        $this->setPaginationVisibilityStatus(true);

        return $this;
    }

    public function setPaginationVisibilityDisabled(): self
    {
        $this->setPaginationVisibilityStatus(false);

        return $this;
    }

    public function setPerPageVisibilityStatus(bool $status): self
    {
        $this->perPageVisibilityStatus = $status;

        return $this;
    }

    public function setPerPageVisibilityEnabled(): self
    {
        $this->setPerPageVisibilityStatus(true);

        return $this;
    }

    public function setPerPageVisibilityDisabled(): self
    {
        $this->setPerPageVisibilityStatus(false);

        return $this;
    }

    /**
     * @param  array<mixed>  $accepted
     */
    public function setPerPageAccepted(array $accepted): self
    {
        $this->perPageAccepted = $accepted;

        return $this;
    }

    /**
     * @throws DataTableConfigurationException
     */
    public function setPerPage(int $perPage): self
    {
        if (! in_array($perPage, $this->getPerPageAccepted(), true)) {
            throw new DataTableConfigurationException('You can only set per page values that are in your accepted values list.');
        }

        $this->perPage = $perPage;

        return $this;
    }

    public function unsetPerPage(): self
    {
        $this->perPage = null;

        return $this;
    }

    public function setPaginationMethod(string $paginationMethod): self
    {
        $this->paginationMethod = $paginationMethod;

        return $this;
    }

    public function setDisplayPaginationDetails(bool $status): self
    {
        $this->shouldShowPaginationDetails = $status;

        return $this;
    }

    public function setDisplayPaginationDetailsEnabled(): self
    {
        $this->setDisplayPaginationDetails(true);

        return $this;
    }

    public function setDisplayPaginationDetailsDisabled(): self
    {
        $this->setDisplayPaginationDetails(false);

        return $this;
    }

    /**
     * Set a default per-page value (if not set already by session or querystring)
     */
    public function setDefaultPerPage(int $defaultPerPage): self
    {
        if (in_array((int) $defaultPerPage, $this->getPerPageAccepted())) {
            $this->defaultPerPage = $defaultPerPage;
        }

        return $this;
    }

    public function setShouldRetrieveTotalItemCountStatus(bool $status): self
    {
        $this->shouldRetrieveTotalItemCount = $status;

        return $this;

    }

    public function setShouldRetrieveTotalItemCountEnabled(): self
    {
        $this->setShouldRetrieveTotalItemCountStatus(true);

        return $this;
    }

    public function setShouldRetrieveTotalItemCountDisabled(): self
    {
        $this->setShouldRetrieveTotalItemCountStatus(false);

        return $this;
    }

    // --- merged from PaginationHelpers (#28) ---

    public function getPageName(): ?string
    {
        return $this->pageName;
    }

    public function hasPageName(): bool
    {
        return $this->pageName !== null;
    }

    public function getPaginationStatus(): bool
    {
        return $this->paginationStatus;
    }

    public function getPaginationTheme(): string
    {
        return $this->paginationTheme;
    }

    #[Computed]
    public function showPaginationDropdown(): bool
    {
        return $this->paginationIsEnabled() && $this->perPageVisibilityIsEnabled();
    }

    #[Computed]
    public function paginationIsEnabled(): bool
    {
        return $this->getPaginationStatus() === true;
    }

    public function paginationIsDisabled(): bool
    {
        return $this->getPaginationStatus() === false;
    }

    public function getPaginationVisibilityStatus(): bool
    {
        return $this->paginationVisibilityStatus;
    }

    public function paginationVisibilityIsEnabled(): bool
    {
        return $this->getPaginationVisibilityStatus() === true;
    }

    public function paginationVisibilityIsDisabled(): bool
    {
        return $this->getPaginationVisibilityStatus() === false;
    }

    public function getComputedPageName(): string
    {
        $pageName = 'page';

        // If the component has a specific page name set
        if ($this->hasPageName()) {
            $pageName = $this->getPageName();
        } elseif (! $this->isTableNamed('table')) {
            // If the component has a custom table name but no custom page name
            $pageName = $this->getTableName().'Page';
        }

        return $pageName;
    }

    public function getPerPage(): int
    {
        return $this->perPage ?? $this->getDefaultPerPage();
    }

    public function getDefaultPerPage(): int
    {
        return in_array((int) $this->defaultPerPage, $this->getPerPageAccepted()) ? $this->defaultPerPage : ($this->getPerPageAccepted()[0] ?? 10);
    }

    /**
     * @return array<mixed>
     */
    public function getPerPageAccepted(): array
    {
        return $this->perPageAccepted;
    }

    public function getPerPageVisibilityStatus(): bool
    {
        return $this->perPageVisibilityStatus;
    }

    public function perPageVisibilityIsEnabled(): bool
    {
        return $this->getPerPageVisibilityStatus() === true;
    }

    public function perPageVisibilityIsDisabled(): bool
    {
        return $this->getPerPageVisibilityStatus() === false;
    }

    public function isPaginationMethod(string $paginationMethod): bool
    {
        return $this->paginationMethod === $paginationMethod;
    }

    /**
     * @return array<mixed>
     */
    public function getPerPageDisplayedItemIds(): array
    {
        return $this->paginationCurrentItems;
    }

    public function getPerPageDisplayedItemCount(): int
    {
        return $this->paginationCurrentCount;
    }

    #[Computed]
    public function showPaginationDetails(): bool
    {
        return $this->shouldShowPaginationDetails === true;
    }

    // TODO: Test
    public function setupPagination(): void
    {
        if ($this->paginationIsDisabled()) {
            // Ensure perPage is initialized for serialization even when disabled.
            if (! isset($this->perPage)) {
                $this->setPerPage($this->getDefaultPerPage());
            }

            return;
        }

        // getPerPage() resolves a session/query-string value or the configured
        // default. Because mountWithPagination() no longer pins perPage before
        // configure() runs, this now correctly honors setDefaultPerPage() (#2050).
        $candidate = (int) session($this->getPerPagePaginationSessionKey(), $this->getPerPage());

        if (in_array($candidate, $this->getPerPageAccepted(), true)) {
            $this->setPerPage($candidate);
        } else {
            $this->setPerPage($this->getDefaultPerPage());
        }
    }

    /**
     * Reset the page using the custom page name
     */
    public function resetComputedPage(): void
    {
        $this->resetPage($this->getComputedPageName());
    }

    private function getPerPagePaginationSessionKey(): string
    {
        return $this->tableName.'-perPage';
    }

    #[Computed]
    public function getShouldRetrieveTotalItemCount(): bool
    {
        return $this->shouldRetrieveTotalItemCount;
    }

    // --- merged from HasPaginationStyling (#28) ---

    protected array $perPageFieldAttributes = ['default-styling' => true, 'default-colors' => true, 'class' => ''];

    protected array $paginationWrapperAttributes = ['class' => ''];

    #[Computed]
    public function getPerPageFieldAttributes(): array
    {
        return $this->perPageFieldAttributes;
    }

    public function getPaginationWrapperAttributes(): array
    {
        return $this->paginationWrapperAttributes ?? ['class' => ''];
    }

    #[Computed]
    public function getPaginationWrapperAttributesBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getPaginationWrapperAttributes());
    }

    public function setPerPageFieldAttributes(array $attributes = []): self
    {
        $this->perPageFieldAttributes = [...$this->perPageFieldAttributes, ...$attributes];

        return $this;
    }

    public function setPaginationWrapperAttributes(array $paginationWrapperAttributes): self
    {
        $this->paginationWrapperAttributes = array_merge(['class' => ''], $paginationWrapperAttributes);

        return $this;
    }
}

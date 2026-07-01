<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

trait WithLoadingPlaceholder
{
    protected bool $displayLoadingPlaceholder = false;

    protected string $loadingPlaceholderContent = 'Loading';

    protected ?string $loadingPlaceholderBlade = null;

    // --- merged from LoadingPlaceholderConfiguration (#28) ---

    public function setLoadingPlaceholderStatus(bool $status): self
    {
        $this->displayLoadingPlaceholder = $status;

        return $this;
    }

    public function setLoadingPlaceholderEnabled(): self
    {
        $this->setLoadingPlaceholderStatus(true);

        return $this;
    }

    public function setLoadingPlaceholderDisabled(): self
    {
        $this->setLoadingPlaceholderStatus(false);

        return $this;
    }

    public function setLoadingPlaceholderContent(string $content): self
    {
        $this->loadingPlaceholderContent = $content;

        return $this;
    }

    public function setLoadingPlaceholderBlade(string $customBlade): self
    {
        $this->loadingPlaceholderBlade = $customBlade;

        return $this;
    }

    // --- merged from LoadingPlaceholderHelpers (#28) ---

    public function hasDisplayLoadingPlaceholder(): bool
    {
        return $this->getDisplayLoadingPlaceholder();
    }

    public function getDisplayLoadingPlaceholder(): bool
    {
        return $this->displayLoadingPlaceholder;
    }

    public function getLoadingPlaceholderContent(): string
    {
        return $this->loadingPlaceholderContent ?? __($this->getLocalisationPath().'loading');
    }

    public function hasLoadingPlaceholderBlade(): bool
    {
        return ! is_null($this->getLoadingPlaceHolderBlade());
    }

    public function getLoadingPlaceHolderBlade(): ?string
    {
        return $this->loadingPlaceholderBlade;
    }

    // --- merged from HasLoadingPlaceholderStyling (#28) ---

    protected array $loadingPlaceHolderAttributes = [];

    protected array $loadingPlaceHolderIconAttributes = [];

    protected array $loadingPlaceHolderWrapperAttributes = [];

    protected array $loadingPlaceHolderRowAttributes = [];

    protected array $loadingPlaceHolderCellAttributes = ['class' => '', 'default' => true];

    public function getLoadingPlaceholderAttributes(): array
    {
        return $this->getCustomAttributes(propertyName: 'loadingPlaceHolderAttributes', default: true, classicMode: true);

    }

    public function getLoadingPlaceHolderIconAttributes(): array
    {
        return $this->getCustomAttributes(propertyName: 'loadingPlaceHolderIconAttributes', default: true, classicMode: true);

    }

    public function getLoadingPlaceHolderWrapperAttributes(): array
    {
        return $this->getCustomAttributes(propertyName: 'loadingPlaceHolderRowAttributes', default: true, classicMode: true);
    }

    public function getLoadingPlaceHolderRowAttributes(): array
    {
        return $this->getCustomAttributes(propertyName: 'loadingPlaceHolderRowAttributes', default: true, classicMode: true);
    }

    public function getLoadingPlaceHolderCellAttributes(): array
    {
        return $this->getCustomAttributes(propertyName: 'loadingPlaceHolderCellAttributes', default: true, classicMode: true);

    }

    public function setLoadingPlaceHolderAttributes(array $attributes): self
    {
        $this->setCustomAttributes('loadingPlaceHolderAttributes', [...$this->getCustomAttributes(propertyName: 'loadingPlaceHolderAttributes', default: false, classicMode: true), ...$attributes]);

        return $this;
    }

    public function setLoadingPlaceHolderIconAttributes(array $attributes): self
    {
        $this->setCustomAttributes('loadingPlaceHolderIconAttributes', [...$this->getCustomAttributes(propertyName: 'loadingPlaceHolderIconAttributes', default: false, classicMode: true), ...$attributes]);

        return $this;
    }

    public function setLoadingPlaceHolderRowAttributes(array $attributes): self
    {
        $this->setCustomAttributes('loadingPlaceHolderRowAttributes', [...$this->getCustomAttributes(propertyName: 'loadingPlaceHolderRowAttributes', default: false, classicMode: true), ...$attributes]);

        return $this;
    }

    public function setLoadingPlaceHolderWrapperAttributes(array $attributes): self
    {
        $this->setCustomAttributes('loadingPlaceHolderRowAttributes', [...$this->getCustomAttributes(propertyName: 'loadingPlaceHolderRowAttributes', default: false, classicMode: true), ...$attributes]);

        return $this;
    }
}

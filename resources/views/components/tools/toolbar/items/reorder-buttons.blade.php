@aware(['tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5','localisationPath'])
<div x-data x-cloak x-show="reorderStatus"
    @class([$this->themeClasses('toolbar.reorder.margin')])
>
    <button
        x-on:click="reorderToggle"
        type="button"
        @class([$this->themeClasses('toolbar.reorder.button')])
    >
        <span x-cloak x-show="currentlyReorderingStatus">
         {{ __($localisationPath.'cancel') }}
        </span>

        <span x-cloak x-show="!currentlyReorderingStatus">
        {{ __($localisationPath.'Reorder') }}
        </span>

    </button>
    
    <div :class="{ 'inline d-inline' : currentlyReorderingStatus }" x-cloak x-show="currentlyReorderingStatus" >
        <button
            type="button"
            x-on:click="updateOrderedItems"
            @class([$this->themeClasses('toolbar.reorder.button') => ($isTailwind || ($isBootstrap && $this->currentlyReorderingStatus))])
        >
            <span>
            {{ __($localisationPath.'save') }}
            </span>
        </button>
    </div>


</div>

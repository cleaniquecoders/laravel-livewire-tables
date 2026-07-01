@php($lwtTheme = ($isTailwind ?? true) ? 'tailwind' : 'bootstrap-5')
<a {{ $attributes->merge()
            ->class([
                lwtThemeClasses($lwtTheme,'actionbtn.styling') => ($attributes['default-styling'] ?? true),
                lwtThemeClasses($lwtTheme,'actionbtn.colors') => $isTailwind && ($attributes['default-colors'] ?? true),
            ])
            ->except(['default','default-styling','default-colors'])
        }}
           @if($action->hasWireAction())
            {{ $action->getWireAction() }}="{{ $action->getWireActionParams() }}"
           @endif
           @if($action->getWireNavigateEnabled())
            wire:navigate
           @endif
        >

        @if($action->hasIcon() && $action->getIconRight())
            <span {{ $action->getLabelAttributesBag() }}>{{ $action->getLabel() }}</span>
            <i {{ $action->getIconAttributes()
                    ->class([lwtThemeClasses($lwtTheme,'actionbtn.iconright').' '.$action->getIcon() => true])
                    ->except(['default','default-styling','default-colors'])
                }}
            ></i>
        @elseif($action->hasIcon() && !$action->getIconRight())
            <i {{ $action->getIconAttributes()
                    ->class([lwtThemeClasses($lwtTheme,'actionbtn.iconleft').' '.$action->getIcon() => true])
                    ->except(['default','default-styling','default-colors'])
                }}
            ></i>
            <span {{ $action->getLabelAttributesBag() }}>{{ $action->getLabel() }}</span>
        @else
            <span {{ $action->getLabelAttributesBag() }}>{{ $action->getLabel() }}</span>
        @endif
</a>

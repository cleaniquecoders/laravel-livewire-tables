@php($lwtTheme = ($isTailwind ?? true) ? 'tailwind' : 'bootstrap-5')
<div @class([lwtThemeClasses($lwtTheme,'column.color.wrapper') => $isTailwind])>
    <div {{ $attributeBag->class([
            lwtThemeClasses($lwtTheme,'column.color.swatch') => $isTailwind && ($attributeBag['default'] ?? (empty($attributeBag['class']) || (!empty($attributeBag['class']) && ($attributeBag['default'] ?? false)))),
        ]) }}
        @style([
            "background-color: {$color}" => $color,
        ])
    >
    </div>
</div>

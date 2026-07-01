@aware([ 'tableName', 'primaryKey','isTailwind','isBootstrap'])
@props(['row', 'rowIndex'])

@if ($this->collapsingColumnsAreEnabled && $this->hasCollapsedColumns)
    @php($customAttributes = $this->getTrAttributes($row, $rowIndex))
    <tr x-data
        @toggle-row-content.window="($event.detail.tableName === '{{ $tableName }}' && $event.detail.row === {{ $rowIndex }}) ? $el.classList.toggle('{{ $this->themeClasses('collapsed.hiddenclass') }}') : null"
        {{
            $attributes->merge([
                    'wire:loading.class.delay' => 'opacity-50 dark:bg-gray-900 dark:opacity-60',
                    'wire:key' => $tableName.'-row-'.$row->{$primaryKey}.'-collapsed-contents',
                ])
                ->merge($customAttributes)
                ->class([
                    $this->themeClasses('collapsed.tr.even') => (($customAttributes['default'] ?? true) && $rowIndex % 2 === 0),
                    $this->themeClasses('collapsed.tr.odd') => (($customAttributes['default'] ?? true) && $rowIndex % 2 !== 0),
                ])
                ->except(['default','default-styling','default-colors'])
        }}
    >
        <td colspan="{{ $this->getColspanCount }}" @class([$this->themeClasses('collapsed.td')])>
            <div>
                @foreach($this->getCollapsedColumnsForContent as $colIndex => $column)

                    <p wire:key="{{ $tableName }}-row-{{ $row->{$primaryKey} }}-collapsed-contents-{{ $colIndex }}" @class([
                            $this->themeClasses('collapsed.p.base') => true,
                            $this->themeClasses('collapsed.p.a') => $column->shouldCollapseAlways(),
                            $this->themeClasses('collapsed.p.b') => !$column->shouldCollapseAlways() && !$column->shouldCollapseOnTablet() && $column->shouldCollapseOnMobile(),
                            $this->themeClasses('collapsed.p.c') => !$column->shouldCollapseAlways() && ($column->shouldCollapseOnTablet() || $column->shouldCollapseOnMobile()),
                            $this->themeClasses('collapsed.p.d') => !$column->shouldCollapseAlways() && !$column->shouldCollapseOnTablet() && !$column->shouldCollapseOnMobile(),
                    ])>
                        <strong>{{ $column->getTitle() }}</strong>: 
                        @if($column->isHtml())
                            {!! $column->setIndexes($rowIndex, $colIndex)->renderContents($row) !!}
                        @else
                            {{ $column->setIndexes($rowIndex, $colIndex)->renderContents($row) }}
                        @endif
                    </p>
                @endforeach
            </div>
        </td>
    </tr>
@endif

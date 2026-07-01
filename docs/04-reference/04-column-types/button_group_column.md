# Button Group Columns

Button group columns let you provide an array of LinkColumns to display in a single cell.

```php
ButtonGroupColumn::make('Actions')
    ->attributes(function($row) {
        return [
            'class' => 'space-x-2',
        ];
    })
    ->buttons([
        LinkColumn::make('View') // make() has no effect in this case but needs to be set anyway
            ->title(fn($row) => 'View ' . $row->name)
            ->location(fn($row) => route('user.show', $row))
            ->attributes(function($row) {
                return [
                    'class' => 'underline text-blue-500 hover:no-underline',
                ];
            }),
        LinkColumn::make('Edit')
            ->title(fn($row) => 'Edit ' . $row->name)
            ->location(fn($row) => route('user.edit', $row))
            ->attributes(function($row) {
                return [
                    'target' => '_blank',
                    'class' => 'underline text-blue-500 hover:no-underline',
                ];
            }),
    ]),
```


Please also see the following for other available methods:
- [Available Methods](../03-columns/available-methods.md)
- [Column Selection](../03-columns/column-selection.md)
- [Secondary Header](../03-columns/secondary-header.md)
- [Footer](../03-columns/footer.md)

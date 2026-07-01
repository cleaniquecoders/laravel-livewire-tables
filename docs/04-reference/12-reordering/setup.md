# Setup

## Multiple tables on one page

Every table defaults to the `tableName` `table`, which is also used to build its DOM ids. If you render
more than one table on the same page, give each a unique `tableName` so their ids (and the reorder
JavaScript's element lookup) never collide — otherwise reordering one table can operate on the wrong
one:

```php
public function configure(): void
{
    $this->setTableName('products'); // unique per table on the page
}
```

## Specify your reorder column and direction

By default the reorder column will be `sort` and the direction will be `asc`.

If you want to change that:

```php
public function configure(): void
{
    $this->setDefaultReorderSort('order', 'desc');
}
```

## Specify your reorder method

By default the method that will be called when the save button is clicked is `reorder`.

If you want to change that:

```php
public function configure(): void
{
    $this->setReorderMethod('changeOrder');
}
```

## Hiding the reorder column unless reordering

If your reorder column is part of your table definition, it will be visible by default. If you want to hide it unless reordering is active you may call this method:

```php
public function configure(): void
{
    $this->setHideReorderColumnUnlessReorderingEnabled();
}
```

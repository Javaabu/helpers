---
title: IsOrdered
sidebar_position: 5
---

This trait adds a sortable order column to a model. When a model is created or updated and the order column is `null`, the order column is automatically set to the next highest order number.

First, add an integer order column to your table.

```php
$table->unsignedInteger('order_column')->index()->default(0);
```

Then use the trait in your model.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Javaabu\Helpers\Traits\IsOrdered;

class MenuItem extends Model
{
    use IsOrdered;
}
```

```php
$first = MenuItem::create(['name' => 'Home']);  // order_column = 0
$second = MenuItem::create(['name' => 'About']); // order_column = 1

// an explicitly given order is not overridden
$third = MenuItem::create(['name' => 'Contact', 'order_column' => 10]); // order_column = 10
```

## Configuration

You can customize the behaviour by overriding the following methods on your model.

```php
class MenuItem extends Model
{
    use IsOrdered;

    // the column used for ordering, defaults to 'order_column'
    public function getOrderColumnName(): string
    {
        return 'sort_order';
    }

    // order number of the first record, defaults to 0
    public function getOrderStartValue(): int
    {
        return 1;
    }

    // set the order when creating if the order column is null, defaults to true
    public function shouldSortWhenCreating(): bool
    {
        return true;
    }

    // set the order when updating if the order column is null, defaults to true
    public function shouldSortWhenUpdating(): bool
    {
        return false;
    }
}
```

:::info

The `updating` event is only fired by Laravel when the model has dirty attributes, so saving an unchanged model will not set the order.

:::

## Changing the start value

By default, ordering starts from `0`. To change it, override the `getOrderStartValue()` method. If you want the same start value for all your models, override it in a shared base model or trait.

## Scoping the order

By default, the highest order number is determined across the whole table. To order records within a group, override the `buildSortQuery()` method.

```php
use Illuminate\Database\Eloquent\Builder;

public function buildSortQuery(): Builder
{
    return static::query()->where('menu_id', $this->menu_id);
}
```

## Ordering records

Use the `ordered` scope to retrieve records by their order.

```php
$items = MenuItem::ordered()->get();
$items = MenuItem::ordered('desc')->get();
```

## Setting a new order

You can reorder records by passing an array of ids to the static `setNewOrder()` method. The first id will get the start value, the second id will get the start value + 1, and so on.

```php
MenuItem::setNewOrder([3, 1, 2]);

// optionally provide a starting order number
MenuItem::setNewOrder([3, 1, 2], 10);
```

## Available methods

| Method | Description |
|---|---|
| `setHighestOrderNumber()` | Set the order column to the next order number |
| `setHighestOrderNumberIfEmpty()` | Set the order column to the next order number only if it is `null` |
| `getNextOrderNumber()` | Get the next available order number |
| `getHighestOrderNumber()` | Get the current highest order number, or `null` if there are no records |
| `buildSortQuery()` | The query used to determine the highest order number |
| `getOrderColumnName()` | The name of the order column |
| `getOrderStartValue()` | The order number given to the first record |
| `shouldSortWhenCreating()` | Whether to set the order when creating |
| `shouldSortWhenUpdating()` | Whether to set the order when updating |

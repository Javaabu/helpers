---
title: HasCachedSoftDeleteCount
sidebar_position: 3
---

This trait allows caching whether a model has a soft deleted record. This can be useful to improve the performance for models with a large number of records.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Javaabu\Helpers\Traits\HasCachedSoftDeleteCount;

class Post extends Model
{
    use SoftDeletes;
    use HasCachedSoftDeleteCount;  
}

```

Now you can call the static `hasRecordsInTrash()` method to check if there are any soft deleted records.

```php
$has_soft_deleted = Post::hasRecordsInTrash(); // returns true or false
```

The trait will cache the value forever until a record is either deleted or restored. 

If you want to manually clear the cache you can call the static `forgetCachedSoftDeleteCount()` method.

```php
Post::forgetCachedSoftDeleteCount(); // clears the cached value
```

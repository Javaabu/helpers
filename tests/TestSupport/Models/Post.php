<?php

namespace Javaabu\Helpers\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Javaabu\Helpers\Traits\HasCachedSoftDeleteCount;

class Post extends Model
{
    use SoftDeletes;
    use HasCachedSoftDeleteCount;

    protected $fillable = ['title'];
}

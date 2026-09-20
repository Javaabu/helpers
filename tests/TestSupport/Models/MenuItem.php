<?php

namespace Javaabu\Helpers\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Javaabu\Helpers\Traits\IsOrdered;

class MenuItem extends Model
{
    use IsOrdered;

    protected $table = 'menu_items';

    protected $fillable = ['name', 'order_column'];
}

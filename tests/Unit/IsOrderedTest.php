<?php

namespace Javaabu\Helpers\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Javaabu\Helpers\Tests\TestCase;
use Javaabu\Helpers\Tests\TestSupport\Models\MenuItem;
use PHPUnit\Framework\Attributes\Test;

class IsOrderedTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_sets_the_order_starting_from_zero_when_creating()
    {
        $first = MenuItem::create(['name' => 'First']);
        $second = MenuItem::create(['name' => 'Second']);

        $this->assertEquals(0, $first->order_column);
        $this->assertEquals(1, $second->order_column);
    }

    #[Test]
    public function it_can_set_the_order_start_value_per_model()
    {
        $item = new class (['name' => 'First']) extends MenuItem {
            public function getOrderStartValue(): int
            {
                return 10;
            }
        };

        $item->save();

        $this->assertEquals(10, $item->order_column);
    }

    #[Test]
    public function it_does_not_override_a_given_order_when_creating()
    {
        $item = MenuItem::create(['name' => 'First', 'order_column' => 5]);

        $this->assertEquals(5, $item->order_column);
    }

    #[Test]
    public function it_does_not_sort_when_creating_if_disabled()
    {
        $item = new class (['name' => 'First']) extends MenuItem {
            public function shouldSortWhenCreating(): bool
            {
                return false;
            }
        };

        $item->save();

        $this->assertNull($item->fresh()->order_column);
    }

    #[Test]
    public function it_sets_the_order_when_updating_if_it_is_null()
    {
        MenuItem::create(['name' => 'First']);

        $item = new class (['name' => 'Second']) extends MenuItem {
            public function shouldSortWhenCreating(): bool
            {
                return false;
            }
        };

        $item->save();

        $this->assertNull($item->order_column);

        $item->name = 'Updated';
        $item->save();

        $this->assertEquals(1, $item->fresh()->order_column);
    }

    #[Test]
    public function it_does_not_sort_when_updating_if_disabled()
    {
        $item = new class (['name' => 'First']) extends MenuItem {
            public function shouldSortWhenCreating(): bool
            {
                return false;
            }

            public function shouldSortWhenUpdating(): bool
            {
                return false;
            }
        };

        $item->save();

        $item->name = 'Updated';
        $item->save();

        $this->assertNull($item->fresh()->order_column);
    }

    #[Test]
    public function it_can_set_a_new_order()
    {
        $first = MenuItem::create(['name' => 'First']);
        $second = MenuItem::create(['name' => 'Second']);
        $third = MenuItem::create(['name' => 'Third']);

        MenuItem::setNewOrder([$third->id, $first->id, $second->id]);

        $this->assertEquals(
            [$third->id, $first->id, $second->id],
            MenuItem::ordered()->pluck('id')->all()
        );

        $this->assertEquals(0, $third->fresh()->order_column);

        MenuItem::setNewOrder([$second->id, $first->id], 5);

        $this->assertEquals(5, $second->fresh()->order_column);
        $this->assertEquals(6, $first->fresh()->order_column);
    }
}

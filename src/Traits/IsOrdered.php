<?php
/**
 * Trait for models with a sortable order column
 */

namespace Javaabu\Helpers\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait IsOrdered
{
    /**
     * Boot function from laravel.
     */
    public static function bootIsOrdered(): void
    {
        static::creating(function (Model $model) {
            if ($model->shouldSortWhenCreating()) {
                $model->setHighestOrderNumberIfEmpty();
            }
        });

        static::updating(function (Model $model) {
            if ($model->shouldSortWhenUpdating()) {
                $model->setHighestOrderNumberIfEmpty();
            }
        });
    }

    /**
     * Set the order column to the next order number if it is null
     */
    public function setHighestOrderNumberIfEmpty(): void
    {
        if (is_null($this->{$this->getOrderColumnName()})) {
            $this->setHighestOrderNumber();
        }
    }

    /**
     * Set the order column to the next order number
     */
    public function setHighestOrderNumber(): void
    {
        $order_column = $this->getOrderColumnName();

        $this->{$order_column} = $this->getNextOrderNumber();
    }

    /**
     * Get the next available order number
     */
    public function getNextOrderNumber(): int
    {
        $highest = $this->getHighestOrderNumber();

        return is_null($highest) ? $this->getOrderStartValue() : $highest + 1;
    }

    /**
     * Get the current highest order number, null if there are no records
     */
    public function getHighestOrderNumber(): ?int
    {
        $max = $this->buildSortQuery()->max($this->getOrderColumnName());

        return is_null($max) ? null : (int) $max;
    }

    /**
     * The query used to determine the highest order number.
     * Override this to scope the ordering, e.g. by a parent id.
     */
    public function buildSortQuery(): Builder
    {
        return static::query();
    }

    public function scopeOrdered(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy($this->getOrderColumnName(), $direction);
    }

    /*
     * This function reorders the records: the record with the first id in the array
     * will get the starting order (defaults to the value of getOrderStartValue()), the record
     * with the second id will get the starting order + 1, and so on.
     *
     * A starting order number can be optionally supplied.
     */
    public static function setNewOrder(array $ids, ?int $start_order = null): void
    {
        if (empty($ids)) {
            return;
        }

        $ids = array_values($ids);

        $instance = new static();
        $order_column = $instance->getOrderColumnName();
        $start_order ??= $instance->getOrderStartValue();

        $models = static::whereIn($instance->getKeyName(), $ids)
            ->get()
            ->keyBy($instance->getKeyName());

        foreach ($ids as $id) {
            if (! isset($models[$id])) {
                continue;
            }

            $model = $models[$id];
            $model->{$order_column} = $start_order++;
            $model->save();
        }
    }

    /**
     * Get the name of the order column
     */
    public function getOrderColumnName(): string
    {
        return 'order_column';
    }

    /**
     * Get the order number given to the first record
     */
    public function getOrderStartValue(): int
    {
        return 0;
    }

    /**
     * Whether to set the order when creating if the order column is null
     */
    public function shouldSortWhenCreating(): bool
    {
        return true;
    }

    /**
     * Whether to set the order when updating if the order column is null
     */
    public function shouldSortWhenUpdating(): bool
    {
        return true;
    }
}

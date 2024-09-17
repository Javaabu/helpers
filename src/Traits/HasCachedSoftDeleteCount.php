<?php

namespace Javaabu\Helpers\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasCachedSoftDeleteCount
{
    public static function bootHasCachedSoftDeleteCount()
    {
        static::deleted(function (Model $model) {
            static::forgetCachedSoftDeleteCount();
        });

        static::restored(function (Model $model) {
            static::forgetCachedSoftDeleteCount();
        });
    }

    public static function getSoftDeleteCacheKey()
    {
        $model_class = static::class;
        $model = new $model_class();
        return $model->getMorphClass() . '.has_soft_deletes';
    }

    public static function hasRecordsInTrash(): bool
    {
        return cache()->rememberForever(static::getSoftDeleteCacheKey(), function () {
            return static::onlyTrashed()->exists();
        });
    }

    public static function forgetCachedSoftDeleteCount()
    {
        cache()->forget(static::getSoftDeleteCacheKey());
    }
}

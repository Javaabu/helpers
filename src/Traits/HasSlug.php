<?php
/**
 * Simple trait to set slug field
 */

namespace Javaabu\Helpers\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasSlug
{
    /**
     * Boot function from laravel.
     */
    public static function bootHasSlug()
    {
        static::saving(function ($model) {
            $field = $model->getSlugKey();
            $model->{$field} = $model->getUniqueSlug($model->{$field});
        });
    }

    /**
     * Get the slug field name
     * @return string
     */
    public function getSlugKey()
    {
        return 'slug';
    }

    /**
     * Get the name field name
     * @return string
     */
    public function getSlugNameKey()
    {
        return 'name';
    }

    /**
     * Get the slug separator
     * @return string
     */
    public function getSlugSeparator()
    {
        return '-';
    }

    /**
     * Slugify the value
     * @param $value
     * @return string
     */
    public function slugify($value)
    {
        //convert to slug
        return Str::slug($value, $this->getSlugSeparator());
    }

    /**
     * Get the slug for the value
     * @param $value
     * @return string
     */
    public function getSlug($value)
    {
        // default to name, if the slug
        // is not provided
        if (empty($value)) {
            $value = $this->{$this->getSlugNameKey()};
        }

        return $this->slugify($value);
    }

    /**
     * Find a unique slug
     *
     * @param string $value
     * @return string
     */
    public function getUniqueSlug($value)
    {

        //convert to slug
        $value = $this->getSlug($value);
        $separator = $this->getSlugSeparator();
        $suffix = '';
        $count = 0;

        //find a unique slug
        while (! $this->isUniqueSlug($value . $suffix)) {
            $count++;
            $suffix = $separator . $count;
        }

        return $value . $suffix;
    }

    /**
     * Check if slug is unique
     *
     * @param string $value
     * @return bool
     */
    public function isUniqueSlug($value)
    {

        //check if slug exists
        $id_key = $this->getKeyName();
        $count = static::where($this->getSlugKey(), $value);

        if ($this->hasSoftDelete()) {
            $count->withTrashed();
        }

        if ($id = $this->{$id_key}) {
            $count->where($id_key, '!=', $id);
        }

        return ! $count->exists();
    }

    /**
     * Check if is a soft deleting model
     * @return boolean
     */
    public function hasSoftDelete()
    {
        // ... check if 'this' model uses the soft deletes trait
        return in_array(SoftDeletes::class, class_uses_recursive($this));
    }
}

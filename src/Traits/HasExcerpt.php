<?php
/**
 * Simple trait for models with excerpts
 */

namespace Javaabu\Helpers\Traits;

use Illuminate\Support\Str;

trait HasExcerpt
{
    /**
     * Get the excerpt attribute
     * @return string
     */
    public function getExcerptAttribute()
    {
        return $this->getExcerpt(
            $this->getExcerptLength()
        );
    }

    /**
     * Get the excerpt attribute
     *
     * @param int $length
     * @return string
     */
    public function getExcerpt($length = 200)
    {
        return Str::limit(
            strip_tags($this->{$this->getExcerptField()}),
            $length
        );
    }

    /**
     * Get the excerpt field
     * @return string
     */
    public function getExcerptField()
    {
        return 'description';
    }

    /**
     * Get the default excerpt length
     * @return int
     */
    public function getExcerptLength()
    {
        return 200;
    }
}

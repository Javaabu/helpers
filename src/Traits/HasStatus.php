<?php
/**
 * Simple trait for status posts
 */

namespace Javaabu\Helpers\Traits;

trait HasStatus
{
    /**
     * Get the status label
     * @return string
     */
    public function getStatusLabel($status)
    {
        $status_class = static::$status_class;
        return $status_class::getLabel($status);
    }

    /**
     * Get status name attribute
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return $this->getStatusLabel($this->status);
    }

    /**
     * Get the status slug
     * @return string
     */
    public function getStatusSlug($status)
    {
        $status_class = static::$status_class;
        return $status_class::getSlug($status);
    }

    /**
     * Get status slug attribute
     * @return string
     */
    public function getStatusSlugAttribute()
    {
        return $this->getStatusSlug($this->status);
    }

    /**
     * Update the status
     *
     * @param $status | desired status
     * @param bool $save | whether to save
     */
    public function updateStatus($status, $save = false)
    {
        $this->status = $status;

        if ($save) {
            $this->save();
        }
    }
}

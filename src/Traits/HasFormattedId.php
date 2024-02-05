<?php
/**
 * Simple trait for formatted ids
 */

namespace Javaabu\Helpers\Traits;

trait HasFormattedId
{
    /**
     * Get the id prefix
     * @return string
     */
    public function getIdPrefixAttribute()
    {
        return 'ID';
    }

    /**
     * Get the formatted id
     * @return string
     */
    public function getFormattedIdAttribute()
    {
        return $this->id_prefix.str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Extract id from formatted id
     * @param $formatted_id
     * @return string
     */
    public function extractId($formatted_id)
    {
        return intval(preg_replace('/[^0-9]/', '', $formatted_id));
    }

    /**
     * Find by formatted id
     * @param $query
     * @param $formatted_id
     * @return mixed
     */
    public function scopeByFormattedId($query, $formatted_id)
    {
        return $query->whereId($this->extractId($formatted_id));
    }
}

<?php
/**
 * Simple trait for formatted ids
 */

namespace Javaabu\Helpers\Traits;

use Illuminate\Support\Str;

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
     * Get the id field name
     * @return string
     */
    public function getIdFieldToFormat(): string
    {
        return 'id';
    }

    /**
     * Whether the formatted id should be padded
     */
    public function shouldPadFormattedId(): bool
    {
        return true;
    }

    /**
     * Get the id to format
     */
    public function getIdToFormat()
    {
        $field = $this->getIdFieldToFormat();

        return $this->{$field};
    }

    /**
     * Get the formatted id
     * @return string
     */
    public function getFormattedIdAttribute()
    {
        $id = $this->getIdToFormat();

        if ($this->shouldPadFormattedId()) {
            $id = Str::padLeft($id, 6, '0');
        }

        return $this->id_prefix.$id;
    }

    /**
     * Extract id from formatted id
     * @param $formatted_id
     * @return string
     */
    public function extractId($formatted_id)
    {
        $id = trim(Str::after($formatted_id, $this->id_prefix));

        return is_numeric($id) ? intval($id) : $id;
    }

    /**
     * Find by formatted id
     * @param $query
     * @param $formatted_id
     * @return mixed
     */
    public function scopeByFormattedId($query, $formatted_id)
    {
        return $query->where($this->getIdFieldToFormat(), $this->extractId($formatted_id));
    }
}

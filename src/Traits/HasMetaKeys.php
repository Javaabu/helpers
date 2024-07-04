<?php
/**
 * Simple trait for meta key posts
 *
 * User: Arushad
 * Date: 06/10/2016
 * Time: 16:28
 */

namespace Javaabu\Helpers\Traits;

use Illuminate\Support\Str;

trait HasMetaKeys
{

    /**
     * Set the meta
     * Convert the keys to snake case
     *
     * @param array $meta
     * @param string $attribute
     */
    public function setMeta($meta, $attribute = 'meta')
    {
        if (is_array($meta)) {
            $new_meta = [];
            foreach ($meta as $key => $value) {
                $key = $this->getMetaKey($key);
                $new_meta[$key] = $value;
            }

            $meta = $new_meta;
        }

        if ($this->isJsonCastable($attribute) && $meta) {
            $meta = $this->castAttributeAsJson($attribute, $meta);
        }

        $this->attributes[$attribute] = $meta ?: null;
    }

    /**
     * Convert meta keys to snake case
     *
     * @param string $key
     * @return string
     */
    public function getMetaKey($key)
    {
        return Str::snake(strtolower($key));
    }

    /**
     * Convert the meta keys to title keys
     *
     * @param $key
     * @return string
     */
    public function getMetaKeyName($key)
    {
        return str_replace('_', ' ', Str::title($key));
    }

}

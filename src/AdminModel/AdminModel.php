<?php
/**
 * Methods that admin models should have
 */

namespace Javaabu\Helpers\AdminModel;

use Illuminate\Database\Eloquent\Builder;

interface AdminModel
{
    /**
     * Get the admin url
     *
     * @return string
     */
    public function getAdminUrlAttribute(): string;

    /**
     * Get the admin link
     *
     * @return string
     */
    public function getAdminLinkAttribute(): string;

    /**
     * Get the name to be displayed on the admin link
     *
     * @return string
     */
    public function getAdminLinkNameAttribute(): string;

    /**
     * Generates an admin link using the given attribute
     *
     * @return string
     */
    public function generateAdminLink(string $attribute = 'admin_link_name'): string;

    /**
     * Get can view admin link
     *
     * @return boolean
     */
    public function canViewAdminLink(): bool;

    /**
     * Get the name for log
     *
     * @return string
     */
    public function getLoggingNameAttribute(): string;

    /**
     * Get the log url
     * @return string
     */
    public function getLogUrlAttribute(): string;

    /**
     * Get the causer log url
     * @return string
     */
    public function getCauserLogUrlAttribute(): string;

    /**
     * A search scope
     *
     * @param Builder $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search): mixed;
}

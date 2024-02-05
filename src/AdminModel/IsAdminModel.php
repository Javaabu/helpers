<?php
/**
 * Methods that admin models should have
 */

namespace Javaabu\Helpers\AdminModel;

trait IsAdminModel
{
    /**
     * Get admin user attribute
     *
     * @return string
     */
    public function getAdminLinkAttribute()
    {
        if ($this->canViewAdminLink()) {
            $admin_url = $this->admin_url;
        } else {
            $admin_url = '';
        }

        $before = $admin_url ? '<a href="' . e($admin_url) . '">' : '';
        $after = $admin_url ? '</a>' : '';

        return $before . e($this->admin_link_name) . $after;
    }

    /**
     * Get can view admin link
     *
     * @return boolean
     */
    public function canViewAdminLink()
    {
        return auth()->check() && auth()->user()->can('view', $this);
    }

    /**
     * Get the name for the admin link
     *
     * @return string
     */
    public function getAdminLinkNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the name for log
     *
     * @return string
     */
    public function getLoggingNameAttribute()
    {
        return $this->admin_link_name;
    }

    /**
     * Get the log url
     *
     * @return string
     */
    public function getLogUrlAttribute()
    {
        return add_query_arg([
            'subject_type' => $this->getMorphClass(),
            'subject_id' => $this->id,
        ], route('admin.logs.index'));
    }

    /**
     * Get the causer log url
     *
     * @return string
     */
    public function getCauserLogUrlAttribute()
    {
        return add_query_arg([
            'causer_type' => $this->getMorphClass(),
            'causer_id' => $this->id,
        ], route('admin.logs.index'));
    }
}

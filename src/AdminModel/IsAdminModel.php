<?php
/**
 * Methods that admin models should have
 */

namespace Javaabu\Helpers\AdminModel;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait IsAdminModel
{
    /**
     * Get admin user attribute
     *
     * @return string
     */
    public function getAdminLinkAttribute(): string
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
    public function canViewAdminLink(): bool
    {
        return auth()->check() && auth()->user()->can('view', $this);
    }

    /**
     * Get the name for the admin link
     *
     * @return string
     */
    public function getAdminLinkNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Get the name for log
     *
     * @return string
     */
    public function getLoggingNameAttribute(): string
    {
        return $this->admin_link_name;
    }

    /**
     * Get the log url
     *
     * @return string
     */
    public function getLogUrlAttribute(): string
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
    public function getCauserLogUrlAttribute(): string
    {
        return add_query_arg([
            'causer_type' => $this->getMorphClass(),
            'causer_id' => $this->id,
        ], route('admin.logs.index'));
    }

    /**
     * A search scope
     *
     * @param Builder $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search): mixed
    {
        if (property_exists($this, 'searchable') && $this->searchable) {
            $searchable = Arr::wrap($this->searchable);

            $first = true;
            foreach ($searchable as $attribute) {
                if  ($first) {
                    $first = false;
                    $method = 'where';
                } else {
                    $method = 'orWhere';
                }

                $query->{$method}($attribute, 'like', '%'.$search.'%');
            }

            return $query;
        }

        return $query->where($this->getKeyName(), $search);
    }
}

<?php
/**
 * Simple trait for publishable models
 */

namespace Javaabu\Helpers\Traits;

use App\Models\User;

trait Publishable
{
    use HasStatus;

    /**
     * Checks if published
     * @return bool
     */
    public function getIsPublishedAttribute()
    {
        return $this->status == $this->getPublishedKey();
    }

    /**
     * Checks if pending
     * @return bool
     */
    public function getIsPendingAttribute()
    {
        return $this->status == $this->getPendingKey();
    }

    /**
     * Checks if draft
     * @return bool
     */
    public function getIsDraftAttribute()
    {
        return $this->status == $this->getDraftKey();
    }

    /**
     * Checks if rejected
     * @return bool
     */
    public function getIsRejectedAttribute()
    {
        return $this->status == $this->getRejectedKey();
    }

    /**
     * A published scope
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where($this->getTable().'.status', '=', $this->getPublishedKey());
    }

    /**
     * A draft scope
     * @param $query
     * @return mixed
     */
    public function scopeDraft($query)
    {
        return $query->where($this->getTable().'.status', '=', $this->getDraftKey());
    }

    /**
     * A pending scope
     * @param $query
     * @return mixed
     */
    public function scopePending($query)
    {
        return $query->where($this->getTable().'.status', '=', $this->getPendingKey());
    }

    /**
     * A rejected scope
     * @param $query
     * @return mixed
     */
    public function scopeRejected($query)
    {
        return $query->where($this->getTable().'.status', '=', $this->getRejectedKey());
    }

    /**
     * Return the published key
     * @return int
     */
    public function getPublishedKey()
    {
        $status_class = static::$status_class;
        return $status_class::PUBLISHED;
    }

    /**
     * Return the pending key
     * @return int
     */
    public function getPendingKey()
    {
        $status_class = static::$status_class;
        return $status_class::PENDING;
    }

    /**
     * Return the draft key
     * @return int
     */
    public function getDraftKey()
    {
        $status_class = static::$status_class;
        return $status_class::DRAFT;
    }

    /**
     * Return the rejected key
     * @return int
     */
    public function getRejectedKey()
    {
        $status_class = static::$status_class;
        return $status_class::REJECTED;
    }

    /**
     * Update the status
     *
     * @param $status | desired status
     * @param bool $publish | send for approving
     * @return void
     */
    public function updateStatus($status, $publish = false)
    {
        //first check if requesting for publishing
        if ($publish || $status == $this->getPublishedKey()) {
            $this->publish();
        } elseif ($status == $this->getRejectedKey()) {
            $this->reject();
        } elseif ($status && auth()->check() && auth()->user()->can('publish', static::class)) {
            $this->status = $status;
        } else {
            $this->draft();
        }
    }

    /**
     * Publish the post
     * @return void
     */
    public function publish()
    {
        if ($user = auth()->user()) {
            $this->status = $user->can('publish', static::class) ? $this->getPublishedKey()
                : $this->getPendingKey();
        }
    }

    /**
     * Reject the post
     * @return void
     */
    public function reject()
    {
        if ($user = auth()->user()) {
            $this->status = $user->can('publish', static::class) ? $this->getRejectedKey()
                : $this->getDraftKey();
        }
    }

    /**
     * Reject the post
     * @return void
     */
    public function draft()
    {
        $this->status = $this->getDraftKey();
    }

    /**
     * User visible
     *
     * @param $query
     * @return mixed
     */
    public function scopeUserVisible($query)
    {
        $admin = auth()->user() instanceof User ?
            auth()->user() :
            auth()->guard('web_admin')->user();

        if ($admin) {
            if ($admin->can('create', static::class)) {
                //can view all
                return $query;
            }
        }

        // everyone can view published
        return $query->published();
    }
}

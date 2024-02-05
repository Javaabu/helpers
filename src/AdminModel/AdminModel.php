<?php
/**
 * Methods that admin models should have
 */

namespace Javaabu\Helpers\AdminModel;

interface AdminModel
{
    /**
     * Get the admin url
     * @return string
     */
    public function getAdminUrlAttribute();

    /**
     * Get the admin link
     * @return string
     */
    public function getAdminLinkAttribute();

    /**
     * Get the name to be displayed on the admin link
     * @return string
     */
    public function getAdminLinkNameAttribute();

    /**
     * Get can view admin link
     *
     * @return boolean
     */
    public function canViewAdminLink();

    /**
     * Get the name for log
     * @return string
     */
    public function getLoggingNameAttribute();

    /**
     * Get the log url
     * @return string
     */
    public function getLogUrlAttribute();

    /**
     * Get the causer log url
     * @return string
     */
    public function getCauserLogUrlAttribute();
}

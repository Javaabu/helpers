<?php
/**
 * Simple trait for controllers
 */

namespace Javaabu\Helpers\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait ControllerHelpers
{
    /**
     * Show success message
     *
     * @param string $message
     */
    protected function flashSuccessMessage(string $message = '')
    {
        flash_push('alerts', [
            'title' => __('Success!'),
            'text' => $message ?: __('Your inputs have been saved.'),
            'type' => 'success',
        ]);
    }

    /**
     * Redirect request
     *
     * @param Request $request
     * @param string $default Default redirect url
     * @return RedirectResponse
     */
    protected function redirect(Request $request, string $default = '')
    {
        $redirect = $request->redirect ?: $default;
        return redirect()->to(relative_url($redirect));
    }

    /**
     * Get per page
     *
     * @param Request $request
     * @param int $default
     * @return int
     */
    protected function getPerPage(Request $request, int $default = 0)
    {
        return abs($request->input('per_page', $default ?: get_setting('per_page')));
    }

    /**
     * Get an allowed value from the request
     *
     * @param Request $request
     * @param $key
     * @param $allowed_values
     * @param string $default
     * @return string
     */
    protected function getAllowedValue(Request $request, $key, array $allowed_values, $default)
    {
        return in_array($request->input($key), $allowed_values) ? $request->input($key) : $default;
    }
}

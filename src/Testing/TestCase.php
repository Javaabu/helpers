<?php

namespace Javaabu\Helpers\Testing;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    /**
     * Visit the given URI with a POST request.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function adminPost($uri, array $data = [], array $headers = [])
    {
        return $this->post($this->adminUrl($uri), $data, $headers);
    }

    /**
     * Visit the given URI with a PUT request.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function adminPut($uri, array $data = [], array $headers = [])
    {
        return $this->put($this->adminUrl($uri), $data, $headers);
    }

    /**
     * Visit the given URI with a DELETE request.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function adminDelete($uri, array $data = [], array $headers = [])
    {
        return $this->delete($this->adminUrl($uri), $data, $headers);
    }

    /**
     * Visit the given URI with a PATCH request.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function adminPatch($uri, array $data = [], array $headers = [])
    {
        return $this->patch($this->adminUrl($uri), $data, $headers);
    }

    /**
     * Visit the given URI with a GET request.
     *
     * @param  string  $uri
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function adminGet($uri, array $headers = [])
    {
        return $this->get($this->adminUrl($uri), $headers);
    }

    /**
     * Turn the given URI into a fully qualified admin URL.
     *
     * @param  string  $uri
     * @return string
     */
    protected function adminUrl(string $uri): string
    {
        if (Str::startsWith($uri, '/')) {
            $uri = substr($uri, 1);
        }

        // add prefix
        if ($prefix = config('app.admin_prefix')) {
            $uri = $prefix . '/' . trim($uri, '/');
        }

        if ($domain = config('app.admin_domain')) {
            if (! Str::startsWith($domain, 'http')) {
                $domain = 'https://' . $domain;
            }

            $uri = trim($domain, '/') . '/' . trim($uri, '/');
        }

        return trim(url($uri), '/');
    }
}

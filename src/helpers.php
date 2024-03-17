<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Request as RequestFacade;

if (! function_exists('add_error_class')) {
    /**
     * Adds error class if has error
     *
     * @param bool $has_error
     * @param string $classes
     * @param string $error_class
     * @return string
     * @deprecated Use javaabu/forms components instead
     */
    function add_error_class($has_error, $classes = 'form-control', $error_class = 'is-invalid')
    {
        return $has_error ? $classes . ' ' . $error_class : $classes;
    }
}

if (! function_exists('to_array')) {
    /**
     * Converts a comma delimited string to an array
     * If an array is passed in, returns same array
     *
     * @param mixed
     * @return array
     */
    function to_array($array_str): array
    {
        $array = $array_str;
        if (! is_array($array_str)) {
            $array = explode(',', $array_str);
        }

        return $array;
    }
}

if (! function_exists('safe_in_array')) {
    /**
     * Checks if value is in_array
     *
     * @param mixed  $needle
     * @param mixed  $haystack
     * @param  bool  $strict  false
     * @return bool
     */
    function safe_in_array(mixed $needle, mixed $haystack, bool $strict = false): bool
    {
        if (is_array($haystack)) {
            return in_array($needle, $haystack, $strict);
        } else {
            return $strict ? $needle === $haystack : $needle == $haystack;
        }
    }
}

if (! function_exists('strip_protocol')) {
    /**
     * Remove protocol from url string
     *
     * @param string $url
     * @return string
     */
    function strip_protocol($url): string
    {
        return preg_replace('#^https?://#', '', $url);
    }
}

if (! function_exists('url_path')) {
    /**
     * Remove the host and query params from a url
     *
     * @param  string  $url
     * @return string
     */
    function url_path(string $url): string
    {
        $url_parts = parse_url($url);
        return isset($url_parts['path']) ? trim($url_parts['path'], '/ ') : '';
    }
}

if (! function_exists('add_sort_class')) {
    /**
     * Adds sorting class
     *
     * @param  string  $field
     * @param  string  $classes
     * @return string
     * @deprecated Use javaabu/forms <x-form-th> instead
     */
    function add_sort_class(string $field, string $classes = ''): string
    {
        $sorting_class = 'sorting';
        if (RequestFacade::get('orderby') == $field) {
            $sorting_class .= '_' . strtolower(RequestFacade::get('order', 'ASC'));
        }

        if ($classes) {
            $sorting_class .= ' ' . $classes;
        }

        return $sorting_class;
    }
}

if (! function_exists('top_level_slugs')) {
    /**
     * Get all top level routes
     *
     * @return array
     */
    function top_level_slugs(): array
    {
        $route_collection = Route::getRoutes();
        $top_routes = [];

        foreach ($route_collection as $route) {
            $path = $route->uri;
            $path_name = explode('/', $path);
            $current_path = $path_name[0] ?? '';
            if (! Str::startsWith($current_path, '{') && $current_path && !in_array($current_path, $top_routes)) {
                $top_routes[] = $current_path;
            }
        }

        return $top_routes;
    }
}

if (! function_exists('is_color')) {
    /**
     * Checks if is a hex color value
     * Optionally checks for #
     */
    function is_color($color): bool
    {
        return preg_match('/^#{0,1}([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color) == true;
    }
}

if (! function_exists('number_format_exact')) {
    /**
     * Number format with unlimited precision
     *
     * @param $number
     * @param  string  $decimal
     * @return string
     */
    function number_format_exact($number, string $decimal = '.'): string
    {
        $broken_number = explode($decimal, (string) $number);
        $string = number_format($broken_number[0]);
        $string .= isset($broken_number[1]) ? $decimal.$broken_number[1] : '';

        return $string;
    }
}

if (! function_exists('remove_prefix')) {
    /**
     * Remove the given prefix from a string
     * @param $needle
     * @param $haystack
     * @return string
     */
    function remove_prefix($needle, $haystack): string
    {
        if (str_starts_with($haystack, $needle)) {
            $haystack = substr($haystack, strlen($needle));
        }

        return $haystack;
    }
}

if (! function_exists('remove_suffix')) {
    /**
     * Remove the given suffix from a string
     *
     * @param $needle
     * @param $haystack
     * @return string
     */
    function remove_suffix($needle, $haystack): string
    {
        if (substr($haystack, -strlen($needle), strlen($needle)) == $needle) {
            $haystack = substr($haystack, 0, strlen($haystack) - strlen($needle));
        }

        return $haystack;
    }
}

if (! function_exists('slug_to_title')) {
    /**
     * Convert slug to title case
     *
     * @param $slug
     * @param  string  $separator
     * @return string
     */
    function slug_to_title($slug, string $separator = '_'): string
    {
        return Str::title(str_replace($separator, ' ', $slug));
    }
}

if (! function_exists('errors_has_prefix')) {
    /**
     * Check if a errors has a key with a specific prefix
     *
     * @param ViewErrorBag $errors
     * @param $prefix
     * @return bool
     */
    function errors_has_prefix(ViewErrorBag $errors, $prefix): bool
    {
        $keys = $errors->keys();
        foreach ($keys as $key) {
            if (Str::startsWith($key, $prefix)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('expects_json')) {
    /**
     * Check if a request expects a json response
     *
     * @param  Request  $request
     * @return bool
     */
    function expects_json(Request $request): bool
    {
        return $request->is(config('app.api_prefix').'/*') || $request->expectsJson();
    }
}

if (! function_exists('relative_url')) {
    /**
     * Converts an absolute url to a relative url
     *
     * @param  string|null  $full_url
     * @return bool|string
     */
    function relative_url(string|null $full_url): bool|string
    {
        // first check if it starts with the current domain
        if (Str::startsWith($full_url, secure_url('/'))) {
            return remove_prefix(secure_url('/'), $full_url);
        } elseif (Str::startsWith($full_url, url('/'))) {
            return remove_prefix(url('/'), $full_url);
        } else {
            // remove the protocol
            return preg_replace('(^.*://)', '', $full_url);
        }
    }
}

if (! function_exists('strip_slashes_from_strings_only')) {
    /**
     * Strip slashes from strings only
     */
    function stripslashes_from_strings_only($value)
    {
        return is_string($value) ? stripslashes($value) : $value;
    }
}

if (! function_exists('map_deep')) {
    /**
     * Map deep
     */
    function map_deep($value, $callback)
    {
        if (is_array($value)) {
            foreach ($value as $index => $item) {
                $value[ $index ] = map_deep($item, $callback);
            }
        } elseif (is_object($value)) {
            $object_vars = get_object_vars($value);
            foreach ($object_vars as $property_name => $property_value) {
                $value->$property_name = map_deep($property_value, $callback);
            }
        } else {
            $value = call_user_func($callback, $value);
        }

        return $value;
    }
}

if (! function_exists('urlencode_deep')) {
    /**
     * URL encode deep
     */
    function urlencode_deep($value)
    {
        return map_deep($value, 'urlencode');
    }
}

if (! function_exists('_http_build_query')) {
    /**
     * Custom http build query
     *
     * @param $data
     * @param null  $prefix
     * @param null  $sep
     * @param  string  $key
     * @param  bool  $urlencode
     * @return string
     */
    function _http_build_query($data, $prefix = null, $sep = null, string $key = '', bool $urlencode = true): string
    {
        $ret = array();

        foreach ((array) $data as $k => $v) {
            if ($urlencode) {
                $k = urlencode($k);
            }
            if (is_int($k) && $prefix != null) {
                $k = $prefix.$k;
            }
            if (!empty($key)) {
                $k = $key . '%5B' . $k . '%5D';
            }
            if ($v === null) {
                continue;
            } elseif ($v === false) {
                $v = '0';
            }

            if (is_array($v) || is_object($v)) {
                $ret[] = _http_build_query($v, '', $sep, $k, $urlencode);
            } elseif ($urlencode) {
                $ret[] = $k . '=' . urlencode($v);
            } else {
                $ret[] = $k . '=' . $v;
            }
        }

        if (null === $sep) {
            $sep = ini_get('arg_separator.output');
        }

        return implode($sep, $ret);
    }
}

if (! function_exists('build_query')) {
    /**
     * Build query
     */
    function build_query($data): string
    {
        return _http_build_query($data, null, '&', '', false);
    }
}

if (! function_exists('add_query_arg')) {
    /**
     * Retrieves a modified URL query string.
     *
     * You can rebuild the URL and append query variables to the URL query by using this function.
     * There are two ways to use this function; either a single key and value, or an associative array.
     *
     * Using a single key and value:
     *
     *     add_query_arg( 'key', 'value', 'http://example.com' );
     *
     * Using an associative array:
     *
     *     add_query_arg( array(
     *         'key1' => 'value1',
     *         'key2' => 'value2',
     *     ), 'http://example.com' );
     *
     * Omitting the URL from either use results in the current URL being used
     * (the value of `$_SERVER['REQUEST_URI']`).
     *
     * Values are expected to be encoded appropriately with urlencode() or rawurlencode().
     *
     * Setting any query variable's value to boolean false removes the key (see remove_query_arg()).
     *
     * Important: The return value of add_query_arg() is not escaped by default. Output should be
     * late-escaped with esc_url() or similar to help prevent vulnerability to cross-site scripting
     * (XSS) attacks.
     *
     * @since 1.5.0
     * @since 5.3.0 Formalized the existing and already documented parameters
     *              by adding `...$args` to the function signature.
     *
     * @param string|array $key   Either a query variable key, or an associative array of query variables.
     * @param string       $value Optional. Either a query variable value, or a URL to act upon.
     * @param string       $url   Optional. A URL to act upon.
     * @return string New URL query string (unescaped).
     */
    function add_query_arg(...$args): string
    {
        if (is_array($args[0])) {
            if (count($args) < 2 || false === $args[1]) {
                $uri = $_SERVER['REQUEST_URI'] ?? url('');
            } else {
                $uri = $args[1];
            }
        } else {
            if (count($args) < 3 || false === $args[2]) {
                $uri = $_SERVER['REQUEST_URI'] ?? url('');
            } else {
                $uri = $args[2];
            }
        }

        $frag = strstr($uri, '#');
        if ($frag) {
            $uri = substr($uri, 0, -strlen($frag));
        } else {
            $frag = '';
        }

        if (0 === stripos($uri, 'http://')) {
            $protocol = 'http://';
            $uri      = substr($uri, 7);
        } elseif (0 === stripos($uri, 'https://')) {
            $protocol = 'https://';
            $uri      = substr($uri, 8);
        } else {
            $protocol = '';
        }

        if (str_contains($uri, '?')) {
            list($base, $query) = explode('?', $uri, 2);
            $base                .= '?';
        } elseif ($protocol || !str_contains($uri, '=')) {
            $base  = $uri . '?';
            $query = '';
        } else {
            $base  = '';
            $query = $uri;
        }

        parse_str($query, $qs);
        $qs = urlencode_deep($qs); // This re-URL-encodes things that were already in the query string.
        if (is_array($args[0])) {
            foreach ($args[0] as $k => $v) {
                $qs[ $k ] = $v;
            }
        } else {
            $qs[ $args[0] ] = $args[1];
        }

        foreach ($qs as $k => $v) {
            if (false === $v) {
                unset($qs[ $k ]);
            }
        }

        $ret = build_query($qs);
        $ret = trim($ret, '?');
        $ret = preg_replace('#=(&|$)#', '$1', $ret);
        $ret = $protocol . $base . $ret . $frag;
        return rtrim($ret, '?');
    }
}

if (! function_exists('flash_push')) {
    /**
     * Push flash message
     * @param $key
     * @param $data
     */
    function flash_push($key, $data): void
    {
        // get current data
        $values = session($key, []);

        // append the new data
        $values[] = $data;

        // flash the new data
        session()->flash($key, $values);
    }
}

if (! function_exists('parse_date')) {
    /**
     * Convert string to carbon
     *
     * @param  string|Carbon  $date
     * @return Carbon|null
     */
    function parse_date($date): ?Carbon
    {
        if ($date instanceof Carbon) {
            return $date;
        }

        if ($date) {
            try {
                return Carbon::parse($date);
            } catch (Exception $e) {
            }
        }

        return null;
    }
}

if (! function_exists('public_url')) {
    /**
     * Get a public url
     *
     * @param  string  $path
     * @return string
     */
    function public_url(string $path = '/'): string
    {
        return portal_url($path, 'public');
    }
}

if (! function_exists('portal_url')) {
    /**
     * Get portal specific url
     *
     * @param  string  $path
     * @param null     $portal
     * @return string
     */
    function portal_url(string $path = '/', $portal = null): string
    {
        $domain = url('');

        switch ($portal) {
            case 'public':
                $domain = config('app.url');
                break;

            case 'admin':
                $domain = config('app.admin_domain');
                break;
        }

        if ($domain) {
            $domain = rtrim($domain, '/');
        }

        // check if it has protocol
        if (! Str::startsWith($domain, 'http')) {
            $protocol = RequestFacade::secure() ? 'https://' : 'http://';
            $domain = $protocol.$domain;
        }


        return rtrim($domain.'/'.ltrim($path, '/'), '/');
    }
}

if (! function_exists('current_portal')) {
    /**
     * Get the current portal
     *
     * @return string
     */
    function current_portal(): string
    {
        $host = RequestFacade::getHost();

        switch ($host) {
            case config('app.admin_domain'):
                return 'admin';
                break;
        }

        return 'public';
    }
}

if (! function_exists('current_controller')) {
    function current_controller(): string
    {
        $action = app('request')->route()->getAction();

        $controller = class_basename($action['controller']);

        list($controller, $action) = explode('@', $controller);
        return $controller;
    }
}

if (! function_exists('if_route')) {
    function if_route($var): bool
    {
        return app('request')->routeIs($var);
    }
}

if (! function_exists('if_route_pattern')) {
    function if_route_pattern($var): bool
    {
        return app('request')->routeIs($var);
    }
}

if (! function_exists('convert_hr_to_bytes')) {
    /**
     * Converts a shorthand byte value to an integer byte value.
     *
     * @param   string  $value  A (PHP ini) byte value, either shorthand or ordinary.
     * @return  int
     *
     * https://developer.wordpress.org/reference/functions/wp_convert_hr_to_bytes/
     */
    function convert_hr_to_bytes($value)
    {
        $value = strtolower(trim($value));
        $bytes = (int)$value;

        if (false !== strpos($value, 'g')) {
            $bytes *= 1024 * 1024 * 1024;
        } elseif (false !== strpos($value, 'm')) {
            $bytes *= 1024 * 1024;
        } elseif (false !== strpos($value, 'k')) {
            $bytes *= 1024;
        }

        // Deal with large (float) values which run into the maximum integer size.
        return min($bytes, PHP_INT_MAX);
    }
}

if (! function_exists('max_upload_size')) {
    /**
     * Determines the maximum upload size allowed in php.ini
     * and media library in bytes
     *
     * @return  int
     *
     * https://developer.wordpress.org/reference/functions/wp_max_upload_size/
     */
    function max_upload_size($in_kb = false): int
    {
        $u_bytes = convert_hr_to_bytes(ini_get('upload_max_filesize'));
        $p_bytes = convert_hr_to_bytes(ini_get('post_max_size'));
        $media_bytes = config('media-library.max_file_size');

        $bytes = min($u_bytes, $p_bytes, $media_bytes);

        return $in_kb ? floor($bytes / 1024) : $bytes;
    }
}

if (! function_exists('format_file_size')) {
    /**
     * Convert kb to human-readable file size
     *
     * @param  int  $kb
     * @return string
     */
    function format_file_size(int $kb): string
    {
        $bytes = $kb * 1024;

        if ($bytes < 1000000) {
            $filesize = $bytes * .0009765625; // bytes to KB
            $type = __('KB');
        } elseif ($bytes < 1000000000) {
            $filesize = ($bytes * .0009765625) * .0009765625; // bytes to MB
            $type = __('MB');
        } else {
            $filesize = (($bytes * .0009765625) * .0009765625) * .0009765625; // bytes to GB
            $type = __('GB');
        }

        if($filesize < 0) {
            return $filesize = '';
        } else {
            return round($filesize, 2).''.$type;
        }
    }
}

if (! function_exists('random_id_or_generate')) {
    /**
     * Get a random id from the model or generate a new one using faker
     *
     * @param $model_class
     * @param  string  $key
     * @param  array  $where
     * @param  string  $return  supports value | object
     * @param  bool  $generate  whether to always generate
     * @return mixed
     */
    function random_id_or_generate(
        $model_class,
        string $key = 'id',
        array $where = [],
        string $return = 'value',
        bool $generate = false
    ): mixed
    {
        $id = $model_class::inRandomOrder();

        foreach ($where as $field => $value) {
            $id->where($field, $value);
        }

        $id = $return == 'object' ? $id->first() : $id->value($key);

        if ((! $id) && $generate) {
            $id = $model_class::factory();

            if (method_exists($id, 'withRequiredRelations')) {
                $id = $id->withRequiredRelations();
            }

            $id = $id->create($where);

            if ($return != 'object') {
                $id = $id->{$key};
            }
        }

        return $id;
    }
}

if (! function_exists('is_api_request')) {
    /**
     * Check if is an api request
     *
     * @param  Request  $request
     * @return bool
     */
    function is_api_request(Request $request): bool
    {
        return $request->is(config('app.api_prefix').'/*');
    }
}

if (! function_exists('request_ip')) {
    /**
     * Get the ip from the current request
     */
    function request_ip(): ?string
    {
        if (env('CLOUDFLARE_ENABLED') && isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else {
            return request()->ip();
        }
    }
}

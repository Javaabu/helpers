<?php

namespace Javaabu\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Javaabu\Helpers\Http\Middleware\JsonOnly;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerCustomValidationRules();

        Carbon::macro('timeOfDay', function () {
            $date = now();

            $hour = $date->format('H');

            if ($hour < 12 && $hour >= 4) {
                return 'morning';
            }

            if ($hour > 12 && $hour < 17) {
                return 'afternoon';
            }

            return 'evening';
        });

        Arr::macro('rootKeys', function (array $array) {
            $keys = [];

            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $keys[] = $key;
                } else {
                    $keys[] = $value;
                }
            }

            return $keys;
        });
    }

    protected function registerCustomValidationRules()
    {
        /**
         * Rule is to be defined like this:
         *
         * 'passcheck:users,password,id,1' - Means password is taken from users table, user is searched by field id equal to 1
         */
        Validator::extend('passcheck', function ($attribute, $value, $parameters) {
            $users_table = $parameters[0];
            $id_field = $parameters[2];
            $user_id = $parameters[3];
            $pass_field = $parameters[1];

            $user = DB::table($users_table)->where($id_field, $user_id)->first([$pass_field]);
            if (Hash::check($value, $user->{$pass_field})) {
                return true;
            } else {
                return false;
            }
        });

        /**
         * Rule is to be defined like this:
         *
         * 'slug:-' - Means the value must be a slug with special char -
         */
        Validator::extend('slug', function ($attribute, $value, $parameters) {
            $special_char = $parameters[0] ?? '-';
            return preg_match('/^([a-z0-9]+['.$special_char.'][a-z0-9]+|[a-z0-9])*$/', $value);
        });

        /**
         * Define error message for slug
         */
        Validator::replacer('slug', function ($message, $attribute, $rule, $parameters) {
            $special_char = $parameters[0] ?? '-';
            return str_replace(':special_char', $special_char, $message);
        });

        /**
         * Rule is to be defined like this:
         *
         * 'ids_exist:table,[field],[where_field],[where_value]' - Means field is taken from given table
         */
        Validator::extend('ids_exist', function ($attribute, $value, $parameters) {
            $values = to_array($value);
            $id_field = $parameters[1] ?? 'id';
            if (is_array($values)) {
                //get specified ids
                $ids = DB::table($parameters[0])
                    ->whereIn($id_field, $values)
                    ->select([$id_field]);

                if (!empty($parameters[2]) && !empty($parameters[3])) {
                    $ids = $ids->where($parameters[2], $parameters[3])
                        ->select([$id_field, $parameters[2]]);
                }

                $ids = $ids->pluck($id_field);

                //check if all ids exists
                foreach ($values as $value) {
                    if (! $ids->contains($value)) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        });

        /**
         * Rule is to be defined like this:
         *
         * 'latitude' - Means the value must be a valid latitude
         */
        Validator::extend('latitude', function ($attribute, $value) {
            return is_numeric($value) && preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $value);
        });

        /**
         * Rule is to be defined like this:
         *
         * 'longitude' - Means the value must be a valid longitude
         */
        Validator::extend('longitude', function ($attribute, $value) {
            return is_numeric($value) && preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $value);
        });

        /**
         * Rule is to be defined like this:
         *
         * 'array_exists:val1,val2,..' - Means $value is array, and all values exists in given array
         */
        Validator::extend('array_exists', function ($attribute, $values, $parameters) {
            $values = to_array($values);
            if (is_array($values)) {
                foreach ($values as $value) {
                    if (!in_array($value, $parameters)) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        });

        /**
         * Rule is to be defined like this:
         *
         * 'color' - Means the value must be a hex color
         */
        Validator::extend('color', function ($attribute, $value) {
            return is_color($value);
        });

        /**
         * Assumes that child attributes that are validated are the allowed attributes.
         * to be used to validate input array keys.
         * Rule is to be defined like this:
         *
         * 'parent.*' => 'allowed_attributes'
         * https://stackoverflow.com/questions/55503686/laravel-validation-only-allow-known-properties-attributes-otherwise-fail-valid
         */
        Validator::extendImplicit('allowed_attributes', function ($attribute, $value, $parameters, $validator) {
            // If the attribute to validate request top level
            if (strpos($attribute, '.') === false) {
                return in_array($attribute, $parameters);
            }

            // If the attribute under validation is an array
            if (is_array($value)) {
                return empty(array_diff_key($value, array_flip($parameters)));
            }

            // If the attribute under validation is an object
            foreach ($parameters as $parameter) {
                if (substr_compare($attribute, $parameter, -strlen($parameter)) === 0) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Require helpers defined on the package.
        require_once __DIR__ . '/helpers.php';

        // require local helpers
        foreach (glob(app_path().'/Helpers/*.php') as $filename) {
            require_once($filename);
        }

        $this->registerMiddlewareAliases();
    }

    public function registerMiddlewareAliases(): void
    {
        app('router')->aliasMiddleware('json', JsonOnly::class);
    }
}

<?php

namespace Javaabu\Helpers\Testing;

use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;
use Javaabu\Permissions\Models\Role;
use Database\Seeders\PermissionsSeeder;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Notification::fake();
    }

    /**
     * Assert that the password equals certain value
     * @param $expected
     * @param $actual
     */
    public function assertPasswordEquals($expected, $actual)
    {
        $this->assertTrue(Hash::check($expected, $actual), "Expected password to be $expected");
    }

    /**
     * Assert that the password does not equals certain value
     * @param $expected
     * @param $actual
     */
    public function assertPasswordNotEquals($expected, $actual)
    {
        $this->assertFalse(Hash::check($expected, $actual), "Expected password to not be $expected");
    }

    /**
     * Get the token for the user
     * @param $user
     * @param null $broker
     * @return
     */
    protected function getResetToken($user, $broker = null)
    {
        return app(PasswordBrokerManager::class)
            ->broker($broker)
            ->createToken($user);
    }

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

    /**
     * Initialize the db
     */
    protected function seedDatabase()
    {
        $this->seed(PermissionsSeeder::class);
    }

    /**
     * Acting as a specific user
     *
     * @param $email
     * @param string $guard
     */
    protected function actingAsAdmin(
        array $permissions = [],
        $email = 'demo-admin@javaabu.com',
        $role = 'test_role',
        string $guard = 'web_admin'
    )
    {
        $this->seedDatabase();

        //find the user
        $user = is_object($email) ? $email : $this->getActiveAdminUser($email, $role);

        if ($permissions) {
            $this->givePermissionTo($user, $permissions);
        }

        $this->actingAs($user, $guard);
    }

    /**
     * Get active user
     */
    protected function getActiveAdminUser($email, $role = 'test_role'): User
    {
        // find the user
        $user = User::whereEmail($email)->first();

        // if missing, create
        if (! $user) {
            $user = User::factory()
                ->active()
                ->create([
                    'email' => $email,
                ]);
        }

        // assign role
        if (! $user->hasRole($role)) {
            $role = $this->getRole($role);

            $user->assignRole($role);
        }

        return $user;
    }

    /**
     * Get role
     */
    protected function getRole($role_name, $guard = 'web_admin'): Role
    {
        // find the role
        $role = Role::whereName($role_name)
                    ->whereGuardName($guard)
                    ->first();

        // if missing, create
        if (! $role) {
            $role = Role::factory()
                ->create([
                    'name' => $role_name,
                    'guard_name' => $guard
                ]);
        }

        return $role;
    }

    /**
     * Revoke permission
     *
     * @param $user
     * @param $permission
     */
    protected function revokePermissionTo($user, $permission)
    {
        $user->roles()
            ->first()
            ->revokePermissionTo($permission);
    }

    /**
     * Grant permission
     *
     * @param $user
     * @param $permission
     */
    protected function givePermissionTo($user, $permission)
    {
        $user->roles()
            ->first()
            ->givePermissionTo($permission);
    }

    protected function getFactory($class): Factory
    {
        $factory = $class::factory();

        if (method_exists($factory, 'withRequiredRelations')) {
            $factory->withRequiredRelations();
        }

        return $factory;
    }
}

<?php

namespace Javaabu\Helpers\Testing;

use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Cookie\CookieValuePrefix;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Javaabu\Settings\Testing\FakesSettings;
use Laravel\Passport\ApiTokenCookieFactory;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Javaabu\Permissions\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Javaabu\Permissions\Models\Role;
use Database\Seeders\PermissionsSeeder;

abstract class TestCase extends BaseTestCase
{
    use FakesSettings;
    
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
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
        $permissions = [],
        $email = 'demo-admin@javaabu.com',
        $role = 'test_role',
        string $guard = 'web_admin'
    )
    {
        $this->seedDatabase();

        //find the user
        if (is_object($email)) {
            $user = $email;

            if ($permissions) {
                $this->givePermissionTo($user, $permissions);
            }
        } else {
            $user = $this->getActiveAdminUser($email, $role, $permissions);
        }

        $this->actingAs($user, $guard);
    }

    /**
     * Acting as a api admin user
     *
     * @param $email
     * @param string $guard
     */
    protected function actingAsApiAdmin(
        $permissions = [],
        $email = 'demo-admin@javaabu.com',
        $role = 'test_role',
        string $guard = 'api_admin',
        $scopes = ['read', 'write']
    )
    {
        $this->seedDatabase();

        //find the user
        if (is_object($email)) {
            $user = $email;

            if ($permissions) {
                $this->givePermissionTo($user, $permissions);
            }
        } else {
            $user = $this->getActiveAdminUser($email, $role, $permissions);
        }

        $this->actingAsApiUser($user, $scopes, $guard);
    }

    /**
     * Get active user
     */
    protected function getActiveAdminUser($email, $role = 'test_role', $permissions = []): User
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

        if ($permissions) {
            $this->givePermissionTo($user, $permissions);
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
    protected function givePermissionTo($user, $permissions)
    {
        // If input permission starts with *, then get all permissions for the model
        if (is_string($permissions) && str($permissions)->startsWith('*')) {
            $filter = str($permissions)->afterLast('*');
            $permissions = Permission::query()
                ->where('model', $filter)
                ->pluck('name')
                ->toArray();

        }

        $user->roles()
            ->first()
            ->givePermissionTo($permissions);
    }

    protected function getFactory($class): Factory
    {
        $factory = $class::factory();

        if (method_exists($factory, 'withRequiredRelations')) {
            return $factory->withRequiredRelations();
        }

        return $factory;
    }

    /**
     * Make a json API call
     *
     * @param $method
     * @param $uri
     * @param array $data
     * @param string $access_cookie
     * @param array $headers
     * @param array $cookies
     * @return TestResponse
     */
    public function jsonApi($method, $uri, array $data = [], string $access_cookie = '', array $headers = [], array $cookies = [])
    {
        $files = $this->extractFilesFromDataArray($data);

        $content = json_encode($data);

        $headers = array_merge([
            'CONTENT_LENGTH' => mb_strlen($content, '8bit'),
            'CONTENT_TYPE' => 'application/json',
            'Accept' => 'application/json',
            'X-CSRF-TOKEN' => session()->token(),
        ], $headers);

        $cookies = array_merge([
            Passport::cookie() => $access_cookie,
        ], $cookies);

        return $this->call(
            $method,
            $uri,
            [],
            $cookies,
            $files,
            $this->transformHeadersToServerVars($headers),
            $content
        );
    }

    /**
     * Acting as a specific API user
     * @param mixed $email
     * @param array $scopes
     */
    protected function actingAsApiUser($email, $scopes = ['read', 'write'], $guard = null)
    {
        $this->seedDatabase();

        //find the user
        $user = is_object($email) ? $email : $this->getActiveAdminUser($email);

        if (! $guard) {
            $guard = $user instanceof User ? 'api_admin' : 'api_' . ($user->getMorphClass());
        }

        Passport::actingAs($user, $scopes, $guard);
    }

    /**
     * Get an access token
     * @param string $grant_type
     * @param array $scopes
     * @param array $params
     * @param Client|null $client
     */
    protected function getAccessToken(string $grant_type = 'client_credentials', array $scopes = ['read', 'write'], array $params = [], Client $client = null)
    {
        if (empty($client)) {
            // create a new client
            $user = $this->getActiveAdminUser('demo-user@javaabu.com');
            $client = (new ClientRepository())->create(
                $user->id,
                'Test Client',
                'http://localhost'
            );
        }

        $request_params = array_merge([
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'grant_type' => $grant_type,
            'scope' => implode(' ', $scopes),
        ], $params);

        // make the request
        $response = $this->json('post', '/api/v1/oauth/token', $request_params)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
            ]);

        return ($response->json())['access_token'];
    }

    /**
     * Get client access token
     * @param array $scopes
     * @return mixed
     */
    protected function getClientAccessToken(array $scopes = ['read', 'write']): mixed
    {
        return $this->getAccessToken('client_credentials', $scopes);
    }

    /**
     * Get client access token
     * @param $username
     * @param $user_type
     * @param string $password
     * @param array $scopes
     * @return mixed
     */
    protected function getPasswordAccessToken($username, $user_type, string $password, array $scopes = ['read', 'write']): mixed
    {
        // create a new password client
        $client = (new ClientRepository())->create(
            $this->getActiveAdminUser($username)->id,
            'Test Client',
            'http://localhost',
            false,
            true
        );

        return $this->getAccessToken(
            'password',
            $scopes,
            compact('username', 'user_type', 'password'),
            $client
        );
    }

    /**
     * Get user access token
     *
     * @param $email
     * @param array $scopes
     * @return mixed
     */
    protected function getUserAccessToken($email, string $password, array $scopes = ['read', 'write']): mixed
    {
        $user = is_object($email) ? $email : $this->getActiveUser($email);
        return $this->getPasswordAccessToken($user->email, 'user', $password, $scopes);
    }

    /**
     * With OAuth Cookie
     *
     * @param $user
     * @return string
     */
    protected function getOAuthCookie($user)
    {
        $cookie_factory = new ApiTokenCookieFactory(app('config'), app('encrypter'));

        // initialize the CSRF Token
        session()->start();

        $identifier = ($user && $user->is_active) ? $user->getPassportCookieIdentifier() : null;

        $cookie = $cookie_factory->make($identifier, session()->token());

        return app('encrypter')->encrypt(
            CookieValuePrefix::create($cookie->getName(), app('encrypter')->getKey()).$cookie->getValue(),
            Passport::$unserializesCookies
        );
    }
}

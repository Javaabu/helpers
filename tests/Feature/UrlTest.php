<?php

namespace Javaabu\Helpers\Tests\Feature;

use Javaabu\Helpers\Tests\TestCase;

class UrlTest extends TestCase
{
    /** @test */
    public function it_can_convert_a_full_url_to_a_relative_url()
    {
        $this->assertEquals('google.com', relative_url('https://google.com'), 'Cannot remove protocol from external url');
        $this->assertEquals('google.com', relative_url('http://google.com'), 'Cannot remove protocol from external url');
        $this->assertEquals('google.com', relative_url('google.com'), 'Invalid relative url');
        $this->assertEquals('google.com?abc=2', relative_url('google.com?abc=2'), 'Query parameters are not retained');
        $this->assertEquals('/home', relative_url(url('home')), 'Cannot remove domain from local url');
        $this->assertEquals('/home', relative_url(secure_url('home')), 'Cannot remove domain from local url');
        $this->assertEquals('', relative_url(null), 'Cannot handle null');
        $this->assertEquals('', relative_url(''), 'Cannot handle empty string');
    }

    /** @test */
    public function it_can_add_query_args_to_a_url()
    {
        $this->withoutExceptionHandling();

        $this->assertEquals('http://example.com?key=value', add_query_arg('key', 'value', 'http://example.com'));
        $this->assertEquals('http://example.com?key=value', add_query_arg(['key' => 'value'], 'http://example.com'));
        $this->assertEquals('http://example.com?key=value&other_key', add_query_arg(['key' => 'value'], 'http://example.com?key=old_value&other_key'));
        $this->assertEquals(url('').'?key=value', add_query_arg('key', 'value'));
    }
}

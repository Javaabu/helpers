<?php

namespace Javaabu\Helpers\Tests\Unit;

use Javaabu\Helpers\Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function it_correctly_runs_to_array()
    {
        $this->assertEquals(['mango', 'apple'], to_array('mango,apple'));
        $this->assertEquals(['mango', 'apple'], to_array(['mango', 'apple']));
    }

    /** @test */
    public function it_correctly_runs_safe_in_array()
    {
        $this->assertFalse(safe_in_array('mango', 'mango,apple'));
        $this->assertTrue(safe_in_array('mango', 'mango'));
        $this->assertFalse(safe_in_array('1', 1, true));
        $this->assertTrue(safe_in_array('1', 1, false));
        $this->assertTrue(safe_in_array('mango', ['mango', 'apple']));
    }

    /** @test */
    public function it_correctly_runs_strip_protocol()
    {
        $this->assertEquals('google.com', strip_protocol('https://google.com'));
        $this->assertEquals('google.com', strip_protocol('http://google.com'));
    }

    /** @test */
    public function it_correctly_runs_url_path()
    {
        $this->assertEquals('about', url_path('https://google.com/about?foo=bar&buz=true'));
    }

    /** @test */
    public function it_correctly_runs_top_level_slugs()
    {
        $this->assertEquals([], top_level_slugs());

        $this->registerTestRoute('welcome');

        $this->assertEquals(['welcome'], top_level_slugs());
    }

    /** @test */
    public function it_correctly_runs_is_color()
    {
        $this->assertFalse(is_color('red'));
        $this->assertTrue(is_color('#000'));
        $this->assertTrue(is_color('#000000'));
        $this->assertFalse(is_color('#0000001'));
    }

    /** @test */
    public function it_correctly_runs_number_format_exact()
    {
        $this->assertEquals('1,120.5', number_format_exact(1120.5));
    }

    /** @test */
    public function it_correctly_runs_remove_prefix()
    {
        $this->assertEquals('google.com', remove_prefix('http://', 'http://google.com'));
        $this->assertEquals('google.com', remove_prefix('http://', 'google.com'));
    }

    /** @test */
    public function it_correctly_runs_remove_suffix()
    {
        $this->assertEquals('google.com', remove_suffix('/about', 'google.com/about'));
        $this->assertEquals('google.com', remove_suffix('/about', 'google.com'));
    }

    /** @test */
    public function it_correctly_runs_slug_to_title()
    {
        $this->assertEquals('Apple', slug_to_title('apple'));
        $this->assertEquals('Apple Magic', slug_to_title('apple_magic'));
        $this->assertEquals('Apple Magic', slug_to_title('apple Magic', ' '));
    }

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

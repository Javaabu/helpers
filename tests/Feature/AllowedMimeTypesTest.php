<?php

namespace Javaabu\Helpers\Tests\Feature;

use Javaabu\Helpers\Media\AllowedMimeTypes;
use Javaabu\Helpers\Tests\TestCase;

class AllowedMimeTypesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_check_if_a_given_mime_type_as_a_string_is_an_allowed_mime_type(): void
    {
        $result = AllowedMimeTypes::isAllowedMimeType('image/jpeg', 'image');
        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_check_if_a_given_mime_type_as_an_array_is_an_allowed_mime_type()
    {
        $result = AllowedMimeTypes::isAllowedMimeType('image/jpeg', ['image', 'video']);
        $this->assertTrue($result);

        $result = AllowedMimeTypes::isAllowedMimeType('video/mp4', ['image', 'video']);
        $this->assertTrue($result);
    }

}

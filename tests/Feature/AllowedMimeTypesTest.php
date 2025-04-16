<?php

namespace Javaabu\Helpers\Tests\Feature;

use Javaabu\Helpers\Media\AllowedMimeTypes;
use Javaabu\Helpers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AllowedMimeTypesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('defaults.max_upload_file_size', 1024 * 10);
        $this->app['config']->set('defaults.max_image_file_size', 1024 * 2);
    }

    #[Test]
    public function it_can_get_default_icon_pack(): void
    {
        $this->assertEquals('fontawesome', AllowedMimeTypes::getDefaultIconPack());
    }

    #[Test]
    public function it_can_change_the_default_icon_pack(): void
    {
        AllowedMimeTypes::setDefaultIconPack('material');

        $this->assertEquals('material', AllowedMimeTypes::getDefaultIconPack());
    }

    #[Test]
    public function it_can_get_the_icon_prefix(): void
    {
        $this->assertEquals('fa-regular fa-', AllowedMimeTypes::getIconPrefix());
        $this->assertEquals('zmdi zmdi-', AllowedMimeTypes::getIconPrefix('material'));
    }

    #[Test]
    public function it_can_register_the_icon_prefix(): void
    {
        AllowedMimeTypes::registerIconPrefix('fontawesome', 'fa-light fa-');

        $this->assertEquals('fa-light fa-', AllowedMimeTypes::getIconPrefix());
    }

    #[Test]
    public function it_can_get_the_icon(): void
    {
        $this->assertEquals('file-word', AllowedMimeTypes::getIcon('word'));
        $this->assertEquals('file-word', AllowedMimeTypes::getIcon('application/msword'));
        $this->assertEquals('file-text', AllowedMimeTypes::getIcon('application/msword', 'material'));
        $this->assertEquals('fa-regular fa-file-word', AllowedMimeTypes::getIcon('application/msword', with_prefix: true));
        $this->assertEquals('file', AllowedMimeTypes::getIcon('test'));
    }

    #[Test]
    public function it_can_register_icons(): void
    {
        AllowedMimeTypes::registerIcons('fontawesome', [
            'test' => 'file-test'
        ]);

        $this->assertEquals('file-test', AllowedMimeTypes::getIcon('test'));

        AllowedMimeTypes::registerIcons('fontawesome', [
            'default' => 'file'
        ], false);

        $this->assertEquals('file', AllowedMimeTypes::getIcon('word'));
    }

    #[Test]
    public function it_can_get_the_max_file_size_based_on_multiple_file_types(): void
    {
        $this->assertEquals(1024 * 10, AllowedMimeTypes::getMaxFileSize(['document', 'image']));
    }

    #[Test]
    public function it_can_get_the_max_file_size_based_on_file_type(): void
    {
        $this->assertEquals(1024 * 2, AllowedMimeTypes::getMaxFileSize('image'));
        $this->assertEquals(1024 * 10, AllowedMimeTypes::getMaxFileSize('document'));
    }

    #[Test]
    public function it_can_register_mimetypes(): void
    {
        // not registered
        $this->assertEmpty(AllowedMimeTypes::getAllowedMimeTypes('paper'));

        // register
        AllowedMimeTypes::registerMimeTypes('paper', ['text/plain']);

        $this->assertEquals(['text/plain'], AllowedMimeTypes::getAllowedMimeTypes('paper'));
    }

    #[Test]
    public function it_can_register_file_size_settings(): void
    {
        // not registered
        $this->assertEquals('max_upload_file_size', AllowedMimeTypes::getFileSizeSetting('paper'));

        // register
        AllowedMimeTypes::registerFileSizeSettings('max_document_file_size', ['bag', 'paper']);

        $this->assertEquals('max_document_file_size', AllowedMimeTypes::getFileSizeSetting('paper'));
    }

    #[Test]
    public function it_can_register_mime_type_extensions(): void
    {
        // not registered
        $this->assertNull(AllowedMimeTypes::getExtension('text/paper'));

        // register
        AllowedMimeTypes::registerMimeTypeExtensions(['text/paper' => 'pp']);

        $this->assertEquals('pp', AllowedMimeTypes::getExtension('text/paper'));
    }

    #[Test]
    public function it_can_get_file_size_setting_from_type(): void
    {
        $this->assertEquals('max_image_file_size', AllowedMimeTypes::getFileSizeSetting('icon'));
        $this->assertEquals('max_image_file_size', AllowedMimeTypes::getFileSizeSetting('image'));
        $this->assertEquals('max_upload_file_size', AllowedMimeTypes::getFileSizeSetting('document'));
    }

    #[Test]
    public function it_can_get_file_extension_from_mime_type(): void
    {
        $this->assertEquals('jpeg', AllowedMimeTypes::getExtension('image/jpeg'));
    }

    #[Test]
    public function it_can_get_file_extensions_from_mime_types(): void
    {
        $this->assertEquals(['jpeg', 'ico'], AllowedMimeTypes::getExtensions(['image/jpeg', 'image/x-icon', 'image/x-ico']));
    }

    #[Test]
    public function it_can_check_if_a_given_mime_type_as_a_string_is_an_allowed_mime_type(): void
    {
        $result = AllowedMimeTypes::isAllowedMimeType('image/jpeg', 'image');
        $this->assertTrue($result);
    }

    #[Test]
    public function it_can_check_if_a_given_mime_type_as_an_array_is_an_allowed_mime_type()
    {
        $result = AllowedMimeTypes::isAllowedMimeType('image/jpeg', ['image', 'video']);
        $this->assertTrue($result);

        $result = AllowedMimeTypes::isAllowedMimeType('video/mp4', ['image', 'video']);
        $this->assertTrue($result);
    }

    #[Test]
    public function it_can_get_all_allowed_types()
    {
        $result = AllowedMimeTypes::getAllowedTypes();
        $this->assertEquals([
            'image',
            'icon',
            'document',
            'video',
            'audio',
            'excel',
            'paper',
        ], $result);
    }
}

<?php

namespace Javaabu\Helpers\Tests\Feature;

use Javaabu\Helpers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ValidatorsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $langs = [
            'en',
            'dv'
        ];

        $files = [
            'auth',
            'pagination',
            'passwords',
            'validation'
        ];

        foreach ($langs as $lang) {
            foreach ($files as $file) {
                $path = $lang . '/' . $file . '.php';

                $this->copyFile(__DIR__ . '/../../lang/' . $path, $this->app->langPath($path));
            }
        }
    }

    protected function tearDown(): void
    {
        $this->deleteDirectory($this->app->langPath('/'));

        parent::tearDown();
    }

    #[Test]
    public function it_can_validate_a_slug()
    {
        $validator = validator(
            ['slug' => 'A b c'],
            ['slug' => 'slug']
        );

        $this->assertTrue($validator->fails());
        $this->assertEquals(
            'The slug may only contain lowercase letters, numbers, and -.',
            $validator->getMessageBag()->first('slug')
        );
    }

    #[Test]
    public function it_can_load_localized_validation()
    {
        $this->app->setLocale('dv');

        $validator = validator(
            ['slug' => 'A b c'],
            ['slug' => 'slug']
        );

        $this->assertTrue($validator->fails());
        $this->assertEquals(
            'slug ގައި ހަމައެކަނި ހިމެނޭނީ ކުދި އަކުރާއި، ނަންބަރާއި، -.',
            $validator->getMessageBag()->first('slug')
        );
    }
}

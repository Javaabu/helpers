<?php

namespace Javaabu\Helpers\Tests\Feature;

use Javaabu\Helpers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class HelpersServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        $this->copyFile($this->getTestStubPath('helpers.php'), $this->applicationBasePath() . '/app/Helpers/helpers.php');

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->deleteDirectory($this->app->path('Helpers'));

        parent::tearDown();
    }

    #[Test]
    public function it_loads_local_helpers()
    {
        $this->withoutExceptionHandling();

        $this->registerTestRoute('helpers-test');

        $this->get('/helpers-test')
            ->assertSuccessful()
            ->assertSeeText('helpers work');
    }
}

<?php

namespace Javaabu\Helpers\Tests\Unit;

use Javaabu\Helpers\Enums\PublishStatuses;
use Javaabu\Helpers\Tests\TestCase;

class EnumsTest extends TestCase
{
    /** @test */
    public function it_can_generate_enum_label()
    {
        $this->assertEquals('Pending', PublishStatuses::PENDING->getLabel());
        $this->assertEquals([
            'draft'     => 'Draft',
            'pending'   => 'Pending',
            'published' => 'Published',
            'rejected'  => 'Rejected',
        ], PublishStatuses::getLabels());
    }
}

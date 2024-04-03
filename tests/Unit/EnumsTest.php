<?php

namespace Javaabu\Helpers\Tests\Unit;

use Javaabu\Helpers\Enums\UserStatuses;
use Javaabu\Helpers\Tests\TestCase;

class EnumsTest extends TestCase
{
    /** @test */
    public function it_can_generate_enum_label()
    {
        $this->assertEquals('Pending', UserStatuses::PENDING->getLabel());
        $this->assertEquals([
            'approved' => 'Approved',
            'pending' => 'Pending',
            'banned' => 'Banned'
        ], UserStatuses::getLabels());
    }
}

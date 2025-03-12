<?php

namespace Javaabu\Helpers\Tests\Unit;

use Javaabu\Helpers\Enums\HasColor;
use Javaabu\Helpers\Enums\IsStatusEnum;
use Javaabu\Helpers\Enums\PublishStatuses;
use Javaabu\Helpers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class EnumsTest extends TestCase
{
    #[Test]
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

    #[Test]
    public function it_can_see_that_an_enum_is_a_status_enum()
    {
        $this->assertTrue(in_array(IsStatusEnum::class, class_implements(PublishStatuses::class)));
        $this->assertTrue(method_exists(PublishStatuses::class, 'getLabel'));
        $this->assertTrue(method_exists(PublishStatuses::class, 'getLabels'));
        $this->assertTrue(method_exists(PublishStatuses::class, 'labels'));
        $this->assertTrue(method_exists(PublishStatuses::class, 'getColor'));
    }

    #[Test]
    public function it_can_get_enum_color()
    {
        // Check if enum implements HasColor
        $this->assertTrue(in_array(HasColor::class, class_implements(PublishStatuses::class)));

        $this->assertEquals('secondary', PublishStatuses::DRAFT->getColor());

        $this->assertEquals(
            [
                'draft'     => 'secondary',
                'pending'   => 'info',
                'published' => 'success',
                'rejected'  => 'danger',
            ],
            [
                PublishStatuses::DRAFT->value     => PublishStatuses::DRAFT->getColor(),
                PublishStatuses::PENDING->value   => PublishStatuses::PENDING->getColor(),
                PublishStatuses::PUBLISHED->value => PublishStatuses::PUBLISHED->getColor(),
                PublishStatuses::REJECTED->value  => PublishStatuses::REJECTED->getColor(),
            ]
        );
    }
}

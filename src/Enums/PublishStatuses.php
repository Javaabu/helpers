<?php

namespace Javaabu\Helpers\Enums;


enum PublishStatuses: string implements IsEnum
{
    use NativeEnumsTrait;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';

    public static function labels(): array
    {
        return [
            self::DRAFT->value     => __("Draft"),
            self::PENDING->value   => __("Pending"),
            self::PUBLISHED->value => __("Published"),
            self::REJECTED->value  => __("Rejected"),
        ];
    }
}

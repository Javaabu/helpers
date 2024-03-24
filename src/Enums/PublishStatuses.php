<?php

namespace Javaabu\Helpers\Enums;


enum PublishStatuses: string implements IsEnum
{
    use NativeEnumsTrait;

    const DRAFT = 'draft';
    const PENDING = 'pending';
    const PUBLISHED = 'published';
    const REJECTED = 'rejected';

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

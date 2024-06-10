<?php

namespace Javaabu\Helpers\Enums;


enum PublishStatuses: string implements IsStatusEnum
{
    use NativeEnumsTrait;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';

    public function getColor(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::PENDING => 'info',
            self::PUBLISHED => 'success',
            self::REJECTED => 'danger',
        };
    }
}

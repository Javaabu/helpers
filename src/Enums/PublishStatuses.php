<?php

namespace Javaabu\Helpers\Enums;


enum PublishStatuses: string implements IsEnum
{
    use NativeEnumsTrait;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';
}

<?php

namespace Javaabu\Helpers\Enums;


enum PublishStatuses: string implements IsEnum
{
    use NativeEnumsTrait;

    const DRAFT = 'draft';
    const PENDING = 'pending';
    const PUBLISHED = 'published';
    const REJECTED = 'rejected';
}

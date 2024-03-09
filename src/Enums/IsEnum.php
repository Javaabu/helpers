<?php

namespace Javaabu\Helpers\Enums;

interface IsEnum
{
    public static function labels(): array;

    public function getLabel(): string;
}

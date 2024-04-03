<?php

namespace Javaabu\Helpers\Enums;

interface IsEnum
{
    public static function labels(): array;

    public static function getLabels(): array;

    public function getLabel(): string;
}

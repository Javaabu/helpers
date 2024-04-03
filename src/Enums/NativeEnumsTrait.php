<?php

namespace Javaabu\Helpers\Enums;


use BackedEnum;
use Illuminate\Support\Str;

trait NativeEnumsTrait
{
    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }

    public static function getLabelFromKey(string $key): string
    {
        return self::labels()[$key] ?? '';
    }

    public static function getKeys(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return static::getLabels();
    }

    public static function getLabels(): array
    {
        $cases = static::cases();

        $labels = [];

        /** @var static $case */
        foreach ($cases as $case) {
            $labels[$case->value] = __(slug_to_title($case->name));
        }

        return $labels;
    }

    public static function slugs(string|BackedEnum $input)
    {
        if ($input instanceof BackedEnum) {
            $input = $input->value;
        }

        $status_slugs = [];
        $cases = self::cases();

        foreach ($cases as $case) {
            $status_slugs[$case->value] = $case->value;
        }

        return $status_slugs[$input] ?? '';
    }

    public static function names(string|BackedEnum $input)
    {
        if ($input instanceof BackedEnum) {
            $input = $input->value;
        }

        $status_names = [];
        $cases = self::cases();

        foreach ($cases as $case) {
            $status_names[$case->value] = $case->getLabel();
        }

        return $status_names[$input] ?? '';
    }
}

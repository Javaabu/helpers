<?php
/**
 * Simple class to check for mimetype
 */

namespace Javaabu\Helpers\Media;

use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

abstract class AllowedMimeTypes
{
    /**
     * @var array
     */
    protected static array $allowed_mime_types = [
        'image' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/tiff',
            'image/x-citrix-png',
            'image/x-png',
            'image/svg+xml',
            'image/svg',
        ],

        'icon' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/tiff',
            'image/x-citrix-png',
            'image/x-png',
            'image/x-icon',
            'image/vnd.microsoft.icon'
        ],

        'document' => [
            'application/pdf',
            'image/jpeg',
            'image/png',
        ],

        'video' => [
            'video/webm',
            'video/ogg',
            'video/mp4',
        ],

        'excel' => [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'application/vnd.ms-excel.sheet.macroEnabled.12',
            'application/vnd.ms-excel.template.macroEnabled.12',
            'application/vnd.ms-excel.addin.macroEnabled.12',
            'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'text/csv',
        ]
    ];

    public static function registerMimeTypes(string $key, array $mime_types): void
    {
        self::$allowed_mime_types[$key] = $mime_types;
    }

    /**
     * Get the allowed mime types for the specific type
     *
     * @param  string|array  $type
     * @return array
     */
    public static function getAllowedMimeTypes(string|array $type): array
    {
        if (is_array($type)) {
            $mime_types = [];

            foreach ($type as $one_type) {
                if (isset(self::$allowed_mime_types[$one_type])) {
                    $mime_types[] = self::$allowed_mime_types[$one_type];
                }
            }

            return Arr::flatten($mime_types);
        }

        return $type ? (self::$allowed_mime_types[$type] ?? []) : Arr::flatten(self::$allowed_mime_types);
    }

    /**
     * Generate allowed mime type html string
     *
     * @param  string  $type
     * @param  string  $separator
     * @return string
     */
    public static function getAllowedMimeTypesString(string $type, string $separator = ','): string
    {
        return implode($separator, self::getAllowedMimeTypes($type));
    }

    /**
     * Check if is an allowed mime type for the given type
     *
     * @param  string  $mime_type
     * @param  string  $type
     * @return boolean
     */
    public static function isAllowedMimeType(string $mime_type, string $type): bool
    {
        return in_array($mime_type, self::getAllowedMimeTypes($type));
    }

    /**
     * Get the validation rule for the given type
     *
     * @param  string  $type
     * @param  bool    $as_array
     * @return string|array
     */
    public static function getValidationRule(string $type, bool $as_array = false, ?int $max_size = null): array|string
    {
        if (is_null($max_size)) {
            $max_size = $type == 'image' ? get_setting('max_image_file_size') : get_setting('max_upload_file_size');
        }

        $rules = [
            'nullable',
            'mimetypes:'.AllowedMimeTypes::getAllowedMimeTypesString($type),
            'max:'.$max_size,
        ];

        return $as_array ? $rules : implode('|', $rules);
    }

    /**
     * Get the type from the mime type
     * @param string $mime_type
     * @return string|null
     */
    public static function getType(string $mime_type): ?string
    {
        foreach (self::$allowed_mime_types as $type => $mime_types) {
            if (in_array($mime_type, $mime_types)) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Get the validation rule for the given type of attachment
     *
     * @param string|null $type
     * @return array
     */
    public static function getAttachmentValidationRule(string $type = null): array
    {
        $rules = [
            'nullable',
            Rule::exists('media', 'id')->whereIn('mime_type', AllowedMimeTypes::getAllowedMimeTypes($type)),
        ];

        return $rules;
    }

    /**
     * Get the the extension for the mime type
     *
     * @param $mime
     * @return mixed|string|null
     */
    public static function getExtension($mime)
    {
        return isset(self::$mime_type_extensions[$mime]) ? self::$mime_type_extensions[$mime] : null;
    }
}

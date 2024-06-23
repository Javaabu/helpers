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
    protected static array $file_size_settings = [
        'max_image_file_size' => [
            'icon',
            'image',
        ],
    ];

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

        'audio' => [
            'audio/mp3',
            'audio/wav',
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

    /**
     * @var array
     */
    protected static $mime_type_extensions = [
        'video/3gpp2'                                                               => '3g2',
        'video/3gp'                                                                 => '3gp',
        'video/3gpp'                                                                => '3gp',
        'application/x-compressed'                                                  => '7zip',
        'audio/x-acc'                                                               => 'aac',
        'audio/ac3'                                                                 => 'ac3',
        'application/postscript'                                                    => 'ai',
        'audio/x-aiff'                                                              => 'aif',
        'audio/aiff'                                                                => 'aif',
        'audio/x-au'                                                                => 'au',
        'video/x-msvideo'                                                           => 'avi',
        'video/msvideo'                                                             => 'avi',
        'video/avi'                                                                 => 'avi',
        'application/x-troff-msvideo'                                               => 'avi',
        'application/macbinary'                                                     => 'bin',
        'application/mac-binary'                                                    => 'bin',
        'application/x-binary'                                                      => 'bin',
        'application/x-macbinary'                                                   => 'bin',
        'image/bmp'                                                                 => 'bmp',
        'image/x-bmp'                                                               => 'bmp',
        'image/x-bitmap'                                                            => 'bmp',
        'image/x-xbitmap'                                                           => 'bmp',
        'image/x-win-bitmap'                                                        => 'bmp',
        'image/x-windows-bmp'                                                       => 'bmp',
        'image/ms-bmp'                                                              => 'bmp',
        'image/x-ms-bmp'                                                            => 'bmp',
        'application/bmp'                                                           => 'bmp',
        'application/x-bmp'                                                         => 'bmp',
        'application/x-win-bitmap'                                                  => 'bmp',
        'application/cdr'                                                           => 'cdr',
        'application/coreldraw'                                                     => 'cdr',
        'application/x-cdr'                                                         => 'cdr',
        'application/x-coreldraw'                                                   => 'cdr',
        'image/cdr'                                                                 => 'cdr',
        'image/x-cdr'                                                               => 'cdr',
        'zz-application/zz-winassoc-cdr'                                            => 'cdr',
        'application/mac-compactpro'                                                => 'cpt',
        'application/pkix-crl'                                                      => 'crl',
        'application/pkcs-crl'                                                      => 'crl',
        'application/x-x509-ca-cert'                                                => 'crt',
        'application/pkix-cert'                                                     => 'crt',
        'text/css'                                                                  => 'css',
        'text/x-comma-separated-values'                                             => 'csv',
        'text/comma-separated-values'                                               => 'csv',
        'application/vnd.msexcel'                                                   => 'csv',
        'application/x-director'                                                    => 'dcr',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/x-dvi'                                                         => 'dvi',
        'message/rfc822'                                                            => 'eml',
        'application/x-msdownload'                                                  => 'exe',
        'video/x-f4v'                                                               => 'f4v',
        'audio/x-flac'                                                              => 'flac',
        'video/x-flv'                                                               => 'flv',
        'image/gif'                                                                 => 'gif',
        'application/gpg-keys'                                                      => 'gpg',
        'application/x-gtar'                                                        => 'gtar',
        'application/x-gzip'                                                        => 'gzip',
        'application/mac-binhex40'                                                  => 'hqx',
        'application/mac-binhex'                                                    => 'hqx',
        'application/x-binhex40'                                                    => 'hqx',
        'application/x-mac-binhex40'                                                => 'hqx',
        'text/html'                                                                 => 'html',
        'image/x-icon'                                                              => 'ico',
        'image/x-ico'                                                               => 'ico',
        'image/vnd.microsoft.icon'                                                  => 'ico',
        'text/calendar'                                                             => 'ics',
        'application/java-archive'                                                  => 'jar',
        'application/x-java-application'                                            => 'jar',
        'application/x-jar'                                                         => 'jar',
        'image/jp2'                                                                 => 'jp2',
        'video/mj2'                                                                 => 'jp2',
        'image/jpx'                                                                 => 'jp2',
        'image/jpm'                                                                 => 'jp2',
        'image/jpeg'                                                                => 'jpeg',
        'image/pjpeg'                                                               => 'jpeg',
        'application/x-javascript'                                                  => 'js',
        'application/json'                                                          => 'json',
        'text/json'                                                                 => 'json',
        'application/vnd.google-earth.kml+xml'                                      => 'kml',
        'application/vnd.google-earth.kmz'                                          => 'kmz',
        'text/x-log'                                                                => 'log',
        'audio/x-m4a'                                                               => 'm4a',
        'audio/mp4'                                                                 => 'm4a',
        'application/vnd.mpegurl'                                                   => 'm4u',
        'audio/midi'                                                                => 'mid',
        'application/vnd.mif'                                                       => 'mif',
        'video/quicktime'                                                           => 'mov',
        'video/x-sgi-movie'                                                         => 'movie',
        'audio/mpeg'                                                                => 'mp3',
        'audio/mpg'                                                                 => 'mp3',
        'audio/mpeg3'                                                               => 'mp3',
        'audio/mp3'                                                                 => 'mp3',
        'video/mp4'                                                                 => 'mp4',
        'video/mpeg'                                                                => 'mpeg',
        'application/oda'                                                           => 'oda',
        'audio/ogg'                                                                 => 'ogg',
        'video/ogg'                                                                 => 'ogg',
        'application/ogg'                                                           => 'ogg',
        'font/otf'                                                                  => 'otf',
        'application/x-pkcs10'                                                      => 'p10',
        'application/pkcs10'                                                        => 'p10',
        'application/x-pkcs12'                                                      => 'p12',
        'application/x-pkcs7-signature'                                             => 'p7a',
        'application/pkcs7-mime'                                                    => 'p7c',
        'application/x-pkcs7-mime'                                                  => 'p7c',
        'application/x-pkcs7-certreqresp'                                           => 'p7r',
        'application/pkcs7-signature'                                               => 'p7s',
        'application/pdf'                                                           => 'pdf',
        'application/octet-stream'                                                  => 'pdf',
        'application/x-x509-user-cert'                                              => 'pem',
        'application/x-pem-file'                                                    => 'pem',
        'application/pgp'                                                           => 'pgp',
        'application/x-httpd-php'                                                   => 'php',
        'application/php'                                                           => 'php',
        'application/x-php'                                                         => 'php',
        'text/php'                                                                  => 'php',
        'text/x-php'                                                                => 'php',
        'application/x-httpd-php-source'                                            => 'php',
        'image/png'                                                                 => 'png',
        'image/x-png'                                                               => 'png',
        'application/powerpoint'                                                    => 'ppt',
        'application/vnd.ms-powerpoint'                                             => 'ppt',
        'application/vnd.ms-office'                                                 => 'ppt',
        'application/msword'                                                        => 'doc',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/x-photoshop'                                                   => 'psd',
        'image/vnd.adobe.photoshop'                                                 => 'psd',
        'audio/x-realaudio'                                                         => 'ra',
        'audio/x-pn-realaudio'                                                      => 'ram',
        'application/x-rar'                                                         => 'rar',
        'application/rar'                                                           => 'rar',
        'application/x-rar-compressed'                                              => 'rar',
        'audio/x-pn-realaudio-plugin'                                               => 'rpm',
        'application/x-pkcs7'                                                       => 'rsa',
        'text/rtf'                                                                  => 'rtf',
        'text/richtext'                                                             => 'rtx',
        'video/vnd.rn-realvideo'                                                    => 'rv',
        'application/x-stuffit'                                                     => 'sit',
        'application/smil'                                                          => 'smil',
        'text/srt'                                                                  => 'srt',
        'image/svg+xml'                                                             => 'svg',
        'image/svg'                                                                 => 'svg',
        'application/x-shockwave-flash'                                             => 'swf',
        'application/x-tar'                                                         => 'tar',
        'application/x-gzip-compressed'                                             => 'tgz',
        'image/tiff'                                                                => 'tiff',
        'font/ttf'                                                                  => 'ttf',
        'text/plain'                                                                => 'txt',
        'text/x-vcard'                                                              => 'vcf',
        'application/videolan'                                                      => 'vlc',
        'text/vtt'                                                                  => 'vtt',
        'audio/x-wav'                                                               => 'wav',
        'audio/wave'                                                                => 'wav',
        'audio/wav'                                                                 => 'wav',
        'application/wbxml'                                                         => 'wbxml',
        'video/webm'                                                                => 'webm',
        'image/webp'                                                                => 'webp',
        'audio/x-ms-wma'                                                            => 'wma',
        'application/wmlc'                                                          => 'wmlc',
        'video/x-ms-wmv'                                                            => 'wmv',
        'video/x-ms-asf'                                                            => 'wmv',
        'font/woff'                                                                 => 'woff',
        'font/woff2'                                                                => 'woff2',
        'application/xhtml+xml'                                                     => 'xhtml',
        'application/excel'                                                         => 'xl',
        'application/msexcel'                                                       => 'xls',
        'application/x-msexcel'                                                     => 'xls',
        'application/x-ms-excel'                                                    => 'xls',
        'application/x-excel'                                                       => 'xls',
        'application/x-dos_ms_excel'                                                => 'xls',
        'application/xls'                                                           => 'xls',
        'application/x-xls'                                                         => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
        'application/vnd.ms-excel'                                                  => 'xlsx',
        'application/xml'                                                           => 'xml',
        'text/xml'                                                                  => 'xml',
        'text/xsl'                                                                  => 'xsl',
        'application/xspf+xml'                                                      => 'xspf',
        'application/x-compress'                                                    => 'z',
        'application/x-zip'                                                         => 'zip',
        'application/zip'                                                           => 'zip',
        'application/x-zip-compressed'                                              => 'zip',
        'application/s-compressed'                                                  => 'zip',
        'multipart/x-zip'                                                           => 'zip',
        'text/x-scriptzsh'                                                          => 'zsh',
    ];


    public static function registerMimeTypes(string $key, array $mime_types): void
    {
        self::$allowed_mime_types[$key] = $mime_types;
    }

    public static function registerFileSizeSettings(string $setting_key, array $file_types): void
    {
        self::$file_size_settings[$setting_key] = $file_types;
    }

    public static function registerMimeTypeExtensions(array $extensions): void
    {
        self::$mime_type_extensions = array_merge(self::$mime_type_extensions, $extensions);
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
     * @param  string|array  $type
     * @param  string  $separator
     * @return string
     */
    public static function getAllowedMimeTypesString(string|array $type, string $separator = ','): string
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
    public static function isAllowedMimeType(string $mime_type, array|string $type): bool
    {
        return in_array($mime_type, self::getAllowedMimeTypes($type));
    }

    /**
     * Get the max size in kb for the given type
     */
    public static function getMaxFileSize(string|array $types): int
    {
        $max_size = 0;
        $types = Arr::wrap($types);

        foreach ($types as $type) {
            // first check if a setting is defined
            $size = get_setting("max_{$type}_file_size");

            if (empty($size)) {
                $setting_key = self::getFileSizeSetting($type);
                $size = get_setting($setting_key);
            }

            $size = (int) $size;

            // check if max size
            if ($size > $max_size) {
                $max_size = $size;
            }
        }

        return $max_size;
    }

    /**
     * Get the validation rule for the given type
     *
     * @param  string  $type
     * @param  bool    $as_array
     * @return string|array
     */
    public static function getValidationRule(string|array $type, bool $as_array = false, ?int $max_size = null): array|string
    {
        if (is_null($max_size)) {
            $max_size = self::getMaxFileSize($type);
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
     * Get the file size setting for the given type
     * @param string $file_type
     * @return string
     */
    public static function getFileSizeSetting(string $file_type): string
    {
        foreach (self::$file_size_settings as $setting_key => $types) {
            if (in_array($file_type, $types)) {
                return $setting_key;
            }
        }

        return 'max_upload_file_size';
    }

    /**
     * Get the validation rule for the given type of attachment
     *
     * @param string|null $type
     * @return array
     */
    public static function getAttachmentValidationRule(string|array $type = null): array
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
    public static function getExtension(?string $mime_type): ?string
    {
        return self::$mime_type_extensions[$mime_type] ?? null;
    }

    /**
     * Get the extensions for the mime types
     *
     * @param $mime
     * @return mixed|string|null
     */
    public static function getExtensions(array $mime_types): array
    {
        $extensions = [];

        foreach ($mime_types as $mimetype) {
            if ($extension = self::getExtension($mimetype)) {
                $extensions[] = $extension;
            }
        }

        return array_unique($extensions);
    }
}

---
title: AllowedMimeTypes
sidebar_position: 1
---

This class provides convenient validation methods for different file types.

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Javaabu\Helpers\Media\AllowedMimeTypes;

class ProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {       
        $rules = [
            'featured_image' => AllowedMimeTypes::getValidationRule('image'),
        ];

        return $rules;
    }
}

```

## Available Methods

The `AllowedMimeTypes` class has the following available static methods.

### getAllowedMimeTypes(string|array $type): array

Given a file type, or an array of types, returns an array of allowed mime types.

```php
$mimetypes = AllowedMimeTypes::getAllowedMimeTypes('image');
/* $mimetypes 
[
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/tiff',
    'image/x-citrix-png',
    'image/x-png',
    'image/svg+xml',
    'image/svg',
]
*/
```

To register your own mime types, you can call the `AllowedMimeTypes::registerMimeTypes` method in the `boot` method of your`App\Providers\AppServiceProvider` class.

```php
use Javaabu\Helpers\AllowedMimeTypes;

AllowedMimeTypes::registerMimeTypes('word', ['application/vnd.ms-word', 'text/plain']);
```

### getAllowedMimeTypesString(string|array $type, string $separator = ','): string

Given a file type, or an array of types, returns a string of allowed mime types separated by the given delimiter.

```php
$mimetypes = AllowedMimeTypes::getAllowedMimeTypesString('image');
/* $mimetypes 
"image/jpeg,image/png,image/gif,image/tiff,image/x-citrix-png,image/x-png,image/svg+xml,image/svg"
*/
```

### isAllowedMimeType(string $mime_type, array|string $type): bool

Checks whether a given mimetype is allowed for the given file type(s).

```php
AllowedMimeTypes::isAllowedMimeType('audio/mp3', 'image'); // returns false
```

### getMaxFileSize(string $type): int

Returns the max allowed file size in KB for the given file type. By default, the method will look if a `'max_<type>_file_size''` setting is available. Otherwise, it will fallback to the `'max_upload_file_size'` setting. Make sure the setting returns an int.

```php
AllowedMimeTypes::getMaxFileSize('image');
// returns value of max_image_file_size setting
```

By default, the method will look for a setting in the format `'max_{type}_file_size'`. If the setting is not available, then it will fallback to `'max_upload_file_size'` setting.

To register your own file size settings for a set of file types, you can call the `AllowedMimeTypes::registerFileSizeSettings` method in the `boot` method of your`App\Providers\AppServiceProvider` class.

```php
use Javaabu\Helpers\AllowedMimeTypes;

AllowedMimeTypes::registerFileSizeSettings('max_audio_visual_file_size', ['video', 'audio']);
```

In the above example, both `video` and `audio` files will use the `'max_audio_visual_file_size'` setting.

### getValidationRule(string $type, bool $as_array = false, ?int $max_size = null): array|string

Generates the validation rule for the given file type. Optionally pass a custom file size.

### getType(string $mime_type): ?string

Given a mime type, returns the corresponding file type.

```php
AllowedMimeTypes::getType('image/jpeg');
// returns image
```

### getFileSizeSetting(string $file_type): string

Given a file type, returns the registered file size setting. If no setting is registered, falls back to `'max_upload_file_size'`.

```php
AllowedMimeTypes::getFileSizeSetting('icon');
// returns 'max_image_file_size'
```

### getAttachmentValidationRule(string $type = null): array

Given a file type, generates a validation rule for valid media record from `spatie/laravel-medialibrary` media table.

### getExtension(?string $mime_type): ?string

Given a mimetype, returns the corresponding file extension.

```php
AllowedMimeTypes::getExtension('image/jpeg');
// returns 'jpeg'
```

To register your own mime type extensions, you can call the `AllowedMimeTypes::registerMimeTypeExtensions` method in the `boot` method of your`App\Providers\AppServiceProvider` class.

```php
use Javaabu\Helpers\AllowedMimeTypes;

AllowedMimeTypes::registerMimeTypeExtensions([
    'image/png' => 'png',
    'image/ico' => 'ico'
]);
```




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

### getAllowedMimeTypes(string|array $type = ''): array

Given a file type, or an array of types, returns an array of allowed mime types. If no type is provided, returns all allowed mimetypes.

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

### getDefaultIconPack(): string

Returns the default icon pack. 

```php
$icon_pack = AllowedMimeTypes::getDefaultIconPack();
// fontawesome
```

To change the default icon pack, you can call the `AllowedMimeTypes::setDefaultIconPack` method in the `boot` method of your`App\Providers\AppServiceProvider` class.
Out of the box, the package supports `fontawesome` and `material` icon packs.

```php
use Javaabu\Helpers\AllowedMimeTypes;

AllowedMimeTypes::setDefaultIconPack('material');
```

### getIconPrefix(string $icon_pack = ''): string

Returns the icon prefix for the given icon pack. If no icon pack is given, returns the prefix for the default icon pack.

```php
$prefix = AllowedMimeTypes::getIconPrefix('material');
// zmdi zmdi-
```

To change the icon prefix for a given icon pack, you can call the `AllowedMimeTypes::registerIconPrefix` method in the `boot` method of your`App\Providers\AppServiceProvider` class.

```php
use Javaabu\Helpers\AllowedMimeTypes;

AllowedMimeTypes::registerIconPrefix('fontawesome', 'fa-light fa');
```

### getIcon(string $mime_type, string $icon_pack = '', bool $with_prefix = false): string

Returns the icon for the given mimetype. If no icon pack is given, uses the default icon pack. If an icon is not defined directly for the given mime type, then it will fallback to the file type of the mime type. If no icon is defined for the file type as well, then will fallback to the `default` icon of the icon pack.

```php
AllowedMimeTypes::getIcon('word'); // file-word
AllowedMimeTypes::getIcon('application/msword'); // file-word
AllowedMimeTypes::getIcon('application/msword', 'material'); // file-text
AllowedMimeTypes::getIcon('application/msword', with_prefix: true)); // fa-regular fa-file-word
AllowedMimeTypes::getIcon('missing-mimetype')); // file
```

To register your own icons for a given icon pack, you can call the `AllowedMimeTypes::registerIcons` method in the `boot` method of your`App\Providers\AppServiceProvider` class. This will merge any existing with your new icons. If you want to fully override the icons for a given icon pack, then you can set the `merge` option to false. 

```php
use Javaabu\Helpers\AllowedMimeTypes;

// add to icons
AllowedMimeTypes::registerIcons('fontawesome', [
    'text/javascript' => 'file-code'
]);

// fully override icons
AllowedMimeTypes::registerIcons('material', [
    'default' => 'file',
    'text/javascript' => 'code'
]);

// register your own icon pack
AllowedMimeTypes::registerIcons('feather', [
    'default' => 'file',
    'text/javascript' => 'code'
]);
```

### getAllowedMimeTypesString(string|array $type = '', string $separator = ','): string

Given a file type, or an array of types, returns a string of allowed mime types separated by the given delimiter. If no type is given, returns all mimetypes separated by given delimiter.

```php
$mimetypes = AllowedMimeTypes::getAllowedMimeTypesString('image');
/* $mimetypes 
"image/jpeg,image/png,image/gif,image/tiff,image/x-citrix-png,image/x-png,image/svg+xml,image/svg"
*/
```

### isAllowedMimeType(string $mime_type, array|string $type = ''): bool

Checks whether a given mimetype is allowed for the given file type(s). If no type is given, checks if the given mimetype is allowed.

```php
AllowedMimeTypes::isAllowedMimeType('audio/mp3', 'image'); // returns false
```

### getMaxFileSize(string|array $types = ''): int

Returns the max allowed file size in KB for the given file type. If an array of file types is given or no type is given, it will return the maximum size allowed from all the file types. By default, for each given file type, the method will look if a `'max_<type>_file_size''` setting is available. Otherwise, it will fallback to the `'max_upload_file_size'` setting.

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

### getValidationRule(string|array $type = '', bool $as_array = false, ?int $max_size = null): array|string

Generates the validation rule for the given file type. If no type is given, will allow all allowed mime types. Optionally pass a custom file size.

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

### getAttachmentValidationRule(string|array $type = null): array

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
    'image/x-ico' => 'ico'
]);
```

### getExtensions(array $mime_types): array

Given an array of mimetypes, returns an array of corresponding unique file extensions.

```php
AllowedMimeTypes::getExtensions(['image/jpeg', 'image/x-icon', 'image/x-ico']);
// returns ['jpeg', 'ico']
```




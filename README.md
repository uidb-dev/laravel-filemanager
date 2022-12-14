# Laravel 5 FileManager - Upgrade to Laravel 9


========


## Installation

### Laravel >= 5.5:
Require this package with composer:

```php
composer require uidb-dev/laravel-filemanager
```
That's it :)


### Configuration:
Register package's routes in the routes service provider file:
```php
FileManager::routes();
```

Publish the config file using:
```php
php artisan vendor:publish --tag="file-manager-config"
```

Include the tightenco/ziggy js routes putting the routes generator on your layout file (in the ```<head>``` tag):
```php
@routes
```

For including the package assets add the next lines to your layout template:
```php
// Inside the <head> tag
<meta name="csrf-token" content="{{ csrf_token() }}">
// And
@include('FileManager::partials.styles')

// Before closing the <body> tag
<script>
    $(function () {
        FileManagerModal.init();
    });
</script>
@include('FileManager::partials.scripts')
@include('FileManager::partials.file-manager-modal')
```

Add the crop validation translation to your validation.php translation file:
```php
'is_croppable' => 'The :attribute is not croppable according to all sizes.',
```

Prepare a minimalist layout for popup state, then add it to the file-manager.php config file.


* Make sure you choose a disk on the package configuration file - Files will be stored on that disk.


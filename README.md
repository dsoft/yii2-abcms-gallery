# Yii2 abcms gallery
Simple image gallery admin module for yii2.

## Installation:
```bash
composer require abcms/yii2-gallery:dev-master
```
Run the database migration:
```bash
./yii migrate --migrationPath=@vendor/abcms/yii2-gallery/migrations
```

## Configuration:

Add module to the admin modules configuration array:
```php
'modules' => [
    'gallery' => [
        'class' => 'abcms\gallery\module\Module',
    ],
],
```

Add categories and image sizes to params.php under gallery key:
```php
'gallery' => [
    'categories' => [
        1 => [
            'name' => 'News',
            'sizes' => [
                'small' => [
                    'width' => 440,
                    'height' => 440,
                ],
            ],
        ],
    ],
],
```

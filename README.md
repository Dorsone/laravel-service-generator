# Laravel Artisan Command For Creating and Linking Service
### Installation

Add following code to your ```composer.json```
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/dorsone/laravel-service"
    }
]
```

Second Step
```
composer require dorsone/laravel-service
composer dump-autoload
```

Finally
Add following code to your config/app.php file ProvidersSection
```php
\Dorsone\LaravelService\Providers\ServiceGeneratorProvider::class
```

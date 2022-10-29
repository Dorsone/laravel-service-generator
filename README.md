# Laravel Artisan Command For Creating and Linking Service
### Installation
```
composer require dorsone/laravel-service
composer dump-autoload
```

Add following code to your config/app.php file ProvidersSection
```php
\Dorsone\LaravelService\Providers\ServiceGeneratorProvider::class
```

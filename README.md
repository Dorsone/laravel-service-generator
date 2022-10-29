# Laravel Artisan Command For Creating and Linking Service
This library adds to your project functionality that can be generate a services

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
Add following code to your ```config/app.php``` file ProvidersSection
```php
\Dorsone\LaravelService\Providers\ServiceGeneratorProvider::class
```

Create your first service!

```
php artisan make:service TestService --controller=TestController
```

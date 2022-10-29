# Laravel artisan command for creating and linking services
With this library, you can generate Services and automatically connect them to Controllers

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

Next step
```console
composer require dorsone/laravel-service
```

Finally
Add following code to your ```config/app.php``` file ProvidersSection
```php
\Dorsone\LaravelService\Providers\ServiceGeneratorProvider::class
```

Create your first service!

```console
php artisan make:service TestService --controller=TestController
```

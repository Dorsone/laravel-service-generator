# Laravel artisan command for creating and linking services
With this library, you can generate Services and automatically connect them to Controllers

### Installation

```console
composer require dorsone/laravel-service
```

Finally
Add following code to your ```config/app.php``` file to providers section
```php
\Dorsone\LaravelService\Providers\ServiceGeneratorProvider::class
```

Create your first service!

```console
php artisan make:service TestService --controller=TestController
```

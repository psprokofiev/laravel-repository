# Laravel Repository

```php
/**
 * Class LaravelRepository
 * @package Psprokofiev\LaravelRepository
 * 
 * @method \Illuminate\Database\Eloquent\Model getSingle(int $id)
 * @method \Illuminate\Database\Eloquent\Builder getQuery() 
 * @method string getTable()
 * @method string getConnection()
 */
```

### Create new repository
```cmd
php artisan make:repository User
```
will create `\App\Repositories\UserRepository` for `\App\Models\User`

### Single model
```php
\App\Models\User::repository()->getSingle(1);
```
```
App\Models\User {#4107
     id: "1",
     name: "Mr. Denis Rolfson III",
     email: "maximus.dubuque@example.net",
     email_verified_at: "2021-04-09 20:29:24",
     created_at: "2021-04-09 20:29:24",
     updated_at: "2021-04-09 20:29:24",
   }
```

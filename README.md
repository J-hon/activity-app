# Studio14 task
This application is displays trending movies, allows users to sign up & create a custom movie list.

### Prerequisites
1. PHP version v8.1
2. MySQL v8.0 (MariaDB will not work. Has to be MySql)
3. Composer v2

# Setting it up
These are the steps to get the app up and running. Once you're using the app.

1. Clone the repository
2. Run `composer install`
3. Run  `cp .env.example .env`
4. Run `php artisan key:generate`
5. Create a MySQL database. Add the database name and password as well as the username to your `.env`
6. Run migrations: `php artisan migrate --seed`
7. Run `npm install`
8. Run `php artisan serve` and open [Home](http:://localhost:8000) in your browser

```sh
Login as super admin

Endpoint : /api/v1/auth/sigin
HTTP Verb: `POST`
{
    "email": "johndoe@example.net",
    "password": "password"
}
```

# Testing
Run `php artisan test` or `vendor/bin/phpunit`


Click [here](https://documenter.getpostman.com/view/10806538/2s84LSsph8) to view the Postman documentation

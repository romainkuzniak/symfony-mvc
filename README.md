# MVC Design with Symfony
This is an example of a Symfony application using MVC design.
The aim is to illustrate the following presentation :

## Install
In order to use the application, follow these simple steps.

``` bash
composer install
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load
php app/console server:run
```

Go to [http://localhost:8000/sprints/3](http://localhost:8000/sprints/3)


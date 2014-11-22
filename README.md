# Symfony

## Install
```
composer install
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load
php/app/console server:run
```

Go to http://localhost:8000/sprints/1


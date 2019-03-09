## Hexlet test workshop - CRUD

[![Travis-CI Build Status](https://travis-ci.org/2heoh/hexlet-workshop-test-crud.svg?branch=master)](https://travis-ci.org/2heoh/hexlet-workshop-test-crud)

- install mysql
- setup connection to mysql in .env
```
DB_CONNECTION=mysql
DB_HOST=<db host>
DB_PORT=3306
DB_DATABASE=<db name>
DB_USERNAME=<db user>
DB_PASSWORD=<db password>
```

- run migration
```
php artisan migrate
```
- run service
```
php artisan serve
```
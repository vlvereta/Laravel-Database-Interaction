# Laravel-Database-Interaction
Migrations, seeds, Eloquent ORM.

#### Установка

Установка показана в рабочем окружении OS Linux:

```
git clone https://github.com/vlvereta/Laravel-Database-Interaction.git
cd project-dir
composer install
cp .env.example .env
php artisan key:generate
```

#### Задание 1
Создать миграции которые создадут таблицы currency, money, wallet, user.
Создать классы сиды(seeds) для таблиц currency, user, wallet, money используя factories и пакет Faker. 

Схема:

| currency ||
| ---------- | ------------- |
| id | int | 
| name | string(unique) |


| money ||
| ---------- | ------------- |
| id | int | 
| currency_id | int |
| amount | float |
| wallet_id | int |
| deleted | eloquent soft delete flag |


| wallet | |
| ---------- | ------------- |
| id | int |
| user_id | int |
| deleted | eloquent soft delete flag |


| user | |
| ---------- | ------------- |
| id | int |
| name | varchar (100) |
| email | varchar (100) |


Реализовать классы - Eloquent модели в папке app/Entity, которые будут описывать соответствующие таблицы и связи между ними(hasOne, hasMany, etc).

#### Задание 0

Реализовать интерфейс CurrencyServiceInterface.

**create** - создает currency модель.

#### Задание 1

Реализовать интерфейс UserServiceInterface.

**findAll** - возвращает коллекцию всех пользователей

**findById** - возвращает пользователя по ID, если пользователя с таким идентификатором не существует - возвращает NULL

**save** - создает/обновляет запись пользователя

**delete** - удаляет запись пользователя по ID из таблицы, при удалении должен также
удаляться кошелек(wallet), привязанный к этому пользователю

#### Задание 2

Реализовать интерфейс WalletServiceInterface. 

**findByUser** - возвращает запись кошелька конкретного польователя 

**create** - создает кошелек для пользователя. Не может существовать больше 1 записи с тем же user_id.

**findCurrencies** - возвращает коллекцию currency с которыми связан кошелек. 

#### Задание 3

Реализовать интерфейс MoneyServiceInterface.

**create** - создает money модель.

**maxAmount** - возвращает float значение, наибольшее кол-во валюты в хранилище.

#### Запуск тестов

```
./vendor/bin/phpunit
```

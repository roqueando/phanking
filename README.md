# Phanking

A little test that will be used to PHP job tests. Consist in simulate a banking system that just have a few features like create user, deposit, withdraw and transfer to other users.

### Installing packages

``` sh
composer install
```

### Running tests

```sh
./vendor/bin/phpunit
```


## How it works

PHP does not have a nice REPL like Elixir, Python or Ruby so to use that without problems I had to use a development package called "composer repl". So to run it just type `composer repl` and use the main functions


## Main features

- Create User -> will create an user in the Bank state
```php
use Phanking\UseCase\User{Add};

$user = (new Add(name: "User Test", initialCurrency: "brl"))->call()
```

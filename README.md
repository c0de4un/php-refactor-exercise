# Gilded Rose

## Minimum System Requirements
* 2-Core CPU with at least 1Ghz
* 2 GB RAM
* 16 GB HDD

## Software Requirements
* PHP 8+
* GIT

## Dependencies
* PHPUnit
* PHPStan
* Easy-Coding-Standard
* Approval-Tests

## Installation
Use shell script, or manually walk through steps
* Install PHP packages via composer:
```sh
php composer.phar install
php composer dump-autoload
```

## Tests
```sh
php composer.phar tests
```

## Contribute
1. Add unit-tests for any model logic changes
2. Before pushing changed, fix code-style with:
```sh
php composer.phar fix-cs
```

# Class Notes: PHP Unit

## TODO
* Update syntax for data providers in the examples (see Class Notes)

## Class Notes
Data Providers:
* The provider method needs to be declared `static`
* Need to add a `use` statement when using PHP 8 attribute notation
```
use PHPUnit\Framework\Attributes\DataProvider;
```

### Test Doubles
* Dependency Injection
  * See PSR-11: https://www.php-fig.org/psr/psr-11/
  * Also Martin Fowler's website

### Code Kata IV
The API simulation and data is located here:
```
/home/vagrant/Zend/api
```

## Errata
* http://localhost:8888/#/8/25
  * 'Here was have a User object' ???
* http://localhost:8888/#/10/6
  * `cd /path/to/completed/api` s/be /home/vagrant`
* Correct paths in the last lab
  * API simulator is located in `/home/vagrant/Zend/api` *not* under "/completed/api"
  * Also make sure `setup()` and `teardown()` declare return type `void`
* When using Prophecy you need to add the composer package as follows:
```
composer require phpspec/prophecy
```



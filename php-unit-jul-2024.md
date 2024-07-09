# Class Notes: PHP Unit - July 2024

## TODO
* Get list of tools/platforms that can determine test coverage
* Chris Hartjes website
 * http://www.thegrumpyprogrammer.com/
 * https://grumpy-learning.com/
* Find attribute use to ignore a test that's not complete

## Homework
* Set up your source code for running the labs
* Lab: Code Kata I (FizzBuzz)

## Lab Setup
If using the VM
* Follow the instructions provided in class
If not using th VM:
* Download source file (provided by your instructor)
* Create and unzip into a `Zend` folder
* From a command prompt change to the `Zend` folder
* Run `composer update` (or `composer.phar update`)

## Class Notes
Data Providers:
* The provider method needs to be declared `static`
* Need to add a `use` statement when using PHP 8 attribute notation
```
use PHPUnit\Framework\Attributes\DataProvider;
```
When using Prophecy you need to add the composer package as follows:
* In PHP unit versions prior to 9 it was automatically included
* Now you must add the package yourself
```
composer require phpspec/prophecy
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
* http://localhost:8888/#/4/11
  * Missing ">"
  * Add 3rd arg



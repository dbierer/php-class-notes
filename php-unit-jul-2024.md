# Class Notes: PHP Unit - July 2024

## TODO
* Add classes `WidgetStorage` and `WidgetStorageTest` to `sandbox` and `completed` folders

* Q: Do the mock supporting classes allow you to limit how many times a mock method is called?
* A: Yes: see: https://docs.phpunit.de/en/11.2/test-doubles.html#configuring-mock-objects
* A: For Prophecy you can use `shouldBeCalledTimes()` to specify a number of times it can be called

* Q: What about code coverage?
* A: See: https://docs.phpunit.de/en/11.2/code-coverage.html

* Q: Are there any BDD test frameworks for PHP?
* A: See: https://docs.behat.org/en/latest/
* A: See: https://codeception.com/
* A: See: https://kahlan.github.io/docs/

* Q: How do you ignore ignore a test that's not complete?
* A: Use the `markTestIncomplete()` method
  * See: https://docs.phpunit.de/en/11.2/writing-tests-for-phpunit.html#incomplete-tests
* A: You can also mark a test to be skipped using `markTestSkipped()`
  * See: https://docs.phpunit.de/en/11.2/writing-tests-for-phpunit.html#skipping-tests
* A: There are Attributes you can use to conditionally skip tests
  * See: https://docs.phpunit.de/en/11.2/writing-tests-for-phpunit.html#skipping-tests-using-attributes
* A: You can identify test dependencies using the `#[Depends('xxx')]` attribute
  * See: https://docs.phpunit.de/en/11.2/writing-tests-for-phpunit.html#test-dependencies

* Q: How do you mock a static method?
* A: (from Dmitry) https://www.thecoderscamp.com/phpunit-mock-static-method/
* A: Have a look at this as well: https://docs.phpunit.de/en/11.2/fixtures.html#global-state
* A: Note regarding built-in mock builder (https://docs.phpunit.de/en/11.2/test-doubles.html#test-doubles):
```
Please note that final, private, and static methods cannot be doubled.
They are ignored by PHPUnit’s test double functionality and retain their
original behavior except for static methods which will be replaced by a
method throwing an exception.
```
* A: Suggested approaches:
  * Use the anonymous class approach to simulate the static call
  * Use this library: https://github.com/Codeception/AspectMock

* Q: What is the link to Chris Hartjes (author of this course) website?
* A: http://www.thegrumpyprogrammer.com/
* A: https://grumpy-learning.com/

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
What about 0?
* (from Eduard) https://www.youtube.com/watch?v=1MKFLCu_9bc

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
* Mock static method
  * (from Dmitry) https://www.thecoderscamp.com/phpunit-mock-static-method/

### Code Kata IV
The API simulation and data is located here:
```
/home/vagrant/Zend/api
```

## Errata
* http://localhost:8888/#/4/11
  * Missing ">"
  * Add 3rd arg



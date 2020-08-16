# PHP Test Prep -- Aug 2020

## Working Schedule
* Tue 04 Aug: up to Mod 3 XML
* Thu 06 Aug: 3 - 4 + deliver 1st Mock
* Tue 11 Aug: Review Mock 1 + Mod 5 - 7 (partial)
* Thu 13 Aug: Finish Mods 7 and 8 + Deliver Mock 2
* Tue 18 Aug: Review Mock 2 + 9 - 10 + deliver Mock Final
* Thu 20 Aug: 11 - 12 + Review Mock Final

## TODO

## Q & A
* Q: Can an Interface contain properties?
* A: No.  If you try to add a property, this message will result:
```
PHP Fatal error:  Interfaces may not include member variables in ...
```
* Q: Find reference to article about REST vs. SOAP done by Oracle
* A: https://www.ateam-oracle.com/performance-study-rest-vs-soap-for-mobile-applications

## Class Notes

### Test Logistics
* Warning: check the COVID-19 protocols at your preferred test center before scheduling a test
* General topic info: https://www.zend.com/training/php-certification-exam
* FAQ: https://www.zend.com/training/certification-faq

### Bitwise Operations
* Tutorial on PHP Bitwise Operators for the Exam:
  * https://www.w3resource.com/php/operators/bitwise-operators.php
* Bitwise "Truth Table":
```
Bitwise AND
0 & 0 = 0
0 & 1 = 0
1 & 0 = 0
1 & 1 = 1

Bitwise OR
0 | 0 = 0
0 | 1 = 1
1 | 0 = 1
1 | 1 = 1

Bitwise XOR
0 ^ 0 = 0
0 ^ 1 = 1
1 ^ 0 = 1
1 ^ 1 = 0
```
* `php.ini` config settings: https://www.php.net/manual/en/configuration.changes.modes.php
* From the 1st in-class quiz:
```
echo ~(($a | $b) ^ $c) ? 'T' : 'F';
// from Catalin-Marius to All Participants:
(0010 | 0101) = 0111 ^ 0111 = ~0000 = 1111 => 'T'
```
### XPath / XML
* Basic Usage Guide: https://www.php.net/manual/en/simplexml.examples-basic.php
* Tutorial: https://www.w3schools.com/xml/xpath_intro.asp
* Tutorial: https://www.w3schools.com/xml/default.asp
### SOAP
* https://www.php.net/manual/en/soapclient.soapclient.php
* https://www.php.net/manual/en/soapserver.soapserver.php
### DateTime
* NOTE: `DateInterval` also accepts "relative" formats: https://www.php.net/manual/en/datetime.formats.relative.php

### Strings
* Be "glancingly familiar" with the string functions, especially those starting with `str*`
  * Letter `i` indicates case-insensitive
  * Letter `r` indicates in reverse
  * Letter `u` indicates user-defined callback
* `printf` family
  * Format codes documents under [`sprintf`](https://www.php.net/sprintf)
  * Make sure you understand the basic format codes

### Regex
Various `preg*` examples: https://github.com/dbierer/classic_php_examples/tree/master/regex

### Arrays
Summary of array add and remove functions:

| &nbsp;                          | `array_push()` | `array_pop()` | `array_shift()` | `array_unshift()` |
| :------------------------------ | :------------: | :-----------: | :-------------: | :---------------: |
| Adds to the array               | X              | &nbsp;        | &nbsp;          | X                 |
| Removes from the array          | &nbsp;         | X             | X               | &nbsp;            |
| Beginning of the array          | &nbsp;         | &nbsp;        | X               | X                 |
| End of the array                | X              | X             | &nbsp;          | &nbsp;            |
| Returns the new array count     | X              | &nbsp;        | &nbsp;          | X                 |
| Returns the removed element     | &nbsp;         | X             | X               | &nbsp;            |



### Anonymous Functions
Reference to `Closure` class: https://www.php.net/closure

### OOP
* Example on PDF page 297 (slide 8/16) generates warning, which was fixed in PHP 7.4:
```
Warning: Declaration of Container\ControllerServiceContainer::set(string $name, $value) should be compatible with Container\ServiceContainer::set($name, $value)
```
* Example on PDF page 308 (slide 8/27): `use` syntax should be as follows.  Curly braces are not appropriate in this situation.
```
use FactoryInterface, IndexControllerFactory;
```
* Example on PDF page 308 (slide 8/27): the abstract method `set()` is not defined which means a fatal error will be generated

#### Generators and Delegating Generators
* https://www.php.net/manual/en/language.generators.overview.php


#### Magic Methods
You will be responsible for *all* magic methods except for:
* `__serialize()` : only available as of PHP 7.4
* `__unserialize()` : only available as of PHP 7.4
* See: https://www.php.net/manual/en/language.oop5.magic.php

#### SPL
Make sure you are "glancingly familiar" with the SPL
* See: http://php.net/manual/en/book.spl.php
* Pay special attention to `ArrayObject` and `ArrayIterator`
* Don't have to know all the iterators, but have a general idea what they do

#### Late Static Binding
Read the explanation: https://www.php.net/manual/en/language.oop5.late-static-bindings.php

#### Traits
* Traits are affected by `namespace`
* Make sure you're familiar with `use` / `as` / `insteadof` with reference to traits
* Study traits keywords "as" and "insteadof"
* https://www.php.net/traits

## Security
* http://localhost:9999/#/10/26 (PDF 433): needs 2 arguments:
```
random_int(int $min, int $max);
```
* Make sure you know the flags and defaults for `htmlspecialchars()`
  * https://www.php.net/htmlspecialchars

## Database
Notes from `PDO::bindValue()`:
  * What the `bindValue()` docs fail to explain without reading them _very_ carefully is that bindParam() is passed to PDO byref - whereas `bindValue()` isn't. Thus with `bindValue()` you can do something like $stmt->bindValue(":something", "bind this"); whereas with bindParam() it will fail because you can't pass a string by reference, for example.
* http://localhost:8888/#/9/26: PDOException is never thrown because the error mode is not set!

## Exceptions
* http://localhost:8888/#/12/8: aggregate Exceptions are separated by "|"

## ERRATA
* 2/57  correct answer s/be B and C.  PSR-4 is only applicable if the question addresses directory structure and namespace
* 4/42: correct answer: `255 255.000000`
* 5/17: array_search(): Returns element *key* value, or boolean false. A third boolean parameter includes type checking.

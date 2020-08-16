# PHP Test Prep -- Aug 2020

## Working Schedule
* Tue 04 Aug: up to Mod 3 XML
* Thu 06 Aug: 3 - 4 + deliver 1st Mock
* Tue 11 Aug: Review Mock 1 + Mod 5 - 7 (partial)
* Thu 13 Aug: Finish Mods 7 and 8 + Deliver Mock 2
* Tue 18 Aug: Review Mock 2 + 9 - 10 + deliver Mock Final
* Thu 20 Aug: 11 - 12 + Review Mock Final

## TODO
* Table summarizing push/pop/shift/unshift
* Add link to Closure for study
* Add some var_dumps to the example 7-29-278
* Add a link to Generators and Delegating Generators
* Add link to Late Static Binding
* Study traits keywords "as" and "insteadof"

## Q & A
* Q: Can an Interface contain properties?
* A: ???
* Q: Find reference to article about REST vs. SOAP done by Oracle
* A: https://www.ateam-oracle.com/performance-study-rest-vs-soap-for-mobile-applications

## Notes
* Warning: COVID-19 Protocols
* General topic info: https://www.zend.com/training/php-certification-exam
* FAQ: https://www.zend.com/training/certification-faq
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

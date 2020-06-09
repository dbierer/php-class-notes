# PHP Test Prep -- June 2020

## Note to Self
* Check on when to deliver mock exams

## Schedule
* Tue 02 Jun: 1  - 2
* Thu 04 Jun: 3
* Tue 09 Jun: 4 - 5
* Thu 11 Jun: 7  - 8 (finish up to and including "Magic Methods")
* Tue 16 Jun: 8  - 10 (finish up to and including "Escaping")
* Thu 17 Jun: 10 - 12

## Notes
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

# PHP Test Prep -- June 2020

## Schedule
* Tue 02 Jun: 1  - 2
* Thu 04 Jun: 3  - 4
* Tue 09 Jun: 5  - 6
* Thu 11 Jun: 7  - 8
* Tue 16 Jun: 8  - 10
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

# PHP Certification - Aug 2021

## Homework
* For Fri 03 Sep 2021
  * Quiz questions for course module 9 "Database"
  * Quiz questions for course module 10 "Security"
  * Quiz questions for course module 11 "Web Features"
  * Quiz questions for course module 12 "Error Handling"
  * Final Mock Exam
* For Wed 01 Sep 2021
  * Quiz questions for course module 7 "Functions"
  * Quiz questions for course module 8 "OOP"
  * Mock Exam #2
* For Mon 30 Aug 2021
  * Quiz questions for course module 4 "Strings and Patterns"
  * Quiz questions for course module 5 "Arrays"
  * Quiz questions for course module 6 "I/O"
  * Mock Exam #1
* For Fri 27 Aug 2021
  * Quiz questions for course module 2 "PHP Basics"
  * Quiz questions for course module 3 "Data Formats ..."

## Docker Container Setup
* Download the ZIP file from the URL given by the instructor
* Unzip into a new folder `/path/to/zip`
* Follow the setup instructions in `/path/to/zip/README.md`

## TODO
* Q: What is the class name used if `unserialize()` can't find the class def?

* Q: Find out where in the docs you would learn about `zend.multibyte` php.ini directive?
* A: It's listed under the _Language Options_ section of the core php.ini settings documentation
* A: See: https://www.php.net/manual/en/ini.core.php#ini.sect.language-options

## Class Notes
Overview of topics: https://www.zend.com/training/php-certification-exam
Good overview of typical PHP program operation:
* https://www.zend.com/blog/exploring-new-php-jit-compiler

### Bitwise Operators
Tutorial oriented towards the exam:
* https://www.w3resource.com/php/operators/bitwise-operators.php
Truth table:
```
<?php
echo "Logical AND\n";
printf("%04b\n", 0b00 & 0b00);
printf("%04b\n", 0b00 & 0b01);
printf("%04b\n", 0b01 & 0b00);
printf("%04b\n", 0b01 & 0b01);

echo "Logical OR\n";
printf("%04b\n", 0b00 | 0b00);
printf("%04b\n", 0b00 | 0b01);
printf("%04b\n", 0b01 | 0b00);
printf("%04b\n", 0b01 | 0b01);

echo "Logical XOR\n";
printf("%04b\n", 0b00 ^ 0b00);
printf("%04b\n", 0b00 ^ 0b01);
printf("%04b\n", 0b01 ^ 0b00);
printf("%04b\n", 0b01 ^ 0b01);
```
Left/right shift illustration:
```
<?php
echo 16 << 3;
echo "\n";
echo 0b10000000;
echo "\n";

echo 16 >> 3;
echo "\n";
echo 0b00000010;
echo "\n";

echo 15 >> 3;
echo "\n";
echo 0b00000001;
echo "\n";
```
* Study up on `gc_collect_cycles()`

## Data Formats
Read up on `SimpleXMLElement`
* https://www.php.net/manual/en/simplexml.examples-basic.php
* XPath Tutorial: https://www.w3schools.com/xml/xpath_intro.asp
* `DateTime` examples
```
<?php
$date[] = new DateTime('third thursday of next month');
$date[] = new DateTime('now', new DateTimeZone('CET'));
$date[] = new DateTime('@' . time());
$date[] = (new DateTime())->add(new DateInterval('P3D'));

var_dump($date);
```
  * Study on `DateTimeInterval` and `DateTimeZone` and also "relative" time formats
  * In addition, be aware of the basic time format codes

## Strings
* Study the docs on `sprintf()` to get format codes for that family of functions
* Tutorial on PHP regex: https://www.w3schools.com/php/php_regex.asp
* Using regex to swap sub-patterns
```
<?php
$text = 'Doug Bierer';
$patt = '/(.*)\s(.*)/';
echo preg_replace($patt, '$2, $1', $text);
```

## Functions
* Read up on `Closure::bindTo()`
  * https://www.php.net/manual/en/closure.bindto.php

## OOP
* Read up on magic methods!
  * https://www.php.net/manual/en/language.oop5.magic.php
  * Don't worry about any methods added after PHP 7.1
  * `__destruct()` called when object goes out-of-scope
    * End of program
    * `unset()`
    * Called in a function and function call ends
    * Overwritten
* SPL
  * Make sure you study:
    * `*Iterator*` : just know what they are
    * `ArrayIterator` and `ArrayObject` make sure you're up to speed on these!
  * Just be aware of the "classic" data structure classes
* Generators
  * https://www.php.net/manual/en/class.generator.php
* Late Static Binding
  * https://www.php.net/manual/en/language.oop5.late-static-bindings.php
* Traits
  * https://www.php.net/manual/en/language.oop5.traits.php

## Security Topic
Questions are drawn from here:
* https://www.php.net/manual/en/security.php
Read up on the `crypt()` function
* https://www.php.net/manual/en/function.crypt.php

## Change Request
* 2-57: answers s/be B & C; D answer makes assumption not born out by the question
* 6-19: s/be:
```

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => implode("\r\n", $headers),
        'content' => $query
    ]
];
```
* 8-16: "Class Member Overrides"
  * Example doesn't work because the child class fails to define the method in compliance with parent method requirements
* 8-97:
  * C ans is also correct, can use `iterator_to_array()` because `ArrayObject` is iterable


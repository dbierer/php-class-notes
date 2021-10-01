# PHP Certification - Sep 2021

## TODO


## Homework
For Fri 01 Oct:
* All remaining quiz questions (course modules 9 - 12)
* Final Mock Exam

For Wed 29 Sep:
* Quiz questions for course module 8 "OOP"
* Second Mock Exam

For Mon 27 Sep:
* Quiz questions for course module 5 "Arrays"
* Quiz questions for course module 6 "I/O"
* Quiz questions for course module 7 "Functions"
* First Mock Exam

For Thu 23 Sep:
* Quiz questions for course module 3 "Data Formats and Types"
* Quiz questions for course module 4 "Strings and Patterns"

For Wed 22 Sep:
* Quiz questions for course module 2 "PHP Basics"

For Fri 24 Sep:
* Quiz questions for course module 3 "Data Formats ..."

## Docker Container Setup
* Download the ZIP file from the URL given by the instructor
* Unzip into a new folder `/path/to/zip`
* Follow the setup instructions in `/path/to/zip/README.md`

## TODO

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

## Garbage Collection
Have a look at this article:
https://www.php.net/manual/en/features.gc.performance-considerations.php

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
* https://www.php.net/manual/en/datetime.formats.relative.php

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
* `preg_replace()` and `preg_match()` example using sub-patterns:
```
<?php
$string = 'April 15, 2003';
$pattern = '/(\w+) (\d+), (\d+)/i';
$replacement = '$2 $1 $3';
echo preg_replace($pattern, $replacement, $string);

preg_match($pattern, $string, $matches);
var_dump($matches);
```
## I/O
Streams
* Don't have to study *all* functions, just certain of the more common ones
* https://www.php.net/streams
  * `stream_context_create()`
  * `stream_wrapper_register()`
  * `stream_filter_register()`
  * `stream_filter_append()`
  * `stream_socket_client()`


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
Make sure you read up on `htmlspecialchars()`
* https://www.php.net/htmlspecialchars
Do a quick read on the `crypt()` function
* `password_hash()` leverages this
* Might be on the test
File upload documentation
* https://www.php.net/manual/en/features.file-upload.php

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


* This needs a space in front of "16"
```

$x = 0x10;   $y = 020;  $z = "16";
$x += 0b100; $y += "4"; $z += 04;
echo $x;
echo $y;
echo $z;
```
* PDF pg. 202 / 5-17
  * `array_search()` returns the *key* (if found), not the value!

* PDF 8-16: child class definition should match that of the parent class!  Otherwise:
```
Warning: Declaration of Container\ControllerServiceContainer::set(string $name, $value) should be compatible with Container\ServiceContainer::set($name, $value) in /srv/code/test.php on line 20
```
* Should be like this:
```
<?php

namespace Container;
use FactoryInterface;
class ServiceContainer {
    protected $services = [];

    public function set($name, $value) {
        $this->services[$name] = $value;
    }
}

class ControllerServiceContainer extends ServiceContainer {
    protected $factories = [];

    public function set($name, $value) {
        ($value instanceof FactoryInterface) ? $this->factories[$name] = $value :
            parent::set($name, $value);
    }
}
```
* 8-22: parent `__construct()` cannot `final` in this example!  Should be:
```

namespace Container;
use FactoryInterface;
abstract class ServiceContainer {
    protected const PATH = '/path';
    protected $services = [];
    public function __construct($name, $service) {
        $this->services[$name] = $service;
    }
}
class ControllerServiceContainer extends ServiceContainer {
    protected $factories = [];
    public function __construct(string $name, $value) {
        ($value instanceof FactoryInterface)? $this->factories[$name] = $value :
            parent::__construct($name, $value);
    }
}

$container = new ControllerServiceContainer('created_date', new \Datetime('now'))
```
* http://localhost:9999/#/10/26
  * `random_int()` needs 2 args
* http://localhost:9999/#/12/8
```
try {
    $pdo = new PDO($params);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception | PDOException $e) {
    error_log('Database error: ' . $e->getMessage()));
} catch (Throwable $t) {
    error_log('General error: ' . $t->getMessage()));
} finally {
    echo 'Database connection ';
    echo ($pdo) ? 'succeeded' : 'failed';
}
```

Mock Exam #2
* Ques 1
  * First answers use `$data` so result is impossible
  * D and E are correct: answer key needs updating
  * Change `$data` to `$str` and change to choose 3
* Ques 5
  * Leading sentence bad
* Ques 12
  * Leading sentence bad

Mock Final Exam:
* Question 3: missing code block
* Question 5: maybe not use the word "listing"
* Question 13: missing \\
* Question 21: need to add "None of the above"
* Question 25: missing end };
* Question 27: missing " in 2nd SQL statement

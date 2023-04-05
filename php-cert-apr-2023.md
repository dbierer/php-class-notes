# PHP Certification -- Apr 2023

## TODO

## Homework
For Thu 6 Apr 2023
* Quiz questions for Topic #2 (Data Formats and Types)
* Quiz questions for Topic #3 (Strings and Patterns)

For Wed 5 Apr 2023
* Quiz questions for Topic #1 (Basics)

## Class Notes
* Topic Areas: https://www.zend.com/training/php-certification-exam
* PHP Source Code: https://github.com/php/php-src
* Magic constants: https://www.php.net/manual/en/language.constants.magic.php


* When would you use an alias along with `use`
```
<?php
namespace X {
    class Test {}
}

namespace Y {
    class Test {}
}

namespace Z {
    // must use alias, otherwise PHP doesn't know which "Test" you're referring to
    use X\Test as XT;
    use Y\Test as YT;
    $test = new XT();
}

```
* Type coercion / type juggling
  * Study this example:
```
<?php
$a = 123;
$b = 456;
$c = '789';
// in the case combined operations, the last one wins
$e = $a + $b . $c;
var_dump($e);   // string(579789)
$e = $a . $b + $c;
var_dump($e);   // int(124245)
// the data type of $b is changed because of the string operators "."
$b = $a . '+' . $b;
var_dump($b);
// the data type of $c is "juggled" temporarily to int to satisfy the operation
$d = $a + $c;
var_dump($c);
```
  * Another example:
```
<?php
$a = 11;
$b = 22;
$c = 'The sum is: ' . $a + $b;
var_dump($c);

// In PHP 7.1:
/*
PHP Warning:  A non-numeric value encountered in /srv/code/test.php on line 4
int(22)
*/

// IMPORTANT: the result in PHP 8 is different!
// string(14) "The sum is: 33"
```
* Assignment Operator
  * IMPORTANT: all object assignments are by reference (unless you use keyword `clone`)
```
<?php
class Test
{
	public $value = 1;
}
$a = new Test();
$b = $a;	// all object assignments are by reference!
$b->value = 2;
var_dump($a, $b);

// output:
/*
/srv/code/test.php:9:
class Test#1 (1) {
  public $value =>
  int(2)
}
/srv/code/test.php:9:
class Test#1 (1) {
  public $value =>
  int(2)
}
*/
```

* Example of left/right shift
```
<?php
$three = 0b00000011; // 3
// 3 << 5
$final = 0b01100000; // 96
// 96 >> 5
$final = 0b00000011; // 4
// same thing but using 7
$three = 0b00000111; // 7
// 3 << 5
$final = 0b11100000; // 224
// 224 >> 6
$final = 0b00000011; // 3
```

## Docker Container Setup
* Download the ZIP file via Zoom
* Unzip into a new folder `/path/to/zip`
* Follow the setup instructions in `/path/to/zip/README.md`

## Q & A
* Q: How do I know if an extension is part of the "core"
* A: See: https://github.com/php/php-src/tree/php-7.1.33/ext
  * These are all core
  * Not all are enabled by default
  * Only the ones enabled will be on the test

What's the difference between `define()` and `const` for constants:
```
<?php
namespace x {
    define('TEST1', 'xyz');
    const TEST2 = 'abc';
}

namespace y {

    function test()
    {
        return TEST1 . TEST2;
    }

    echo test();
    // output: xyzTEST2
}
```
Namespaces:
* Cannot have keywords in the namespace in PHP 7.1
```
namespace Test\List\Whatever;

use ArrayObject;

$obj = new ArrayObject([1,2,3,4,5]);
var_dump($obj);
// PHP Parse error:  syntax error, unexpected 'List' (T_LIST), expecting identifier (T_STRING) in /srv/code/test.php on line 2
```
IMPORTANT: when assigning objects, it's automatically by reference (even without the `&`)
```
<?php
$obj = new stdClass();
$obj->name = 'TEST';
$abc = $obj;
$abc->name = 'Whatever';
echo $obj->name;
echo PHP_EOL;
// Output: "Whatever"
```

What is considered "empty"?
* https://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting
  * Overview of topics: https://www.zend.com/training/php-certification-exam
* Good overview of typical PHP program operation:
  * https://www.zend.com/blog/exploring-new-php-jit-compiler
Constants
```
<?php
namespace abc {
        define('WHATEVER', 'Whatever', TRUE);
        const ANYTHING = 'Anything';
}

namespace xyz {
        echo WHATEVER;
        echo ANYTHING;
}
```

### Bitwise Operators
Tutorial oriented towards the exam:
* https://www.w3resource.com/php/operators/bitwise-operators.php
* Truth table:
```
<?php
echo "Logical AND\n";
printf("%04b\n", 0b00 & 0b00);  // 0
printf("%04b\n", 0b00 & 0b01);  // 0
printf("%04b\n", 0b01 & 0b00);  // 0
printf("%04b\n", 0b01 & 0b01);  // 1

echo "Logical OR\n";
printf("%04b\n", 0b00 | 0b00);  // 0
printf("%04b\n", 0b00 | 0b01);  // 1
printf("%04b\n", 0b01 | 0b00);  // 1
printf("%04b\n", 0b01 | 0b01);  // 1

echo "Logical XOR\n";
printf("%04b\n", 0b00 ^ 0b00);  // 0
printf("%04b\n", 0b00 ^ 0b01);  // 1
printf("%04b\n", 0b01 ^ 0b00);  // 1
printf("%04b\n", 0b01 ^ 0b01);  // 0
```
Examples of the three ops:
```
<?php
$a = 0b11111111;
$b = 0b11011101;

printf("%08b", $a & $b); // 1101 1101
printf("%08b", $a | $b); // 1111 1111
printf("%08b", $a ^ $b); // 0010 0010
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
Nested Ternary Construct
```
$a = 30;
$b = 20;
echo ($a < $b) ? 'Less' : (($a == $b) ? 'Equal' : 'Greater');
// output: "Greater"
```
Null coalesce operator example
```
$token = $_GET['token'] ?? $_POST['token'] ?? $_COOKIE['token'] ?? 'DEFAULT';
 ```
Yet another example
```
<?php
// example of null coalesce operator
// first expression is the 1st CLI arg
// if that's not present, looks to the URL or post
$action = $argv[1] ?? $_GET['action'] ?? $_POST['action'] ?? 'nothing';
```
Switch statement example
```
<?php
$a = '1';

switch ($a) {
	case 1 :
		echo 'A';
	    break;
	case '2' :
		echo 'B';
	    break;
	default :
		echo 'C';
}
// output: "A" because switch does a non-strict comparison
// NOTE: if the "break;" is missing, it would keep running code
```


`php.ini` file settings:
* https://www.php.net/manual/en/ini.list.php
Extensions
* These are in the core:
  * https://github.com/php/php-src/tree/PHP-7.1.30/ext
  * *but* not all are enabled by default
  * You're only tested on the extensions enabled by default


## Garbage Collection
* Study up on `gc_collect_cycles()`
Have a look at this article:
https://www.php.net/manual/en/features.gc.performance-considerations.php

## Data Formats
Read up on `SimpleXMLElement`
* https://www.php.net/manual/en/simplexml.examples-basic.php
* Simple example
```
<?php
$xml = <<<EOT
<topics>
    <topic id="1">XML</topic>
    <topic id="2">Web Services</topic>
    <topic id="3">Whatever</topic>
    <info>
        <name>Doug</name>
        <name>Hudo</name>
    </info>
</topics>
EOT;

$simple = new SimpleXMLElement($xml);
echo $simple->info->name;       // Doug
echo $simple->info->name[1];    // Hudo
echo $simple->topic[2];         // Whatever
echo $simple->topic[2]['id'];   // 3
```

* XPath Tutorial: https://www.w3schools.com/xml/xpath_intro.asp
* `DateTime` examples
```
<?php
// for relative formats see:
// https://www.php.net/manual/en/datetime.formats.relative.php
$date[] = new DateTime('2023-03-16');
$date[] = new DateTime('third thursday of next month');
$date[] = new DateTime('now', new DateTimeZone('CET'));
$date[] = new DateTime('@' . time());
$date[] = (new DateTime())->add(new DateInterval('P3D'));
var_dump($date);
```
* `DateInterval` format codes
  * See: https://www.php.net/manual/en/dateinterval.construct.php
* Don't forget that to run a SOAP request, you can also use:
  * `SoapClient::__soapCall()`
  * `SoapClient::__doRequest()`
* Example of a soap client:
  * https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php
* Study on `DateTimeInterval` and `DateTimeZone` and also "relative" time formats
* In addition, be aware of the basic time format codes
  * https://www.php.net/manual/en/datetime.format.php
* Pay close attention to `strftime()`
  * https://www.php.net/manual/en/function.strftime.php
* PayPal has a SOAP API that is publically accessible
* REST vs. SOAP:
  * See: https://www.ateam-oracle.com/post/performance-study-rest-vs-soap-for-mobile-applications

## Strings
* Be very careful with `strpos()` and `stripos()`
```
<?php
$str = 'The quick brown fox jumped over the fence';
echo '"The" was ';
echo (stripos($str, 'The')) ? 'found' : 'not found';
echo ' in the string ' . $str;
echo PHP_EOL;

// actual output:
// "The" was not found in the string The quick brown fox jumped over the fence
```
* Study `substr()` with negative args
```
<?php
$a = 'test.php';
//   test.               php
$b = substr($a, 0, -3) . substr($a, -3);
echo ($a === $b) ? 'T' : 'F';

// ouput: "T"
```

* Study the docs on `sprintf()` to get format codes for that family of functions
* Example using negative offsets:
```
<?php
$dir = '/home/doug/some/directory/';
if (substr($dir, 0, 1) === '/') echo 'Leading slash' . PHP_EOL;
if (substr($dir, -1) === '/') echo 'Trailing slash' . PHP_EOL;
if ($dir[-1] === '/') echo 'Trailing slash' . PHP_EOL;
```
* Tutorial on PHP regex: https://www.w3schools.com/php/php_regex.asp
* Using regex to find distinct words (using `\b`)
```
<?php
$str[] = 'This is an example of error_reporting';	// NO MATCH
$str[] = 'ERROR: this is problem';					// MATCH
$patt  = '/\bERROR\b/i';
$srch  = 'ERROR';
foreach ($str as $item) {
	echo $item . "\n";
	echo (preg_match($patt, $item)) ? 'MATCH' : 'NO MATCH';
	echo "\n";
}
```

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
* Same thing, but going from European date format to American
```
<?php
$str = date('d M Y');
// subpatt: 1      2      3
$pat = '/^(\d+?) (\w+?) (\d{4})$/';
$rep = '$2 $1, $3';
echo preg_replace($pat, $rep, $str);
echo PHP_EOL;
// example output: "Mar 16, 2023"
```

Greediness Example:
```
<?php
$str = '<p>Para 1</p><p>Para 2</p><p>Para 3</p>';
// $pat = '!<p>.*</p>!';    // returns the entire string
$pat = '!<p>.*?</p>!';  // returns "<p>Para 1</p>"
preg_match($pat, $str, $matches);
var_dump($matches);
echo PHP_EOL;
```
General regex coding examples:
* https://github.com/dbierer/classic_php_examples/tree/master/regex

## Arrays
For iterating through an array beginning-to-end don't forget about these functions:
* `array_walk()`
* `array_walk_recursive()`
* `array_map()`
Also: please don't forget the array *navigation* functions:
* `reset()`: sets pointer to top
* `end()`  : sets pointer to end
* `prev()` : advances array pointer
* `next()` : un-advances array pointer
* `key()`  : returns index value at array pointer
* `current()` : returns value of element at array pointer

## I/O
Streams
* Don't have to study *all* functions, just certain of the more common ones
* https://www.php.net/streams
  * `stream_context_create()`
  * `stream_wrapper_register()`
  * `stream_filter_register()`
  * `stream_filter_append()`
  * `stream_socket_client()`
In addition to the informational file functions mentioned, you also have:
* `fileatime()`
* `filemtime()`
* `filectime()`
etc.

## Functions
* Read up on `Closure::bindTo()`
  * https://www.php.net/manual/en/closure.bindto.php
* Anonymous function example:
```
<?php
$label = 'Result: ';
$add = function ($a, $b) use ($label) {
    return $label . ($a + $b);
};

$sub = function ($a, $b) use ($label) {
    return $label . ($a - $b);
};

echo $add(6, 3) . PHP_EOL . $sub(6, 3);
// Result: 9
// Result: 3

```
* Alternative example of `bindTo()`
```
<?php
class Airplane {
    public $type;
    function __construct(string $type) {
        $this->type = $type;
    }
    function getClosure() {
        return function() {
            return $this->type;
        };
    }
}
class X {
    public $type = 'X';
}

$airplane1 = new Airplane('Airliner');
$closure1 = $airplane1->getClosure();
echo $closure1(). PHP_EOL;
$closure2 = $closure1->bindTo(new X());
echo $closure2();

```


## OOP
* Read up on magic methods!
  * https://www.php.net/manual/en/language.oop5.magic.php
  * Examples: https://github.com/dbierer/classic_php_examples/tree/master/oop/*magic*.php
  * Don't worry about any methods added after PHP 7.1
  * `__destruct()` called when object goes out-of-scope
    * End of program
    * `unset()`
    * Called in a function and function call ends
    * Overwritten
* Interfaces can be used as "free agents" to define functionality
  * This example ties an interface into an inheritance hierarchy
```
<?php
interface SetGet {
    public function set(string $name, callable $service);
    public function get(string $name) : callable;
}
abstract class Container implements SetGet {
    protected $services = [];
}
class ServiceContainer extends Container {
    /*
    public function set(string $name, callable $value) {
        $this->services[$name] = $value;
    }
    */
    public function get(string $name) : callable {
        return $this->services[$name];
    }
}
$service = function () { return (new DateTime('now'))->format('l, d M Y'); };
$container = new ServiceContainer();
$container->set('today', $service);
echo $container->get('today')();
```
* Autoloading Examples:
  * https://github.com/dbierer/classic_php_examples/tree/master/oop
  * Look for `oop_autoload*.php`
* Callable
  * Examples of what is considered "callable"
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/callable_examples.php

* Iteration
  * Lookup these interfaces and understand what they do
     * `Traversable`
      * Both of the interfaces mentioned `extend` this interface
     * `Iterator`
       * Introduced earlier
       * Requires hard-coded iteration methods
     * `IteratorAggregate`
       * Passes the buck
       * Don't have to hard code iteration methods
* Late static binding
  * https://www.php.net/manual/en/language.oop5.late-static-bindings.php
* Serialization example:
```
<?php
class Test
{
        public $a = 0;
        public $b = 0;
    public $c = 'Test';
    public $d = [];
    public $e = '';
        public function __construct(int $a, float $b, string $c, array $d)
        {
                $this->a = $a;
                $this->b = $b;
                $this->c = $c;
                $this->d = $d;
                $this->e = md5(rand(1111,9999));
        }
        public function __sleep()
        {
                return ['a','b','c','d'];
        }
        public function __wakeup()
        {
                $this->e = md5(rand(1111,9999));
        }
}
$test = new Test(222, 3.456, 'TEST', [1,2,3]);
var_dump($test);
$str = serialize($test);
echo $str . PHP_EOL;

$obj = unserialize($str);
var_dump($obj);
```
* Type hints
  * If `declare(strict_types=1)` is not set, the type hint does a "soft" type cast
```
<?php
function test (int $a, int $b)
{
    return $a + $b;
}

echo test(2, 2);
echo PHP_EOL;
echo test('2', '2');
echo PHP_EOL;
echo test(2.666, 2.777);
echo PHP_EOL;
echo test('A', 'B');
echo PHP_EOL;
// actual output:
/*
4
4
4
PHP Fatal error:  Uncaught TypeError: Argument 1 passed to test() must be of the type integer, string given, called in /srv/code/test.php on line 13 and defined in /srv/code/test.php:2
*/

```

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

## Database Topic
Fetch Modes:
* Focus on array and object fetch modes
* Study the difference between `bindValue()` and `bindParam()`
  * See: https://www.php.net/manual/en/pdostatement.bindvalue.php#80285

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
Security related `php.ini` settings
* `open_basedir`
* `doc_root`
* `user_dir`
* `cgi.force_redirect`
Security validation functions
* is_*()
  * Checks the actual data type of the variable
* ctype_*()
  * This family checks the actual *contents* of the variable
* filter*()
Read up especially on `filter_var()`
* https://www.php.net/filter_var

## Web Features
Make sure you're up on the `php.ini` settings pertaining to web features
URL: https://www.php.net/manual/en/ini.list.php

* `variables_order`
* `request_order`
* `memory_limit`
* `post_max_size`
* `upload_max_filesize`
* `file_uploads`
* `max_file_uploads`

Form postings
* HTML input get `enctype` attribute
  * See: https://developer.mozilla.org/en-US/docs/Web/API/HTMLFormElement/enctype

## Error Handling
Example of aggregated Catch block:
```
try {
    $pdo = new PDO($params);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException | Exception $e) {
    error_log('Database error: ' . date('Y-m-d H:i:s'));
} catch (Throwable $e) {
    error_log('Any and all errors or exceptions: ' . date('Y-m-d H:i:s'));
} finally {
    echo 'Database connection ';
    echo ($pdo) ? 'succeeded' : 'failed';
}
```

Example of making object callable:
```
<?php
$sum = new class () {
    public $num = 0;
    public function __invoke($val) {
        $this->num += $val;
    }
};

$a = [1, 2, 3, 4, 5, 6, 7, 8];
array_walk($a, $sum);
echo 'Sum of Digits: ' . $sum->num;
// output: 36
```
See: https://github.com/dbierer/classic_php_examples/blob/master/oop/callable_examples.php

## Error Handling
* Don't forget to study the `error_log()` as well
  * https://www.php.net/manual/en/function.error-log.php
* Also: there are a few others to look for as well
  * https://www.php.net/manual/en/ref.errorfunc.php
* To see value of some of the ERROR* bit constants:
```
<?php
$err = [
    E_NOTICE,
    E_PARSE,
    E_WARNING,
    E_ERROR,
    E_STRICT,
    E_DEPRECATED,
    E_ALL
];
foreach ($err as $x)
    printf("%016b\n", $x);
```

## Resources
* https://github.com/dbierer/classic_php_examples/


## Q & A
* Q: Info on `__set_state()`?
* A: Designed to set state prior to using `var_export()`
* A: See: https://www.php.net/manual/en/language.oop5.magic.php#object.set-state


## Change Request
* http://localhost:8884/#/4/27
  * "nin digit"
* "an underscore"
* http://localhost:8884/#/9/38
  * The wording on the question isn't clear. There *is* no result!!!
  * Please clarify the wording

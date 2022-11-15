# PHP Certification - Nov 2022

Last: http://localhost:8884/#/8/50

## TODO
* Start classes 1 hour early
* Get the link to the Zend Yellow Pages
  * https://www.zend-zce.com/en/services/certification/zend-certified-engineer-directory
* Get the link to the topic areas
  * https://www.zend.com/training/php-certification-exam

## Homework
For Thu 17 Nov 2022
* All remaining quiz questions
* Final Mock Exam

For Tue 15 Nov 2022
* Quiz questions for Topic #6 (OOP)
* Mock Exam #2

For Thu 10 Nov 2022
* Quiz questions for Topic #4 (Arrays)
* Quiz questions for Topic #5 (I/O)
* Quiz questions for Topic #6 (Functions)
* Mock Exam #1

For Tue 8 Nov 2022
* Quiz questions for Topic #2 (Data Formats and Types)
* Quiz questions for Topic #3 (Strings and Patterns)

For Thu 3 Nov 2022
* Quiz questions for Topic #1 (Basics)


## Docker Container Setup
* Download the ZIP file via Zoom
* Unzip into a new folder `/path/to/zip`
* Follow the setup instructions in `/path/to/zip/README.md`

## Class Notes
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
``
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
Overview of topics: https://www.zend.com/training/php-certification-exam
Good overview of typical PHP program operation:
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
Truth table:
```
<?php
echo "Logical AND\n";
printf("%04b\n", 0b00 & 0b00);	// 0
printf("%04b\n", 0b00 & 0b01);	// 0
printf("%04b\n", 0b01 & 0b00);	// 0
printf("%04b\n", 0b01 & 0b01);	// 1

echo "Logical OR\n";
printf("%04b\n", 0b00 | 0b00);	// 0
printf("%04b\n", 0b00 | 0b01);	// 1
printf("%04b\n", 0b01 | 0b00);	// 1
printf("%04b\n", 0b01 | 0b01);	// 1

echo "Logical XOR\n";
printf("%04b\n", 0b00 ^ 0b00);	// 0
printf("%04b\n", 0b00 ^ 0b01);	// 1
printf("%04b\n", 0b01 ^ 0b00);	// 1
printf("%04b\n", 0b01 ^ 0b01);	// 0
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
* XPath Tutorial: https://www.w3schools.com/xml/xpath_intro.asp
* `DateTime` examples
```
<?php
// for relative formats see:
// https://www.php.net/manual/en/datetime.formats.relative.php
$date[] = new DateTime('third thursday of next month');
$date[] = new DateTime('now', new DateTimeZone('CET'));
$date[] = new DateTime('@' . time());
$date[] = (new DateTime())->add(new DateInterval('P3D'));
var_dump($date);
```
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
$str = '5 April 2022';
$pat = '/^(\d+?) (\w+?) (\d{4})$/';
$rep = '$2 $1, $3';
echo preg_replace($pat, $rep, $str);
echo PHP_EOL;
```

Greediness Example:
```
<?php
$str = '<p>Para 1</p><p>Para 2</p><p>Para 3</p>';
// $pat = '!<p>.*</p>!';	// returns the entire string
$pat = '!<p>.*?</p>!';	// returns "<p>Para 1</p>"
preg_match($pat, $str, $matches);
var_dump($matches);
echo PHP_EOL;
```
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
Study the difference between `bindValue()` and `bindParam()`

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
## Resources
* https://xkcd.com/327/

## Change Request
* http://localhost:8884/#/8/41
  * No property level data-typing in PHP 7.1!!!
  * s/be
```
<?php
class UserEntity {
    public $hash = '';
    protected $first = '';
    protected $last  = '';
    public function __construct(string $first, string $last) {
        $this->first = $first;
        $this->last  = $last;
        $this->hash  = bin2hex(random_bytes(8));
    }
    public function __sleep() {
        return ['first','last'];
    }
    public function getFullName() {
        return $this->first . ' ' . $this->last;
    }
}
$userEntity = new UserEntity('Mark', 'Watney');
$str = serialize($userEntity);
echo $str;  // NOTE: "hash" does not appear in serialized string
```
* http://localhost:8884/#/8/37
  * Please provide a simpler and clearer example!
* http://localhost:8884/#/8/26
  * Please rework this example: not 100% clear on how Interfaces are used
* http://localhost:8884/#/8/10
  * Doesn't work as written
  * Try this:
```
<?php
class ServiceContainer {
    protected $services = [];
    public function __construct(string $name, callable $value){
        $this->set($name, $value);
    }
    public function set(string $name, callable $value) {
        $this->services[$name] = $value;
    }
    public function get(string $name) {
        return $this->services[$name]();
    }
}
$callback = function () { return (new DateTime())->format('l, d M Y'); };
$container = new ServiceContainer('date', $callback);
echo $container->get('date');
```


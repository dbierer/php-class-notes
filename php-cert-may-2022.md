# PHP Certification - April 2022

## TODO

## Homework
For Weds 3 May 2022
* Quizzes for Topic #1 (Basics)
For Fri 5 May 2022
* Quizzes for Topic #2 (Data Formats and Types)

## Docker Container Setup
* Download the ZIP file from the URL given by the instructor
* Unzip into a new folder `/path/to/zip`
* Follow the setup instructions in `/path/to/zip/README.md`

## TODO

## Class Notes
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
  * You're only tested on the extenions enabled by default


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

* Study on `DateTimeInterval` and `DateTimeZone` and also "relative" time formats
* In addition, be aware of the basic time format codes
  * https://www.php.net/manual/en/datetime.format.php
* Example of a soap client:
  * https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php
* PayPal has a SOAP API that is publically accessible
* REST vs. SOAP:
  * See: https://www.ateam-oracle.com/post/performance-study-rest-vs-soap-for-mobile-applications

## Strings
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
  * Don't worry about any methods added after PHP 7.1
  * `__destruct()` called when object goes out-of-scope
    * End of program
    * `unset()`
    * Called in a function and function call ends
    * Overwritten
* Serialization example:
```
<?php
class User
{
	public $first = 'Fred';
	public $last  = 'Flintstone';
	public $role  = 'Cavemen';
	public $test  = [1,2,3];
	public $hash  = '';
	public function __construct()
	{
		$this->hash = bin2hex(random_bytes(8));
	}
	public function getName()
	{
		return $this->first . ' ' . $this->last;
	}
	public function __sleep()
	{
		return ['first','last','role','test'];
	}
	public function __wakeup()
	{
		$this->__construct();
	}
}

echo '<pre>';
$user = new User();
echo $user->getName();
echo "\n";

$str = serialize($user);
echo $str . "\n";
var_dump($user);
echo "\n";

$obj = unserialize($str);
echo $obj->getName();
echo "\n";
var_dump($obj);
echo '</pre>';
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

## Change Request



## php_cert Repo for Class Demo
* http://localhost:8888/show.php?f=02-58-84.php
  * Need to add ' ' to output


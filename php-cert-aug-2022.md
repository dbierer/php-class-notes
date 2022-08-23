# PHP Certification - Aug 2022

## Homework
For Mon 22 Aug 2022
* Quiz Questions for Topic 7 (OOP)
* Mock Exam #1
* Mock Exam #2

For Weds 10 Aug 2022
* Quiz questions for Topic 1 (Syntax/Basics)
For Fri 19 Aug 2022
* Quiz questions for Topic 2 (Data Formats and Types)
* Quiz questions for Topic 3 (Strings and Patterns)
* Quiz questions for Topic 4 (Arrays)
* Quiz questions for Topic 5 (I/O)
* Quiz questions for Topic 6 (Functions)
* Mock Exam #1

## TODO

## Docker Container Setup
* Download the ZIP file from the URL given by the instructor
* Unzip into a new folder `/path/to/zip`
* Follow the setup instructions in `/path/to/zip/README.md`

## Class Notes
Basic representation of integers
* https://www.php.net/manual/en/language.types.integer.php
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
PECL
* See https://pecl.php.net
PEAR
* See https://pear.php.net
## Caching
See: https://www.zend.com/blog/exploring-new-php-jit-compiler
* Look for the "Before JIT" section

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
* SimpleXML example
```
<?php
$xml = <<<EOT
<outer>
	<A>
		<B>B11</B>
		<B>B12</B>
		<B>B13</B>
	</A>
	<A>
		<B>B21</B>
		<B>
			<C>C1</C>
			<C>C2</C>
			<C>C3</C>
		</B>
		<B>B23</B>
	</A>
</outer>
EOT;
$obj = new SimpleXMLElement($xml);
var_dump($obj);
```
* JSON example
```
<?php
$json = <<<EOT
{
	"name":"Fred Flintstone",
	"age" : 39,
	"address": {
		"city" : "Bedrock",
		"state" : "Whatever",
	},
	"status": 999
}
EOT;
try {
	$data = json_decode($json);
	var_dump($data);
} catch (Throwable $t) {
	echo $t;
}
if (json_last_error() !== JSON_ERROR_NONE) {
	echo json_last_error();
	echo "\n";
	echo json_last_error_msg();
	echo "\n";
}
```

* Don't forget that to run a SOAP request, you can also use:
  * `SoapClient::__soapCall()`
  * `SoapClient::__doRequest()`
* PayPal has a SOAP API that is publically accessible
* Example of a SOAP client
  * https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php
* Study on `DateTimeInterval` and `DateTimeZone` and also "relative" time formats
* In addition, be aware of the basic time format codes
  * https://www.php.net/manual/en/datetime.format.php
* Pay close attention to `strftime()`
  * https://www.php.net/manual/en/function.strftime.php
* Example of a soap client:
  * https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php
* REST vs. SOAP:
  * See: https://www.ateam-oracle.com/post/performance-study-rest-vs-soap-for-mobile-applications

## Strings
* `stripos()` example of potential problem when used with `if`
```
<?php
$str = 'The quick brown fox jumped over the fence.';
echo (stripos($str, 'the')) ? '"the" was found' : '"the" was NOT found';
echo " in $str\n"; // returns "NOT found"
echo $str[0] . "\n";

echo (stripos($str, 'the') !== FALSE) ? '"the" was found' : '"the" was NOT found';
echo " in $str\n";	// returns "found"
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
* Examples of regular expressions:
  * https://github.com/dbierer/classic_php_examples/tree/master/regex
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
Wrappers
* https://www.php.net/manual/en/wrappers.php

## Functions
* Read up on `Closure::bindTo()`
  * https://www.php.net/manual/en/closure.bindto.php
* Example with variable number of arguments:
```
<?php
function superDump()
{
	var_dump(func_get_args());
}

$a = new ArrayIterator([1,2,3]);
$b = [4,5,6];
$c = 'Test';

superDump($a, $b, $c);

```

## OOP
* Read up on magic methods!
  * https://www.php.net/manual/en/language.oop5.magic.php
  * Don't worry about any methods added after PHP 7.1
  * `__destruct()` called when object goes out-of-scope
    * End of program
    * `unset()`
    * Called in a function and function call ends
    * Overwritten
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
Another example of `serialize()` and `unserialize()`
```
<?php
class Test
{
	public $name = '';
	public $address = ['city' => 'Surin', 'country' => 'TH'];
	public $member = TRUE;
	public $id = 101;
	public $amount = 99.99;
	public $time = NULL;
	public $sensitive = '';
	public function __construct()
	{
		$this->time = new DateTime('now');
		$this->sensitive = md5(rand(100001,999999));
	}
	public function __toString()
	{
		return serialize($this);
	}
	public function __sleep()
	{
		return ['name','address','member','id','amount'];
	}
	public function __wakeup()
	{
		self::__construct();
	}
}
$test = new Test();
$str  = serialize($test);
echo $test . PHP_EOL;
echo $str . PHP_EOL;

$obj = unserialize($str);
echo ($test == $obj) ? 'SAME' : 'NOT SAME';
echo PHP_EOL;
echo $obj . PHP_EOL;

var_dump($test);
var_dump($obj);
```
* Things that are considered `callable`
  * See: https://github.com/dbierer/classic_php_examples/blob/master/oop/callable_examples.php
  * NOTE: `fn => xxx` is not on the test! (PHP 7.4+)

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
* http://localhost:4444/#/2/82
  Answer s/be "max_memory_limit"
* http://localhost:9999/#/4/16
  * Remove `similar_text()`
* http://localhost:9999/#/2/59
  * s/be No space in "C" answer!
* http://localhost:9999/#/8/4
  * Missing "}" in 2nd method
* http://localhost:9999/#/9/19
  * s/be "All records in B that *do not* match records in A"
* http://localhost:9999/#/10/26
  * `random_int()` takes 2 arguments!
* http://localhost:9999/#/10/57
  * Looks like the "C" answer is also correct
* http://localhost:9999/#/12/8
  * The code doesn't show aggregate Catch blocks (see example above)
* http://localhost:9999/#/3/30
  * Remove "--" in front of "$xml"
* http://localhost:9999/#/3/40
  * "A" answer needs to be reworded
* http://localhost:9999/#/4/39
  * Please review this code block and make sure it works
  * Also, the next slide has a slight difference remove `++` from `$pos++`

## Mock Exam 2
Question 3 is wrong.
Number s/be "999.000.000,00"

## Change Request for Code Repo
* http://localhost:8888/show.php?f=02-58-84.php s/be a space!

## php_cert Repo for Class Demo
* http://localhost:8888/show.php?f=02-58-84.php
  * Need to add ' ' to output


# PHP Certification - Dec 2022

Last: http://localhost:8884/#/2/40

## Homework
For Fri 09 Dec
* All remaining quiz questions
* Final mock exam

For Wed 07 Dec
* Quiz questions for "OOP" topic
* Mock Exam #2

For Mon 05 Dec
* Quiz questions for "Arrays" topic
* Quiz questions for "I/O" topic
* Quiz questions for "Functions" topic
* Mock Exam #1 (to be uploaded in class via Zoom)

For Fri 02 Dec
* Quiz questions for "Basics" topic
* Quiz questions for "Data Formats and Types" topic
* Quiz questions for "Strings and Patterns" topic

## TODO
* Q: What is the purpose of the `json_encode/decode()` "$depth" option?
* A: The `$depth` is a limit. If the source data exceeds the nesting limit, you end up with `NULL`
* A: Need to confirm above

* Q: What other protocols does SOAP support? SMTP?
* A: SOAP supports XML but can also use SMTP (Simple Mail Transport Protocol), although the latter is rarely used nowadays
  * See: https://en.wikipedia.org/wiki/SOAP
  * See: https://www.w3.org/TR/soap/

* Q: When were the PSR standards developed?
* A: The first commit for PSR-7, one of the first to be developed, was 10 Jun 2014
* A: PSR-0, the first autoloading standard, was _deprecated_ in  2014-10-21

* Q: Will the PSRs be on the test?
* A: No

* Q: What are the "standard" extensions?
* A: See: https://github.com/php/php-src/tree/PHP-7.1.30/ext

* Q: Link to the Zend Yellow Pages
* A: https://www.zend-zce.com/en/services/certification/zend-certified-engineer-directory
* Q: Link to the topic areas
* A: https://www.zend.com/training/php-certification-exam

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

## Basics
Classnames are not case sensitive, even when using namespaces:
```
<?php
namespace X {
	class Test
	{
		public $name = 'X_TEST';
	}
}

namespace Y {
	class TEST
	{
		public $name = 'Y_TEST';
	}
}

namespace {
	use X\Test;
	use Y\TEST;;
	// solution: use an alias:
	// use Y\TEST as YTest;
	$test = new Test();
	echo $test->name;
}
// output:
// PHP Fatal error:  Cannot use Y\TEST as TEST because the name is already in use in /srv/code/test.php on line 18
```

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
Comparing ASCII values
```
<?php
$a = 'A';
$b = 'b';
var_dump($a < $b);	// TRUE
var_dump($a == $b);	// FALSE
var_dump($a > $b);	// FALSE
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
* Pay strict attention to the "changeable" modes
  * https://www.php.net/manual/en/configuration.changes.modes.php
Extensions
* These are in the core:
  * https://github.com/php/php-src/tree/PHP-7.1.30/ext
  * *but* not all are enabled by default
  * You're only tested on the extensions enabled by default
Switch example
```
<?php
$a = '123';

switch ($a) {
	case 123 :
		echo __LINE__;
	case 456 :
		echo __LINE__;
	case '123' :
		echo __LINE__;
	default :
		echo __LINE__;
}
echo PHP_EOL;

// expected: 6
// actual:   681012
```
`continue` and `break`
* Both accept an integer argument
* Default is `1`
* If you specify a number > 1, it continues or breaks out of that many nesting levels
* See: https://www.php.net/manual/en/control-structures.break.php
* See: https://www.php.net/manual/en/control-structures.continue.php


## Garbage Collection
* Study up on `gc_collect_cycles()`
* Have a look at this article:
  * https://www.php.net/manual/en/features.gc.performance-considerations.php

## Data Formats
Read up on `SimpleXMLElement`
* https://www.php.net/manual/en/simplexml.examples-basic.php
* XPath Tutorial: https://www.w3schools.com/xml/xpath_intro.asp
Simple example:
```
<?php
$str = <<<EOT
<Outer>
	<A>
		<B>
			<C>Value 1</C>
			<C>Value 2</C>
			<C>Value 3</C>
			<C id="123" />
		</B>
		<B>
			<C>Value 4</C>
			<C>Value 5</C>
			<C>Value 6</C>
		</B>
	</A>
	<A>
		<C>Value 2-1</C>
		<C>Value 2-2</C>
		<C>Value 2-3</C>
		<C id="123" />
	</A>
</Outer>
EOT;
$xml = new SimpleXMLElement($str);
echo $xml->A->B->C[3]['id']; // output: "123"
echo PHP_EOL;
echo $xml->A[1]->B->C; // output: "Value 2-1"
echo PHP_EOL;
var_dump($xml->xpath('//A/C')); // returns array of 4 SimpleXMLElement instances for the "C" nodes directly under "A"
echo PHP_EOL;
```
Don't forget that to run a SOAP request, you can also use:
  * `SoapClient::__soapCall()`
  * `SoapClient::__doRequest()`
Example of a soap client:
  * https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php
  * PayPal has a SOAP API that is publically accessible
REST vs. SOAP:
  * See: https://www.ateam-oracle.com/post/performance-study-rest-vs-soap-for-mobile-applications
JSON examples:
```
<?php
$arr = [
	'A' => [
		'B' => [
			'C' => [
				'C1',
				'C2',
				'C3',
				'D' => [
					'E' => [
						'E1',
						'E2',
						'E3',
					],
				],
			],
		],
	],
];

$json = json_encode($arr, JSON_PRETTY_PRINT, 512);
$decoded[] = json_decode($json, FALSE); // stdClass instance
$decoded[] = json_decode($json, TRUE);	// associative array
var_dump($decoded);
echo PHP_EOL;

```

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
Example from slides:
```
<?php

$date = new DateTime();
// DateTime::COOKIE = "1, d-M-y H:i:s T"
echo $date->format(DateTime::COOKIE);
echo PHP_EOL;

// DateTime::RSS = "D, d M Y H:i:s O"
echo $date->format(DateTime::RSS);
echo PHP_EOL;
```
DateTime examples:
* See: https://github.com/dbierer/classic_php_examples/tree/master/date_time

Study on `DateTimeInterval` and `DateTimeZone` and also "relative" time formats
* In addition, be aware of the basic time format codes
  * https://www.php.net/manual/en/datetime.format.php
* Pay close attention to `strftime()`
  * https://www.php.net/manual/en/function.strftime.php

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
Phonetic functions example:
```
<?php
$a = 'akshual';
$b = 'actual';
echo metaphone($a);	// AKXL
echo PHP_EOL;
echo metaphone($b); // AKTL
echo PHP_EOL;

```

* Tutorial on PHP regex: https://www.w3schools.com/php/php_regex.asp
* Regex examples: https://github.com/dbierer/classic_php_examples/tree/master/regex
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
Regex examples:
* See: https://github.com/dbierer/classic_php_examples/tree/master/regex

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
* Inheritance
  * Visibility can go from `protected` in the super class to `public` in the sub-class, but not the other way around
  * Data types can go from specific to general, but not the other way around
```
<?php
class A
{
	protected $test = NULL;
	public function getTest()
	{
		return var_export($this->test, TRUE);
	}
	public function setTest(array $test)
	{
		$this->test = $test;
	}
}

class B extends A
{
	// doesn't work:
	// protected function setTest(ArrayIterator $test)

	// works:
	public function setTest(iterable $test)
	{
		$this->test = $test;
	}
}

$b = new B();
$b->setTest(new ArrayIterator([1,2,3]));
echo $b->getTest();

```
* Abstract classes:
```
<?php
abstract class A
{
	protected $test = NULL;
	public function getTest()
	{
		return var_export($this->test, TRUE);
	}
	public abstract function setTest(array $test);
}

class B extends A
{
	public function setTest(iterable $test)
	{
		$this->test = $test;
	}
}

$b = new B();
$b->setTest(new ArrayIterator([1,2,3]));
echo $b->getTest();
```
* Interface example
```
<?php
interface TestInterface
{
	public function setTest(array $test);
}

abstract class A implements TestInterface
{
	protected $test = NULL;
	public function getTest()
	{
		return var_export($this->test, TRUE);
	}
}

class B extends A
{
	// NOTE: this is mandatory as "setTest()" isn't defined anywhere else
	public function setTest(iterable $test)
	{
		$this->test = $test;
	}
}

$b = new B();
 $b->setTest(new ArrayIterator([1,2,3]));
echo $b->getTest();

```
* Example that shows how classes implementing interfaces that extend from "Traversable" work as arguments
```
<?php
class ShowSomething
{
    public function show(Traversable $iterator)
    {
        $output = '<ul>';
        foreach ($iterator as $item)
            $output .= '<li>' . $item . '</li>';
        $output .= '</ul>' . PHP_EOL;;
        return $output;
    }
}
$show = new ShowSomething();

// this works because "ArrayIterator" implements "Iterator"
$obj  = new ArrayIterator(['A','B','C']);
echo $show->show($obj);

// this works because "ArrayObject" implements "IteratorAggregate"
$obj  = new ArrayObject(['A','B','C']);
echo $show->show($obj);
```
* Magic method `__invoke()` example + examples of `callable` type
```
<?php
// list of "callable" variations
class Test
{
	public function something()
	{
		return 'SOMETHING';
	}
	public static function somethingElse()
	{
		return 'SOMETHING ELSE';
	}
}

function whatever ()
{
	return 'WHATEVER';
}

$what = function () {
	return 'WHAT';
};

$invoke = new class () {
	public function __invoke()
	{
		return 'INVOKE';
	}
};

function test (callable $callback)
{
	echo $callback();
	echo PHP_EOL;
}

$test = new Test();

// all of these are considered "callable"
test('whatever');
test($what);
test([$test, 'something']);
test('Test::somethingElse');
test($invoke);
```
* Two of the magic methods must be defined as `static`
  * `__callStatic()`
  * `__set_state()`
  * All the others are *not* defined as static

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
* `ArrayObject` usage
```
<?php

$arrayobject = new ArrayObject(['one', 'two', 'three']);

$arrayobject[] = 'four';
$arrayobject[0] = '1';
$arrayobject->append('five');
$arrayobject['test'] = 'TEST';

// Iterate
foreach($arrayobject as $item) {
    echo $item . PHP_EOL;
}

// Iterate with injected ArrayIterator
$iterator = $arrayobject->getIterator();
while($iterator->valid()) {
    echo $iterator->key() . '=>' . $iterator->current();
    $iterator->next();
}
```

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
* http://localhost:8884/#/3/21
  * Need to confirm definition of `$depth` parameter
* http://localhost:8884/#/3/24
  * RSS format string is this: `D, d M Y H:i:s O`
* http://localhost:8884/#/2/82
  * "E" ans should have `max_memory_limit`
* http://localhost:8884/#/3/42
  * `$json` should be assigned using heredoc notation or escape the `"`
* http://localhost:8884/#/4/40
  * Suggestion: add another line of code that calls the function to clarify its usage
* http://localhost:8884/#/8/41
  * There is *NO* property level data-typing allowed in PHP 7.1
  * Should appear as follows:
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
echo $str;
echo PHP_EOL;
```

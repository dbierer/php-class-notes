# PHP Certification - Sep 2022

Last Slide: http://localhost:8884/#/8/27

## TODO
* Q: Does `__set_state()` also affect Xdebug and Reflection?

* Q: Get link to ZCE Yellow Pages
* A: https://www.zend-zce.com/en/services/certification/zend-certified-engineer-directory

* Q: Link to topics:
* A: https://www.zend.com/training/php-certification-exam

* Q: Do you have any examples of unicode escape syntax example with emojis?
* A: https://github.com/dbierer/classic_php_examples/blob/master/basics/unicode_escape_characters.php

* Q: Re: `is_soap_fault()` usage: wouldn't it still throw an Exception?
* A: TBD

## Homework
For Mon 10 Oct 2022
* Mock Exam 2
* Quizzes for Topics 8 to 11 (everything that's left)
* Final Mock Exam

For Fri 07 Oct 2022
* Mock Exam 2
* Quizzes for Topic 7 (OOP)

For Mon 03 Oct 2022
* Mock Exam 1
* Quizzes for Topic 5 (I/O)
* Quizzes for Topic 6 (Functions)
For Fri 30 Sep 2022
* Quizzes for Topic 2 (Formats and Types)
* Quizzes for Topic 3 (Strings and Patterns)
* Quizzes for Topic 4 (Arrays)
For Wed 28 Sep 2022
* Quizzes for Topic 1 (Basics)


## Docker Container Setup
* Download the ZIP file from the URL given by the instructor
* Unzip into a new folder `/path/to/zip`
* Follow the setup instructions in `/path/to/zip/README.md`

## Class Notes
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

## Change Request
* http://localhost:9999/#/4/16
  * Remove `similar_text()`
* http://localhost:9999/#/2/59
  * s/be No space in "C" answer!
* http://localhost:9999/#/9/19
  * s/be "All records in B that *do not* match records in A"
* http://localhost:9999/#/10/26
  * `random_int()` takes 2 arguments!
* http://localhost:9999/#/10/57
  * he "C" answer is not correct because there is no option `PASSWORD_BLOWFISH`
* http://localhost:9999/#/12/8
  * The code doesn't show aggregate Catch blocks (see example above)
* http://localhost:8884/#/1/11
  * Refresh link to ZCE Yellow Pages
  * https://www.zend-zce.com/en/services/certification/zend-certified-engineer-directory
* http://localhost:8884/#/1/14
  * s/be https://www.zend.com/training/php-certification-exam
* http://localhost:8884/#/4/26
  * s/be "upper case variant"
* http://localhost:8884/#/5/27
  * need to add `key()`
* http://localhost:8884/#/6/10
  * Should also add `file_exists()` and `file*time()`
* http://localhost:8884/#/8/25
  * Interfaces *cannot* have properties!!!
* http://localhost:8884/#/8/27
  * Code will not work as shown
  * Class `ControllerServiceContainer` needs to implement `set()`!
* http://localhost:8884/#/8/42
  * Revise and produce a better example that shows excluding a property
* http://localhost:8884/#/8/43
  * `__wakeup()` example doesn't really do anything!
* http://localhost:8884/#/8/45
  * Def of `__set_state()` needs to be `static`
* http://localhost:8884/#/8/51
  * Mention that it's allowed to state `return` with no values on `void`
* http://localhost:8884/#/8/79
  * "B" answer doesn't make sense

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

## Resources
* https://xkcd.com/327/

## Mock Exam 2
Question 3 is wrong.
Number s/be "999.000.000,00"

## Change Request for Code Repo
* http://localhost:8888/show.php?f=02-58-84.php s/be a space!

## php_cert Repo for Class Demo
* http://localhost:8888/show.php?f=02-58-84.php
  * Need to add ' ' to output


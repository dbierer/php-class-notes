# PHP III May 2019

## TODO:

## Homework
* For Tue 14 May 2019
  * All: Built-in Web Server Lab + Experiment with PHP CLI
* For Thu 9 May 2019
  Collabedit: http://collabedit.com/qx3mg
* For Tue 7 May 2019
  * Setting up Apache Jmeter
  * Setting up the Jenkins CI


## Class Discussion
* DateTime Intervals:
  * Relative intervals: see: https://www.php.net/manual/en/datetime.formats.relative.php
  * More Examples: https://github.com/dbierer/classic_php_examples/tree/master/date_time
  * https://github.com/dbierer/classic_php_examples/blob/master/date_time/date_time_date_period.php
    * Note to self: check and update if needed!
* PubSub Example: https://github.com/dbierer/php7cookbook/blob/master/source/chapter11/chap_11_pub_sub_simple_example.php
* Find another example of DoublyLinkedList
  * See: https://github.com/dbierer/php7cookbook/blob/master/source/chapter10/chap_10_linked_double.php
  * See: https://github.com/dbierer/php7cookbook/blob/master/source/chapter10/chap_10_linked_list_include.php
* Find example of stacked iterators
  * See: https://github.com/dbierer/php7cookbook/blob/master/source/chapter03/chap_03_developing_functions_stacked_iterators.php
* Variable based stream wrapper
  * See: https://github.com/dbierer/classic_php_examples/blob/master/file/streams_custom_wrapper.php
* Streams Docs: https://www.php.net/manual/en/book.stream.php
  * For devices, see: https://www.php.net/manual/en/function.stream-socket-client.php

## Corrections:
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/2/9: PHP Fatal error:  Uncaught PDOException: SQLSTATE[HY000] [1049] Unknown database 'php3' in /home/vagrant/Zend/workspaces/DefaultWorkspace/php3/src/ModPhpAdvanced/Generators/GenDb/runTransactionModel.php:11
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/2/10: also: when you are processing an unknown number of results, maybe safer
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/2/39: extra ","
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/4/31: recommend removing any APC refs
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/4/35: should mention installing via pecl

## Class Examples
* ArrayObject
```
<?php
class Test extends ArrayObject
{
}

$array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
$obj   = new Test($array);
echo $obj->offsetGet('a');
echo PHP_EOL;
echo $obj['a'];
echo PHP_EOL;
var_dump($obj);
echo PHP_EOL;
echo serialize($obj);
```
* Example of anon function w/ __invoke()
```
<?php
class Test
{
	function __invoke($n1, $n2) {
		return function() use($n1, $n2) {
			echo $n1 + $n2 ;
		};
	}
}

function simpleAddCalc($n1, $n2) {
    return function() use($n1, $n2) {
        echo $n1 + $n2 ;
    };
}

$calc = simpleAddCalc(5, 10);
// Here we bind the call to the internal anonymous function
$calc();
// Can also do this:
simpleAddCalc(5, 10)();

// shows that this is a Closure instance
var_dump($calc);

// need to add additional () to force construct to self-invoke
(new Test())(5, 10)();
```
* Type Hinting
```
<?php
declare(strict_types = 1);
namespace src\ModPhpAdvanced\StrictTyping;
class UserStrictTyping {
    protected $firstname ;
    protected $lastname ;
    public function __construct(string $firstname, string $lastname) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function getFirstname () : string {
        return $this->firstname;
    }

    public function getLastname () : string {
        return $this->lastname;
    }
    public function getFullName() : string {
		return $this->firstname . ' ' . $this->lastname;
	}
    public function calc(float $a, float $b) : int {
		var_dump($a, $b);
		return $a + $b;
	}

}

try {
	$user = new UserStrictTyping('1234','Flintstone');
	echo $user->getFullName();
	echo PHP_EOL;
	// generates fatal error
	$result = $user->calc((int) 2, (int) 2);
	var_dump($result);
} catch (Throwable $e) {
	echo get_class($e) . ':' . $e->getMessage();
}
```
* Callable examples
```
<?php
function needCallable(callable $call, $a, $b)
{
	return $call($a, $b);
}

class DoesInvoke
{
	public function __invoke($a, $b)
	{
		return $a + $b;
	}
}

class DoesNotInvoke
{
	public function calcNot($a, $b)
	{
		return $a + $b;
	}
}

// these are all callable directly:
$does = new DoesInvoke();
$anon = function ($a, $b) { return $a + $b; };
function calc($a, $b)
{
	return $a + $b;
}

// this is NOT directly callable:
$not  = new DoesNotInvoke();

// all of these work directly
echo needCallable($does, 2, 2);
echo needCallable($anon, 2, 2);
echo needCallable('calc', 2, 2);

// this generates error:
// echo needCallable($not, 2, 2);

// need to do this:
// internally, PHP invokes "$not->calcNot(2,2)"
echo needCallable([$not, 'calcNot'], 2, 2);
```
* Null Coalesce
```
<?php
$name = $_GET['name'] ?? $_POST['name'] ?? $_COOKIE['name'] ?? $_SESSION['name'] ?? 'guest';
$name = strip_tags($name);
echo htmlspecialchars($name);
setcookie('name', $name);
```
* Aggregating Catch Blocks
```
<?php
// new approach:
try {
	$pdo = new PDO(1,2,3,4);
} catch (PDOException | Exception | Error $e) {
	echo get_class($e) . ':' . $e->getMessage();
}
echo PHP_EOL;

// traditional:
try {
	$pdo = new PDO(1,2,3,4);
} catch (PDOException $e) {
	echo get_class($e) . ':' . $e->getMessage();
} catch (Exception $e) {
	echo get_class($e) . ':' . $e->getMessage();
} catch (Error $e) {
	echo get_class($e) . ':' . $e->getMessage();
}
```
* Linked list example:
```
<?php
$data = [
	'M' => ['date' => '2019-01-01', 'amount' => 3.33],
	'D' => ['date' => '2018-02-02', 'amount' => 1.11],
	'X' => ['date' => '2017-03-03', 'amount' => 2.22],
];

$test1 = $data;

// sorts only by the 1st element
asort($test1);
//var_dump($test1);

$linked = array_column($data, 'amount');
$amount = array_combine(array_keys($data), $linked);
//var_dump($amount);
asort($amount);

// linked list $amount ascending order
foreach($amount as $key => $value) {
	echo implode(',', $data[$key]) . PHP_EOL;
}

// linked list $revse present amount in descending order
$reverse = array_reverse($amount);
foreach($reverse as $key => $value) {
	echo implode(',', $data[$key]) . PHP_EOL;
}

```
* Example of RecursiveDirectoryIterator
```
<?php
$recurse = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../Documents'));

foreach ($recurse as $key => $value) {
	echo $key . ':' . var_export($value, TRUE) . PHP_EOL;
}
```

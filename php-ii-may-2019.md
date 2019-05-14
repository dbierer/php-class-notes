# PHP Fundamentals II -- May 2019

## Homework
* for Tue 14 May 2019
  Collabedit: http://collabedit.com/3phdt
  * Drew: Lab: Interfaces
  * Marcella: Lab: Type Hinting
  * Olawale: Lab: Build Custom Exception Class
* for Sun 12 May 2019
  Collabedit: http://collabedit.com/a43bt
  * Olawale: Lab: Create an Extensible Super Class
    * https://github.com/oadekoya12/zend-training/blob/master/php_II_assignment/Create_an_Extensible_Super_Class.php
  * Pedro: Lab: Magic Methods
    * https://github.com/pedrosuazo/phpcourses
* for Thu 9 May 2019
  Collabedit: http://collabedit.com/pvw9e
  * Drew: Lab: Namespace
  * Marcella: Lab: Create a Class

## TODO
* Post multi-autoloader example to classic repo
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_multiple_autoloader_example.php

## Corrections
* file:///D:/Repos/PHP-Fundamentals-II/Course_Materials/index.html#/2/33: sub-class doesn't override!

## Class Discussion
* Trait examples:
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_traits.php
* Namespace in single file example
```
<?php
namespace X {
	class Test
	{
		public function getTest()
		{
			return __CLASS__;
		}
	}
}

namespace Y {
	use DateTime;
	class Test
	{
		public function getTest()
		{
			return __CLASS__;
		}
		public function getTime()
		{
			$time = new DateTime();
			return $time->format('Y-m-d H:i:s');
		}
	}
}

namespace {
	$test = new \Y\Test();
	echo $test->getTest();
	echo PHP_EOL;
	echo $test->getTime();
}
```
* Autoloading example
```
<?php
// this file would be in /sandbox/public
// assumes /sandbox/Demo/Test1.php and /sandbox/Demo/Test2.php are defined
spl_autoload_register(
	function ($class)
	{
		$base = realpath(__DIR__ . '/..');
		include_once $base . '/' . str_replace('\\', '/', $class) . '.php';
	}
);

use Demo\ {Test1, Test2};
$test1 = new Test1();
$test2 = new Test2();
echo $test1->getTest();
echo PHP_EOL;
echo $test2->getTest();
```
* Inheritance example overriding __construct()
```
<?php
class User {
    public const  TABLE = 'user' ;
    public $firstName = 'Fred';
    public $lastName  = 'Flintstone';
	public function __construct($firstname, $lastname) {
		$this->firstName = $firstname;
		$this->lastName = $lastname;
    }
    public function getFullName() {
		return $this->firstName . ' ' . $this->lastName;
	}
}
class GuestUser extends User {
    public $role = 'Caveman';
    public function getRole() {
        return $this->role;
    }
	public function __construct($firstname, $lastname, $role) {
		parent::__construct($firstname, $lastname);
		$this->role = $role;
    }
}

$user = new User('Betty', 'Rubble');
echo $user->getFullName();
echo PHP_EOL;

$guest = new GuestUser('Barney', 'Rubble', 'Neighbor');
echo $guest->getFullName() . ' is a ' . $guest->getRole();
echo PHP_EOL;
```
* Examples of __toString and __destruct()
```
<?php

class Test
{
	public $test = 'TEST';
	public $tag  = 1;
	public function getTest()
	{
		return $this->test;
	}
	public function __toString()
	{
		return var_export($this, TRUE);
	}
	public function __destruct()
	{
		$date = new DateTime();
		echo 'Object instance: ' . $this->tag . ':' . $date->format('Y-m-d H:i:s:u') . PHP_EOL;
	}
}

$date = new DateTime();
echo $date->format('Y-m-d H:i:s:u');
echo PHP_EOL;

$test1 = new Test();
$test2 = new Test();
$test3 = new Test();

$test1->tag = 1;
$test2->tag = 2;
$test3->tag = 3;

unset($test2);
echo 'The class name is ' . $test1;
echo PHP_EOL;
echo 'End of the program' . PHP_EOL;
// NOTE: __destruct() is in LIFO order
```
* Examples of magic methods:
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_invoke_and_tostring.php
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_call_unlimited_getters_setters.php
* Examples of callable types
```
<?php
class Test {
    public function callIt(callable $callback, array $params) {
        return $callback($params);
    }
}

$operands[0] = 2;
$operands[1] = 3;
$callback = function ($p) {
    return 'The result of '
           . $p[0] . ' times ' . $p[1]
           . ' is ' . ($p[0] * $p[1]);
};
$test = new Test;
echo $test->callIt($callback, $operands);
echo PHP_EOL;

$anonCallback = new class() {
	public function __invoke($p)
	{
		return 'The result of ' . $p[0] . ' + ' . $p[1] . ' is ' . array_sum($p);
	}
};

$p = [2, 2];
echo $test->callIt($anonCallback, $p);
echo PHP_EOL;

class Whatever {
	public function __invoke($p)
	{
		return 'The result of ' . $p[0] . ' - ' . $p[1] . ' is ' . ($p[0] - $p[1]);
	}
};

$p = [2, 2];
echo $test->callIt(new Whatever(), $p);
echo PHP_EOL;
```
* Scalar type hinting
```
<?php
declare(strict_types=1);
class Test
{
	public function add(float $a, float $b)
	{
		return $a + $b;
	}
}

$test = new Test();
// this works
echo $test->add(9.99, 7);
echo PHP_EOL;
// this works
echo $test->add(9.99, 7.77);
echo PHP_EOL;
// this does not work
echo $test->add(9.99, '7');
echo PHP_EOL;
```
* Examples of try/catch
```
<?php
class Test
{
	public $pdo = NULL;
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}
}

try {
	$pdo = new PDO('x','y','z');
} catch (PDOException $e) {
	echo get_class($e) . PHP_EOL;
	echo $e->getMessage() . PHP_EOL;
	echo $e->getTraceAsString();
} catch (Exception $e) {
	echo get_class($e) . PHP_EOL;
	echo $e->getMessage() . PHP_EOL;
	echo $e->getTraceAsString();
}

try {
	$pdo = new PDO();
} catch (ArgumentCountError $e) {
	echo get_class($e) . PHP_EOL;
	echo $e->getMessage() . PHP_EOL;
	echo $e->getTraceAsString();
}
```

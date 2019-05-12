# PHP Fundamentals II -- May 2019

## TODO
* Post multi-autoloader example to classic repo
* Reset editor for \n\n

## Homework
* for Sun 12 May 2019
  Collabedit: http://collabedit.com/a43bt
  * Olawale: Lab: Create an Extensible Super Class
    * https://github.com/oadekoya12/zend-training/blob/master/php_II_assignment/Create_an_Extensible_Super_Class.php
  * Pedro: Lab: Magic Methods
* for Thu 9 May 2019
  Collabedit: http://collabedit.com/pvw9e
  * Drew: Lab: Namespace
  * Marcella: Lab: Create a Class

## Corrections
* file:///D:/Repos/PHP-Fundamentals-II/Course_Materials/index.html#/2/33: sub-class doesn't override!

## Class Discussion
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

# PHP Fundamentals II -- May 2019

## Homework
* for Thu 9 May 2019
  Collabedit: http://collabedit.com/pvw9e
  * Drew: Lab: Namespace
  * Marcella: Lab: Create a Class
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

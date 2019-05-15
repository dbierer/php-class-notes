# PHP Fundamentals II -- May 2019

## Homework
* for Thu 16 May 2019
  Collabedit: http://collabedit.com/2gy8c
  * Pedro: Lab: Traits
* for Tue 14 May 2019
  Collabedit: http://collabedit.com/3phdt
  * Drew: Lab: Interfaces
  * Marcella: Lab: Type Hinting
    * https://github.com/MParkerVM/PHPCourse.git
    * NOTE: branch `TypeHintingLab`
  * Olawale: Lab: Build Custom Exception Class
    * https://github.com/oadekoya12/zend-training/blob/master/php_II_assignment/Create_an_Extensible_Super_Class.php
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
* Static and Singleton design pattern example:
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_singleton_getinstance_example.php#L59
  * Also, read on late static binding here: https://php.net/manual/en/language.oop5.late-static-bindings.php
* Example of where cloning might be useful
```
<?php

// NOTE: objects are passed reference
$today = new DateTime();
$day90 = $today->add(new DateInterval('P90D'));

// Same object == same output
echo $today->format('Y-m-d');
echo PHP_EOL;
echo $day90->format('Y-m-d');
echo PHP_EOL;
echo ($today === $day90) ? 'REFERENCE' : 'CLONE';
echo PHP_EOL;

// using cloning
$today = new DateTime();
$day90 = clone $today;
$day90 = $day90->add(new DateInterval('P90D'));

// Same object == same output
echo $today->format('Y-m-d');
echo PHP_EOL;
echo $day90->format('Y-m-d');
echo PHP_EOL;
echo ($today === $day90) ? 'REFERENCE' : 'CLONE';
echo PHP_EOL;
```
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

## Homework
* for Thu 9 May 2019
  Collabedit: http://collabedit.com/pvw9e
```
// Homework for Thu 9 May 2019

//Drew Homework 1
/************************************
Order App Name spaces.
1. From the entry point on index.php there are 2 references to namespaces. I'm not quite sure those will map as the the Controller/Core directories are not in the same directory as the index.php files. They are in a src\OrderApp\.. directory structure.
2. It does appear that the 2 are named correctly, in that the
 3 was stating that it did appear that the "best practice" was being used in the naming conventions. Directory matched namespace and the name of files matched class names
 4 was an observation in one of the directories that multiple libraries were being imported with one line


*************************************/

//Marcella HW
//I struggled with this segment, and the purpose of the function and construct.
//I also just ran out of time to continue working on this.

<?php

class Report
{

    protected $startDate;
    protected $endDate;
    protected $dept;
    protected $productClass;

    public function __construct($startDate, $dept, $productClass)
    {
        $this->startDate = $startDate;
        $this->endDate   = ($startDate + 7);
        $this->dept      = $dept;
        $this->productClass = $productClass;
    }
    public function getVars()
    {
        return get_object_vars($this);
    }
    public function getAnything($name)
    {
        if (isset($this->$name)) {
            $val = $this->$name;
        } else {
            $val = NULL;
        }
        return $val;
    }
}

$report[] = new Report (21090501, 271, 812);
$report[] = new Report (21090401, 271, 812);
$report[] = new Report (21090501, 272, 357);

foreach ($report as $repObj) {
    echo 'The start date is: ' . $repObj->getAnything('startDate') . PHP_EOL;
    // this works only if properties are public:
    foreach (get_object_vars($repObj) as $varName => $repdata) {
        //echo $repObj . " is " . $repdata;
        echo get_class($repObj) . ' variable ' . $varName . ' contains ' . $repdata . PHP_EOL;
    }
    // this works any time:
    foreach ($repObj->getVars() as $varName => $repdata) {
        //echo $repObj . " is " . $repdata;
        echo get_class($repObj) . ' variable ' . $varName . ' contains ' . $repdata . PHP_EOL;
    }
}

//var_dump($report);
```
* for Sun 12 May 2019
  Collabedit: http://collabedit.com/a43bt
```
* For Sun 12 May 2019
  * Olawale: Lab: Create an Extensible Super Class
<?php
// Class definition
class Automobile
{
    // Declare  properties
    public $fuel;
    protected $engine;
    private $transmission;
}
class Car extends Automobile
{
    // Constructor
    public function __construct(){
        echo 'The class "' . __CLASS__ . '" was initiated!<br>';
    }
    public function setparam($fuel,$engine,$transmission = 4){
      $this->fuel = $fuel;
      $this->engine = $engine;
      $this->transmission = $transmission;
    }
    public function __toString(){
      return var_export($this, TRUE);
    }

}
$car = new Car();
$car->setparam('Regular','1.8L');
echo $car;
echo PHP_EOL;

$car->setparam('Deluxe','5.0', '6');
echo $car;
echo PHP_EOL;

```
* for Tue 14 May 2019
  Collabedit: http://collabedit.com/3phdt
```
<?php
/* Drew Homework
* Homework for Tues 14 May 2019
* Lab: Interfaces
*/
interface GolfGame
{
    public function getCourseRecord($key);
    public function setCourseRecord($courseName,$player,$score);
}

class GolfCourseRecord
{
    public $golfCourse;
    public $golfPlayer;
    public $score;
}

class GolfCourses implements GolfGame
{
    protected $golfCourseRecord = [];
    public function __construct(GolfCourseRecord $record = NULL)
    {
        if ($record) $this->golfCourseRecord[] = $record;
    }
    public function getCourseRecord($key)
    {
        return $this->golfCourseRecord[$key] ?? NULL;
    }
    public function setCourseRecord($course,$player,$score)
    {
        $record = new GolfCourseRecord;
        $record->golfCourse = $course;
        $record->golfPlayer = $player;
        $record->score = $score;
        $this->golfCourseRecord[] = $record;
        return $this;
    }
    public function getCourseInfo($key)
    {
        $record = $this->getCourseRecord($key);
        if ($record) {
            return 'Congratulations ' . $record->golfPlayer
                   . '! You have set a score of ' . $record->score
                   . ' at ' . $record->golfCourse . '.';
        } else {
            return NULL;
        }
    }
}

$courses = new GolfCourses();
$courses->setCourseRecord('Hawaii','Drew',-12)
        ->setCourseRecord('Durand Eastman','Doug',168)
        ->setCourseRecord('Pebble Beach','Marcella',-20)
        ->setCourseRecord('John Deere Classic','Olawale',0);

echo $courses->getCourseInfo(0);

var_dump($courses);

/*Marcella Homework

Lab: Type Hinting
1. Create a new class with some properties and methods.
2. Add a constructor.
3. Type hint in the constructor for the interface created in the last exercise.
4. Instantiate an object from one of your previous subclasses.
5. Add it as a dependent object to the new object created in step one, and store it.

--I have not completed this yet.  Hoping to today, but have had some issues come up.
This is my current code, but I'm still trying to wrap my head around steps 3-5.
I was able to add an interface, and use some type hinting, but I don't understand the concept of type hinting to an interface.

https://github.com/MParkerVM/PHPCourse/tree/TypeHintingLab/public


*/

<?php
// Class definition
// declare(strict_types = 1);
class Automobile
{
    // Declare  properties
    public $fuel;
    protected $engine;
    private $transmission;
}
class Car extends Automobile
{
    // Constructor
    public function __construct(){
        echo 'The class "' . __CLASS__ . '" was initiated!<br>';
    }
    public function setparam($fuel,$engine,$transmission = 4){
      $this->fuel = $fuel;
      $this->engine = $engine;
      $this->transmission = $transmission;
    }
    public function __toString(){
      return var_export($this, TRUE);
    }
}


try {

    $car = new Car();
    $car->setparam('Regular','1.8L');
    echo $car;
    echo PHP_EOL;

    $car->setparam('Deluxe','5.0', '6');
    echo $car;
    echo PHP_EOL;

    $car->setparam('Deluxe');
    echo $car;
} catch (Exception $e) {
  echo '***********************';
  echo 'Exception' . PHP_EOL;
  echo $e->getMessage();
} catch (ArgumentCountError $e) {
  echo '***********************';
  echo 'ArgumentCountError' . PHP_EOL;
  echo $e->getMessage();
  echo $e->getCode();
} catch (Throwable $e) {
  echo '***********************';
  echo 'Throwable' . PHP_EOL;
  echo $e->getMessage();
  echo $e->getCode();
}
```

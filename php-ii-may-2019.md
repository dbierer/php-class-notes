# PHP Fundamentals II -- May 2019

file:///D:/Repos/PHP-Fundamentals-II/Course_Materials/index.html#/4/46

## Homework
* for Tue 21 May 2019
  Collabedit: http://collabedit.com/m9tff
  * Olawale: Lab: Email
* for Sun 19 May 2019
  Collabedit: http://collabedit.com/x2jdf
  * Drew: Lab: SQL Statements: from the VM:
```
mysql -u vagrant -pvagrant
mysql> show databases;
mysql> use phpcourse;
mysql> show tables;
mysql> show create table orders;
// run different commands
mysql> exit
```
  * Marcella: Lab: Prepared Statements
  * All: Lab: Stored Procedure
  * All: Lab: Transaction
  * Path to source code in VM is this:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/ {sandbox | php2 | orderapp}
```
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
* Install MongoDB for demo

## Corrections
* file:///D:/Repos/PHP-Fundamentals-II/Course_Materials/index.html#/2/33: sub-class doesn't override!
* file:///D:/Repos/PHP-Fundamentals-II/Course_Materials/index.html#/4/17: duplicate slide
* file:///D:/Repos/PHP-Fundamentals-II/Course_Materials/index.html#/6/2: s/be "custom"
## Class Discussion
* Example of regex
```
<?php
$contents = file_get_contents('https://php.net/manual/en/reference.pcre.pattern.syntax.php');
//         Sub Matches:  1     2    3
$pattern  = '/<a.*?href=("|\')(.*?)("|\').*?>/';
preg_match_all($pattern, $contents, $matches);
var_dump($matches[2]);
// the actual links are the 2nd sub-pattern
```
* ETag Example
```
<?php
/*
 *      etag.php
 */
// Set eTag
$etag = "1.0.1_2019_05_20";

//$etag_match = $etag . "-gzip";
$none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : "";
if ( $none_match == $etag ) {
	header('304 Not Modified', TRUE, 304);
	exit;
} else {
	header("ETag: $etag");
}
?>
<!DOCTYPE html>
<head>
	<title>ETag Example</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.16" />
</head>
<body>
<h1>ETag Example</h1>
NEW: ONLY FOR TODAY ... SPECIAL!!!

Refresh this page and check the header details.

<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br>aaaa bbbb cccc dddd eeee ffff gggg hhhh iiii jjjj
<br>kkkk llll mmmm nnnn oooo pppp qqqq rrrr ssss tttt
<br><a href="index.php">BACK</a>
</body>
</html>
```
* Headers example
```
<?php
// if you see the error: "Headers already sent" it means you have output already before setting a header
//header('Content-Type: application/json');
header('Something: anything');
// default behavior is to REPLACE duplicate headers
header('Something: nothing');
// otherwise you can ADD duplicates as follows:
header('Duplicate: 1');
header('Duplicate: 2', FALSE);

$data = ['a' => 1, 'b' => 2, 'c' => 3];
echo json_encode($data);

phpinfo(INFO_VARIABLES);
```
* Example of nested buffering
```
<?php
// Top level buffer
ob_start();

$now = new DateTime();
echo 'some content in the first buffer ' . $now->format('H:i:s:u');
echo PHP_EOL;

// Begin Nested buffer ******************************************************
ob_start();
$now = new DateTime();
echo 'some content in the second buffer ' . $now->format('H:i:s:u');
echo PHP_EOL;

// Get the nested buffer contents
$content2 = ob_get_contents();
ob_end_clean();
// End Nested buffer ******************************************************

// Get and clean from the outer buffer
$content1 = ob_get_clean();
$now = new DateTime();
echo $content1 . $now->format('H:i:s:u');
echo PHP_EOL;
echo $content2;
echo PHP_EOL;
```
* PDO example showing error handling
```
<?php
ini_set('display_errors', 0);
define('ERROR_LOG', __DIR__ . '/error.log');
try {
	$dsn  = 'mysql:host=localhost;dbname=phpcourse';
	$opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
	$pdo  = new PDO($dsn, 'vagrant', 'vagrant', $opts);
	$sql  = 'UPDATE customers SET id=? WHERE id=?;';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([5,1]);
	if ($stmt->rowCount()) {
		echo 'Update Succeeded!';
	} else {
		echo 'Unknown Problem :-(';
	}
} catch (Throwable $e) {
	$message = date('Y-m-d H:i:s') . ':' . get_class($e) . ':' . $e->getMessage();
	file_put_contents(ERROR_LOG, $message, FILE_APPEND);
	echo 'Unable to complete the database operation [' . __LINE__ . ']';
} catch (Throwable $e) {
	$message = date('Y-m-d H:i:s') . ':' . get_class($e) . ':' . $e->getMessage();
	file_put_contents(ERROR_LOG, $message, FILE_APPEND);
	echo 'Unknown error [' . __LINE__ . ']';
}
```
* Object Relational Mapping: https://www.doctrine-project.org/projects/orm.html
* PHP 3rd party libraries: https://packagist.org/
* Database Rankings: https://db-engines.com/en/ranking
* PDO examples:
  * https://github.com/dbierer/classic_php_examples/tree/master/db
  * https://github.com/dbierer/classic_php_examples/blob/master/db/db_pdo_fetch_class.php

* Post multi-autoloader example to classic repo
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_multiple_autoloader_example.php
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
* For Sun 19 May 2019
```
/**Marcella Homework
*Lab - Prepared Statement
*1. Create a prepared statement script.
*2. Add a try/catch construct.
*3. Add a new customer record binding the customer parameters.
*
* Is it common / good practice / practical to use a try / catch INSIDE of a class?
* It seems to me you would have a newUser class with functions inside to complete this SQL.
* Would you put the try catch inside of that?  Or TRY to instantiate the newUser class and catch THAT error?
**/

<?php

$dsn  = 'mysql:host=localhost;dbname=phpcourse';
$opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$pdo  = new PDO($dsn, 'vagrant', 'vagrant', $opts);
$statemt = $pdo->prepare( 'INSERT INTO users (firstname,lastname,userid,bday) VALUES (?,?,?,?)' );

$fname = 'Marcella';
$lname = 'Parker';
$usid  = 'Delfinus';
$bday  = '07/25';

// If you needed to first verify that the userid is unique:
/*
   $stmt = $pdo->prepare('SELECT userid FROM users WHERE userid = :placeholder;');
   $stmt->execute(['placeholder' => $usid]);
   if ($stmt->rowCount()) {
       echo 'This user id is already in use.  Please choose another.';
   } else {
      // carry on
   }
 *
 */

$statemt->bindParam(1, $fname);
$statemt->bindParam(2, $lname);
$statemt->bindParam(3, $usid);
$statemt->bindParam(4, $bday);

try {
    $statemt->execute();

} catch (PDOException $e){
    echo get_class($e) . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString();
} catch (Throwable $e){
    echo get_class($e) . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString();
}


/**Marcella # 2
*Lab - Transaction
*1. Create a transaction script.
*2. Execute two SQL statements.
*3. Handle any exceptions.
*This is built to fail and hit the CATCH block.
**/

<?php

try {
    // Get the connection instance
    $pdo = new PDO('mysql:host=localhost;dbname=phpcourse','vagrant','vagrant');

    // Set error mode attribute
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin the transaction
    $pdo->beginTransaction();
    $pdo->exec("insert into customers (firstname, lastname) values ('Bob')");
    $pdo->exec("insert into orders (date, status, amount, description, customer)
        values(1360796400, 'open', 1200, 'PHP Testing', 6)");
    $pdo->commit();
    echo 'Success!';
} catch (PDOException $e ){
    $pdo->rollBack();
    echo 'Failed: ' . $e->getMessage();
}

/**
LAB: SQL Statements --DREW #1
Identify the result of the each of the following SQL statements:
**/
1. SELECT * FROM users;
--This will get all users that are in the users table
2. SELECT firstname, lastname FROM users AS u WHERE u.id = 25;
--This will select just the first & last name for a single user with id of 25
3. INSERT INTO users (firstname, lastname) VALUES (James, Bond);
--This will insert a new user into the table with a the name of James Bond
4. UPDATE users SET firstname=Rube, lastname=Goldberg WHERE users.id=420;
--This will update the name of the user that has an id of 420
5. SELECT * FROM users ORDER BY lastname DESC;
--This will select all users and put them in order by lastname Z-A
```

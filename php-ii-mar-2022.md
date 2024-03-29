# PHP-II Class Notes -- Mar 2022

## Homework
* For Wed 23 Mar 2022: https://collabedit.com/kh4b6
* For Fri 25 Mar 2022: https://collabedit.com/y5ea7
* For Thu 31 Mar 2022: https://collabedit.com/pscdf

## TODO
* Change request for Errata
* Send copy to Nick
* Check on POSIX usage
```
<?php
$num = '800-555-1212';

// uses the "shortcut" syntax
$pat = '/(\d+)-(\d+)-(\d+)/';
preg_match_all($pat, $num, $match);
var_dump($match);

// uses the "POSIX" syntax
$pat = '/([:digit:]+)-([:digit:]+)-([:digit:]+)/';
preg_match_all($pat, $num, $match);
var_dump($match);
```

## Q & A
* Q: What's faster, SOAP or REST?
* A: See: https://www.ateam-oracle.com/post/performance-study-rest-vs-soap-for-mobile-applications

* Q: What are the main changes in PHP 8.1?
* A: See: https://www.zend.com/blog/php-8-1
* A: See: https://www.php.net/manual/en/migration81.php

* Q: Any examples using PHP 8.1 fibers?
* A: See: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/tree/main/ch12

* Q: Example of a class that implements multiple interfaces?
* A: `ArrayObject` (see: https://www.php.net/arrayobject)

* Q: Example of different "callable" types
* A: See: https://www.php.net/manual/en/language.types.callable.php
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/callable_examples.php

* Q: RE: https://github.com/laminas/laminas-db/blob/2.14.x/src/Adapter/Driver/Pgsql/Connection.php. Why are there `use` statements for functions?  Are they necessary?
* A: From MWOP: It's a performance optimization.
  * If you do not have a use function​ statement, then PHP has to do the following:
    * Check the current namespace for a function matching the name
    * Check the global namespace for a function matching the name
  * By having the use function​ statement present, you omit the first step. It's a micro-optimization, but it also gives intent: you are indicating that the function IS NOT in the current namespace, and you are aware of that.
  * It also prevents somebody from overriding the function by creating one in the namespace and applying different behavior. (That said, I've sometimes relied on this when unit testing to inject spies!)

* Q: Examples of plugin architecture using `__call()`?
* A: https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
* A: Search your codebase for `__call()` and see what you get
```
grep -rn . -e "__call"
```

## Class Notes
Nullable Types
* Add a `?` in front of the data type
* It means that data or NULL
* Example
```
// in all versions of PHP >= 7:
function xyz(?string $name)
{
        return strtoupper($name);
}
// in PHP 8:
function xyz(string|null $name)
{
        return strtoupper($name);
}
```

Interfaces
* Example: https://github.com/laminas/laminas-db/blob/master/src/Adapter/AdapterInterface.php
* Example: https://www.php-fig.org/psr/psr-7/

Abstract Classes
* Example: https://github.com/laminas/laminas-db/blob/master/src/TableGateway/AbstractTableGateway.php
* Example: https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
Magic Methods
* Examples of `__get()` and `__set()`
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_get_set.php
* `__sleep()` and `__wakeup()`
```
class User{
    protected string $firstName;
    protected string $lastName;
    protected string $userName;
    protected string $hash;
    public function __construct(string $firstName, string $lastName, string $password='')
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $firstName . ' ' . $lastName;
        if (!empty($hash)) {
                        $this->hash = password_hash($password, PASSWORD_DEFAULT);
                } else {
                        $this->__wakeup();
                }
    }
    public function __sleep()
    {
                return ['firstName','lastName','userName'];
        }
        public function __wakeup()
        {
                $password = bin2hex(random_bytes(8));
                $this->hash = password_hash($password, PASSWORD_DEFAULT);
        }
    public function confirmPassword(string $password) : bool
    {
                return password_verify($password, $this->hash);
        }
        public function __toString()
        {
                return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        }
}

$user = new User('Fred','Flintstone');
$str  = serialize($user);
$new  = unserialize($str);
echo $str;
echo $new;

$json = json_encode($user);
$new2 = json_decode($json);
//echo $new2;

var_dump($user);
var_dump($new);
var_dump($new2);
```

Class Constants
* Refer to a class constant _within_ the class using the keyword `self::XXX`
* Refer to a class constant _outside_ the class using the class name `Test::XXX`
```
<?php
class Test
{
        public const TEST = 'TEST';
        public static function getTest()
        {
                return self::TEST;
        }
}

echo Test::TEST;
echo Test::getTest();
```
You can assign a data type to properties as of PHP 7.4
* Values are converted to that data type if you don't `declare(strict_types=1);`
* If you need strict typing to be enforced, add the strict_types declaration
```
<?php
declare(strict_types=1);
class Test
{
        public const TEST = 'TEST';
        public string $fname = 'Fred';
        public string $lname = 'Flintstone';
        public static function getTest()
        {
                return self::TEST;
        }
        public function getFullName()
        {
                return $this->fname . ' ' . $this->lname;
        }
}

echo Test::TEST;
echo Test::getTest();
echo "\n";
$test = new Test();
$test->fname = 123;
echo $test->getFullName();
var_dump($test);

// Actual Output:
/*
TESTTEST
PHP Fatal error:  Uncaught TypeError: Cannot assign int to property Test::$fname of type string in C:\Users\ACER\Desktop\test.php:22
Stack trace:
#0 {main}
  thrown in C:\Users\ACER\Desktop\test.php on line 22
 */
```
Constructor Argument Promotion example:
```
<?php
class UserEntity
{
    public function __construct(
        public string $firstName = 'Fred',
        public string $lastName = 'Flintstone',
        public string|null $date = NULL
    )
    {
                // you can still something inside the body of the method:
                $this->date = date('Y-m-d');
        }
}

$user[] = new UserEntity('Jack' , 'Ryan');
$user[] = new UserEntity('Monte' , 'Python');
$user[] = new UserEntity();

var_dump($user);
```
Examples of obtaining property info from inside vs. outside
```
<?php
class UserEntity
{
        protected $hash = '';
    public function __construct(
        public string $firstName = 'Fred',
        public string $lastName = 'Flintstone',
        public string|null $date = NULL
    )
    {
                $this->date = date('Y-m-d');
                $this->hash = bin2hex(random_bytes(8));
        }
        public function getArrayCopy()
        {
                return get_object_vars($this);
        }
        public function getJson()
        {
                return json_encode($this->getArrayCopy(), JSON_PRETTY_PRINT);
        }
}

$user = new UserEntity();
var_dump($user);
var_dump($user->getArrayCopy());
var_dump(get_object_vars($user));
echo $user->getJson();
echo json_encode($user, JSON_PRETTY_PRINT);
```
Examples of generic to specific
```
<?php
class Transportation
{
        public string $media;   // space, air, land, surface, under water
}
class Sea extends Transportation
{
        public string $steering;        // rudder, hydroplane, etc.
        public string $waterTightCompartments;
}
class Land extends Transportation
{
        public string $engineSize = 0;  // litres
        public int $numberPassengers = 0;
        public int $numberWheels = 0;
        public string $fuelType = '';   // petrol, electricity, etc.
        public function getNumberWheels()
        {
                return $this->numberWheels;
        }
}
class Automobile extends Land
{
}
class Truck extends Land
{
}
```
Anonymous class examples:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/anonymous_class_repurposing.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php

Example where class implementing an interface uses a "wider" data type hint
```
<?php
interface ConfirmInterface
{
    public function setObject(ArrayObject $obj);
}

class User implements ConfirmInterface
{
    protected string $firstName;
    protected string $lastName;
    protected string $userName;
    protected string $hash;
    protected $obj = NULL;
    public function __construct(string $firstName, string $lastName, string $password='')
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $firstName . ' ' . $lastName;
        if (!empty($hash)) {
                        $this->hash = password_hash($password, PASSWORD_DEFAULT);
                } else {
                        $this->hash = bin2hex(random_bytes(8));
                }
    }
    public function confirmPassword(string $password) : bool
    {
                return password_verify($password, $this->hash);
        }
        // "iterable" is a "wider" definition that encompasses both arrays and anything thing that's iterable
        public function setObject(iterable $obj)
        {
                $this->obj =$obj;
        }
}


$user = new User('Fred','Flintstone');
$user->setObject(new ArrayObject([1,2,3,4,5]));
var_dump($user);

$user->setObject([1,2,3,4,5]);
var_dump($user);
```
Keyword `static` (vs. `self`)
```
<?php
class Test
{
        public static function getInstance() : static
        {
                return new static();
        }
}

class Xyz extends Test
{
}

$a = Test::getInstance();
$b = Xyz::getInstance();
echo var_dump($a);      // Instance of Test
echo var_dump($b);  // Instance of Xyz
```
Exceptions
```
<?php
// `catch` blocks need to go from specific to general
// the order is *extremely* important
try {
    // ...
} catch (PDOException $e) {
    $logEntry = date('Y-m-d H:i:s') . '|' . get_class($e) . ':' . $e->getMessage() . PHP_EOL;
    error_log($logEntry, 3, 'path/to/database_error.log');
} catch (Exception $e ) {
    $logEntry = date('Y-m-d H:i:s') . '|' . get_class($e) . ':' . $e->getMessage() . PHP_EOL;
    error_log($logEntry, 3, 'path/to/error.log');
} catch (Throwable $t ) {
    $logEntry = date('Y-m-d H:i:s') . '|' . get_class($t) . ':' . $t->getMessage() . PHP_EOL;
    error_log($logEntry, 3, 'path/to/really_bad_situation.log');
}
// from here ... don't really do too much
// maybe redirect, but that's about it
// the Zend engine is potentially in an unstable state!
```
Late Static Binding
```
<?php
// See: https://www.php.net/manual/en/language.oop5.late-static-bindings.php
class A {
    public static function who() {
        echo __CLASS__;
    }
    public static function test() {
                self::who();
        static::who();
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

A::test();
B::test();

// output: "AAAB"
```
Traits
* Often, various frameworks will provide a trait to match an interface
  * https://github.com/laminas/laminas-db/blob/master/src/Adapter/AdapterAwareInterface.php
  * https://github.com/laminas/laminas-db/blob/master/src/Adapter/AdapterAwareTrait.php
* If a class implements `AdapterAwareInterface`, then all the developer needs to do is to use `AdapterAwareTrait`
Clone
* PHP automatically assigns objects by reference
* If you want a *different* copy, use `clone`
* Example:
```
<?php
class User
{
        public $firstName = 'Fred';
        public $lastName  = 'Flintstone';
}

$user = new User();
$other = $user;
$other->firstName = 'Wilma';
var_dump($user, $other);

/*
object(User)#1 (2) {
  ["firstName"]=>
  string(5) "Wilma"
  ["lastName"]=>
  string(10) "Flintstone"
}
object(User)#1 (2) {
  ["firstName"]=>
  string(5) "Wilma"
  ["lastName"]=>
  string(10) "Flintstone"
}
 */

$user = new User();
$other = clone $user;
$other->firstName = 'Wilma';
var_dump($user, $other);

/*
object(User)#1 (2) {
  ["firstName"]=>
  string(4) "Fred"
  ["lastName"]=>
  string(10) "Flintstone"
}
object(User)#2 (2) {
  ["firstName"]=>
  string(5) "Wilma"
  ["lastName"]=>
  string(10) "Flintstone"
}
 */
```
* If you need the `__construct()` to run when you clone, you can do it this way:
```
<?php
class User
{
        public $firstName = 'Fred';
        public $lastName  = 'Flintstone';
        public $hash = '';
        public function __construct()
        {
                $this->hash = bin2hex(random_bytes(8));
        }
        public function __clone()
        {
                static::__construct();
        }
}

$user = new User();
$other = $user;
$other->firstName = 'Wilma';
var_dump($user, $other);

$user = new User();
$other = clone $user;
$other->firstName = 'Wilma';
var_dump($user, $other);
```
Enumerations
```
<?php
enum Gender : string
{
    case MALE   = 'M';
    case FEMALE = 'F';
    case OTHER  = 'X';
}

class Signup
{
    public function __construct(
        public string $username,
        public string $password,
        public string $dateOfBirth,
        // NOTE: using the Gender enum shown in an earlier slide
        public Gender $gender)
    {}
    public function getGender()
    {
                return $this->gender->value;
        }
}

$fred = new Signup('fred', 'pass', '1970-01-01', Gender::MALE);
var_dump($fred);
echo $fred->getGender();
echo "\n";
foreach(Gender::cases() as $item) echo $item->value;
```
Example of an Abstract class
```
<?php
<?php
// example of an abstract class

abstract class AbstractTable
{
    public string $tableName = '';
    public function __construct(public array $fieldNames = []) {}
    public abstract function select();
    public abstract function insert();
    public abstract function update();
    public abstract function delete();
    public function buildInsert()
    {
        return 'INSERT INTO ' . $this->tableName
             . ' ('
             . implode(',', $this->fieldNames)
             . ') VALUES (:'
             . implode(',:', $this->fieldNames)
             . ');';
    }
}
// you would then extend this class and define specifics for each table
// and override the $tableName property in the child classes
class UserTable extends AbstractTable
{
    public string $tableName = 'user';
    public function select() { /* do something */ }
    public function insert() { /* do something */ }
    public function update() { /* do something */ }
    public function delete() { /* do something */ }
    public function findUserById (int $id) { /* do something */ }
    // etc.
}
$table = new UserTable(['first','last','email','password']);
```
PDO Connect Info
```
<?php
try {
    // Get the connection instance
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=phpcourse', 'vagrant', 'vagrant', $options);
    // Statements ...
} catch (PDOException $e ){
    // Handle exception...
} catch (Throwable $e ){
    // Handle everything else
}
```
PDO example using stored procedure
```
<?php

try {
    // Get the connection instance
    $pdo = new PDO('mysql:host=localhost;dbname=phpcourse','vagrant','vagrant',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Hard coded input parameters (simulates filtered, validated and sanitized inputs)
    $fname = 'Mark';
    $lname = 'Watney';

    // Prepare an SQL statement and get a statement object
    $sql  = 'CALL newCustomer (' . $pdo->quote($fname) . ',' . $pdo->quote($lname) . ')';
    $stmt = $pdo->query($sql);

    // Execute the SQL statement
    if ($stmt->rowCount() > 0) {
        echo "New user $fname  $lname added";
    }
} catch (PDOException $e){
    //Handle PDO runtime problems
} catch (Throwable $t){
    //Handle error
}
```
Regex Examples
```
<?php
$fn = 'some_graphic.jjpg';
$pt = '/.*.jpg$/';  // matches *any* character followed by "jpg" at the end
echo (preg_match($pt, $fn)) ? 'Valid' : 'Invalid';  // Valid
echo "\n";
$pt = '/.*\.jpg$/'; // if you're looking for ".", you need to escape it!
echo (preg_match($pt, $fn)) ? 'Valid' : 'Invalid';  // Invalid
echo "\n";
```
* Alternatives + sub-patterns
```
<?php
$txt = '<b>First</b><i>Second</i><p>Third</p>';
$pt  = '!(<b>(.*?)<\/b>)|(<i>(.*?)</i>)!';
preg_match_all($pt, $txt, $match);
var_dump($match);
```
* Using word boundary in a pattern
```
<?php
$txt = 'The quick,brown,fox jumped? Yes,over the "fence," I think.';
$pt  = '!\b(\w+?)\b!';
preg_match_all($pt, $txt, $match);
var_dump($match);

// submatch portion of output:
/*
  [1]=>
  array(11) {
    [0]=>
    string(3) "The"
    [1]=>
    string(5) "quick"
    [2]=>
    string(5) "brown"
    [3]=>
    string(3) "fox"
    [4]=>
    string(6) "jumped"
    [5]=>
    string(3) "Yes"
    [6]=>
    string(4) "over"
    [7]=>
    string(3) "the"
    [8]=>
    string(5) "fence"
    [9]=>
    string(1) "I"
    [10]=>
    string(5) "think"
  }
*/
```
PHP 8.1 Fibers
* Clone this repo: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices.git
* Go to the `/path/to/repo/ch12` directory
* Make sure you're running PHP 8.1
* Now try this:
```
// run the callbacks without using fibers and note the elapsed time:
php php8_fibers_blocked.php
// now run the same set of callbacks using fibers and note the elapsed time:
php php8_fibers_unblocked.php
```
Abstract Class and Interface
```
<?php
namespace OrderApp\Core\Form\Inputs;

interface GetInputInterface
{
    public function getInput() : string;
}
// NOTE: because this class fails to implement `getInput()`
//       as mandated  by GetInputInterface
//       it must be declared abstract (passes the buck down the line)
abstract class ClassName implements GetInputInterface
{
    // PHP 8 constructor argument promotion:
	public string $fullname = '';
    public function __construct(
        public array $usernames = [],
        public string $fname = '',
        public string $lname = '',
        public string $type = 'text')
    {
        $this->fullname = $fname . ' ' . $lname;
	}
}

class AnotherClass extends ClassName
{
	public function getInput() : string
	{
		$input = "<input type=\"$this->type\"";
		$input .= '>';
		return $input;
	}
}

$another = new AnotherClass(['A','B','C'], 'Fred', 'Flintstone', 'html');
var_dump($another);
```
Example of an XML-based service:
* See: https://graphical.weather.gov/xml/
SimpleXML Example
```
<?php
$doc = <<<EOT
<?xml version = "1.0" encoding = "UTF-8" ?>
<produce xmlns:ea = "test">
    <vegetables>
        <vegetable unit = "pound">
            <name> tomatoes </name>
            <price> 2.99 </price>
        </vegetable>
        <vegetable unit = "ounce">
            <name>carrots</name>
            <price>1.99</price>
        </vegetable>
        <vegetable unit = "pkg">
            <name>broccoli</name>
            <price>4.99</price>
        </vegetable>
    </vegetables>
</produce>
EOT;

$xml = new SimpleXMLElement($doc);

// Get the vegies
$vegies = $xml->vegetables;

// Get the first vegie using array notation
echo __LINE__ . ':' . $vegies->vegetable[0]->name;

// Output item data
foreach ( $vegies->vegetable as $node ) {
    echo "Content: " . $node->name . "\n" ;
}

// Output XML from the SimpleXMLElement object
echo $xml->asXML();

// Output to an xml file
$xml->asXML( 'newproduce.xml' );

// xpath query

$result = $xml->xpath('//name');
var_dump($result);
```
SOAP Client Request
* See: https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php

REST Requests using Streams
* You can use `file_get_contents()` or `fopen()` followed by `fgets()`
* If you want an HTTP method other than `GET`, use `stream_context_create()` and supply that as the 4th argument
* OR ... better yet: use the cURL extension!

Resource to object migration
```
<?php
// create a new cURL resource
$ch = curl_init();

// this will *FAIL* in PHP 8 and above:
// if (!is_resource($ch)) exit('ERROR: problem creating connection');

// do this instead:
// works in *all* versions of PHP including PHP 8 and above
if (empty($ch)) exit('ERROR: problem creating connection');

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://api.unlikelysource.com/api?city=Rochester&country=US");
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
$result = curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);

var_dump($result);
```

## Errata

* http://localhost:8888/#/3/23
  * s/be `$this->lastName = $lastName ;` not `$this->lastnNme = $lastName ;`
* http://localhost:8888/#/5/36 * and all similar examples!
  * s/be
```
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$pdo = new PDO('mysql:host=localhost;dbname=phpcourse', 'vagrant', 'vagrant', $options);
```
* http://localhost:8888/#/6/11
  * s/be no "$"
```
$to = 'Clark <clark@zend.com>';
```
* http://localhost:8888/#/7/8
  * s/b "three" different forms

# PHP II - Sep 2023

Last: http://php-oop/#/3/68

## TODO
* Q: Where is the Maze Runner code?
* A: See: https://github.com/dbierer/php_games/tree/main/src/PhpTraining/Maze
* A: It will show you a simple OOP architecture that includes an abstract class and an interface


* Q: Can you find plugin example that uses `__call()`?
* A: See: https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
* A: See: https://github.com/laminas/laminas-mvc/blob/3.6.x/src/Controller/PluginManager.php
* A: See: https://github.com/laminas/laminas-mvc/tree/3.6.x/src/Controller/Plugin

* Q: Do you have an example of form filtering using callbacks?
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/web/form_with_filtering_and_validation.php


## Homework
For Thu 7 Sep 2023
* Install XAMPP
  * https://www.apachefriends.org/download.html
* https://collabedit.com/uh8ym


## XAMPP Notes

### Add vhost definition for `sandbox` and `orderapp`
Follow these instructions to add an Apache vhost (virtual host) definition to the `orderapp`, `sandbox`, and `php2` websites:
* From a terminal window (command prompt):
  * Run `gedit` as the root user:
```
sudo gedit
```
  * Open the file `/etc/hosts`
  * Add an entry to the local hosts file to simulate servers named `orderapp`, `sandbox`, and `php2`
```
127.0.0.1   orderapp sandbox php2
```
  * Save the file
  * Make a note of where you unzipped the course files
    * In this set of instructions we'll call it `/path/to/files`
  * Make a note of where XAMPP stores its Apache vhost configuration
    * In this set of instructions we'll call it `/xampp/apache/conf/extra/httpd-vhosts.conf`
    * Open this file and paste this in at the bottom of the file:
```
<VirtualHost *:80>
   ServerName orderapp
   DocumentRoot /path/to/files/orderapp/public
   <Directory /path/to/files/orderapp/public>
       Options Indexes FollowSymlinks MultiViews
       AllowOverride All
       Require all granted
   </Directory>
</VirtualHost>
<VirtualHost *:80>
   ServerName sandbox
   DocumentRoot /path/to/files/sandbox
   <Directory /path/to/files/sandbox >
       Options Indexes FollowSymlinks MultiViews
       AllowOverride All
       Require all granted
   </Directory>
</VirtualHost>
<VirtualHost *:80>
   ServerName php2
   DocumentRoot /path/to/files/php2
   <Directory /path/to/files/php2 >
       Options Indexes FollowSymlinks MultiViews
       AllowOverride All
       Require all granted
   </Directory>
</VirtualHost>
```
  * Save the above file
  * Exit `gedit`
  * Use the XAMPP control panel to restart Apache
  * Test the new simulated server from the command line
```
ping -c3 sandbox
```
  * Access `sandbox` from the your browser: `http://sandbox/`


### Restore the database
* Open phpMyAdmin from the XAMPP console
* Create a database called `phpcourse`
* Select the new database
* Assign a user `vagrant` with password `vagrant` to the `phpcourse` database
* Select "Import" and choose the file located under `/path/to/files/orderapp/data/sql/phpcourse.sql`

## Resources
Code examples: https://github.com/dbierer/classic_php_examples
PHP Road Map: https://wiki.php.net/rfc
Where it all started:
* Seminal work: "Design Patterns: Elements of Reusable Object-Oriented Software"
PHP Road Map:
* https://wiki.php.net/rfc

## Class Notes

### Namespaces
Namespace standard: PSR-4
* https://www.php-fig.org/psr/psr-4/

You can use keyword `use` to identify built-in PHP classes (global namespace)
```
<?php
namespace Test\Me;

use DateTime;
class Whatever
{
	public function getTime()
	{
		return (new DateTime('now'))->format('l, d-M-Y');
	}
}

$what = new Whatever();
echo $what->getTime();
echo PHP_EOL;
```

Differences between PHP 7 and 8:
```
// works in PHP 7 but not 8 (notice the spaces)
namespace This \ Is \ Normal;
// works in PHP 8 but not 7 (notice the key word "list")
namespace This\Is\A\List;
```

Keyword `as` is used to resolve ambiguities
```
<?php
namespace A\B\C {
    class Test
    {
        public $name = 'ABC';
    }
}

namespace X\Y\Z {
    class Test
    {
        public $name = 'XYZ';
    }
}

namespace {
    // if aliases weren't used, you'd get a Fatal Error
    use A\B\C\Test as ATest;
    use X\Y\Z\Test as ZTest;
    $test = new ATest();
    echo $test->name;
}
```

Autoloader Examples:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_autoload_example.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_autoload_class_example.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_autoload_example_using_map_algorithm.php

Autoloading example:
```
<?php
spl_autoload_register(function ($class) {
    require_once __DIR__
           . DIRECTORY_SEPARATOR
           . str_replace('\\', DIRECTORY_SEPARATOR, $class)
           . '.php';
});

use Test\Something\{Test,Whatever};
$test = new Test();
var_dump($test->getIterator([1,2,3,4,5]));
$what = new Whatever();
var_dump($what->whatever());
```

Class example:
```
<?php
namespace My\Different\Space;

// you can identify PHP classes like this:
use ArrayObject;
class Test
{
    public function test()
    {
        return __NAMESPACE__;
    }
    public function getArrayObject(array $arr)
    {
        // or: use leading backslash:
        return new \ArrayObject($arr);
    }
}
```
Calling program:
```
<?php
include __DIR__ . '/Test.php';
use My\Different\Space\Test;

// alternatively, you can do this:
// $test = new \My\Different\Space\Test();

$test = new Test();
echo $test->test();

$arr = [1,2,3,4,5];
$obj = $test->getArrayObject($arr);
var_dump($obj);
```
Cannot yet assign a new object instance when you declare a property.
* Instead you need to make the new object property inside the class construct method
```
<?php
class UserEntity {
    public const TABLE = 'user';

    // Properties
    public int $id = 0;
    protected string $firstName = '';
    protected string $lastName  = '';

    // "new" is not yet allowed in PHP 8
    // this doesn't work:
    // public DateTime $time = new DateTime();

	// do this instead:
    public DateTime $time;

	public function __construct()
	{
		$this->time = new DateTime();
	}
    public function getFirstName() :string {
        return $this->firstName;
    }
}

$user = new UserEntity();
echo $user->time->format('l, d M Y');
echo PHP_EOL;

```
You can call methods internally using `$this`
```
<?php
class UserEntity {
    protected $firstName, $lastName;
    // Method
    public function getFirstName() :string {
        return $this->firstName;
    }
    // Method
    public function getLastName() :string {
        return $this->lastName;
    }
    // Method
    public function getFullName() :string {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }
}
```

Call methods from inside a class: use `$this`
```
<?php
class Test
{
    protected string $first = 'fred';
    protected string $last  = 'flintstone';
    public function getFirst()
    {
        return ucfirst($this->first);
    }
    public function getLast()
    {
        return ucfirst($this->last);
    }
    public function getName()
    {
        return $this->getFirst() . ' ' . $this->getLast();
    }
}
$test = new Test();
echo $test->getName();
```
Example using `__construct()`
```
<?php
class UserEntity {
    protected string $firstName;
    protected string $lastName;
    public function __construct($firstName, $lastName) {
        $this->firstName = $firstName ;
        $this->lastName = $lastName ;
    }
    public function getName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}

$user[] = new UserEntity('Jack' , 'Ryan');
$user[] = new UserEntity('Monte' , 'Python');
foreach ($user as $obj)
    echo $obj->getName() . "\n";
```
Constructor argument promotion example:
```
<?php
class Test
{
    // contructor argument promotion
    // only in PHP 8.0 and above
    public function __construct(public string $first = '', public string $last = '')
    {
        // do nothing
    }
    public function getFirst()
    {
        return ucfirst($this->first);
    }
    public function getLast()
    {
        return ucfirst($this->last);
    }
    public function getName()
    {
        return $this->getFirst() . ' ' . $this->getLast() . "\n";
    }
}
$test1 = new Test('Fred', 'Flintstone');
echo $test1->getName();

$test2 = new Test('Wilma', 'Flintstone');
echo $test2->getName();

var_dump($test1, $test2);
```
Use the `__construct()` method when you have a "hard" dependency
* Something that if it doesn't exist, it doesn't make sense to even create the instance
* Example: https://github.com/laminas/laminas-db/blob/master/src/TableGateway/TableGateway.php

Example using `get_object_vars()` to return JSON representation of object properties
```
<?php

class UserEntity {
    public function __construct(
        public string $firstName,
        public string $lastName
    ) {}
    public function getJson()
    {
        return json_encode(get_object_vars($this), TRUE);
    }
}

$user1 = new UserEntity('Jack' , 'Ryan');
$user2 = new UserEntity('Monte' , 'Python');

echo $user1->getJson();
echo PHP_EOL;
echo $user2->getJson();

```

Inheritance example:
```
//             Transportation
//                   $capacity + $passengers
//    Land           Sea                   Air
//     etc.
//  Car  Truck    Sailboat Freighter   PropPlane   Jet
//   etc.
```

Practical anonymous class example:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php
* Example of returning data in object form with 2 different rendering methods: JSON or array
```
<?php
class UserEntity {
    public function __construct(
        public string $firstName,
        public string $lastName
    ) {}
    public function getData()
    {
        return new class(get_object_vars($this))
        {
			public array $data = [];
            public function __construct(...$vars)
            {
				$this->data = $vars;
			}
            public function getJson()
            {
                return json_encode($this->data, TRUE);
            }
            public function getArrayCopy()
            {
                return $this->data;
            }
        };
    }
}

$user1 = new UserEntity('Jack' , 'Ryan');
$user2 = new UserEntity('Monte' , 'Python');

echo $user1->getData()->getJson();
echo PHP_EOL;
var_dump($user2->getData()->getArrayCopy());
```
Overriding method example rewritten so that it works:
```
<?php
// The superclass
class UserEntity {
    protected string $firstName;
    protected function setFirstName ($firstName) {
        $this->firstName = $firstName;
    }
}

// The subclass
class GuestUser extends UserEntity {
    protected string $mi;
    public function setFirstName($firstName, $mi = null) {
        $this->firstName = (!$mi) ? $firstName : $firstName . ' ' . $mi;
    }
    public function getFirstName()
    {
		return $this->firstName;
	}
}

$guest = new GuestUser();
$guest->setFirstName('Fred', 'J');
echo $guest->getFirstName();
```

Restrictions when overriding a method:
* When overriding a method, you can "expand" the data type in the signature
* But you can't "narrow" it down
* You are free to add additional arguments as long as you respect the data types of the original args
* OR ... just remove the data type entirely which frees you from any restrictions
```
<?php
class Base
{
    public int $a;
    public int $b;
    public function add(int $a, int $b)
    {
        return $a + $b;
    }
}

//
class Whatever extends Base
{
    // this works:
    public function add(int|float $a, int|float $b, int|float $c = 0)
    {
        return $a + $b + $c;
    }
    /*
    // this does *not* work:
    public function add(float $a, float $b, float $c = 0)
    {
        return $a + $b + $c;
    }
    */
}

$what = new Whatever();
echo $what->add(1, 2, 3);

```

## Magic Methods
Example of `__toString()`
```
<?php

class UserEntity {
    public function __construct(
        protected string $firstName,
        protected string $lastName) {
    }

    public function __toString(): string {
        //return get_class($this);
        return json_encode(get_object_vars($this), TRUE);
    }
}

$userEntity = new UserEntity('Mark', 'Watney');
//echo $userEntity;

$reflect = new ReflectionObject($userEntity);
echo $reflect;

// NOTE: this is what you'll see in the 1st of Reflection:
// Object of class [ <user> class UserEntity implements Stringable ] {
// This interface is automatically assigned by PHP 8 and above
// as long as you define __toString()
```
Examples of `__get()` and `__set()`
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_get_set.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_get_set_unlimited_properties_controlled.php

Example of `__destruct()`
* https://github.com/dbierer/filecms-core/blob/main/src/Common/Image/Captcha.php

Serialization example:
```
<?php
class UserEntity
{
    public $status = ['A','B','C'];
    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected float $balance,
        protected int $id
    ) {}
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
$user = new UserEntity('Fred', 'Flintstone', 999.99, 101);
$text = serialize($user);
//$text = json_encode($user);
echo $text . "\n";
$obj = unserialize($text);
//$obj = json_decode($text);
echo $obj->getFullName() . "\n";
var_dump($obj);

```
Example of `__sleep()` and `__wakeup()`
```
<?php
class UserEntity {
    public $hash = '';
    public function __construct(
        protected string $firstName,
        protected string $lastName)
    {
        $this->hash = bin2hex(random_bytes(8));
    }
    public function __sleep()
    {
        return ['firstName','lastName'];
    }
    public function __wakeup()
    {
        $this->hash = bin2hex(random_bytes(8));
    }
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    public function getNativeString(): string {
        return serialize($this);
    }
}
$userEntity = new UserEntity('Mark', 'Watney');
var_dump($userEntity);
echo PHP_EOL;

$native = $userEntity->getNativeString();
$obj  = unserialize($native);
echo $native;
echo PHP_EOL;
var_dump($obj);
```
Example of `__serialize()` and `__unserialize()`
```
<?php
class UserEntity {
    public $hash = '';
    public function __construct(
        protected string $firstName,
        protected string $lastName)
    {
        $this->hash = bin2hex(random_bytes(8));
    }
    public function __serialize()
    {
		$vars = get_object_vars($this);
		$vars['sleep_date'] = date('Y-m-d H:i:s');
		unset($vars['hash']);
        return $vars;
    }
    public function __unserialize($array)
    {
        // $array contains values restored from the serialization
		foreach ($array as $var => $val) {
			if ($var === 'sleep_date') continue;
			$this->$var = $val;
		}
        $this->hash = bin2hex(random_bytes(8));
    }
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    public function getNativeString(): string {
        return serialize($this);
    }
}
$userEntity = new UserEntity('Mark', 'Watney');
var_dump($userEntity);
echo PHP_EOL;

$native = $userEntity->getNativeString();
$obj  = unserialize($native);
echo $native;
echo PHP_EOL;
var_dump($obj);
```
Example of when getters and setters are useful:
```
class Test
{
    protected $date;
    const DEFAULT_FMT = 'Y-m-d H:i:s';
    // use getters and setters if there's a need for further processing
    public function setDate(string $str) : void
    {
        $this->date = new DateTime($str);
    }
    public function getDate(string $fmt = self::DEFAULT_FMT) : string
    {
        return $this->date->format($fmt);
    }
}
```
Example of controlled unlimited properties
```
<?php
class Test
{
    public const FIELDS = ['fname','lname','balance'];
    public $vars = [];
    // Returns an inaccessible property
    public function __set($key, $value) {
        if (in_array($key, self::FIELDS)) {
            $this->vars[$key] = $value;
        }
    }
    public function __get($key) {
        return $this->vars[$key] ?? '';
    }
}

$test = new Test();
$test->fname = 'Fred';
$test->lname = 'Flintstone';
$test->balance = 999.99;
$test->doesNotExist = 'TEST';
echo $test->fname . ' ' . $test->lname
     . ' has a balance of ' . $test->balance
     . ' and ' . $test->doesNotExist;
```
Example of `__destruct()`
```
<?php
class Test1
{
	public function __destruct()
	{
		echo __CLASS__ . ':' . microtime(TRUE) . PHP_EOL;
	}
}
class Test2
{
	public function __destruct()
	{
		echo __CLASS__ . ':' . microtime(TRUE) . PHP_EOL;
	}
}
class Test3
{
	public function __destruct()
	{
		echo __CLASS__ . ':' . microtime(TRUE) . PHP_EOL;
	}
}
class Test4
{
	public function __destruct()
	{
		echo __CLASS__ . ':' . microtime(TRUE) . PHP_EOL;
	}
}

$test1 = new Test1();
$test2 = new Test2();
$test3 = new Test3();
$test4 = new Test4();

unset($test1);
$test2 = NULL;
echo 'Last Line: ' . __LINE__ . PHP_EOL;
// actual output:
/*
Test1:1694104612.2758
Test2:1694104612.276
Last Line: 38
Test4:1694104612.276
Test3:1694104612.276
*/
```

Other examples of magic methods:
* https://github.com/dbierer/classic_php_examples/tree/master/oop
* Look for `oop_magic*.php`

Example of Abstract class with abstract method:
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractActionController.php
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractRestfulController.php

Interface example:
```
<?php
interface ServiceInterface {
    public function getService(string $key);
    public function setService(string $key, callable $service);
}

abstract class AbstractController implements ServiceInterface {
    public const FORMAT = 'l, d M Y H:i:s';
    protected array $services = [];
}

class MvcController extends AbstractController
{
    public function getService(string $key)
    {
        return $this->services[$key] ?? NULL;
    }
    public function setService(string $key, callable $service)
    {
        $this->services[$key] = $service;
    }
}

$callback = new class () {
    protected $date = NULL;
    public function __construct()
    {
        $this->date = new DateTime('now');
    }
    public function __invoke()
    {
        return $this->date->format(AbstractController::FORMAT);
    }
};

$controller = new MvcController();
$controller->setService('date', $callback);
echo $controller->getService('date')();
```
Example of "type widening"
* The subclass can have a data type that's "wider" than the super class
```
<?php
interface TestInterface
{
    public function doIterate(array $arr) : string;
}

class Test implements TestInterface
{
    // you could also use "iterable" as a data type
    // which is a combo of array|Traversable
    public function doIterate(iterable $arr) : string
    {
        $output = '';
        foreach ($arr as $item) $output .= $item . PHP_EOL;
        return $output;
    }
}

$test = new Test();
$arr = range('A','F');
echo $test->doIterate($arr);
echo $test->doIterate(new ArrayIterator($arr));
```

Examples of what is `callable`
* https://github.com/dbierer/classic_php_examples/blob/master/oop/callable_examples.php
```
<?php
function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

$anon = function ($a,$b) {
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
};

$class = new class() {
    public function __invoke($a,$b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }
};

$a = array(3, 2, 5, 6, 1);

usort($a, $class);

foreach ($a as $key => $value) {
    echo "$key: $value\n";
}

```
* Another example of what is considered callable:
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

$anon = new class() {
    public function __invoke(array $params)
    {
        return 'The sum is: ' . array_sum($params);
    }
};

$stat = new class() {
    public function sum(array $params)
    {
        return 'The sum is: ' . array_sum($params);
    }
};

class Whatever
{
    public static function sum(array $params)
    {
        return 'The sum is: ' . array_sum($params);
    }
}


$test = new Test;
echo $test->callIt($callback, $operands);
echo PHP_EOL;
echo $test->callIt('array_sum', $operands);
echo PHP_EOL;
echo $test->callIt($anon, $operands);
echo PHP_EOL;
echo $test->callIt([$stat, 'sum'], $operands);
echo PHP_EOL;
echo $test->callIt('Whatever::sum', $operands);
```
Type `int` can "widen" to `float` without any loss of precision
```
<?php
declare(strict_types=1);
class Test
{
    public function add(float $a, float $b)
    {
        return 'The sum is: ' . ($a + $b);
    }
}

$test = new Test();
// still works OK: int --> float doesn't lose precision
echo __LINE__ . ':' . $test->add(2, 2);
echo PHP_EOL;
echo __LINE__ . ':' . $test->add(2.555, 2.666);
echo PHP_EOL;
```
If `declare(strict_types=1)` is not in effect, it does a soft typecast
```
<?php
//declare(strict_types=1);
class Test
{
    public function add(float $a, float $b) : float
    {
        return $a + $b;
    }
}

$test = new Test();
// works OK
echo __LINE__ . ':' . $test->add(2, 2);
echo PHP_EOL;

// works OK
echo __LINE__ . ':' . $test->add(2.555, 2.666);
echo PHP_EOL;

// works OK
echo __LINE__ . ':' . $test->add('2.555', '2.666');
echo PHP_EOL;

// Fatal Error
echo __LINE__ . ':' . $test->add('x2.555', 'x2.666');
echo PHP_EOL;
```
Example of going from a specific data type to a more general data type
```
<?php
interface Foo {
    public function test(array $input);
}

class Bar implements Foo {
    // type omitted for $input
    public function test(iterable $input) {
        $text = '';
        foreach($input as $item) $text .= ' ' . $item;
        return 'You requested ' . trim($text);
    }
}

$bar = new Bar();
echo $bar->test(['A','B','C']);
echo $bar->test(new ArrayIterator(['A','B','C']));
```
* Using `static` to get an instance of the lowest level in inheritance tree
```
<?php
class Foo
{
    public function whatever()
    {
        return 'Whatever';
    }
    public function getInstance() : static
    {
        // this returns an error:
        // return new self();
        return new static();
    }
}
class Bar extends Foo {}

$foo = new Foo();
$bar = new Bar();
var_dump($foo->getInstance());    // Foo
var_dump($bar->getInstance());    // Bar
```
Exception / Error example:
```
<?php
try {
    $pdo = new PDO('sqlite://xyz');
} catch (PDOException $a) {
    // catches PDOException
    echo __LINE__ . ':' . get_class($a) . ':' . $a . "\n";
} catch (Exception $a) {
    echo __LINE__ . ':' . get_class($a) . ':' . $a . "\n";
} catch (Error $a) {
    echo __LINE__ . ':' . get_class($a) . ':' . $a . "\n";
}

try {
    $pdo = new PDO();
} catch (PDOException $a) {
    echo __LINE__ . ':' . get_class($a) . ':' . $a . "\n";
} catch (Exception $a) {
    echo __LINE__ . ':' . get_class($a) . ':' . $a . "\n";
} catch (Error $a) {
    // catches Error
    echo __LINE__ . ':' . get_class($a) . ':' . $a . "\n";
}
// actual output:
/*
6:PDOException:PDOException: SQLSTATE[HY000] [14] unable to open database file in C:\Users\ACER\Repos\classic_php_examples\oop\test.php:3
Stack trace:
#0 C:\Users\ACER\Repos\classic_php_examples\oop\test.php(3): PDO->__construct()
#1 {main}
21:ArgumentCountError:ArgumentCountError: PDO::__construct() expects at least 1 argument, 0 given in C:\Users\ACER\Repos\classic_php_examples\oop\test.php:14
Stack trace:
#0 C:\Users\ACER\Repos\classic_php_examples\oop\test.php(14): PDO->__construct()
#1 {main}
*/

```
Using `static` functionality to get a singleton instance
* https://github.com/dbierer/filecms-core/blob/main/src/Common/Generic/Messages.php
Other examples of `static` and `traits`
* https://github.com/dbierer/classic_php_examples/tree/master/oop/*static*.php
* https://github.com/dbierer/classic_php_examples/tree/master/oop/*trait*.php

Simple Trait example
```
<?php
trait TestTrait
{
    public function test()
    {
        return 'TRAIT';
    }
}

class Top
{
    use TestTrait;
}

class Child extends Top
{
}

$top = new Top();
$child = new Child();

echo $top->test();
echo PHP_EOL;
echo $child->test();

```

## PDO
Adding options as 4th argument:
```
try {
    // Get the connection instance
    $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=phpcourse', 'vagrant', 'vagrant', $opts);
    // Statements ...
} catch (PDOException $e ){
    // Handle exception...
}
```
To find the exact DSN for a given database in PDO, look at the Driver class documentation
* Example: DSN for PostgreSQL: https://www.php.net/manual/en/ref.pdo-pgsql.connection.php
Example of handling a large result set:
```
try {
    // Execute a one-off SQL statement and get a statement object
    $stmt = $pdo->query('SELECT * FROM orders');

    // Returns an associative array indexed by column name
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC) {
        // do something with the resulting row
    }

} catch (PDOException $e){
    //Handle error
}
```
Alternative way to execute without using `bindParam()`
* Modifies: https://github.com/ealebrun/PHPII/blob/main/HW-2022-04-27
```
$data = [
    'eventTitle' => 'Wagner, Bryant',
    'eventURL' => 'http://bryant.prestosports.com/sports/bsb/2021-22/schedule#6irpaohben8y4ati',
    'eventDescription' => 'Baseball on May 21, 2022 at 3:00 PM: Wagner, Bryant, Conaty Park',
    'eventCategory' => 'Baseball',
    'eventDateString' => 'Sat, 21 May 2022 19:00:00 GMT',
    'eventGUID' => 'http://bryant.prestosports.com/sports/bsb/2021-22/schedule#6irpaohben8y4at',
    'eventOpponent' => 'Wagner',
];
$stmt->execute($data);
```
Example of `PDO::FETCH_CLASS` mode:
* See: https://github.com/dbierer/classic_php_examples/blob/master/db/db_pdo_fetch_class.php

## Output Buffering
To start output buffering automatically, in the `php.ini` file:
```
// sets buffer size to 4K + activates it
output_buffering=4096
```
* See: https://www.php.net/manual/en/outcontrol.configuration.php#ini.output-buffering
## Email
Headers can include any valid headers as per RFC 2822
* See: http://www.faqs.org/rfcs/rfc2822

## Regex
Alternatives to finding chars at beginning or end of a string:
```
<?php
$str = '/home/doug/whatever/';

// Any PHP above 4
echo ($str[0] ==='/') ? 'Y' : 'N';
echo ($str[-1] ==='/') ? 'Y' : 'N';

// PHP 8
echo (str_starts_with($str,'/')) ? 'Y' : 'N';
echo (str_ends_with($str,'/')) ? 'Y' : 'N';
```
Examples using sub-patterns
```
<?php
$str = '<p>One</p><p>Two</p><p>Three</p>';
$pat = '/<p>(.*?)<\/p>/';
preg_match_all($pat, $str, $match);
var_dump($match);


$str = 'Click here to go to <a target="_blank" href="http://zend.com/">Zend</a>!';
$pat = '/<a.*?href=("|\')(.*?)("|\').*?>/';
preg_match_all($pat, $str, $match);
var_dump($match);
```
Example email validation
```
<?php
$email = [
    'oishin@gmail.com',
    'douglas.bierer@company.com',
    'george@some.company.com',
    'joe25@dc.ie',
    'noona@some.company.co.th',
    'invalid&/*@company',
    '2abc@abc.com',
];
$pattern = '/^[a-z][a-z0-9.-]*@([a-z0-9]+\.)+[a-z]{2,4}$/i';
foreach ($email as $item) {
    echo $item . ' [';
    echo (preg_match($pattern, $item)) ? 'VALID' : 'INVALID';
    echo ']' . PHP_EOL;
}
```
## Composer
Example of advanced usage including scripts
* https://github.com/laminas/laminas-mvc-skeleton/blob/master/composer.json
You can add alternates to `packagist.org` using the `repositories` key in the composer.json file
* Example: https://wpackagist.org/
If you dependency issues, consider adding the `--ignore-platform-reqs` to the `composer install` or `composer update` directive
* This is especially true if you're running 8.1 or 8.2 and the packagist project is set for PHP 7.4 or 8.0

## Web Services
Example of SOAP Client
* https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php
How to generate an HTTP `PUT`, `POST`, etc.
* See: https://www.php.net/stream_context_create
```
<?php
$data = array ('foo' => 'bar', 'bar' => 'baz');
$data = http_build_query($data);
$context_options = array (
        'http' => array (
            'method' => 'POST',
            'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data
            )
        );

$context = stream_context_create($context_options)
$fp = fopen('https://url', 'r', false, $context);
```
Study by Oracle that compares SOAP and REST
* https://www.ateam-oracle.com/post/performance-study-rest-vs-soap-for-mobile-applications
## Output Control
Example using output buffering to create inner content
```
<?php
ob_start ();

$values = ['TH'=>'Thailand','GB'=>'Great Britain','FR'=>'France'];
foreach ($values as $key => $val)
    echo '<tr><th>' . $key . '</th><td>' . $val . '</td></tr>';

$contents = ob_get_clean();

echo '<h1>My Cool Webpage</h1>';
echo '<table>';
echo $contents;
echo '</table>';
```
Simplified ETag Example:
* See: https://github.com/dbierer/classic_php_examples/blob/master/web/etag.php

## Regex
Example of searching for a specific file name pattern in a directory
```
<?php
$list = scandir(__DIR__);
var_dump($list);
$pattern = '/^exam.*\.php$/';
foreach ($list as $item) {
    echo $item . ': ';
    preg_match($pattern, $item, $match);
    echo (!empty($match[0])) ? 'MATCH' : '';
    echo PHP_EOL;
}

```

Misc examples
```
<?php
$data = [
    '/^[A-Z].*/'     => ['The quick brown fox', '12345'],
    '/.*(jpg|png)$/' => ['image.png', 'info.php'],
    '/\bERROR\b/'    => ['ERROR 309: undefined error','This contains ERROR_REPORTING'],
    '/^[A-Za-z ]*$/'  => ['The quick brown fox', '9977 quick brown foxes'],
    '/^[^A-Za-z]*$/' => ['997799989887777','The quick brown fox'],
    '!^http(s)?://\w*!i' => ['https://zend.com','http://sandbox','ftp://whatever.com'],
];

foreach ($data as $pattern => $value) {
    foreach ($value as $item) {
        echo "Testing $item\n";
        echo (preg_match($pattern, $item)) ? 'MATCH' : 'NO MATCH';
        echo PHP_EOL;
    }
}
```
Shows the use of "?" to indicate an optional "s"
```
<?php
$list = [
    'http://zend.com',
    'https://www.perforce.com',
    'ftp://unlikelysource.com',
    'file:///some/path/to/file',
];
// searches for http:// or https://
$pattern = '!^https?://\w*!i';
foreach ($list as $item) {
    echo $item . ': ';
    preg_match($pattern, $item, $match);
    echo (!empty($match[0])) ? 'MATCH' : '';
    echo PHP_EOL;
}

```
Example of `preg_replace()`
```
<?php
$test = '<script>alert("test");</script>';
$pattern = ['/</','/>/','/;/'];

echo preg_replace($pattern, '', $test);
echo PHP_EOL;
// output: "scriptalert("test")/script"

$test = '$script{"alert"} = "script"';
$pattern = ['/{/','/}/'];
$replace = ['[', ']'];
echo preg_replace($pattern, $replace, $test);
// $script["alert"] = "script"
```

PHP 5 to PHP 7 code converter using `preg_replace_callback_array()`
* https://github.com/dbierer/php7cookbook/blob/master/source/chapter01/chap_01_php5_to_php7_code_converter.php#L3
* https://github.com/dbierer/php7cookbook/blob/master/source/Application/Parse/Convert.php

## Change Request
* http://php-oop/#/3/15
  * Cannot yet assign a new instance in the property declaration
* http://localhost:8882/#/3/22
  * "Some Mark Watney"???
* http://localhost:8882/#/3/112 (PDF pg. 133)
  * Last example s/be:
```
Class Vehicle {
    use GroundVehicleTrait, AirVehicleTrait {
        GroundVehicleTrait::getType insteadof AirVehicleTrait;
        AirVehicleTrait::getType as getAirType;
    }
}
```
* http://localhost:8882/#/5/21
  * s/be One-to-Many:: How a single table row maps to multiple rows in another table.
* http://localhost:8882/#/3/123
  * s/be "Class" (leave it at that)
* http://localhost:8882/#/6/4
  * `$contents` is overwritten: typo?

## Q & A
* Q: Can you use the keyword "new" in property or const definition in 8.1?
* A: Yes, but with restrictions.
* A: Full discussion: https://wiki.php.net/rfc/new_in_initializers

* Q: Locate original article on why `__unserialize()` was introduced
* A: https://wiki.php.net/rfc/custom_object_serialization

* Q: URL for database survey website
* A: https://db-engines.com/en/ranking

* Q: Find example of multi-use PDO prepare/execute for Geonames data insert
* A: Will be published here by next week (not published yet):
  * https://github.com/dbierer/classic_php_examples/blob/master/db/db_pdo_multi_prepare_execute_create_geonames_table.php

* Q: Where can I find more PDO examples?
* A: See: https://github.com/dbierer/classic_php_examples/tree/master/db

* Q: Why are we not getting the "headers already sent" error in the VM?
* A: You need to set error reporting in the `php.ini` file:
```
error_reporting=E_ALL
display_errors=on
```
* Q: What are the typical settings for `max-age` in this header:
```
header('Cache-Control: must-revalidate, max-age=0');
```
* A: See: https://stackoverflow.com/questions/1046966/whats-the-difference-between-cache-control-max-age-0-and-no-cache
* A: See: https://stackoverflow.com/questions/18148884/difference-between-no-cache-and-must-revalidate-for-cache-control
* A: See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control

* Q: Can you find an example of using `__call()?`
* A: https://github.com/laminas/laminas-mvc/blob/3.6.x/src/Controller/AbstractController.php
  * Look for `public function __call($method,$params)`

* Q: Can you create an object instance when first declaring a property in PHP 8.1 or 8.2?
* A: Not as of yet. See this example:
```
<?php
class Test
{
    const FORMAT = 'l, d M Y';
    // this doesn't work:
    // public $time = new DateTime();
    // this DOES work:
    public function __construct(public DateTime $time = new DateTime()) {}
    public function getTime()
    {
        return $this->time->format(self::FORMAT);
    }
}
$test = new Test();
echo $test->getTime();
```


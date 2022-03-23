# PHP-II Class Notes -- Mar 2022

## Homework
* For Wed 23 Mar 2022: https://collabedit.com/kh4b6
* For Fri 25 Mar 2022: https://collabedit.com/y5ea7

## Q & A
* Q: Example of a class that implements multiple interfaces?

* Q: Example of different "callable" types

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
	public string $media;	// space, air, land, surface, under water
}
class Sea extends Transportation
{
	public string $steering;	// rudder, hydroplane, etc.
	public string $waterTightCompartments;
}
class Land extends Transportation
{
	public string $engineSize = 0;	// litres
	public int $numberPassengers = 0;
	public int $numberWheels = 0;
	public string $fuelType = '';	// petrol, electricity, etc.
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
echo var_dump($a);	// Instance of Test
echo var_dump($b);  // Instance of Xyz
```

## Errata
* http://localhost:8888/#/3/23
  * s/be `$this->lastName = $lastName ;` not `$this->lastnNme = $lastName ;`

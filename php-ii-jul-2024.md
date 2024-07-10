# PHP II - Jul 2024

## To Do
* Export to find `Stringable` interface???

## Homework
For Fri 12 Jul 2024
* Lab: Create an Extensible Super Class
Complete the following:
* Using the code created in the previous exercise, create an extensible superclass definition. Set the properties and methods that subclasses will need.
* Create one or more subclasses that extend the superclass with constants, properties and methods specific to the subclass.
* Instantiate a couple of objects from the subclasses and execute the methods producing some output.
* Lab: Magic Methods
Complete the following:
* Using the code from the previous exercises, add four magic methods, one of which is the magic constructor.
* The magic constructor should accepts parameters and set those parameters into the object on instantiation.
* Create an index.php file.
* Load, or autoload, the created classes.
* Instantiate object instances, and exercise the magic methods implemented.

For Weds 10 Jul 2024
* Install the course VM (or equivalent)
* Lab: Namespace: Have a look at the OrderApp in the course VM.
  * Identify what namespaces are used
  * How does the OrderApp do its autoloading?
* Lab: Create a Class
* Location of the database in the ZIP file:
  * User: "vagrant"
  * Password: "vagrant"
  * DB name: "phpcourse"
```
/path/orderapp/data/sql/phpcourse.sql
```

## VM Notes
The vagrant setup process can take up to 1 or 2 hours depending on your network connection.
For most situations, where you have an adequate computer and an Internet connection of 100 MBPS or greater, it should complete in less than a hour.

### Updates
When you first bring up the VM, after a few minutes you'll see a prompt to "Update Software"
* Select "Yes" and let it run
* It will take several hours to complete so it's best to let it run overnight.
You'll also see a prompt to "Upgrade the OS"
* Select "No" for this

Accept New Configuration
* At some point you will be asked if you wish to retain the original php.ini configuration or accept the new.
* Go ahead and accept the new configuration.

### Vagrant Up Stops
Depending on your system, you might run into an ssh key/value pair error during the `vagrant up` process.
Try the following:
* In the VM toggle the network connection (lower right) on and off
* If the VM has partially started, click "Reset" under the "Machine" top left menu option
* If that doesn't work, and you're sitting at the command prompt, try the following:
```
vagrant up --provision
```

### Housekeeping
When you've completed the vagrant provisioning process, you might want to do the following:
* Remove unneeded icons from the "Favorites" toolbar to the left side of the screen
* Configure the editor (Geany):
  * Click the "Apps" menu (lower left corner of the screen)
  * In the search box type "Geany"
  * Once Geany comes up, you can add it to the Favorites by right-clicking your mouse and selecting "Add to favorites"
  * To get Geany to run PHP scripts directly:
    * Select "Build" and "Set Build Commands"
    * Next to "Execute," in the "Command" column, enter: `php ./%e`

### Other Stuff
Snapshot
* Be sure to take a snapshot of the VM before you start any of the labs!

System Problem
* If you see this message: `System program problem detected`
* Do this:
```
sudo rm -r /var/crash*
```

## Resources
Constants
* Predefined: https://www.php.net/manual/en/reserved.constants.php
* Magic: https://www.php.net/manual/en/language.constants.magic.php
Code examples:
* https://github.com/dbierer/classic_php_examples
Where it all started:
* Seminal work: "Design Patterns: Elements of Reusable Object-Oriented Software"
Coding Standards: PSR-1 and PSR-12
* https://www.php-fig.org/psr/
ZendPHP Info
* Docker Images: https://help.zend.com/zendphp/current/content/orchestration/docker.htm
* https://help.zend.com/zendphp/current/content/introduction/introduction.htm
PHP Roadmap
* https://wiki.php.net/rfc
* Migration Guides:
  * https://www.php.net/manual/en/appendices.php
Automated WordPress installation using Composer:
* https://github.com/dbierer/automated_wp_installation/blob/main/install_wp_on_hosting_account.sh
Example of rendering content body inside a layout:
* https://github.com/dbierer/filecms-core/blob/main/src/Common/View/Html.php
Database examples:
* https://github.com/dbierer/classic_php_examples/tree/master/db

## Class Notes
### Namespaces
Namespace standard: PSR-4
* https://www.php-fig.org/psr/psr-4/

Simple example:

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
Here's the example from the OrderApp, `index.php` which is in `public`:
```
spl_autoload_register(
    function ($class) {
        $file = str_replace('\\', '/', $class) . '.php';
        require BASE . '/src/' . $file;
    }
);
```
Other autoloading example:
```
<?php
function loader($class) {
	echo $class . PHP_EOL;
	$fn = __DIR__ . '/' . str_replace('\\','/',$class) . '.php';
	require_once($fn);
}
spl_autoload_register('loader');

use X\Caller;

$caller = new Caller();
echo $caller->call_Z();
echo PHP_EOL;
echo $caller->call_A();

// actual output:
/*
X\Caller
X\Y\Z\Test
X\Y\Z:X\Y\Z\Test:X\Y\Z\Test::test
X\Y\A\Test
X\Y\A:X\Y\A\Test:X\Y\A\Test::test
*/
```
"Caller" class
```
<?php
namespace X;

use X\Y\Z\Test as ZTest;
use X\Y\A\Test as ATest;

class Caller
{
	public function call_Z()
	{
		// enclosing "new" in parentheses creates instance and allows its immediate use
		return (new ZTest())->test();
	}
	public function call_A()
	{
		// alternatively, you can do this:
		$test = new ATest();
		$result = $test->test();
		unset($test);
		return $result;
	}
}

```
Example of class using constants:
* https://github.com/dbierer/filecms-core/blob/main/src/Common/Generic/Messages.php

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
You can pre-assign values when using constructor argument promotion:
```
<?php
class UserEntity
{
	public DateTime $date;
    public function __construct(public string $firstName = '', public string $lastName = '')
    {
		$this->date = new DateTime();
    }
}
$user[] = new UserEntity('Jack' , 'Ryan');
$user[] = new UserEntity('Monte' , 'Python');
$user[] = new UserEntity('Uhoh');

var_dump($user);

// example output for last element:
/*
 *  [2]=>
  object(UserEntity)#5 (3) {
    ["date"]=>
    object(DateTime)#6 (3) {
      ["date"]=>
      string(26) "2024-07-08 12:44:37.215814"
      ["timezone_type"]=>
      int(3)
      ["timezone"]=>
      string(3) "UTC"
    }
    ["firstName"]=>
    string(4) "Uhoh"
    ["lastName"]=>
    string(0) ""
  }
}
*/
```
`Private` properties are not supposed to be visible to a child class ... however ...
```
<?php
class Test
{
	private string $name = 'Fred';
	public function getName()
	{
		return $this->name;
	}
}

class Child extends Test {}

$child = new Child();
echo $child->getName();

// actual output: "Fred"
```

Creation of dynamic properties is now deprecated (soon to be removed)
```
<?php
class UserEntity
{
    public function __construct(
		protected string $firstName,
		protected string $lastName)
    {
		// do nothing
    }
    public function init()
    {
		$this->time = new DateTime();
    }

}
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$user1 = new UserEntity('Jack' , 'Ryan');
$user2 = new UserEntity('Monte' , 'Python');
$user1->init();
$user2->init();

var_dump($user1, $user2);

// PHP Deprecated:  Creation of dynamic property UserEntity::$time
// is deprecated in /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php on line 12
```

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
//			Tires					Sea
//			$tires					$rudder
//    Land       Air    			Sailboat Freighter
//  Car  Truck   PropPlane   Jet
//   etc.
```
Using `parent::` example:
```
<?php
class Base
{
    protected string $lastName;
    public function __construct(string $lastName)
    {
        $this->lastName = $lastName;
    }
    public function init(string $lastName)
    {
        $this->lastName = $lastName;
	}

}


class UserEntity extends Base
{
    protected string $firstName;
    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        parent::__construct($lastName);
    }
    public function init(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        parent::init($lastName);
	}
}

// The subclass
class GuestUser extends UserEntity {
    protected string $role;
    public function __construct(string $firstName, string $lastName, $role)
    {
        $this->role = $role;
    }
    public function init(string $firstName, string $lastName)
    {
        parent::init($firstName, $lastName);
	}
}
```

Practical anonymous class example:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php
Example of returning data in object form with 2 different rendering methods: JSON or array
```
<?php

class UserEntity {
    public function __construct(
        public string $firstName,
        public string $lastName
    ) {}
    public function getData()
    {
        return new class($this->firstName, $this->lastName)
        {
            public function __construct(public string $firstName, public string $lastName)
            {}
            public function getJson()
            {
                return json_encode(get_object_vars($this), TRUE);
            }
            public function getArrayCopy()
            {
                return get_object_vars($this);
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
Difference between `stdClass` and an Anonymous class:
```
<?php
$obj = new stdClass();
$obj->name = 'Fred';
$obj->status = 'OK';

var_dump($obj);

$anon = new class('Fred', 'OK') {
	public function __construct(public string $name, public string $status) {}
	public function isOK()
	{
		return ($this->status === 'OK');
	}
};

var_dump($anon);
echo ($anon->isOK()) ? 'ALL OK' : 'NOT OK';

// actual output:

/*
 * object(stdClass)#1 (2) {
  ["name"]=>
  string(4) "Fred"
  ["status"]=>
  string(2) "OK"
}
object(class@anonymous)#2 (2) {
  ["name"]=>
  string(4) "Fred"
  ["status"]=>
  string(2) "OK"
}
ALL OK
*/
```

Example of overriding a method:
```
<?php
class UserEntity {
    protected string|null $firstName;
    public function setFirstName ($firstName) {
        $this->firstName = $firstName;
    }
}

// The subclass
class GuestUser extends UserEntity {
    protected ?string $mi;
    public function setFirstName($firstName, $mi = null) {
        $this->firstName = trim($firstName);
		$this->mi = ($mi ?? '');
    }
}

$user1 = new GuestUser();
$user1->setFirstName('Jack');
$user2 = new GuestUser();
$user2->setFirstName('Monte' , 'P');

var_dump($user1, $user2);
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
        return get_class($this);
        // return json_encode(get_object_vars($this), TRUE);
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
Another example of `__toString()`
```
<?php
class Paragraph
{
	public function __construct(public string $text = '') {}
	public function __toString()
	{
		return '<p>' . $this->text . '</p>';
	}
}
class Bold
{
	public function __construct(public string $text = '') {}
	public function __toString()
	{
		return '<b>' . $this->text . '</b>';
	}
}

$text = <<<TAG
This is paragraph 1
This is paragraph 2
This is bold
TAG;

$count = 0;
$html  = '';
foreach (explode("\n", $text) as $line) {
	if ($count++ === 2) {
		$line = new Bold($line);
	}
	echo (new Paragraph($line));
}

// actual output:
// <p>This is paragraph 1</p><p>This is paragraph 2</p><p><b>This is bold</b></p>

```
In PHP 8, any class that defines `__toString()` is automatically associated with the `Stringable` interface
* Adding this code to the example above:
```
$reflect = new ReflectionObject($line);
echo $reflect;
```
* Here's the output:
```
Object of class [ <user> class Bold implements Stringable ] {
  @@ /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php 10-17

  - Constants [0] {
  }

  - Static properties [0] {
  }

  - Static methods [0] {
  }

  - Properties [1] {
    Property [ public string $text ]
  }

  - Dynamic properties [0] {
  }

  - Methods [2] {
    Method [ <user, ctor> public method __construct ] {
      @@ /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php 12 - 12

      - Parameters [1] {
        Parameter #0 [ <optional> string $text = '' ]
      }
    }

    Method [ <user, prototype Stringable> public method __toString ] {
      @@ /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php 13 - 16

      - Parameters [0] {
      }
      - Return [ string ]
    }
  }
}

```

Example of `__destruct()`
* https://github.com/dbierer/filecms-core/blob/main/src/Common/Image/Captcha.php
Also:
```
<?php
class Test
{
	public function __construct(public string $name) {}
	public function __destruct()
	{
		echo __METHOD__ . ':' . $this->name . PHP_EOL;
	}
}

$test1 = new Test('AAA');
$test2 = new Test('BBB');
$test3 = new Test('CCC');

function whatever()
{
	$test4 = new Test('DDD');
}
whatever();

$test1 = NULL;

echo __LINE__ . PHP_EOL;

// actual output:
/*
Test::__destruct:DDD
Test::__destruct:AAA
23
Test::__destruct:CCC
Test::__destruct:BBB
*/
```
Example using `__invoke()` to turn an object into a super powered anonymous function:
```
<?php
class ShowsJson
{
	public function __invoke(array $arr)
	{
		return json_encode($arr, JSON_PRETTY_PRINT);
	}
}

class ShowsHtml
{
	public function __invoke(array $arr)
	{
		$html = '<ul>';
		foreach ($arr as $value) $html .= '<li>' . $value . '</li>';
		$html .= '</ul>';
		return $html;
	}
}

$json = new ShowsJson();
$html = new ShowsHtml();

echo $json(['AAA','BBB','CCC']);
echo PHP_EOL;
echo $html(['AAA','BBB','CCC']);
echo PHP_EOL;
```
Using `__get()` to give you the ability to read a protected, but you are unable to write to the property
* Effectively, this is a read-only property!
* NOTE: readonly properties were introduced in PHP 8.3
```
<?php
class UserEntity {
    public function __construct(
        protected string $firstName,
        protected string $lastName
    ) {}

    // Returns an inaccessible property
    public function __get($value) {
        return $this->$value ?? NULL;
    }
}

$userEntity = new UserEntity('Mark', 'Watney');
echo $userEntity->firstName;
$userEntity->firstName = 'Fred';

// Actual output:
// MarkPHP Fatal error:  Uncaught Error: Cannot access protected property
```
Example using `__set()` as a "dropbox" where you can write the value but not read it
* NOTE: it's recommended to not use this to assign dynamic properties as this feature is deprecated
```
<?php
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
class DropBox
{
	protected $values = [];
    public function __set(string $name, mixed $value)
    {
        $this->values[$name] = $value;
    }
}
$drop = new DropBox();
$drop->key1 = bin2hex(random_bytes(8));
$drop->key2 = bin2hex(random_bytes(8));
$drop->key3 = bin2hex(random_bytes(8));
$drop->key4 = bin2hex(random_bytes(8));

var_dump($drop);

echo $drop->values['key1']; // Fatal Error
```
Example using `__call()` with a Plugin class
```
<?php
class Test
{
	public function __construct(public object $plugin)
	{}
	public function getTest()
	{
		return 'This is coming from ' . __METHOD__;
	}
	public function __call($method, $args)
	{
		if (method_exists($this->plugin, $method)) {
			$result = $this->plugin->$method($args);
		} else {
			$result = 'Undefined';
		}
		return $result;
	}
}
class Plugin
{
	public function doesNotExist()
	{
		return 'This is coming from the plugin manager';
	}
}


$test = new Test(new Plugin());

echo $test->getTest();
echo PHP_EOL;

echo $test->doesNotExist();
echo PHP_EOL;

// actual output:
/*
This is coming from Test::getTest
This is coming from the plugin manager
*/
```

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
class UserEntity
{
    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected float $balance,
        protected int $id,
        protected string $creditCardNum
    ) {}
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    public function getJson()
    {
		return json_encode(get_object_vars($this));
	}
	public function __sleep()
	{
		$_SESSION['cc'] = $this->creditCardNum;
		return ['firstName','lastName','balance','id'];
	}
	public function __wakeup()
	{
		$this->creditCardNum = $_SESSION['cc'] ?? '';
	}
}
session_start();
$user = new UserEntity('Fred', 'Flintstone', 999.99, 101, '1111-2222-3333-4444');
$text = serialize($user);
//$text = $user->getJson();
echo $text . "\n";
$obj = unserialize($text);
//$obj = json_decode($text);
echo $obj->getFullName() . "\n";
var_dump($obj);
```

Another Example of `__sleep()` and `__wakeup()`
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
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'sleep_date' => date('Y-m-d H:i:s')];
    }
    public function __unserialize($array)
    {
        // $array contains values restored from the serialization
        $this->hash = bin2hex(random_bytes(8));
        $this->firstName = $array['firstName'];
        $this->lastName = $array['lastName'];
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
Same example as above except that it encrypts a CC number before serialization
```
<?php
class UserEntity
{
	protected string $key = '';
	protected string $iv  = '';
    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected string $ccNum)
    {
		$this->key  = substr(bin2hex(md5(rand(0,999999))), 0, 32);
		$this->iv   = substr(bin2hex(md5(rand(0,999999))), 0, 32);
    }
    public function __serialize()
    {
		$_SESSION['key'] = $this->key;
		$_SESSION['iv']  = $this->iv;
        return [
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
            'ccNum'     => base64_encode(
				openssl_encrypt(
					$this->ccNum,
					'aes-256-ctr',
					$this->key,
					0,
					substr($this->iv, 0, 16)
				)
			),
            'sleep_date' => date('Y-m-d H:i:s')];
    }
    public function __unserialize($array)
    {
        // $array contains values restored from the serialization
		$this->key = $_SESSION['key'];
		$this->iv  = $_SESSION['iv'];
        $this->ccNum = openssl_decrypt(base64_decode($array['ccNum']), 'aes-256-ctr', $this->key, 0, substr($this->iv, 0, 16));
        $this->firstName = $array['firstName'];
        $this->lastName = $array['lastName'];
    }
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    public function getNativeString(): string {
        return serialize($this);
    }
}
$userEntity = new UserEntity('Mark', 'Watney', '1111-2222-3333-4444');
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
Other examples of magic methods:
* https://github.com/dbierer/classic_php_examples/tree/master/oop
* Look for `oop_magic*.php`

Three important magic methods not covered in the slides
* `__invoke()`
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_invoke_and_tostring.php
* `__destruct()`
  * See: https://github.com/dbierer/filecms-core/blob/main/src/Common/Image/Captcha.php
* `__call()`
	* Often used to implement "plugins"
	* Avoids having to hard code methods into base classes
	* Used to extend the framework without having to rewrite your base source code
	* Example: https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
	  * Look at `__call()`


Example of Abstract class with abstract method:
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractActionController.php
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractRestfulController.php

Abstract class example:
```
<?php
abstract class Base
{
	public const TABLE = '';
	public array $data = [];
	public function __construct(array $data)
	{
		$this->data = $data;
	}
	public abstract function insert() : bool;
	public function getDataAsArray()
	{
		return get_object_vars($this->data);
	}
}

// for each of the following subclasses:
// 1. Create an insert() method
// 2. Build the SQL pertinent to that class
// 3. Send the SQL to the database to insert $this->data

class Order extends Base
{
	public const TABLE = 'orders';
}

class Order_Line_Item extends Base
{
	public const TABLE = 'order_line_item';
}

class Customer extends Base
{
	public const TABLE = 'customers';
}

// output at this point:

/*
 * PHP Fatal error:  Class Order contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Base::insert) in C:\Users\ACER\Desktop\test.php on line 17
*/
```

Examples of classes with interfaces:
* https://github.com/laminas/laminas-db/blob/master/src/Adapter/Adapter.php

Interface example:
```
<?php
interface ServiceInterface {
    public function getService(string $key);
    public function setService(string $key, callable $service);
}
interface TestInterface {
    public function getTest(string $key);
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
// NOTE: TestInterface mandates `getTest(string $whatever)`
//       and inserts itself into the hierarchy at this point.
//       The effect is seen from this point on down the inheritance hierarchy
class TestController extends MvcController implements TestInterface
{
	public function getTest(string $whatever)
	{
		return $whatever;
	}
}


$callback = new class () {
    protected $date = NULL;
    public function __construct()
    {
        $this->date = new DateTime('now');
    }
    // NOTE: by defining `__invoke()` the anonymous class is now considered "callable"
    public function __invoke()
    {
        return $this->date->format(AbstractController::FORMAT);
    }
};

$controller = new TestController();
$controller->setService('date', $callback);
echo $controller->getService('date')();
```
Interfaces can be implemented at any level within an inheritance structure
* They act as "pseudo" superclass
* They are not tied to specific level within the inheritance tree
```
<?php
interface HashInterface
{
	public function generateHash(string $key) : string;
}
abstract class AbstractUser implements HashInterface
{
	public function __construct(public string $fname, public string $lname) {}
}

class OldStyleUser extends AbstractUser
{
	public function generateHash(string $key) : string
	{
		return md5($key);
	}
}

class NewStyleUser extends AbstractUser
{
	public function generateHash(string $key) : string
	{
		return password_hash($key, PASSWORD_DEFAULT);
	}
}

$old = new OldStyleUser('Fred', 'Flintstone');
$new = new NewStyleUser('George', 'Jetson');

//echo $old->generateHash('password');
echo PHP_EOL;
echo $new->generateHash('password');
echo PHP_EOL;
```
This example demonstrates using an interface as a type hint
* Both `Boss` and `Underling` as well as `Whatever` work as arguments to `do_addition()` because they implement the correct interface.
```
<?php
interface AddInterface
{
	public function add(int $a, int $b) : int;
}

class Boss implements AddInterface
{
	public function add(int $a, int $b) : int
	{
		return $a + $b;
	}
}

class Underling extends Boss
{}

class Whatever implements AddInterface
{
	public function add(int $a, int $b) : int
	{
		return $a + $b;
	}
}


function do_addition(AddInterface $obj, $a, $b)
{
	return $obj->add($a, $b);
}

$obj = new Boss();
echo do_addition($obj, 2, 2);

$obj = new Underling();
echo do_addition($obj, 2, 2);

$obj = new Whatever();
echo do_addition($obj, 2, 2);
```

Example of type hinting
```
<?php
// if activated: Fatal Error occurs on line 13
// declare(strict_types=1);
class Test
{
	public function add(int $a, int $b) : int
	{
		return $a + $b;
	}
}

$test = new Test();
echo $test->add(5.55, 6.66);	// output: 11
echo PHP_EOL;

echo $test->add(5, 6);			// output: 11
echo PHP_EOL;

echo $test->add('5', '6');		// output: 11
echo PHP_EOL;

echo $test->add('5x', 'x6');	// output: Fatal Error
echo PHP_EOL;
```
One more example of using interfaces
```
class Order extends Base implements InsertInterface
{
	public const TABLE = 'order_line_item';
	public function insert() : bool
	{
		// some logic for order line items
		return (bool) rand(0,1);
	}
}

class Customer extends Base implements UpdateInterface
{
	public const TABLE = 'customers';
	public function update(array $data) : bool
	{
		// some logic for orders
		return (bool) rand(0,1);
	}
}

class AddToDatabase
{
	// InsertInterface data type gaurantees the "insert()" method
	public function addItem(InsertInterface $item)
	{
		// do something with the item instance
		if ($item->insert()) {
			$msg = 'Insert success';
		} else {
			$msg = 'Insert failure';
		}
		return $msg;
	}
}

$add = new AddToDatabase();
$item = new Order([1,2,3]);
echo $add->addItem($item);	// works  OK
echo PHP_EOL;

$item = new Customer([1,2,3]);
echo $add->addItem($item);	// Fatal Error
echo PHP_EOL;

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
gType `int` can "widen" to `float` without any loss of precision
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
Using `static` to "float down" to the lowest inheritance level
```
<?php
class Foo
{
	public string $name = 'Fred Flintstone';
    public function getInstance(): static
    {
        return new static();
    }
}

class Bar extends Foo
{}

class Baz extends Bar
{}


$foo = new Foo();
var_dump($foo->getInstance());

$bar = new Bar();
var_dump($bar->getInstance());

$baz = new Baz();
var_dump($baz->getInstance());

// Actual Output
/*
 * object(Foo)#2 (1) {
  ["name"]=>
  string(15) "Fred Flintstone"
}
object(Bar)#3 (1) {
  ["name"]=>
  string(15) "Fred Flintstone"
}
object(Baz)#4 (1) {
  ["name"]=>
  string(15) "Fred Flintstone"
}
*/
```
Typical example using `Exception`
```
<?php
class Test
{
	/**
	 * Divide two numbers
	 *
	 * @throws Exception if division by zero
	 * @param float $a
	 * @param float $b
	 * @return float $a / $b
	 */
	public function divide(float $a, float $b) : float
	{
		if ($b == 0) {
			throw new Exception('Cannot divide by zero!');
		}
		return $a / $b;
	}
}

// this is the calling code, and is most likely
// found someplace else in the application:
try {
	$test = new Test();
	echo $test->divide(22, 0);
	echo PHP_EOL;
} catch (Exception $e) {
	error_log(__FILE__ . ':' . __LINE__ . ':' . $e->getTraceAsString());
	echo $e->getMessage();
}

```
Exceptions are planned ways of bailing out if unable continue:
```
<?php
class Convert
{
	public array $arr = [];
	public function toArray(string $filename)
	{
		if (!file_exists($filename)) {
			throw new Exception('You need to supply a valid CSV file');
		}
		$fh = new SplFileObject($filename, 'r');
		while ($row = $fh->fgetcsv()) {
			$arr[] = $row;
		}
		return $arr;
	}
}

$conv = new Convert();
var_dump($conv->toArray('xyz.csv'));
```

Exception / Error example:
* See: https://www.php.net/manual/en/language.exceptions.php

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
Using `static` for a registry style storage class
* https://github.com/dbierer/filecms-core/blob/main/src/Common/Generic/Registry.php
```
class Registry
{
	public static $items = [];
	public static function set(string $key, mixed $value)
	{
		static::$items[$key] = $value;
	}
	public static function get(string $key)
	{
		return static::$items[$key] ?? NULL;
	}
}

Registry::set('name', 'Doug Bierer');
Registry::set('array', range('A','F'));

// do something

foreach (Registry::get('array') as $item) {
	echo $item . ':' . Registry::get('name') . PHP_EOL;
}

```
This example shows using `static` to store what would normally be standalone functions:
```
<?php
// you can also tie an interface to a static implementation:
interface LowerInterface
{
	public static function makeLower(string $item);
}

class Generic implements LowerInterface
{
	public static $mode = 'upper';
	public static function makeUpper(string $item)
	{
		return strtoupper($item);
	}
	public static function makeLower(string $item)
	{
		return strtolower($item);
	}
	public static function makeWhatever(string $item)
	{
		if (static::$mode === 'upper') {
			$result = static::makeUpper($item);
		} else {
			$result = static::makeLower($item);
		}
		return $result;
	}
}

$text = 'The quick brown fox jumped over the fence.';

echo Generic::makeUpper($text);
echo PHP_EOL;

echo Generic::makeLower($text);
echo PHP_EOL;

Generic::$mode = 'upper';
echo Generic::makeWhatever($text);
echo PHP_EOL;

Generic::$mode = 'lower';
echo Generic::makeWhatever($text);
echo PHP_EOL;

// actual output
/*
 * THE QUICK BROWN FOX JUMPED OVER THE FENCE.
the quick brown fox jumped over the fence.
THE QUICK BROWN FOX JUMPED OVER THE FENCE.
the quick brown fox jumped over the fence.
*/
```

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
Example of nested objects:
```
<?php
class Address
{
	public function __construct(
		public string $streetAddress,
		public string $city,
		public string $postCode,
		public string $country) {}
}

class User
{
	public function __construct(
		public string $name,
		public string $email,
		public Address $address) {}
}

$user = new User(
	'Fred Flintstone',
	'fred@slate_and_granite.com',
	new Address(
		'201 Cobblestone Lane',
		'Bedrock',
		'00000',
		'Unknown')
);

// how to get the city from User
echo $user->name . ' lives in the city of ' . $user->address->city;
echo PHP_EOL;

var_dump($user);
```

## PDO
Example of a generic database class with built-in methods for INSERT, SELECT, UPDATE, DELETE
* https://github.com/dbierer/classic_php_examples/blob/master/db/db_active_record_example.php
Example showing `SELECT` and publishing results as an array of `User` class instances:
```
<?php
$config = include __DIR__ . '/../orderapp/config/config.php';

class User
{
	public $id;
	public $first;
	public $last;
	public function __construct(array $row)
	{
		$this->id = $row['id'];
		$this->first = $row['firstname'];
		$this->last = $row['lastname'];
	}
}

try {
	$pdo = new PDO($config['db']['dsn'],
				   $config['db']['username'],
				   $config['db']['password'],
				   $config['db']['options']);
	$sql = 'SELECT id,firstname,lastname FROM customers';
	$stmt = $pdo->query($sql);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$users[] = new User($row);
	}
	var_dump($users);
} catch (Throwable $t) {
	error_log(get_class($t) . ':' . $t->getMessage() . ':' . $t->getTraceAsString());
	echo 'Database error';
}

```

Example using a stored procedure with `PDO::exec()`
```
<?php
try {
    // Get the connection instance
    $pdo = new PDO('mysql:host=localhost;dbname=phpcourse','vagrant','vagrant',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Hard coded input parameters
    $fname = 'Mark';
    $lname = 'Watney';

    // We can safely use `exec()` because the stored procedure is an INSERT
    // and we are only concerned with the number of rows affected
    if ($pdo->exec(sprintf('CALL newCustomer (%s,%s)', $fname, $lname)) {
        echo "New user $fname  $lname added";
    }
} catch (PDOException $e){
    //Handle error
}
```

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
You can use `PDO::quote()` to manually provide parameter escaping:
```
<?php
$pdo = /* some PDO instance */
$id  = (int) ($_GET['id'] ?? 0);
$id  = ($id < 0) ? 0 : $id;
// assuming $id is sanitized, quote() can be used to manually provide platform quoting
$sql = 'SELECT id, first, last FROM users WHERE id=' . $pdo->quote($id);
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
* Other examples: https://github.com/dbierer/classic_php_examples/tree/master/db
```
<?php
class Order
{ }

$conf= [
	'dsn' => 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=phpcourse',
	'username' => 'vagrant',
	'password' => 'vagrant',
	'options'  => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
];

try {
	$pdo = new PDO($conf['dsn'], $conf['username'], $conf['password'], $conf['options']);

    // Execute a one-off SQL statement and get a statement object
    $stmt = $pdo->query('SELECT * FROM orders');
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Order');

    // Returns an instance of Order, one row at a time
    while ($result = $stmt->fetch()) {
		var_dump($result);
	}
} catch (PDOException $e){
    //Handle error
}

// partial output:
/*
object(Order)#3 (6) {
  ["id"]=>
  int(7)
  ["date"]=>
  string(10) "1360796400"
  ["status"]=>
  string(4) "open"
  ["amount"]=>
  int(300)
  ["description"]=>
  string(24) "A big box of chocolates."
  ["customer"]=>
  int(3)
}
*/

```
Rewritten example using stored procedure:
```

try {
    // Get the connection instance
    $pdo = new PDO('mysql:host=localhost;dbname=phpcourse','vagrant','vagrant',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Hard coded input parameters
    $fname = 'Mark';
    $lname = 'Watney';

    // Prepare an SQL statement and get a statement object
    $sql = 'CALL newCustomer (' . $fname . ',' . $lname . ');';
    $stmt = $pdo->query($sql);

    // Execute the SQL statement
    if ($stmt->rowCount() > 0) {
        echo "New user $fname  $lname added";
    }
} catch (PDOException $e){
    //Handle error
}
```

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
Official list of email headers:
* https://www.iana.org/assignments/message-headers/message-headers.xhtml

## Regex
Simple example finds all files that start with "Test" and end with "php"
```
<?php
$str = [
	'Test.php',
	'Test.jpg',
	'Test2.php',
	'Test2.png',
	'No_Test.php',
];

// or you can use this:
// $patt = '/\ATest.*php\Z/';

$patt = '/^Test.*php$/';

foreach ($str as $item) {
	if (preg_match($patt, $item)) {
		$found = 'Found';
	} else {
		$found = 'Not Found';
	}
	echo $item . ' was ' . $found . PHP_EOL;
}

```
This example extracts a URL from a string:
```
<?php
$text = '<html><body><p>Something</p><p><a href="https://zend.com/">Click Here</a></p></body></html>';
$patt = '/href="(.*?)"/';
$match = [];
if (preg_match($patt, $text, $match)) {
	$url = $match[1] ?? '';
	echo htmlspecialchars($text) . PHP_EOL;
	echo 'The URL is: ' . $url . PHP_EOL;
} else {
	echo 'No Match';
}

// actual output:
/*
&lt;html&gt;&lt;body&gt;&lt;p&gt;Something&lt;/p&gt;&lt;p&gt;&lt;a href=&quot;https://zend.com/&quot;&gt;Click Here&lt;/a&gt;&lt;/p&gt;&lt;/body&gt;&lt;/html&gt;
The URL is: https://zend.com/
 */
```
Matches a Canadian postal code
```
<?php
$text = 'A2A 3B4';
$patt = '/^\w\d\w \d\w\d$/';
preg_match($patt, $text, $match);

var_dump($match);

```

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
Using "dollar" notation to replace the order of subpatterns
```
<?php
$str = 'Flintstone, Fred';
$pat = '/([A-Za-z]+?), ([A-Za-z]+)/';
$rep = '$2 $1';
echo preg_replace($pat, $rep, $str);
// Actual output: "Fred Flintstone"

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

Example of searching for a specific file name pattern in a directory
```
<?php
$list = scandir(__DIR__);
var_dump($list);
$pattern = '/^[\w].*?\.php$/';
foreach ($list as $item) {
    echo $item . ': ';
    preg_match($pattern, $item, $match);
    echo (!empty($match[0])) ? 'MATCH' : 'NO MATCH';
    echo PHP_EOL;
}

// or
var_dump(preg_grep($pattern, $list));

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
Example using sub patterns:
```
<?php
$str = '<a href="https://zend.com">Zend Website</a>';
$pat = '/<a href="(.*?)">(.*?)<\/a>/';
preg_match($pat, $str, $match);
var_dump($match);

// actual output:
/*
array(3) {
  [0]=>
  string(43) "<a href="https://zend.com">Zend Website</a>"
  [1]=>
  string(16) "https://zend.com"
  [2]=>
  string(12) "Zend Website"
}
*/
```
Example using `preg_replace()`
```
<?php
$text = '<script>Bad Javascript</script>';
$pattern = '![^A-Za-z0-9 ]!';
$str = preg_replace($pattern, ' ', $text);
echo $str;
echo PHP_EOL;
echo strip_tags($text);

// actual output:
/*
 script Bad Javascript  script
Bad Javascript
*/
```
Using `$` to represent subpatterns when using `preg_replace()`
```
<?php
$text = 'April 24, 2024 10:15 AM';
$pattern = '/^(\w+).*?(\d+).*?(\d{4})(.*?)$/';
$str = preg_replace($pattern, '$2 $1 $3$4', $text);
echo $str;
echo PHP_EOL;

// Actual output: "24 April 2024 10:15 AM"
```

PHP 5 to PHP 7 code converter using `preg_replace_callback_array()`
* https://github.com/dbierer/php7cookbook/blob/master/source/chapter01/chap_01_php5_to_php7_code_converter.php#L3
* https://github.com/dbierer/php7cookbook/blob/master/source/Application/Parse/Convert.php

Example email validation regex from Andrey:
```
^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$
```
Example from Michael:
```
 $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
```
Example from William:
```
$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
```


## Composer
Example of advanced usage including scripts
* https://github.com/laminas/laminas-mvc-skeleton/blob/master/composer.json
You can add alternates to `packagist.org` using the `repositories` key in the composer.json file
* Example: https://wpackagist.org/
If you dependency issues, consider adding the `--ignore-platform-reqs` to the `composer install` or `composer update` directive
* This is especially true if you're running 8.1 or 8.2 and the packagist project is set for PHP 7.4 or 8.0
If you want Composer to interactively build a `composer.json` file use this command:
```
composer --init
```

## Web Services
SimpleXML Example:
```
<?php
// A simpleXML load file example
$xml = simplexml_load_file( 'produce.xml' );

// Get the vegies
$vegies = $xml->vegetables;

// Get the first vegie using array notation
$vegie = $vegies->vegetable[0]->name;
echo 'Content: ' . $vegie . "\n";

$fruits = $xml->fruits;
echo 'Content: ' . $fruits->fruit[0]->name . "\n" ;
echo 'Content: ' . $fruits->fruit[1]->name . "\n" ;
echo 'Content: ' . $fruits->fruit[2]->name . "\n" ;

// Output item data
foreach ( $fruits->fruit as $node ) {
    echo 'Content: ' . $node->name . "\n" ;
}

// Output XML from the SimpleXMLElement object
//echo $xml->asXML();

// Output to an xml file
$xml->asXML( 'newproduce.xml' );

// actual ouput (minus the XML document)

//var_dump($xml);

/*
Content: tomatoes
Content: strawberries
Content: bananas
Content: apples
Content: strawberries
Content: bananas
Content: apples

*/
```
Here's the XML document:
```
<?xml version="1.0" encoding="UTF-8"?>
<produce xmlns:ea="test">
	<vegetables>
		<vegetable unit="pound">
			<name>tomatoes</name>
			<price>2.99</price>
		</vegetable>
		<vegetable unit="bunch">
			<name>broccoli</name>
			<price>4.99</price>
		</vegetable>
	</vegetables>
	<fruits>
		<fruit unit="pint">
			<name>strawberries</name>
			<price>4.99</price>
			<time>seasonal</time>
		</fruit>
		<fruit unit="bunch">
			<name>bananas</name>
			<price>3.99</price>
			<time>seasonal</time>
		</fruit>
		<fruit unit="bag">
			<name>apples</name>
			<price>4.99</price>
			<time>seasonal</time>
		</fruit>
	</fruits>
</produce>
```
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
Example where you get a Warning "headers already sent"
```
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// stops buffering
ob_end_clean();

header('Test-1: TEST1');
echo '<br />' . __FILE__ . ':' . __LINE__;

// returns a Warning:
header('Test-2: TEST2');
echo '<br />' . __FILE__ . ':' . __LINE__;

// actual output:
/*
/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php:6
Warning: Cannot modify header information - headers already sent by (output started at /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php:6) in /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php on line 8

/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/test.php:9
*/
```

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

## Web Services
REST request example:
* https://github.com/dbierer/classic_php_examples/blob/master/web/rest_api_call_us_weather_svc.php
SOAP example:
* https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php
Example of sending JSON request to Authorize.net
* https://github.com/AuthorizeNet/sample-code-php/tree/master

## Dependency Injection
Great overview of the DI design pattern:
* https://martinfowler.com/articles/injection.html
Configuration for DI services
* See: https://github.com/zendtech/Laminas-Level-2-Attendee/blob/master/onlinemarket.complete/module/Model/config/module.config.php
DI Factory
* See: https://github.com/zendtech/Laminas-Level-2-Attendee/blob/master/onlinemarket.complete/module/Model/src/Adapter/Factory/PrimaryAdapterFactory.php
* See: https://github.com/zendtech/Laminas-Level-2-Attendee/blob/master/onlinemarket.complete/module/Model/src/Model/Factory/CityCodesModelFactory.php

### 502 Bad Gateway
If you're getting this message from the browser inside the VM, do the following:
* Open up a command prompt (CTL+ALT+T)
* Check your PHP version: `php -v`
  * Make a note of the number (e.g. "8.3")
* Switch to "root": `sudo -i`
* Open this file with "nano": `nano /etc/php/$PHP_VER-zend/fpm/pool.d/www.conf`
  * Substitute the PHP version in place of "$PHP_VER"
* Make these changes:
```
; Replace this line:
listen = /run/php/php$PHP_VER-zend-fpm.sock
; With this:
listen = 0.0.0.0:9000
```
* Restart PHP-FPM
```
/etc/init.d/php$PHP_VER-zend-fpm restart
```
* Restart nginx
```
/etc/init.d/nginx restart
```

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
* A: https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
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
* Q: What replaces `Pragma: no-cache` header?
* A: See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Pragma
  * The `Cache-Control: no-cache` should be used for the reponse
  * See: https://stackoverflow.com/questions/10314174/difference-between-pragma-and-cache-control-headers
  * According to the HTTP/1.0 documentation, `Pragma: no-cache` header should only be used in requests.

* Q: What was the actual title the seminal work on software design patterns?
* A: "Design Patterns: Elements of Reusable Object-Oriented Software" (1994)
  * See: https://en.wikipedia.org/wiki/Design_Patterns
  * Also look at Martin Fowler's book "Patterns of Enterprise Application Architecture"
    * https://martinfowler.com/books/eaa.html

Q: Can you use `filter_var()` with the `FILTER_VALIDATE_EMAIL` flag in place of a regex?
A: It works at a very basic level, but doesn't catch everything. Recommend to a regex for rigorous validation (see examples below)

Q: Do you have an example using `preg_grep()`?
A: See: https://github.com/dbierer/classic_php_examples/blob/master/regex/preg_grep.php

Q: What is "skeleton loading?"
A: Still researching this. From what I could see thus far, it appears to be a front-end technology.
  * See: https://bootcamp.uxdesign.cc/skeleton-vs-loading-screens-enhancing-user-experience-during-content-loading-and-data-fetching-3a07b1bdbc9c

Q: What some alternate reasons to use `ob_start()`
A: One good reason is to have the ability to short-circuit long-running AJAX requests!

Q: What are other design patterns that have superceded MVC?
A: There are plenty of modern alternatives.
  * This is a good starting point: https://stackoverflow.com/questions/141912/alternatives-to-the-mvc

Q: How do you set the (or find) the nesting limit for a particular PHP installation?
A: There is no default nesting level for PHP -- it's determined by the OS. However, if you have XDebug installed, any errors might originate from that extension.
  * See this article: https://stackoverflow.com/questions/4293775/increasing-nesting-function-calls-limit

Q: Instructions for adding additional language input sources to change keyboard to German
A: See: https://askubuntu.com/questions/1272094/how-to-install-a-german-keyboard-layout-on-an-english-installation

Q: Reference to readonly properties?
A: Introduced in PHP 8.1. In PHP 8.2 support was added for `readonly` classes
  * See: https://wiki.php.net/rfc/readonly_properties_v2
  * See: https://wiki.php.net/rfc/readonly_amendments

* Q: How many spaces do you need to indent when using YAML?
* A: https://stackoverflow.com/questions/42247535/yaml-how-many-spaces-per-indent

* Q: How do you use a "backed" Enum?
* A: Here's a code fragment that illustrates the use of a backed Enum:
```
<?php
// "backed" enum
// just by putting a return data type of `string`
enum Gender : string
{
    case MALE = 'M';
    case FEMALE = 'F';
    case OTHER = 'O';
}

echo Gender::MALE->value;	// output: "M"
```

* Q: Database agnostic design tool
* A: See: DBeaver.io

* Q: Why can't you "widen" from a super class that defines "int" and subclass that defines "float"?
* A: PHP sees "int" and "float" as two completely different data types -- "float" is *not* a composite super type
* A: Contrast that with "array" and "iterable". "array" is a discreet type whereas "iterable" is actually "array|Iterator"
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_type_hint_widening.php

* Q: Do you have a real-life example of an interface mandating functionality?
* A: This is an excellent example of mandating functionality via interface
  * https://github.com/laminas/laminas-filter/blob/master/src/FilterInterface.php
  * https://github.com/laminas/laminas-filter/blob/master/src/AbstractFilter.php
  * And then, look at any of the Filter classes

* Q: Do the PSRs recommend using `()` when creating new instances?
* A: According to PSR-12::Section 4:
  * When instantiating a new class, parentheses MUST always be present even when there are no arguments passed to the constructor.
  * See: https://www.php-fig.org/psr/psr-12/#4-classes-properties-and-methods

* Q: What version of PHP disallows the auto-creation of properties without declaration?
* A: Here's the RFC: https://wiki.php.net/rfc/deprecate_dynamic_properties
  * Dynamic property deprecation landed in PHP 8.2, however their final removal is not announced
  * The RFC offers the attribute `#[AllowDynamicProperties]` as a way to opt-in to the use of dynamic properties.

* Q: Do you have a list of regex testing websites?
* A: I prefer this one as it's mainly for PHP and supports other functions above just `preg_match()`
  * See: https://www.phpliveregex.com/
* A: This one is good if you also need to test regexes in other languages:
  * See: https://regex101.com/

* Q: When running PHP as an Apache module, how do I update the PHP version?
* A: Follow these steps:
  * From your web server, create a PHP script `info.php` that runs `phpinfo()`
```
<?php
phpinfo();
```
  * From your browser, run `info.php` and make a note of the current PHP version
  * Find the current version of PHP after the update:
```
php -v
```
* Reconfigure the Apache PHP module according to this version.
  * In this example we use "8.0" as the old version, and "8.3" as the new version.
  * Please note that your version may be different so you'll need to adjust the number accordingly
```
sudo apt-add-repository ppa:ondrej/apache2
sudo apt install -y libapache2-mod-php8.3
sudo a2dismod php8.0
sudo a2enmod php8.3
sudo systemctl restart apache2
```

* Q: Do you have an example of a virtual host for Apache?
* A: Here's an example:
```
<VirtualHost *:80>
   ServerName sandbox
   DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox
   <Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/>
       Options Indexes FollowSymlinks MultiViews
       AllowOverride All
       Require all granted
   </Directory>
</VirtualHost>
```
* Q: Why does the "Etag" header not get set?
* A: The value assigned to the header needs to be on quotes (")
  * Here's the solution: `header('ETag: "' . $etag . '"');`
  * https://github.com/dbierer/classic_php_examples/blob/master/web/etag.php

* Q: Research error in the "superclass_lab.php"
* A: If the subclass uses PHP 8 `__construct()` argument promotion, the superclass needs to as well
* A: Otherwise you get this error:
```
PHP Fatal error:  Type of OrderPacked::$ordernumber must not be defined (as in class OrderInfo) in superclass_lab.php on line 53
```

* Q: Examples using $_SESSION?
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/web/session_set_save_handler_example.php

* Q: How to install VSCode in the VM?
* A: See: https://linuxiac.com/install-visual-studio-code-on-ubuntu-22-04/



## Change Request

* http://localhost:8882/#/3/15
  * Cannot have an active expression in the declaration at this point!
* http://localhost:8882/#/3/26
  * Add `get_object_vars()`
* http://localhost:8882/#/3/32
  * Inconsistent use of "super class" vs. "superclass" and also "sub class" or "subclass"
* http://localhost:8882/#/3/69
  * No need to declare this as abstract
* http://localhost:8882/#/3/first-class-examples
  * Don't keep using `parent::`
  * Only incliude 1 example
* http://localhost:8882/#/7/4
  * s/be "matches any character" (not "and")
* http://localhost:8882/#/7/5
  * the discussion `\b` belongs in the slide on built-in char classes
* http://localhost:8882/#/5/41
  * Change the size of the params to 32 to match the database field size
* http://localhost:8882/#/10/14 & 10/15
  * Screenshot needs to be updated
* http://localhost:8882/#/10/21
  * Get rid of `class Test {`
* Update section: needs to go up to 8.4
* http://localhost:8882/#/6/3
  * commandss
* http://localhost:8882/#/3/38
  * Anon class section should *follow* Inheritance
* http://localhost:8882/#/3/46
  * What's up with this slide? Readonly properties???

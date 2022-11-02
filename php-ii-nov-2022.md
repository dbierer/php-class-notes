# PHP II - Nov 2022

Last: http://localhost:8882/#/3/70

## TODO
* Q: Do you have a practical example of `__call()`
* A: Yes: using the "plugin" architecture
* A: TBD

## Homework
For Fri 4 Nov 2022
* Lab: Magic Methods
* Lab: Abstract Classes
* Lab: Interfaces
]
For Wed 2 Nov 2022
* Update the VM
* Lab: Namespace
* Lab: Create a Class
* Lab: Create an Extensible Super Class

## VM Notes
Info
* Username: `vagrant`
* Password: `vagrant`

Update everything!
* Open a terminal window and run this command:
```
sudo apt update
sudo apt -y upgrade
```
* NOTE: this task might take some time

Install phpMyAdmin
* Download the latest version from `https://www.phpmyadmin.net`
* Make note of the version number (e.g. `5.2.0`)
```
cd
VER=5.2.0
unzip Downloads/phpMyAdmin-$VER-all-languages.zip
sudo cp -r phpMyAdmin-$VER-all-languages/* /usr/share/phpmyadmin
sudo cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php
```
* Create the "blowfish secret"
```
sudo -i
export SECRET=`php -r "echo md5(date('Y-m-d-H-i-s') . rand(1000,9999));"`
echo "\$cfg['blowfish_secret']='$SECRET';" >> /usr/share/phpmyadmin/config.inc.php
exit
```
Set permissions
```
sudo chown -R www-data /usr/share/phpmyadmin
```

Snapshot
* Be sure to take a snapshot of the VM before you start any of the labs!

System Problem
* If you see this message: `System program problem detected`
* Do this:
```
sudo rm -r /var/crash*
```

## Resources
Code examples: https://github.com/dbierer/classic_php_examples
PHP Road Map: https://wiki.php.net/rfc
Where it all started:
* Seminal work: "Design Patterns: Elements of Reusable Object-Oriented Software"
PHP Road Map:
* https://wiki.php.net/rfc
Additional examples from PHP III class:
* https://github.com/dbierer/php-iii-demos

## Class Notes

### Namespaces
Autoloader Examples:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_autoload_example.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_autoload_class_example.php

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
Example where you want controlled access to a property:
```
<?php
class UserEntity {
    protected string $phone = '';
	// Method
	public function setPhoneNumber(int $num) : void {
		$str = (string) $num;
		$this->phone = substr($str, 0, 3) . '-' . substr($str, 3, 3) . '-' . substr($str, 6);
	}
	public function getPhoneNumber() : string {
		return $this->phone;
	}
}

$user = new UserEntity();
$user->setPhoneNumber(1112223333);
echo $user->getPhoneNumber();
echo PHP_EOL;
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
Practical anonymous class example:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php
Example showing return info + added functionality:
```
<?php
class Test
{
	public function getCityInfo(string $city, string $country='', string $state='')
	{
		$json = file_get_contents("http://api.unlikelysource.com/api?city=$city&state_prov_code=$state&country=$country");
		// return an anonymous class with the desired info + added functionality
		return new class($json) {
			public string $json = '';
			public function __construct(string $json)
			{
				$this->json = $json;
			}
			public function getString()
			{
				return $this->json;
			}
			public function getArray()
			{
				return json_decode($this->json);
			}
		};
	}
}

$test = new Test();
$obj  = $test->getCityInfo('Bangor','US','ME');
var_dump($obj->getArray());
```

## Magic Methods
Example of `__destruct()`
* https://github.com/dbierer/filecms-core/blob/main/src/Common/Image/Captcha.php
Another Example:
```
<?php
class Test
{
	public $instance = NULL;
	public string $name = 'Fred Flintstone';
	public function __destruct()
	{
		echo __METHOD__ . ':' . $this->name . PHP_EOL;
	}
	public function whatever()
	{
		$this->instance = new self();
		$this->instance->name = __FUNCTION__;
	}
}


$test1 = new Test();
$test1->name = 'TEST1';
var_dump($test1);

$test2 = new Test();
$test2->name = 'TEST2';
$test2->whatever();

// actual output:
/*
object(Test)#1 (2) {
  ["instance"]=>
  NULL
  ["name"]=>
  string(5) "TEST1"
}
Test::__destruct:TEST2
Test::__destruct:whatever
Test::__destruct:TEST1
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
			'sleep_date' => date('Y-m-d H:i:s')
		];
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
Allows direct access to protected properties
```
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
// outputs: "Mark" even though property is protected
```

Other examples of magic methods:
* https://github.com/dbierer/classic_php_examples/tree/master/oop
* Look for `oop_magic*.php`

Example of Abstract class with abstract method:
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
Examples of what is `callable`
* https://github.com/dbierer/classic_php_examples/blob/master/oop/callable_examples.php
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
var_dump($foo->getInstance());  // Foo
var_dump($bar->getInstance());  // Bar
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
## Composer
Example of advanced usage including scripts
* https://github.com/laminas/laminas-mvc-skeleton/blob/master/composer.json
You can add alternates to `packagist.org` using the `repositories` key in the composer.json file
* Example: https://wpackagist.org/

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
## Regex
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
PHP 5 to PHP 7 code converter using `preg_replace_callback_array()`
* https://github.com/dbierer/php7cookbook/blob/master/source/chapter01/chap_01_php5_to_php7_code_converter.php#L3
* https://github.com/dbierer/php7cookbook/blob/master/source/Application/Parse/Convert.php

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


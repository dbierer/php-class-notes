# PHP-Exp Jun 2021

## TODO
* Why are you getting an error when overriding method in child class?

## Homework
For Fri 18 Jun 2021
  * http://collabedit.com/d7gky
  * Lab: Namespace
For Thu 17 Jun 2021
  * http://collabedit.com/x4puv
  * Lab: Embedded PHP
For Wed 16 Jun 2021
  * Use this for homework: http://collabedit.com/yj28t
For Fri 11 Jun 2021
  * Lab: Array (all 4)
  * Lab: First Program
  * Lab: Additional Crew Members
  * Lab: Conditionals (all 5)
  * Lab: Loops (all 4)
  
## VM Setup
Download the source code.  From a terminal window in the VM:
```
cd ~/Zend/workspaces/DefaultWorkspace
wget https://opensource.unlikelysource.com/php-exp-src.zip
unzip php-exp-src.zip
```
Set up the `sandbox` as an Apache virtual host
```
sudo cp /etc/apache2/sites-available/orderapp.conf /etc/apache2/sites-available/sandbox.conf
```
Apache vhost definition:
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
Enable the virtual host
```
sudo a2ensite sandbox.conf 
sudo service apache2 restart
```
Add an entry to the `/etc/hosts` for `sandbox`
```
sudo gedit /etc/hosts
127.0.0.1 sandbox
```

## Class Notes
Simple class example using PHP 8 `__construct()` syntax
```
<?php
class Person{
	public function __construct(
		public $firstname = '',
		public $lastname  = '')
	{}
	public function getFullName()
	{
		return $this->firstname . ' ' . $this->lastname;
	}
}
$person = new Person('Fred', 'Flintstone');
echo $person->getFullName();
echo "\n";
$person->firstname = 'Betty';
echo $person->getFullName();
```
Example of Class Property strict types
* Available in PHP 7.4 and above:
```
<?php
declare(strict_types=1);
class Person{
	public int $status = 0;
	public string $firstname = '';
	public string $lastname  = '';
	public function __construct(
		int $status, 
		string $firstname = '',
		public string $lastname  = '')
	{
		$this->status = $status;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
	}
	public function getFullName()
	{
		return $this->firstname . ' ' . $this->lastname;
	}
}
$person = new Person('Fred', 'Flintstone');
echo $person->getFullName();
echo "\n";
$person->firstname = 'Betty';
// NOTE: this generates a Fatal Error
$person->status = '1';
echo $person->getFullName();
```
Example mixing PHP and HTML
```
<?php
$amount = 99.99;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.36" />
</head>
<body>
Amount Is: <?= $amount ?>
</body>
</html>
```
Example of "pure" PHP that generates HTML
```
<?php
$amount = 99.99;
echo '<!DOCTYPE html><html><head><title>Test</title></head><body>';
echo "Amount is: $amount";
echo '</body></head></html>';
```
Example of type coercion
```
<?php
$a = 123;
$b = 'This value is: ' . $a;
var_dump($a, $b);
```
Forcing the data type is a good way to sanitize data + allow numerics ops to continue
```
<?php
// Assignment
$foo = '<script>you been hacked</script>99';
$foo = (int) $foo; 
// Output response
echo 5 + $foo;
```
Force garbage collection to free memory in long-running programs
```
https://www.php.net/gc_collect_cycles
```
To increase the amount of memory available for a given program run
```
https://www.php.net/ini-set
ini_set('memory_limit', '1G');
```
List of `php.ini` file settings: https://www.php.net/manual/en/ini.core.php

Use PHP 8 `Attributes` in place of `doc blocks` to improve performance
* https://www.php.net/manual/en/language.attributes.syntax.php
* Not available in PHP 7 or below!

Use the `empty()` function to evaluate the contents of a variable to determine if it has any value or not
```
<?php
$arr = [
	[],
	FALSE,
	0,
	0.00,
	'',
	NULL,
	$test['whatever']
];
foreach ($arr as $val) {
	echo (empty($val)) ? 'Empty' : 'Not Empty';
	echo "\n";
}

```
Unpacking (or unwinding) arrays:
```
<?php
$foo = [1, 2, 3];	
$abc = ['A','B','C'];
$bar = [...$foo, ...$abc];
print_r($bar); 
// [1,2,3,'A','B','C']
```
Examples of constants
```
<?php
define('TEST', 'Test');

class Test
{
	const TEST = 'Not Test';
	public static $test  = 'Var Test';
	public function getTest()
	{
		return self::TEST . ':' . TEST;
	}
}

$test = new Test();
echo TEST;
echo "\n";
echo Test::TEST;
echo "\n";
echo $test::TEST;
echo "\n";
echo $test::$test;
echo "\n";
echo $test->getTest();
echo "\n";

// output
/*
Test
Not Test
Not Test
Var Test
Not Test:Test
*/
```
Example of multi-dimensional array with "Y" axis is numeric, "X" axis is string indices
```
<?php
$arr = [
	['first' => 'Fred', 'last' => 'Flintstone'],
	['first' => 'Wilma', 'last' => 'Flintstone'],
	['first' => 'Barney', 'last' => 'Rubble'],
	['first' => 'Betty', 'last' => 'Rubble'],
];
echo $arr[2]['first'] . ' ' . $arr[2]['last'];
```
Diffs between PHP 7 and 8
```
<?php
$arr[-5] = 'Fred';
$arr[-4] = 'Wilma';
$arr[-3] = 'Barney';
$arr[]  = 'Betty';
var_dump($arr);
// In PHP 8, next highest index value is -2
// In PHP 7, next highest index value is -0
```
Null Coalesce Operator
```
<?php
// take the 1st non-null value
$status = $_GET['status'] ?? $_POST['status'] ?? $_COOKIE['status'] ?? 99;
$status = (int) $status;
echo "Status: $status\n";
```
Match expression: alternative to `switch`
```
<?php
$op = 'add';	
$a  = 11;
$b  = 22;
$result = match ($op) {
    'add' => $a + $b,
    'sub' => $a - $b,
	default => NULL
};
echo $result;
```
Using `list()` or `[]` to unroll a sub-array within a `foreach()` loop
```
<?php
$data = [
	['Fred','Flintstone'],
	['Wilma','Flintstone'],
	['Barney', 'Rubble'],
	['Betty', 'Rubble'],
];
foreach ($data as [$first, $last]) echo "$first $last\n";
// output:
/*
Fred Flintstone
Wilma Flintstone
Barney Rubble
Betty Rubble
*/
```
Alternate way of assigning intial array values
```
$astronaut = [
	'0130' => ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
	'0497' => ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
	'1003' => ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
	'0254' => ['firstName' => 'Alice', 'lastName' => 'Aaronson', 'specialty' => 'Pilot'],
	'3392' => ['firstName' => 'Bob', 'lastName' => 'Builder', 'specialty' => 'Mechanic'],
];
```
Three different approaches to array iteration without `foreach()`
```
<?php
$invoice = ['keychain' => 2,  'calculator' =>  10, 'pencil' => 1];
$keys = array_keys($invoice);
$tax_rate = 0.06;
while (!empty($keys)) {
    $key = array_pop($keys);
    $invoice[$key] = $invoice[$key] + $invoice[$key] * $tax_rate;
    echo $key . ': $' . $invoice[$key] . "\n";
}

// using an iterator (preferred approach)
$invoice = ['keychain' => 2,  'calculator' =>  10, 'pencil' => 1];
$iter = new ArrayIterator($invoice);
$tax_rate = 0.06;
while ($iter->valid()) {
	$key = $iter->key();
	$value = $iter->current() * (1 + $tax_rate);
	$iter->offsetSet($key, $value);
	$iter->next();
}
var_dump($iter->getArrayCopy());

// alternative approach (slightly old school)
$invoice  = ['keychain' => 2,  'calculator' =>  10, 'pencil' => 1];
$count    = count($invoice);
$tax_rate = 0.06;
$ctr      = 0;
while ($ctr++ < $count) {
	$key = key($invoice);
	$value = current($invoice) * (1 + $tax_rate);
	$invoice[$key] = $value;
	next($invoice);
}
var_dump($invoice);
```
Example of `named parameters` (PHP 8 only):
```
// PHP 8 named parameters allow you to skips args (if defaults exist)
setcookie (name:'cookie_name', value:'TEST', httponly: TRUE);
```
Example of `static` in a procedural sense doing a recursive directory scan
```
<?php
$path = __DIR__;

function parseDir($path)
{
	static $list = [];
	$tmp = glob($path. '/*');
	foreach ($tmp as $fn) {
		echo $fn . "\n";
		if (is_dir($fn)) {
			parsedir($fn);
		} else {
			$list[] = $fn;
		}
	}
	return $list;
}

var_dump(parseDir($path));

```
Example where the function should return boolean, but you want messages too
```
<?php
// validating form data

function validate_data(array $data, array &$msg) : bool
{
	$err = 0;
	foreach ($data as $key => $val) {
		// length check
		if (strlen($val) > 8) {
			$msg[] = 'All values must be 8 chars or less';
			$err++;
		}
		// alnum check
		if (!ctype_alpha($val)) {
			$msg[] = 'Only letters or numbers accepted';
			$err++;
		}
	}
	return ($err === 0);
}

$data = [
	'This does not #$%^ have alnum',
	'this2ok',
];
$messages = [];
echo (validate_data($data, $messages)) ? 'VALID' : 'INVALID';
echo "\n";
var_dump($messages);
```
Frequently used string functions:
* To get docs: `https://php.net/FUNCTION`
* substr()
* trim()
* strpos()
* str_replace()
Sort functions:
* use `asort()` to retain key/value pairs
* `uasort()` example:
```
<?php
$astronaut = [
['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
['firstName' => 'Alice', 'lastName' => 'Aaronson', 'specialty' => 'Pilot'],
['firstName' => 'Bob', 'lastName' => 'Builder', 'specialty' => 'Mechanic'],
];
$callback = function($a, $b) {
	// NOTE: don't forget to return!!!
	return $a['lastName'] <=> $b['lastName'];
};
uasort($astronaut, $callback);
$pattern = "%10s : %10s : %20s\n";
printf($pattern, 'First', 'Last', 'Specialty');
printf($pattern, '-----', '----', '---------');
foreach ($astronaut as $row)
	vprintf($pattern, $row);
```
Anonymous function example in a callback tree:
* https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch11/php7_bc_break_scanner.php

Example reading a tab-delimited file
```
// source: geonames.org
$src = '/home/vagrant/Downloads/countryInfo.txt';
$fh  = fopen($src, 'r');
if (!$fh) exit('Unable to locate file');
$data = [];
while (!feof($fh)) {
	$line = fgetcsv($fh, separator: "\t");
	printf("%2s | %3s | %s\n", $line[0], $line[1], $line[4]);
}

```
Fibonacci Sequence
```
<?php
function returnNth($n) {
    if ($n === 1 || $n === 2) {
        return 1;
    }
    else { 
        return returnNth($n - 1) + returnNth($n - 2);
    }
}

for ($x = 1; $x < 10; $x++) {
	echo returnNth($x) . "\n";
}
// 0, 1, 2, 3, 5, 8, 13, 21, 34, 55
```
PHP Running in Async Mode:
* Look for info on the Swoole extension
* Good starting point: https://www.zend.com/blog/swoole
Getting down to the TCP/UDP layers:
* https://www.php.net/stream_socket_client

How to do a redirect:
```
header('Location: http://www.example.com/');
exit;
```
Main HTML with some PHP:
```
<?php
$token = base64_encode(random_bytes(8));
$data = ['Fred','Wilma','Barney','Betty'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.36" />
</head>
<body>
Token: <?= $token ?>
<br />
Names:
<ul>
	<?php foreach ($data as $name) : ?>
	<li><?= $name ?></li>
	<?php endforeach; ?>
</ul>
</body>
</html>
```
Example of using PHP to generate HTML:
```
<?php
$token = base64_encode(random_bytes(8));
$data = ['Fred','Wilma','Barney','Betty'];
$out = '<!DOCTYPE html>';
$out .= '<html lang="en">';
$out .= '<head>';
$out .= '<meta charset="utf-8" />';
$out .= '<title>untitled</title>';
$out .= '<meta name="generator" content="Geany 1.36" />';
$out .= '</head>';
$out .= '<body>';
$out .= 'Token: ' . $token;
$out .= '<br />';
$out .= 'Names:';
$out .= '<ul>';
foreach ($data as $name) {
	$out .= '<li>' . $name . '</li>';
}
$out .= '</ul>';
$out .= '</body>';
$out .= '</html>';
echo $out;
```
Security functions:
* `htmlspecialchars()` for "output escaping" (safeguarding suspect data when echoed)
* `strip_tags()` sanitizes incoming data
* `filter_var()` general filtering and sanitization
* `ctype_*()` validation of data types (e.g. alpha, alnum, digits, etc.)
* `str_replace()` used to replace suspect characters with benign substitutes
How to get the incoming HTTP method:
```
$_SERVER['REQUEST_METHOD']
```
Example of multiple autoloaders
* Assumes this directory structure:
```
├── src
│   └── App
│       └── Services
│           ├── Bar.php
│           ├── Base.php
│           └── Foo.php
├── test
│   └── Something.php
```
* Multiple autoloaders:
```
<?php
$loader = function ($class) {
	$path = __DIR__ 
		  . '/src/'
		  . str_replace('\\', '/', $class)
		  . '.php';
	if (file_exists($path)) require $path;
};
function somethingLoader($class)
{
	$temp = explode('\\', $class);
	$class = array_pop($temp);
	require __DIR__ . '/test/' . $class . '.php';
}

spl_autoload_register($loader);
spl_autoload_register('somethingLoader');

use App\Services\ {Foo,Bar};
use My\Really\Great\App\Something;

$foo = new Foo();
echo $foo->getFoo();
$iterator = $foo->getIterator();

$bar = new Bar();
echo $bar->getBar();

$some = new Something();
echo $some->getSomething();
```
## OOP
* In PHP 8 you can use `Attributes` in place of doc blocks
  * Better performance
  * Core language construct
  * Can't be accidentally turned by OpCache settings
* Constructor property promotion example
```
<?php
// works from PHP 5.3 and up
class UserEntity {
    public string $firstName = '';
    public string $lastName  = '';
    public function __construct(string $firstName, string $lastName) {
        $this->firstName = $firstName ;
        $this->lastName = $lastName ;
    }
}
// PHP 8 only
class CavemanEntity {
    public function __construct(
		public string $firstName = '',
		public string $lastName  = '')
	{}
}
 
$user[] = new UserEntity('Jack' , 'Ryan');
$user[] = new UserEntity('Monte' , 'Python');
$user[] = new CavemanEntity('Fred' , 'Flintstone');
$user[] = new CavemanEntity('Barney' , 'Rubble');

$user[0]->__construct('Test', 'One');	// reinitializes the object

var_dump($user);
```
Use `get_object_vars()` inside the class to get all props
* Same applies to `json_encode()`
```
<?php
// works from PHP 5.3 and up
class UserEntity {
	private $status = 0;
    public string $firstName = '';
    public string $lastName  = '';
    public function __construct(string $firstName, string $lastName) {
		$this->status = rand(1000, 9999);
        $this->firstName = $firstName ;
        $this->lastName = $lastName ;
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
// PHP 8 only
class CavemanEntity {
    public function __construct(
		public string $firstName = '',
		public string $lastName  = '')
	{}
}
 
$user[] = new UserEntity('Jack' , 'Ryan');
$user[] = new UserEntity('Monte' , 'Python');
$user[] = new CavemanEntity('Fred' , 'Flintstone');
$user[] = new CavemanEntity('Barney' , 'Rubble');



var_dump($user[0]->getArrayCopy());
var_dump(get_object_vars($user[0]));

echo $user[0]->getJson();
echo "\n";
echo json_encode($user[0], JSON_PRETTY_PRINT);
echo "\n";
```
Example using anonymous class to implement a `FilterIterator`
```
<?php
$iter = new ArrayIterator([1,2,3,4,5,6,7,8]);
$filter = new class($iter) extends FilterIterator {
	public function accept()
	{
		return ($this->current() % 2 === 0);
	}
};

foreach ($filter as $value) echo $value . ' ';
```
Example of handling non-existent property access
```
<?php
class UserEntity {
    public function __construct(
        public string $firstName,
        public string $lastName
    ) {}
 
    // Returns an inaccessible property
    public function __get($value) {
		error_log(__CLASS__ . ': Attempt made to access non-existent property ' . $value);
        return NULL;
    }
}
 
$userEntity = new UserEntity('Mark', 'Watney');
echo $userEntity->middleInitial; // outputs: "Mark"
```
Example of `serialize()` and `unserialize()` using `__sleep()` and `__wakeup()`
```
<?php
class UserEntity {
    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected string $password) {
    }
    // whitelist of allowed properties
    public function __sleep()
    {
		return ['firstName', 'lastName'];
	}
	// objectb initialization post unserialization
	public function __wakeup()
	{
		$this->password = base64_encode(random_bytes(8));
	}
	// produces JSON encoding for this object
	public function getJson()
	{
		$vars = get_object_vars($this);
		// remove the password from the JSON string
		unset($vars['password']);
		return json_encode($vars);
	}
}
 
$userEntity = new UserEntity('Mark', 'Watney', 'password');
$string = serialize($userEntity);
echo $string;
$obj = unserialize($string);
// original object is restored (minus the password)
var_dump($obj);

$json = $userEntity->getJson();
echo $json;
$obj = json_decode($json);
// original object is not restored
var_dump($obj);
```
Using `__call()` to implement a plugin architecture
```
<?php
class Test
{
	public function __construct(public Plugin $plugin) {}
	public function __call($method, $params)
	{
		if (method_exists($this->plugin, $method)) {
			return $this->plugin->$method($params[0]);
		} else {
			throw new Exception('Method does not exist');
		}
	}
}
class Plugin
{
	public function add($args) { return $args[0] + $args[1]; }
	public function sub($args) { return $args[0] - $args[1]; }
	public function mul($args) { return $args[0] * $args[1]; }
	public function div($args) { return $args[0] / $args[1]; }
	public function whatever($args) { return 'whatever'; }
}
$test = new Test(new Plugin());
echo "2 + 2 = " . $test->add([2,2]);
```
What is considered `callable`?
* Any built-in or user defined procedural PHP function
* An anonymous function
* Any class that implements `__invoke()`
* Any class method defined as `static`
* Special array syntax: `[$obj, 'method']`

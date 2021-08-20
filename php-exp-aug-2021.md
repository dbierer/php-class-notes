# PHP-Exp Aug 2021

## TODO
* Q: Please post correct versio of eTag example in this notes page

* Q: Where do I find the PDO connection string ("dsn")?
* A: Look up PDO docs (php.net/pdo) and go to the "Drivers" section
* A: Look for the reference to "XXX_DSN"

* Q: Example of anonymous class using `FilterIterator`
* A: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php

* Q: Example of nested ternary that could be a problem?
* A: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch02/php8_nested_ternary.php
* A: This won't work in PHP 8 without using parentheses

* Q: Enable JIT to test Prime Number generation example

## Homework
* For Wed 18 Aug 2021: http://collabedit.com/pbdfh
* For Mon 16 Aug 2021: http://collabedit.com/ukcwu
* For Fri 13 Aug 2021: http://collabedit.com/vsh4c

## Class Notes
* Data types, max int size, etc.
```
<?php
class Test
{
        public int $neg = 0;
        public int $max = 0;
        public float $float = 0.0;
        public function getInfo()
        {
                $vars = get_object_vars($this);
                foreach ($vars as $key => $value)
                        var_dump($this->$key);
        }
}
$test = new Test();
$test->getInfo();

$test->neg = -9999;
$test->max = PHP_INT_MAX; // max allowed size for an integer
$test->float = 99.99;
$test->getInfo();

// this results in an ERROR
var_dump(++$test->max);
```
* `php.ini` directives: https://www.php.net/manual/en/ini.list.php
* If you have a long-running, memory intensive program, use `ini_set()` to override these settings:
```
ini_set('memory_limit', '1G');
ini_set('max_execution_time', 30);      // 30 seconds
```
* Comments can be expressed as `Attributes` in PHP 8
  * Part of the language
  * Don't require extra effort to introspect
  * See: https://www.php.net/manual/en/language.attributes.syntax.php
* Assignments create copies except for objects which are by reference
```
<?php
$a = new ArrayIterator(['A' => 111, 'B' => 222, 'C' =>333]);
// all object assignments are by reference
$b = $a;
$b->offsetSet('D', 444);
// $a now include offset 'D'
var_dump($a);

$c = ['A' => 111, 'B' => 222, 'C' =>333];
// all other types not by reference
$d = $c;
$d['D'] = 444;
// $c doesn't have 'D'
var_dump($c);
```
* Example of multi-dimensional array and de-referencing it
```
<?php
$books = [
        1 => [
                'title' => "Ender's Game",
                'publisher' => 'Tor',
                'author' => 'Orson Scott Card',
        ],
        2 => [
                'title' => 'Tarzan of the Apes',
                'publisher' => 'Ballantine',
                'author' => 'Edgar Rice Burroughs',
        ]
];

echo $books[2]['author'];
```
* Determining class type
```
<?php
$a = new ArrayIterator([1,2,3]);

echo ($a instanceof ArrayIterator) ? 'TRUE' : 'FALSE';
echo "\n";
echo (get_class($a) === 'ArrayIterator') ? 'TRUE' : 'FALSE';
echo "\n";

````
* Array "unpacking" using the splat operator
```
<?php
$foo = [1, 2, 3];
$bar = [4, 5, 6];
$baz = [$foo, $bar];
print_r($baz);

$baz = array_merge($foo, $bar, [7,8,9]);
print_r($baz);

$baz = [...$foo, ...$bar, 7,8,9];
print_r($baz);
```
* Examples of constants
```
<?php
define('BASE_DIR', __DIR__);
const ABC = 'XYZ';
class Test
{
        const ABC = 'DEF';
        public function getDir()
        {
                return BASE_DIR;
        }
        public function getAbc()
        {
                return ABC . self::ABC;
        }
}

$test = new Test();
echo $test->getDir();
echo PHP_EOL;
echo $test->getAbc();
echo PHP_EOL;
```
* Unicode Escape Syntax Example
  * Must be in double quotes
  * Inside the curly braces, you can put any unicode character
  * Browser must support the character
  * See: https://unicode-table.com/en/
```
<?php
echo "\u{1F60E}\u{1F44D}";
```
* Rewritten multi-dimensional array initialization
```
<?php
// Build the crew.
$mission = [
        'STS395' => [
                'botanist' => ['firstName' => 'Mark', 'lastName' => 'Watney'],
                'commander' => ['firstName' => 'Melissa', 'lastName' => 'Lewis'],
                'specialist' => ['firstName' => 'Beth', 'lastName' => 'Johanssen'],
        ],
        'STS396' => [
                'botanist' => ['firstName' => 'Mark', 'lastName' => 'Watney'],
                'commander' => ['firstName' => 'Melissa', 'lastName' => 'Lewis'],
                'specialist' => ['firstName' => 'Beth', 'lastName' => 'Johanssen'],
        ],
];

// list titles
echo implode("\n", array_keys($mission['STS395']));

// add a new role to STS395
$mission['STS395']['mechanic'] = ['firstName' => 'Fred', 'lastName' => 'Flintstone'];

// Output all elements.
//print_r($mission);
```
* Null coalesce operator
```
<?php
// example taking a value from:
// (1) the URL or
// (2) a form post or
// (3) the session or
// (4) the cookie or
// (5) the default
$token = $_GET['token'] ?? $_POST['token'] ?? $_SESSION['token'] ?? $_COOKIE['token'] ?? 0;
```
* Match expression can substitute for `switch`
```
<?php
// use  a callback if you need more than one line of code
$func = function ($val) {
        // do something
        // do something
        return strtoupper($val);
};

// this is an example of an "arrow" function
$callback = fn ($val) => strtoupper($val);

$val = 'xyz';
$result = match ($val) {
    0 => 'Foo',
    1 => 'Bar',
    default => $callback($val)
}; // Fatal error

echo $result;
```
* Example of `continue` and `break`
```
<?php
$start = microtime(TRUE);
$max = 100000;
for ($x = 5; $x < $max; $x++)
{
    // This if evaluation checks to see if number is odd or even
    if (($x % 2) === 0) continue;
    $test = TRUE;
    for($i = 3; $i < $x; $i++) {
        if(($x % $i) === 0) {
            $test = FALSE;
            break;
        }
    }
    if ($test) echo $x . ', ';
}
echo "Elapsed Time: " . microtime(TRUE) - $start;
echo "\n";
```
* Examples of `list()` operator
```
<?php
$city = [34.9852, -17.0039];
list($lat, $lon) = $city;
var_dump($lat, $lon);

// use this if array is "numeric"
[$lat, $lon] = $city;
var_dump($lat, $lon);

// use this if array is "associative"
$latLon = ['lat' => 34.9852, 'lon' => -17.0039];
['lat' => $lat, 'lon' => $lon] = $latLon;

$city = [
        'Seattle' => [34.9852, -17.0039],
        'DC' => [12.0057, -23.4451],
        'Baltimore' => [44.0045, -62.7781],
];

foreach ($city as $name => [$lat, $lon])
        echo "The lat/lon for $name is: $lat / $lon \n";
```
* You can do something similar to `list()` by using `extract()`
```
<?php
$mission = [
        'STS395' => [
                'botanist' => ['firstName' => 'Mark', 'lastName' => 'Watney'],
                'commander' => ['firstName' => 'Melissa', 'lastName' => 'Lewis'],
                'specialist' => ['firstName' => 'Beth', 'lastName' => 'Johanssen'],
        ],
        'STS396' => [
                'botanist' => ['firstName' => 'Mark', 'lastName' => 'Watney'],
                'commander' => ['firstName' => 'Melissa', 'lastName' => 'Lewis'],
                'specialist' => ['firstName' => 'Beth', 'lastName' => 'Johanssen'],
        ],
];

foreach ($mission as $id => $titles) {
        foreach ($titles as $title => $info) {
                // extract() turns keys into variables
                extract($info);
                echo "$firstName $lastName is a $title\n";
        }
}
```
* `declare()` is used on a file-by-file basis for:
  * Strict type checking
  * Character encoding
  * Setting the `tick` count (used for asynchronous coding)
    * See also: https://www.php.net/manual/en/book.pcntl.php
    * If interested in PHP async, check out the Swoole extension and the ReactPHP framework
* Type-hinting
```
<?php
// "iterable" is a super-type that allows for any array or object that
// is acceptable to foreach()
function sum_of_values(iterable $a)
{
        $total = 0;
        foreach ($a as $price) {
                $total += $price;
        }
        return $total;
}

$a = [1,2,3,4,5];
echo "Sum is: " . sum_of_values($a) . "\n";
$a = new ArrayIterator([1,2,3,4,5]);
echo "Sum is: " . sum_of_values($a) . "\n";
$a = new ArrayObject([1,2,3,4,5]);
echo "Sum is: " . sum_of_values($a) . "\n";
```
* Type declarations: https://www.php.net/manual/en/language.types.declarations.php
* Name parameters (named arguments)
```
<?php
// NOTE: any version of PHP:
setcookie('TEST1', 1111, 0, '', '', FALSE, TRUE);

// NOTE: PHP 8 only!!! :
setcookie('TEST2', 2222, httponly:TRUE);

```
* Use the variadics operator to provide an unlimited number of args
```
<?php
function super_dump(...$params) : void
{
        foreach ($params as $item)
                var_dump($item);
}

$a = [1,2,3];
$b = 'TEST';
$c = 99999.99;
super_dump($a);
super_dump($b, $c);
super_dump('A', 'B', 'C', 'D');
```
* Use `static` if you need to retain the value for successive function calls
```
<?php
define('TOKEN_FN', __DIR__ . '/token.txt');
function getToken()
{
        static $token = NULL;
        if (empty($token)) $token = file_get_contents(TOKEN_FN);
        return $token;
        //return file_get_contents(TOKEN_FN);
}

$start = microtime(TRUE);
for ($x = 0; $x < 100000; $x++) echo getToken();

echo 'Elapsed time: ' . (microtime(TRUE) - $start) . "\n";
```
* Example of a data validation mechanism using pass-by-reference for the `$err` array
```
<?php
// example using pass-by-ref for error messages

function checkAlnum(string $val, array &$err) : bool
{
        $valid = ctype_alnum($val);
        if (!$valid)
                $err[] = $val . ' must only contain letters or numbers';
        return $valid;
}

function checkLength(string $val, int $min, int $max, array &$err) : bool
{
        $valid = (strlen($val) >= $min && strlen($val) <= $max);
        if (!$valid)
                $err[] = "$val must be between $min and $max characters in length";
        return $valid;
}

$data = [
        '12345',
        'some_username',
        'abc',
];

$err = [];
$actual = 0;
$expected = count($data) * 2;
foreach ($data as $item) {
        $actual += checkAlnum($item, $err);
        $actual += checkLength($item, 1, 5, $err);
}
if ($actual === $expected) {
        echo "Valid data\n";
} else {
        echo implode("\n", $err);
}
```
* You can reference individual characters in a string using array syntax
```
<?php
$file = __FILE__;
echo $file;

echo ($file[0] === '/') ? 'Starts with leading slash' : 'Starts with a character';

$max = strlen($file);
for ($x = 0; $x < $max; $x++) echo $file[$x] . PHP_EOL;
```
* Redirect home after failing to open a file
```
<?php
$fh = fopen('file_does_not_exist.txt', 'r');
if ($fh === FALSE) {
        // redirect back home
        header('Location: /');
        exit;
}
fpassthru($fh);
fclose($fh);
```
* Two ways to get a list of files in a directory:
```
<?php
// see: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch02/php8_nested_ternary.php
$path = realpath(__DIR__ . '/..');
$list = glob($path . '/*');
var_dump($list);

$iter = new RecursiveDirectoryIterator($path);
var_dump(iterator_to_array($iter));
```
* Capturing checkbox data, where you are using a key (not empty `[]` )
  * Also: filtering, validation and escaping
```
<?php
$item = '';
$err  = [];
if (!empty($_POST)) {
        $item = $_POST['item'] ?? '';
        // validation:
        if (!ctype_alnum($item)) $err[] = 'ERROR: item can only contain letters and numbers';
        // filtering:
        $item = strip_tags(trim($item));
}
?>
<form action="/test.php" method="post">
    <fieldset>
        <legend>Add Checklist Item</legend>
        <label for="item">Enter the checklist item</label>
        <!-- output escaping: -->
        <input type="text" name="item" id="item" value="<?= htmlspecialchars($item) ?>">
        <label for="priority">Enter the priority</label>
        <input type="text" name="priority" id="priority">
        <br />
        <input type="checkbox" value="M" name="gender[M]" /> Male
        <input type="checkbox" value="F" name="gender[F]" /> Female
        <input type="checkbox" value="X" name="gender[X]" /> Other
        <input type="submit" value="Submit">
    </fieldset>
</form>
<?php if (!empty($err)) echo implode('<br />', $err); ?>
<?php
$male = $_POST['gender']['M'] ?? '';
echo ($male) ? 'You are a man' : 'You are NOT a man';
phpinfo(INFO_VARIABLES);
?>
```
* Autoloading examples:
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_autoload_example.php
  * https://github.com/dbierer/php-ii-jun-2021/blob/master/autoload_example.php

## OOP
PHP 8 provides "constructor argument promotion"
```
<?php
class UserEntity {
    public function __construct(
        public string $firstName = 'Default',
        public string $lastName = 'Default'
    )
    {
                // any body processing is optional
                $this->lastName = strtoupper($lastName);
        }
}
$user[] = new UserEntity();
$user[] = new UserEntity('Jack' , 'Ryan');
$user[] = new UserEntity('Monte' , 'Python');

var_dump($user);
```
This returns object properties in the form an array:
```
<?php
class Test
{
        protected $title = 'Test Title';
        protected $test = 'TEST';
        protected $status = 'Open';
        public function getArrayCopy()
        {
                return get_object_vars($this);
        }
}

$test = new Test();
var_dump($test->getArrayCopy());
```
Use `ArrayObject` if you need to access properties as an array
```
<?php
class Test extends ArrayObject
{
        public function __construct(
                protected $title = 'Test Title',
                protected $test = 'TEST',
                protected $status = 'Open'
        )
        {
                parent::__construct(get_object_vars($this));
        }
}

$test = new Test();
var_dump($test->getArrayCopy());

$test = new Test('New Title', 'NEW TEST', 'Closed');
var_dump($test->getArrayCopy());
```
Anonymous classes
* See: https://github.com/dbierer/classic_php_examples/tree/master/oop
Magic Methods
* See: https://www.php.net/manual/en/language.oop5.magic.php
* `__destruct()` method example: cleans up old CAPTCHA image files
  * https://github.com/dbierer/SimpleHtml/blob/main/src/Common/Image/Captcha.php
* `__get()` and `__set()` example
  * See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_get_set.php
* `__call()` used to implement "plugins"
  * See: https://github.com/laminas/laminas-mvc/blob/4.0.x/src/Controller/AbstractController.php
Serialization native PHP vs. JSON
```
<?php
class Test extends ArrayObject
{
        public function __construct(
                public $title = 'Test Title',
                protected $test = 'TEST',
                protected $status = 'Open'
        )
        {
                parent::__construct(get_object_vars($this));
        }
}

$test = new Test('New Title', 'NEW TEST', 'Closed');
$str  = serialize($test);
$json = json_encode($test);
echo $str . "\n";
echo $json . "\n";

$obj = json_decode($json);
var_dump($obj);

$obj2 = unserialize($str);      // full object Test is restored
var_dump($obj2);
var_dump($obj2->getArrayCopy());
```
Class example of an Abstract class:
* https://www.php.net/FilterIterator
Interfaces make excellent type-hints and serve as pseudo datatypes
```
<?php
interface ArrayCopyInterface
{
        public function getArrayCopy() : array;
}
class Test implements ArrayCopyInterface
{
        public function __construct(
                public $title = 'Test Title',
                protected $test = 'TEST',
                protected $status = 'Open'
        )
        {
        }
        public function getArrayCopy() : array
        {
                return get_object_vars($this);
        }
}

$test = new Test('New Title', 'NEW TEST', 'Closed');
var_dump($test->getArrayCopy());

echo ($test instanceof Test) ? 'Instance of Test' : 'Not Instance';
echo "\n";
echo ($test instanceof ArrayCopyInterface) ? 'Instance of ArrayCopyInterface' : 'Not Instance';
echo "\n";
```
Callable examples
* See: https://github.com/dbierer/php-ii-jun-2021/blob/master/autoload_example.php
Using Interfaces as type hints
* See: https://github.com/laminas/laminas-db/blob/master/src/Adapter/Adapter.php
Strict type checking
```
<?php
declare(strict_types=1);
class Test
{
        public function add(int $a, int $b)
        {
                return $a + $b;
        }
}

$test = new Test();
// works OK
echo $test->add(222, 111);
echo PHP_EOL;
// this is a Fatal Error only if strict_types=1
echo $test->add(222.777, 111.888);
echo PHP_EOL;
// this is a Fatal Error only if strict_types=1
echo $test->add(222, '111');
echo PHP_EOL;
// Fatal Error regardless: non-numeric strings are unacceptable
echo $test->add(222, '111x');
echo PHP_EOL;
```
Late static binding
```
<?php
// also: see https://www.php.net/manual/en/language.oop5.late-static-bindings.php
class Base
{
        public static function getInstance() : self
        {
                return new self();
        }
}
class Child extends Base {}

class Base2
{
        public static function getInstance() : static
        {
                return new static();
        }
}
class Child2 extends Base2 {}

$base = Base::getInstance();
echo get_class($base);
echo PHP_EOL;

$child = Child::getInstance();
echo get_class($child);
echo PHP_EOL;

$base = Base2::getInstance();
echo get_class($base);
echo PHP_EOL;

$child = Child2::getInstance();
echo get_class($child);
echo PHP_EOL;

```
* Example using `clone` with `DateTime` 
```
<?php
$date = new DateTime(); // today's date
for ($x = 30; $x < 100; $x += 30) {
    $day[$x] = clone $date;
    $day[$x]->add(new DateInterval('P' . $x . 'D'));
    echo '<br>' . $day[$x]->format('Y-m-d') . PHP_EOL;
}

var_dump($day);
```
* Example of the "factory" pattern
  * https://github.com/laminas/laminas-diactoros/blob/master/src/ServerRequestFactory.php

## Other Notes
ETag Browser cache manipulation example:
* https://github.com/dbierer/classic_php_examples/blob/master/web/etag.php
API Calls
* REST example: https://github.com/dbierer/classic_php_examples/blob/master/web/rest_api_call_us_weather_svc.php
* SOAP example: https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php

## Resources
Previous class notes:
* https://github.com/dbierer/php-class-notes/blob/master/php-exp-jun-2021.md
Related repositories:
* https://github.com/dbierer/php-ii-aug-2021
* https://github.com/dbierer/php-ii-jun-2021
Web server survey
* https://news.netcraft.com/archives/2021/05/31/may-2021-web-server-survey.html
PHPUnit: https://phpunit.de/
PHPDocumenter: https://phpdoc.org
`php.ini` directives: https://www.php.net/manual/en/ini.list.php
JIT
* Code examples for testing: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/tree/main/ch10
* Settings: 
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


## CURRENT HOMEWORK

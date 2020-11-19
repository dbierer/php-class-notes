# PHP -I Nov 2020

## Homework
  * For Thu 19 Nov 2020
    * http://collabedit.com/hxcbj
  * For Wed 18 Nov 2020
    * https://gist.github.com/dbierer/deae9980ac911bb84aabd2f58604cbcd
  * For Mon 16 Nov 2020
    * http://collabedit.com/t9act
  * For Fri 13 Nov 2020
    * Do a review of how the OrderApp generates HTML forms
    * `orderapp/config/config.php`
    * `orderapp/src/Forms.php`
  * For solutions: create your own gist: https://gist.github.com/
  * For Wed 11 Nov: https://gist.github.com/dbierer/e251abd66213cb58d97647054ef2a4a1
  * For Mon 9 Nov: http://collabedit.com/8f2rd
    ALL labs for course module #3 (Foundation)
    * Lab: The Mixed Array 1: 
    * Lab: The Mixed Array 2:
    * Lab: The Multi Array
    * Lab: The Multi Configuration Array
    * Lab: Additional Crew Members
  * For Fri 6 Nov
    * Create a "Hello World" program such at you can see it as follows: `http://sandbox/hello_world.php`
      * Hint: use this: `echo 'Hello World';`
## VM Notes
* You can create sample program files in this path:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
```
* You can then run the scripts from a terminal window, or
  * From a browser: `http://sandbox/`
* The `sandbox` folder is mapped through the web server using this config file:
  * `/etc/apache2/sites-available`
```
     <VirtualHost *:80>
         ServerName sandbox
         DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
         <Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public/>
             Options Indexes FollowSymlinks MultiViews
             AllowOverride All
             Require all granted
         </Directory>
     </VirtualHost>
```
## Class Notes
* Excellent JavaScript library: https://jquery.com/
* Standings for web dev languages: https://w3techs.com/
* Web design tool: https://www.adobe.com/products/dreamweaver.html
* Pre-Defined Constants
  * Determined when PHP is installed on a server
  * See: https://www.php.net/manual/en/reserved.constants.php
* Great data source: https://www.geonames.org/
* If you need to confirm the data type, use one of the `is_*()` functions
  * Example: https://www.php.net/is_string
* Settings that control PHP's behavior: https://www.php.net/manual/en/ini.list.php
* PHP Documentor Project: automatic documentation generation
  * https://phpdoc.org/
* Two excellent functions to test to see if an array key exists and has a value
  * `array_key_exists($array, $key)` : checks to see if the array key is set; doesn't check the value
  * `empty($array[$key])` : checks to see if there is a value at that key (i.e. non-empty string, non-null, non-zero)
  * `isset($array[$key])` : same as array_key_exists()
* A repo of code examples of all different types:
  * https://github.com/dbierer/classic_php_examples
* Any HTTP header sent by the browser is present in `$_SERVER[]` using this algorithm:
  * Dashes "-" are converted to underscore "_"
  * The key is prepended with 'HTTP_'
  * The key is made all UPPERCASE
* Extremely commonly used string functions:
  * `substr()`
  * `strpos()`
  * `str_replace()`
* To manage third party sofware:
  * Composer: https://getcomposer.org (manages libraries available on Packagist)
  * Packagist: https://packagist.org (largest repository of PHP libraries: current and up-to-date)
  * Replacement for pear.php.net
* Basic tutorials on related technology:
  * HTML: https://www.w3schools.com/html/default.asp
* JavaScript library: jquery.com
* Example of a file upload: https://github.com/dbierer/classic_php_examples/blob/master/web/upload_file.php
* URLs are generally encoded (e.g. special characters get an ASCII code assigned: space == "%20")
  * If you need to do this yourself in a PHP program, use `url_encode()`
## Code Examples
* Simple data type assignments:
```
<?php
$a = 'This is a string';
$b = "This is a string with $a\n";
$c = PHP_INT_MAX;
$d = 123.456;
$e = TRUE;
$f = $c + 1;
var_dump($a, $b, $c, $d, $e, $f);
```
* Array assignments examples:
```
<?php
$names = ['Donald','Boris','Joe','Kamala'];
var_dump($names);

$db = [
	'db_user' => 'admin',
	'db_pwd'  => 'password',
	'db_name' => 'events',
	'db_host' => '192.168.3.16',
];

echo "The name of the database is {$db['db_name']}\n";
```
* Simple object example:
```
<?php
class Person {	
    public $firstname = 'Fred';
    public $lastname  = 'Flintstone';
    public function getFirstName() {
        return $this->firstname;
    }	
}
$person = new Person();
echo $person->getFirstName();
$person->firstname = 'George';
echo $person->getFirstName();
```
* Example of data type changing on the fly
```
<?php
$a = 12345;
// comes back as integer
var_dump($a);
$a = $a . ' is the current number';
// comes back as string
var_dump($a);
```
* Example of enforcing strict data types:
```
<?php
declare(strict_types=1);
class Test {
	public int $a = 12345;
}
$test = new Test();
// comes back as integer
var_dump($test->a);
$test->a = $test->a . ' is the current number';
// comes back as string
var_dump($test->a);
```
* Mixing PHP and HTML
```
<?php
$welcome = '<h1>Welcome</h1>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
<?= $welcome ?>
</body>
</html>
```
* Examples of type juggling
```
<?php
$a = 123;
$b = '456';
$c = $a + $b;
$d = $a . $b;
var_dump($a,$b,$c,$d);

$a = 123;
$b = (string) 456;
$c = $a + $b;
$d = $a . $b;
var_dump($a,$b,$c,$d);

$a = 123;
$b = 'xxx456';
$c = $a + $b;
$d = $a . $b;
var_dump($a,$b,$c,$d);
```
* Example of using type casting to enforce data type + add security
```
<?php
$id = $_GET['id'] ?? 0;
// you could also sanitize inputs using "strip_tags()"
$id = (int) $id;
echo "ID: $id";
```
* Increase memory allocation
```
<?php
// allocates 1 G of RAM for this script execution
ini_set('memory_limit', '1G');
```
* Example showing possible issue with order or precedence
```
<?php	
echo 5 - 3 . '<br>';
echo 5 + 3 . '<br>';
echo 5 * 3 . '<br>';
echo 5 / 3 . '<br>';
echo 5 % 3 . '<br>';
echo 5 ** 3 . '<br>';
$value = 5;
echo $value;
echo "\Revised\n";
// use parentheses to control the flow of the operations
echo '<br>' . (5 - 3);
echo '<br>' . (5 + 3);
echo '<br>' . (5 * 3);
echo '<br>' . (5 / 3);
echo '<br>' . (5 % 3);
echo '<br>' . (5 ** 3);
$value = 5;
echo $value;
```
* Value check vs. data+value check
```
<?php	
$a = '123';
$b = 123;
if ($a == $b) {
	echo "\nEqual " . __LINE__;
} else {
	echo "\nNot Equal" . __LINE__;
}
if ($a === $b) {
	echo "\nEqual " . __LINE__;
} else {
	echo "\nNot Equal" . __LINE__;
}
```
* Example of a loop by 10
```
<?php	
$array = ['A','B','C','D','E','F'];
$pos = 10;
foreach ($array as $value) {
	echo $pos . ':' . $value . "\n";
	$pos += 10;
}
```
* Assigning the root of the project structure to a constant:
```
<?php	
define('BASE_PATH', realpath(__DIR__ . '/..'));
echo BASE_PATH;
```
* Acquiring info from a URL and storing into an array
```
<?php	
// example URL:
// http://sandbox/test.php?first=Doug&last=Bierer&spec=PHP%20Developer

// acquiring input from the URL
$first = $_GET['first'] ?? '';
$last = $_GET['last'] ?? '';
$spec = $_GET['spec'] ?? '';

// sanitizing the input
$first = strip_tags($first);
$last = strip_tags($last);
$spec = strip_tags($spec);

// storing into an array
$astronaut = [
	'firstName' => $first,
	'lastName'  => $last,
	'specialty' => $spec
];

echo '<pre>';
var_dump($astronaut);
echo '</pre>';

echo "Astronaut: " . $astronaut['firstName']
	 . ' ' . $astronaut['lastName']
	 . ' is a ' . $astronaut['specialty'];

// presumably, you'd do something with the array
// etc.
```
* Same code as above, but refactored, taking advantage of the looping structure foreach()
```
<?php	
// example URL:
// http://sandbox/test.php?first=Doug&last=Bierer&spec=PHP%20Developer

// acquiring input from the URL
$astronaut = $_GET ?? [];

// sanitizing the input
foreach ($astronaut as $key => $value) {
	$astronaut[$key] = strip_tags($value);
}

echo '<pre>';
var_dump($astronaut);
echo '</pre>';

echo "Astronaut: " . $astronaut['first']
	 . ' ' . $astronaut['last']
	 . ' is a ' . $astronaut['spec'];

// presumably, you'd do something with the array
// etc.
```
* A more readable way of building an array
```
<?php
// Build the crew
$mission = [
	'STS395' => 
	[
		['firstName' => 'Mark',    'lastName' => 'Watney',    'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis',     'specialty' => 'Commander'],
		['firstName' => 'Beth',    'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
	]
];
 
// Access the Commander's last name
echo $mission['STS395'][1]['lastName'];
```
* Example of generating a series of checkboxes from an array with a pre-selection
```
<?php
// using the ternary operator to test the presence of the key + sanitize
$choice = (isset($_GET['gender'])) ? strip_tags($_GET['gender']) : '';
// another option assigns data sources in chain: 
// -- reads left-to-right
// -- takes the first non-NULL value
// $choice = $_POST['gender'] ?? $_GET['gender'] ?? $_SESSION['gender'] ?? $_COOKIE['gender'] ?? '';
$gender = [
	'M' => 'Male',
	'F' => 'Female',
	'X' => 'Other'
];

echo '<form>';
echo '<ul>';
foreach ($gender as $key => $value) {
	$checked = ($key === $choice) ? ' checked ' : '';
	echo '<li><input type="radio" name="gender" value="' . $key . '" ' . $checked . '/>' . $value . '</li>';
}
echo '</ul>';
echo '<input type="submit" />';
echo '</form>';
```
* Example building an SQL INSERT statement using foreach() and continue
```
<?php
$fields = ['id','first','last','address','city','postcode','country'];
$sql = 'INSERT INTO users (';
foreach ($fields as $name) {
	if ($name == 'id') continue;
	$sql .= $name . ',';
}
$sql[-1] = ' ';
$sql .= ') VALUES (:';
foreach ($fields as $name) {
	if ($name == 'id') continue;
	$sql .= $name . ', :';
}
$sql = substr($sql, 0, -3);
$sql .= ');';
echo $sql;
```
* Example using strict type checks
```
<?php
declare(strict_types=1);
function add(int $a, int $b, string $label)
{
	return $label . ' ' . ($a + $b) . PHP_EOL;
}

echo add('The sum is: ', 2,2);
```
* Example of using an array to build a form + determining the next day
```
<?php
// initializes vars
$message = 'DayCheck';
$days    = [ 'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

// generate HTML SELECT
$select  = '<select name="day">';
foreach ($days as $num => $val)
	$select .= '<option value="' . $num . '">' . $val . '</option>';
$select .= '</select>';

// process POST data
if (isset($_POST['day'])) {
	// sanitize the data
	$num = (int) $_POST['day'];
	$max = count($days);
	if ($num == ($max - 1)) {
		$next = 0;
	} else {
		$next = $num + 1;
	}
	$message = 'See you on ' . $days[$next];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Test</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
	<?= $message ?> <br>
	<form method="post">
	What day is today <?= $select ?>
	<input type="submit" name="button1" class="button" value="Check"/>
	</form>
</body>
</html>
```
* Previous example but using `switch`
```
DayCheck <br>
	<form method="post">
	What day is today <input type="text" name="day">
	<input type="submit" name="button1" class="button" value="Check"/>
	</form>
<?php

$day = $_POST['day'];
$message = '';
switch ($day) {
	case 'Monday' :
		$message = 'Tuesday';
		break;
	case 'Tuesday' :
		$message = 'Wednesday';
		break;
	// not all code shown
	default :
		$message = 'Invalid Day';
}
echo 'See you on ' . $message . '<br>';
?>
```
* Rewritten example of `switch` from homework
```
OriginCheck <br>
	<form method="post">
	Origin Country <input type="text" name="origin">
	<input type="submit" name="button1" class="button" value="Check"/>
	</form>

<?php
$origin = $_POST['origin'] ?? '';
switch ($origin) {
	case 'US':
		$country = 'America';
		break;
	case 'UK':
		$country = 'United Kingdom';
		break;
	case 'PL':
		$country = 'Poland';
		break;
	case 'IN':
		$country = 'India';
		break;
	default:
		$country = 'Undefined Country';
}
echo "The Astronout is from " . $country . "<br>";
```
* Example using type hints + alt lang settings
```
<?php
// initializes vars
define('MAX_DAYS', 7);
$message = 'DayCheck';
$daysWithLanguage    = [ 
	'en' => ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
	'fr' => ['dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi'],
];

// get language setting 
// NOTE: could also extract from $_SERVER['HTTP_ACCEPT_LANGUAGE'] which comes from the browser
$lang = $_GET['lang'] ?? 'en';

// safety check
if (!isset($daysWithLanguage[$lang])) $lang = 'en';

// generate HTML SELECT
function makeSelect(array $days)
{
	$select  = '<select name="day">';
	foreach ($days as $num => $val)
		$select .= '<option value="' . $num . '">' . $val . '</option>';
	$select .= '</select>';
	return $select;
}

function whatsNext(int $num, int $max)
{
	if ($num == ($max - 1)) {
		$next = 0;
	} else {
		$next = $num + 1;
	}
	return $next;
}

// process POST data
if (isset($_POST['day'])) {
	// sanitize the data
	$num = (int) $_POST['day'];
	$max = MAX_DAYS;
	$next = whatsNext($num, $max);
	$message = 'See you on ' . $daysWithLanguage[$lang][$next];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Test</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
	<?= $message ?> <br>
	<form method="post">
	What day is today <?= makeSelect($daysWithLanguage[$lang]) ?>
	<input type="submit" name="button1" class="button" value="Check"/>
	</form>
</body>
</html>
```
* Example that demonstrates how type-hinting facilitates trouble-shooting
```
<?php
// initializes vars
define('MAX_DAYS', 7);
$message = 'DayCheck';
$days= ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

function showDays(array $days)
{
	$output = '';
	foreach ($days as $one) 
		$output .= $one . "<br>\n";
	return $output;
}

echo showDays($a);
```
* Example of function accepting an unknown / unlimited number of args
```
<?php

function superDump(...$args)
{
	$output = '';
	if (!empty($args)) {
		foreach ($args as $var) {
			$output .= "\n";
			$output .= var_export($var, TRUE);
		}
	}
	return $output;
}

$a = new stdClass();
$a->name = 'Doug';
$a->country = 'Thailand';
$b = [1,2,3,4,5];
$c = 'String of some sort';

echo superDump();
echo superDump($a);
echo superDump($a, $b, $c);
```
* Example of successive transformations using pass-by-reference
```
<?php
function reverse(string &$str)
{
	$str = strrev($str);
}
function everyOtherUpper(string &$str)
{
	$len = strlen($str);
	for ($x = 0; $x < $len; $x++) {
		if (($x % 2) === 0) {
			$str[$x] = strtoupper($str[$x]);
		}
	}
}
function everyThirdNum(string &$str)
{
	$len = strlen($str);
	for ($x = 0; $x < $len; $x++) {
		if (($x % 3) === 0) {
			$str[$x] = rand(0,9);
		}
	}
}
$string = 'This is a test, this is only a test.  Do not panic!';
echo $string . "\n";
reverse($string);
everyOtherUpper($string);
everyThirdNum($string);
echo $string . "\n";
```
* Example of using `printf()` to do base conversions: e.g. binary, hex and decimal
```
<?php
$b = 198;
printf('%08b %4X %d', $b, $b, $b);
```
* Demonstrates usage of `strpos()`
```
<?php
$str = 'The quick brown fox jumps over the fence';
echo strpos($str, 'the');	// 31
echo "\n";
echo strpos($str, 'The');	// 0
echo "\n";
var_dump(strpos($str, 'duck'));	// FALSE
echo "\n";
echo stripos($str, 'the');	// 0
echo "\n";

// wrong way to determine presence or absence
if (strpos($str, 'The')) {
	echo "This string contains the word The\n";
} else {
	echo "This string does NOT contain the word The\n";
}


// demonstrates proper usage of strpos to determine presence or absence
if (strpos($str, 'The') !== FALSE) {
	echo "This string contains the word The\n";
} else {
	echo "This string does NOT contain the word The\n";
}
```
* Examples of `sort()`, `asort()` and `ksort()`
```
<?php
$arr = [
	'A' => 111,
	'C' => 333,
	'F' => 999,
	'G' => 888,
	'B' => 777,
	'D' => 444,
	'E' => 555
];

$copy1 = $arr;
$copy2 = $arr;
$copy3 = $arr;

// don't rely upon the return value from sort!!!
// it operates by reference
$result = sort($copy1);

// NOTE: wipes out the keys!
var_dump($copy1);

// Retains the keys
asort($copy2);
var_dump($copy2);

// Sorts by key
ksort($copy3);
var_dump($copy3);
```
* Example using `fopen()`
```
<?php
$fn = __DIR__ .'/gettysburg.txt';

$count = 0;
$fh = fopen($fn, 'r');
while($line = fgets($fh)) {
	$count += str_word_count($line);
}
echo 'The Gettysburg Address has ' . $count . ' words';
fclose($fh);
```
* Example reading from a URL and manipulating contents
```
<?php
$contents = file_get_contents('https://google.com/');
$contents = str_replace(['Google','google'],['Boogle','boogle'],$contents);
echo $contents;
```
* Example using `glob()`
```
<?php
$start = __DIR__ . '/../../orderapp/src';
$list  = glob($start . '/*.php');
foreach ($list as $fn) {
	echo $fn . "\n";
}
```
* Example of how to iterate through an entire directory structure
```
<?php
// Read up on SplFileInfo: https://www.php.net/SplFileInfo
$start = __DIR__ . '/../../orderapp';
$dirIterator = new RecursiveDirectoryIterator($start);
$recurse     = new RecursiveIteratorIterator($dirIterator);
foreach ($recurse as $name => $obj) {
	// $obj == SplFileInfo
	echo $name . "\n";
}
```
* Example of a program that produces either JSON or HTML
```
<?php
$type = $_GET['type'] ?? 'json';
$data = ['A' => 111, 'B' => 222, 'C' => 333];
if ($type == 'json') {
	header('Content-Type: application/json');
	echo json_encode($data, JSON_PRETTY_PRINT);
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
<?php foreach($data as $key => $value) echo 'Key: ' . $key . ' Value: ' . $value . '<br>'; ?>
</body>
</html>
```
* Third way of having PHP generate an HTML page:
```
<?php
$html = file_get_contents('test.html');
$replace = 
	['Sample Test Page',
	 'Welcome',
	 '<p>This represents some contents.</p><p>Blah blah blah.</p>'];
$html = str_replace(['%%TITLE%%','%%HEADER%%','%%CONTENT%%'], $replace, $html);
echo $html;
```
* Here is the sample HTML template:
```
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>%%TITLE%%</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
<H1>%%HEADER%%</H1>
<hr>
%%CONTENT%%
</body>
</html>
```
* Adding to the earlier example form posting:
```
<?php
$html = file_get_contents('test.html');
$replace = 
	['Sample Test Page',
	 'Welcome'];
$replace[] = <<<EOT
<form action="test.php" method="post">
    <fieldset>
        <legend>Add Checklist Item</legend>
        <label for="item">Enter the checklist item</label>
        <input type="text" name="item" id="item" />
        <label for="priority">Enter the priority</label>
        <input type="text" name="priority" id="priority" />
        <input type="submit" value="Submit" />
    </fieldset>
</form>
EOT;
if (!empty($_POST)) {
	$replace[] = var_export($_POST, TRUE);
} else {
	$replace[] = '';
}
$html = str_replace(['%%TITLE%%','%%HEADER%%','%%CONTENT%%','%%MESSAGE%%'], $replace, $html);
echo $html;
```
* Here's the HTML template:
```
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>%%TITLE%%</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
<H1>%%HEADER%%</H1>
<hr>
%%CONTENT%%
<hr>
<pre>%%MESSAGE%%</pre>
</body>
</html>
```
* Revised form from 1st Forms lab
```
<?php
// process data
$username = '';
if (isset($_POST['submit'])) {
	// process submitted data
	phpinfo(INFO_VARIABLES);
} elseif (isset($_POST['cancel'])) {
	// process a cancellation
	// code not shown
}
?>
<?php $class='test'; $color='green'; $id='item test';?>
<?php $att = ['id' => $id, 'class' => $class, 'name' => 'data', 'type' => 'password']?>   
<form action="/test.php" method="post">
<ul style ='list-style:none;'>
	<li style='color: <?= $color ?>;padding: 10px;'>
	Username: <input name="username" id='cb_<?= $id ?>' class='<?= $class ?>' value="<?= $username ?>" type="text" />
	</li>   		
	<li style='color: <?= $color ?>;padding: 10px;'>
	Password: <input <?php foreach($att as $key => $value) echo " $key='$value' ";?> />
</li>	
</ul>
<!-- You could also do this: -->
<input type="submit" name="submit" value="Submit" />
<input type="submit" name="cancel" value="Cancel" />
<!-- <button type = "submit">Submit</button> -->
</form>
```
* Second form example using just PHP + sanitization + validation + output escaping
```
<?php
$message = '';
$config = [
	'username' => [
		'type' => 'text',
		'id'   => 'user_123',
		'title' => 'Enter your username',
		'size' => 40,
		'value' => '',
	],
	'email' => [
		'type' => 'email',
		'id'   => 'email_123',
		'placeholder' => 'Enter your email address',
		'size' => 40,
		'value' => '',
	],
	'age' => [
		'type' => 'number',
		'id'   => 'age_123',
		'placeholder' => 'Must be 18 or older to login',
		'value' => '',
	],
	'submit' => [
		'type' => 'submit',
		'name' => 'submit',
		'value' => 'Login',
	],
];

function htmlTable(string $title = 'Login', array $config) {
	 $html = '<form action="test.php" method="post">' . PHP_EOL;
     $html .= '<table><thead>' . PHP_EOL;
     $html .= "<tr><th colspan=\"2\">$title</th></tr>\n";
     $html .= '</thead><tbody>' . PHP_EOL;    
     foreach ($config as $key => $value) {
		 $html .= '<tr><th>' . ucfirst($key) . '</th>' . PHP_EOL;
		 $html .= '<td><input name="' . $key . '" ';
		 foreach ($value as $attr => $item) {
			 if ($attr == 'value') {
				 $html .= $attr . '=' . '"' . htmlspecialchars($item) . '" ';
			 } else {
				$html .= $attr . '=' . '"' . $item . '" ';
			}
		 }
		 $html .= ' /></td></tr>' . PHP_EOL;
	 }
     $html .= '</tbody></table>' . PHP_EOL;    
     $html .= '</form>' . PHP_EOL;    
     return $html;
}
     
// validation
if (!empty($_POST)) {
	// quick sanitization
	foreach ($_POST as $key => $value) 
		$_POST[$key] = strip_tags($_POST[$key]);
	// capture the input
	$config['age']['value'] = $_POST['age'] ?? '';
	$config['email']['value'] = $_POST['email'] ?? '';
	$config['username']['value'] = $_POST['username'] ?? '';
	//validation
	$expect = 2;
	$actual = 0;
	// #1: check to see if age is integer
	$actual += ctype_digit($config['age']['value']);
	// #2: check to see if age > 18
	$actual += ((date('Y') - $config['age']['value']) <= (date('Y') - 18)) ? 1 : 0;
	if ($actual === $expect) {
		$message = 'Proceed to Login';
	} else {
		$message = 'Sorry ... would you like to see some really great landscapes?';
	}
}

// output
echo htmlTable('Hours Worked', $config);
echo ($message) ? '<hr><b style="color:red;">' . $message . '</b>' : '';
```
* Example using cookies to increment and decrement a counter
```
<?php
// Get the value of the submit button using $_REQUEST['name_of_submit_button']
$button = isset($_REQUEST['action']) ? htmlentities($_REQUEST['action']) : "";
$counter = isset($_COOKIE['counter']) ? (int) $_COOKIE['counter'] : 1;
// Test to see if == "+"
if ( $button == "+" ) {
	// If so then increment the counter
	$counter++;
} else {
	// Otherwise decrement the counter
	$counter--;
}
setcookie("counter", $counter, time()+300, '/');
// Process name
if (isset($_COOKIE['name'])) {
	$name = $_COOKIE['name'];
} elseif (isset($_GET['name'])) {
	$name = $_GET['name'];
	setcookie("name", $name, time()+300, '/');
} else {
	$name = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Counter Example Using Cookies</title>
</head>
<body>
<h1>Counter Example Using Cookies</h1>
<p>&nbsp;</p>
<form name="Cookie" method=GET>
<?php 
if ($name) {
	echo "<b>Hello " . strip_tags($name) . "</b><br>\n"; 
} else {
	echo "<br>Please enter your name:\n";
	echo "<br><input type=text name='name' size=40 maxlength=64>\n";	
	echo "<br><input type=submit name='OK' value='OK'>\n";	
}
?>
<table border=0>
<tr><td><input type=submit name="action" value="+"></td>
<td><input type=submit name="action" value="-"></td></tr>
</table>
</form>
<br>
<b>COUNTER:</b>&nbsp;
<?php 
// Display the current value of the counter here:
echo htmlspecialchars($counter);
?>
<br><a href="index.php">BACK</a>
<?php phpinfo(INFO_VARIABLES); ?>
</body>
</html>
```
* Example of SQL query with pagination
```
<?php

$first = 0;
$page  = $_GET['page'] ?? 0;
$lines = 10;
$offset = (int) $page * $lines;
$conn = mysqli_connect('127.0.0.1', 'vagrant', 'vagrant', 'phpcourse');
$result = mysqli_query($conn, "SELECT * FROM customers LIMIT $lines OFFSET $offset");
$header_pattern = "%2s | %12s | %20s\n";
$pattern = "%2d | %12s | %20s\n";
echo '<pre>';
while ($row = mysqli_fetch_assoc($result)) {
	if ($first++ === 0) {
		$headers = array_keys($row);
		vprintf($header_pattern, $headers);
		vprintf($header_pattern, ['--','------------','------------']);
	}
	vprintf($pattern, $row);
}
echo '</pre>';
mysqli_close($conn);
```
* Example of SQL `join` statement + results:
```
mysql> select * from customers as c join orders as o on c.id = o.customer;
+----+-----------+-----------+----+------------+----------+--------+--------------------------+----------+
| id | firstname | lastname  | id | date       | status   | amount | description              | customer |
+----+-----------+-----------+----+------------+----------+--------+--------------------------+----------+
|  4 | Susan     | Chu       |  1 | 1355097600 | complete |    560 |                          |        4 |
|  3 | Jason     | Flores    |  2 | 1359062345 | invoiced |   9800 |                          |        3 |
|  2 | Janet     | Levitz    |  3 | 1357948800 | held     |    300 |                          |        2 |
|  3 | Jason     | Flores    |  4 | 1359500400 | open     |     34 | Paper                    |        3 |
|  1 | George    | Stevenson |  5 | 1359586800 | open     |   4570 | PHP development          |        1 |
|  5 | Thomas    | White     |  6 | 1359586800 | invoiced |   2000 | Laptop                   |        5 |
|  3 | Jason     | Flores    |  7 | 1360796400 | open     |    300 | A big box of chocolates. |        3 |
+----+-----------+-----------+----+------------+----------+--------+--------------------------+----------+
7 rows in set (0.00 sec)
```

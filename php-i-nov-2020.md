# PHP -I Nov 2020

## Homework
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

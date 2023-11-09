# PHP Foundations -- Oct 2023

## TODO
* Add instructions for Adminer
  * https://adminer.org
* Add instructions for VM update

## Homework
Homework for Fri 10 Nov 2023
* https://collabedit.com/r5wf2

## VM Notes
### Expanded VM Instructions
* https://opensource.unlikelysource.com/expanded_vm_instructions.pdf

Info
* Username: `vagrant`
* Password: `vagrant`

Do Not Accept the Update or Upgrade Prompts
* Once you login it's important to wait a few seconds for the system to come fully up.
* At this point you'll see two prompts: one to update, one to upgrade. Be sure to decline both of these options!
Confirm that no unattended upgrades are in progress:
```
ps -ax |grep unattended
```
If you see any listed (except for the last one which is the `grep` command):
* Make a note of the "process ID" (PID)
* Kill the process as follows:
```
sudo kill [PID]
```

Now you can do the full update/upgrade
* This doesn't upgrade the OS, just the packages
* Open a command terminal and run these commands.
```
sudo dpkg --configure -a
sudo apt -y update && sudo apt -f -y install && sudo apt -y full-upgrade
```
It will take several hours to complete so it's best to let it run overnight.

Accept New Configuration
* At some point you will be asked if you wish to retain the original php.ini configuration or accept the new. Go ahead and accept the new configuration.

Update Apache PHP Module
* So far PHP from the command line (PHP-CLI) has been updated. You'll still need to update the PHP Apache module using these commands. Please note that "8.0" is the old version, and "8.2" is the new version. You may have to change these two values as more recent versions become available.
```
sudo apt-add-repository ppa:ondrej/apache2
sudo apt install libapache2-mod-php8.2
sudo a2dismod php8.0
sudo systemctl restart apache2
sudo a2enmod php8.2
sudo systemctl restart apache2
```

Installing Adminer database administration tool:
* From the VM using its browser, download the desired version (e.g. adminer-4.8.1-mysql-en.php)
* Move from the Downloads folder to `/var/www/html`
```

```


## Class Notes
Example of type juggling with comparison operators:
```
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$a = '111';
$b = 111;
echo ($a == $b) ? 'Equal' : 'Not Equal';
// Equal

$a = ' 111 '; // recommended: use trim($a)
$b = 111;
echo ($a == $b) ? 'Equal' : 'Not Equal';
// Equal

$a = ' 111 x';
$b = 111;
echo ($a == $b) ? 'Equal' : 'Not Equal';
// Not Equal

$a = 'x111x';
$b = 111;
echo ($a == $b) ? 'Equal' : 'Not Equal';
// Not Equal

$a = 'ABC';
$b = 111;
echo ($a == $b) ? 'Equal' : 'Not Equal';
// Not Equal

// this causes a Fatal Error because PHP might lose precision
echo $a + $b;
// Fatal error:  Uncaught TypeError: Unsupported operand types: string + int in /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public/test.php:31
```
For comparison logicals, you can use words instead of symbols:
```
<?php
$foo = 10;
$bar = 5;
echo ($foo == 10 && $bar == 5); // 1

$foo = 5;
$bar = 10;
echo ($foo != $bar || $foo > $bar); // 1
echo ($foo != $bar ^ $foo > $bar); // 1

$foo = 10;
$bar = 5;
echo ($foo == 10 and $bar == 5); // 1

$foo = 5;
$bar = 10;
echo ($foo != $bar or $foo > $bar); // 1
echo ($foo != $bar xor $foo > $bar); // 1
```

If you want to publish PHP code to the `http://sandbox/xxx.php`
* Just create the code in this directory in the VM:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
```

Docblocks
* PHP Documentor project
* https://phpdoc.org/
Comments
* You can also use `Attributes`
* They are part of the language and accessible at runtime
* See: https://www.php.net/manual/en/language.attributes.syntax.php
* Example: https://www.doctrine-project.org/projects/doctrine-orm/en/2.16/tutorials/getting-started.html#adding-bug-and-user-entities

Useful string functions:
* `substr()`
* `str_replace()`
* `strpos()`

How PHP actually works:
* https://www.zend.com/blog/exploring-new-php-jit-compiler

Pre-assigning default values that match the data type:
```
<?php
$a = '';	// string
$b = 0;		// int
$c = 0.0;	// float
$d = TRUE;	// bool

var_dump($a, $b, $c, $d);
```
Pre-defined constants
* Defined when PHP is installed
* See: https://www.php.net/manual/en/reserved.constants.php

Mixing HTML and PHP:
* If you do this you need the closing tags!
```
<?php $name = 'Steven'; ?>
<h1><?= $name; ?></h1>
```

Example using the modulus operator to determine remaining minutes:
```
<?php
$min = 795;
$hours = (int) ($min / 60);
$remain = $min % 60;
echo '$min is $hours hours and $remain minutes\n';

```
Determining the datatype at runtime
```
<?php
// use is_* functions to check the data type
$astronaut = ['Mark', 'Watney', 'Botanist'];
if (is_array($astronaut)) {
	print_r($astronaut);
} elseif (is_string($astronaut)) {
	echo $astronaut;
} else {
	echo 'Unknown';
}
// use gettype() to reveal the data type
echo gettype($astronaut);

```
Using the spread operator to flatten two sub-arrays
```
<?php
$business = ['Mon','Tue','Wed','Thu','Fri'];
$weekend  = ['Sat','Sun'];
$days     = [$business, $weekend];
var_dump($days);
// actual output:
/*
 * array(2) {
  [0]=>
  array(5) {
    [0]=>
    string(3) 'Mon'
    [1]=>
    string(3) 'Tue'
    [2]=>
    string(3) 'Wed'
    [3]=>
    string(3) 'Thu'
    [4]=>
    string(3) 'Fri'
  }
  [1]=>
  array(2) {
    [0]=>
    string(3) 'Sat'
    [1]=>
    string(3) 'Sun'
  }
}
*/

// the spread op (variadics) flattens the 2 sub-arrays into a single linear array
$days     = [...$business, ...$weekend];
var_dump($days);
// actual output:
/*
 * array(7) {
  [0]=>
  string(3) 'Mon'
  [1]=>
  string(3) 'Tue'
  [2]=>
  string(3) 'Wed'
  [3]=>
  string(3) 'Thu'
  [4]=>
  string(3) 'Fri'
  [5]=>
  string(3) 'Sat'
  [6]=>
  string(3) 'Sun'
*/

```
Packing arguments
```
<?php
// example using ... to pack an array

function test(...$a)
{
	return array_sum($a);
}

echo test(1,2,3,4,5);
echo PHP_EOL;
echo test(6,7,8,8,10,11,12,13,14,15);
// output: 15
//         104


```
Difference between `define()` and `const` regarding constants:
```
<?php
define('PATH', __DIR__);

class Test
{
	const PATH = '/var/www/html';
	public function getInternalPath()
	{
		return self::PATH;
	}
	public function getExternalPath()
	{
		return PATH;
	}
}

echo PATH;			// current dir
echo PHP_EOL;
echo Test::PATH;	// /var/www/html
echo PHP_EOL;

$test = new Test();
echo $test->getExternalPath();	// current dir
echo PHP_EOL;
echo $test->getInternalPath();	// /var/www/html
echo PHP_EOL;
```

Adding elements to a multi-dimensional array
```
<?php
$mission = [
    'STS395' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist 2'],s
        // here's how to add as part of the initial assignment
        ['firstName' => 'Fernanda', 'lastName' => 'Fernandes', 'specialty' => 'Computer Specialist 1'],
    ]
];

// here's how to add *after* the initial assignment
$mission['STS395'][] = ['firstName' => 'William', 'lastName' => 'Hodge', 'specialty' => 'Drupal Specialist'];

// here's how to make specific direct assignments
$mission['STS395'][5]['firstName'] = 'William';
$mission['STS395'][5]['lastName']  = 'Hodge';
$mission['STS395'][5]['specialty'] = 'Drupal Specialist';

// overwrite existing values
$mission['STS395'][2]['specialty'] = 'WordPress Specialist';

print_r($mission);

```
Another multi-dim array example:
```
<?php
$mission = [
    'STS395' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
		// adds right here
    ]
];

$mission['STS395'][] = ['firstName' => 'Fred', 'lastName' => 'Flintstone', 'specialty' => 'Caveman'];
$mission['STS396'][] = ['firstName' => 'Barney', 'lastName' => 'Rubble', 'specialty' => 'Caveman Neighbor'];

$mission['STS396'][0]['firstName'] = 'Betty';

print_r($mission);

// actual output:
/*
Array
(
    [STS395] => Array
        (
            [0] => Array
                (
                    [firstName] => Mark
                    [lastName] => Watney
                    [specialty] => Botanist
                )

            [1] => Array
                (
                    [firstName] => Melissa
                    [lastName] => Lewis
                    [specialty] => Commander
                )

            [2] => Array
                (
                    [firstName] => Beth
                    [lastName] => Johanssen
                    [specialty] => Computer Specialist
                )

            [3] => Array
                (
                    [firstName] => Fred
                    [lastName] => Flintstone
                    [specialty] => Caveman
                )

        )

    [STS396] => Array
        (
            [0] => Array
                (
                    [firstName] => Betty
                    [lastName] => Rubble
                    [specialty] => Caveman Neighbor
                )

        )

)
*/

```

Example using the ternary operator to establish a default value when accessing URL params
```
<?php
$name = (!empty($_GET['name'])) ? strip_tags($_GET['name']) : 'Default';
echo '<h1>' . $name . '</h1>';
```
Another example using the ternary operator + input and output sanitization:
```
<?php
// sanitize inputs using "strip_tags()"
$first = (isset($_GET['first'])) ? strip_tags($_GET['first']) : 'Default';
$last  = (isset($_GET['last'])) ? strip_tags($_GET['last']) : 'Default';

// output escaping:
echo htmlspecialchars($first . ':' . $last);

```
This is the same thing as above, but uses the `??` instead:
```
<?php
// sanitize inputs using "strip_tags()"
$first = strip_tags($_GET['first'] ?? 'Default');
$last  = strip_tags($_GET['last'] ?? 'Default');

// output escaping:
echo htmlspecialchars($first . ':' . $last);
```

You can use the '??' in place of a series of if/elseif
```
<?php
$status = (int) ($_REQUEST['status'] ?? $_SESSION['status'] ?? $_COOKIE['status'] ?? 1);
// same thing but using if/elseif:
if (!empty($_REQUEST['status'])) {
	$status = $_REQUEST['status'];
} elseif (!empty($_SESSION['status'])) {
	$status = $_SESSION['status'];
} elseif (!empty($_COOKIE['status'])) {
	$status = $_COOKIE['status'];
} else {
	$status = 1;
}

```
You can also add a 'default' option to `match` expressions:
```
<?php
// NOTE: match does a *strict* comparison (checks data type first)
$result = match ('1') {
    0 => 'Foo',
    1 => 'Bar',
    2 => 'Baz',
    default => 'None of the above'
};
echo $result; // None of the above
```
Iterating through nested `foreach()` loops
* NESTING_LEVEL -1 == the number of `foreach()` loops needed to get to the lowest level of information
```
<?php
// Build the crew
$missions = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
	]
];

foreach($missions as $mission => $astronauts) {
	echo $mission . PHP_EOL;
    foreach ($astronauts as $row) {
		echo '{$row['specialty']} {$row['lastName']} on board' . PHP_EOL;
    }
}
```
Using `for()` to count backwards
```
<?php
$max = 100;
$min = 50;
for ( $i = $max; $i >= $min; $i--) {
    echo 'Count to $i' . '<br>' . PHP_EOL;
}
```
Break out sub-arrays in a `foreach()` loop using `list()` (or alternatively `[]`)
```
<?php
$arr = [
	['Fred','Flintstone','Caveman'],
	['Wilma','Flintstone','Cavewoman'],
	['George','Slate','Boss'],
];

foreach ($arr as [$first,$last,$role]) {
	echo '$first $last is a $role\n';
}

// NOTE: you could also write the foreach() loop as follows:
// foreach ($arr as list($first,$last,$role)) {

// actual output:
/*
Fred Flintstone is a Caveman
Wilma Flintstone is a Cavewoman
George Slate is a Boss
*/
```
You should provide a data type hint for functions with components that are sensitive to the wrong data type
* Protects the function from abuse
* Makes the real source of the error quite clear
```
function searchForError(array $messages) : int
{
	$found = 0;
	$search = 'ERROR';
	foreach ($messages as $item) {
		if (str_contains($item, $search)) {
			$found++;
			break;
		}
	}
	return $found;
}
$messages = [
	'Operation succeeded',
	'ERROR 402',
	'Parse ERROR',
	'Everything OK',
];

echo (searchForError('WHATEVER'))
	? 'ERROR found'
	: 'All OK';
```
If you allow for `NULL` and pass it as a value, it overrides the default assignment:
```
<?php
// allows "string" as a type hint
function welcome(string|null $arg = 'JavaScript') :string {
    return "Welcome to the wonderful world of $arg coding\n";
}

$type = 'Python';

echo welcome();
echo welcome('PHP');
echo welcome($type);
echo welcome(NULL);

// actual output:
/*
Welcome to the wonderful world of JavaScript coding
Welcome to the wonderful world of PHP coding
Welcome to the wonderful world of Python coding
Welcome to the wonderful world of  coding
*/

```
Producing an HTML list from an array using the "splat" operator to allow unlimited args
```
<?php
function arrayToHtml(...$args)
{
    $output = '<ul>' . PHP_EOL;
    // $args = func_get_args();
    if(count($args)){
        foreach($args as $arg){
            $output .= '<li>' . $arg . '</li>' . PHP_EOL;
        }
    }
    $output .= '</ul>' . PHP_EOL;
    return $output;
}

echo arrayToHtml('Mark', 'Watney', 'Botanist', 'Doctor of Philosophy');

// output:
/*
<ul>
<li>Mark</li>
<li>Watney</li>
<li>Botanist</li>
<li>Doctor of Philosophy</li>
</ul>
*/
```

Use `declare(strict_types=1)` to enforce all type hints for that file
```
<?php
// if the following line is omitted, the type-hint acts like a filter (type-cast)
declare(strict_types=1);
// Example of function using 'type hinting'
function add(int $a, int $b) : int
{
	return $a + $b;
}

echo 'The sum of 2 and 2 is ' . add(2, 2) . '\n';
echo 'The sum of 33.33 and 22.22 is ' . add(33.33, 22.22) . '\n';

```
Nullable type: `?string` === `string|null`
```
<?php
// union types were introduced in PHP 8

function get_full_name(string $first, string $last, string|null $middle = NULL)
{
	return ($middle) ? '$first $middle $last\n' : '$first $last\n';
}

echo get_full_name('Fred', 'Flintstone', 'John');
echo get_full_name('Barney', 'Rubble');

// prior to PHP 8, a hybrid type:
// ?string === string|null

function get_full_name2(string $first, string $last, ?string $middle = NULL)
{
	return ($middle) ? '$first $middle $last\n' : '$first $last\n';
}

echo get_full_name2('Fred', 'Flintstone', 'John');
echo get_full_name2('Barney', 'Rubble');
```
Union types can go overboard:
```
<?php
// a bit ridiculous:
function dump(int|float|string|bool|array|object $whatever)
{
	var_dump($whatever);
}

dump(new ArrayObject());
dump([1,2,3,4,5]);

// this makes more sense:
function dump2(mixed $whatever)
{
	var_dump($whatever);
}

dump(new ArrayObject());

// another example of ridiculous:
// dump(true|false|bool $yesNo) {}

```
Array navigation functions example with `while()` loop
```
<?php
$invoiceItems = [
  ['invoiceNumber' => 123, 'invoiceAmount' => 100],
  ['invoiceNumber' => 124, 'invoiceAmount' => 50],
  ['invoiceNumber' => 125, 'invoiceAmount' => 150],
  ['invoiceNumber' => 126, 'invoiceAmount' => 55],
];

$tax = 0.10;

while ($items = current($invoiceItems)) {
    $amountWithTax =  $items['invoiceAmount'] + ($items['invoiceAmount'] * $tax);
    echo 'invoice #' . $items['invoiceNumber'] . ' with invoice amount ' . $items['invoiceAmount'] . ' has the final amount of ' .  $amountWithTax . ' after adding the tax';
    echo '\n';
    next($invoiceItems);
    // might need to add a check to make sure you're not at the end of the array
    // maybe keep a count using "++" and use the count() function to see how many elements are in the array
}
```
Using named parameters
```
<?php
// PHP 7 and below:
setcookie('Test', 1, 0, '', '', false, TRUE);
// PHP 8 allows you to use "named parameters"
setcookie('Test', 1, httponly:TRUE);
```
Using reference to alias an array element:
```
<?php
$config = [
    'router' => [
        'routes' => [
            'market' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/market',
                    'defaults' => [
                        'controller' => 'IndexController',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
];
// now $action is an alias for this array element
$action = &$config['router']['routes']['market']['options']['defaults']['action'];
echo $action . PHP_EOL;
$action = 'test';
print_r($config);

```
Example using `substr()`
```
<?php
$url = 'http://training.zend.com/';
$scheme = substr($url, 0, 5);
if ($scheme === 'https') {
	echo 'Secure URL';
	$path = substr($url, 7);
} else {
	echo 'Insecure URL';
	$path = substr($url, 6);
}
echo PHP_EOL;
echo 'This is the path: ' . $path . PHP_EOL;

// output:
/*
Insecure URL
This is the path: /training.zend.com/
*/
```
Sorting examples
```
<?php
$arr = ['A' => 111, 'C' => 333, 'E' => 555, 'B' => 222, 'D' => 444];
var_dump($arr);
ksort($arr);
var_dump($arr);

// NOTE: using sort() is fast, but you lose the keys
$arr = ['A' => 111, 'C' => 333, 'E' => 555, 'B' => 222, 'D' => 444];
sort($arr);
var_dump($arr);

// NOTE: asort() is very very slightly slower, but keys are retained
$arr = ['A' => 111, 'C' => 333, 'E' => 555, 'B' => 222, 'D' => 444];
asort($arr);
var_dump($arr);
```
Reading a CSV file and echoing the results:
```
<?php
// Open and test for success
if (!$fh = fopen(__DIR__ . '/bitcoin.csv', 'r')) exit('Unable to open file');

$data = [];
while (!feof($fh)) {
    $data[] = fgetcsv($fh);
}

// Iterate the retrieved contents and output
foreach ($data as $row) {
	if (empty($row) || !is_array($row)) continue;
    echo implode("\t", $row);
    echo '<br>' . PHP_EOL;
}

// Close the resource when finished
fclose($fh);
```
Example using `file_put_contents()` and `file_get_contents()`
```
<?php
$file = 'target.txt';
$contents = 'This is a text file' . PHP_EOL;
// NOTE: file_put_contents doesn't add a linefeed
$bytes = file_put_contents( $file, $contents, FILE_APPEND);
echo "$bytes bytes written to the file: $file" . PHP_EOL;
echo file_get_contents($file);
echo PHP_EOL;
```
Redirect to another web page:
```
<?php
// this is how you redirect to another web page:
header('Location: https://training.zend.com/');
exit;
```
Example of HTML form + security measures
```
<?php
$item = '';
$priority = 0;
if(!empty($_POST)) {
    $item = $_POST['item'] ?? '';
    $priority = $_POST['priority'] ?? '';
    if(!empty($item) && !empty($priority)) {
        $item = filter_var(strip_tags($item), FILTER_SANITIZE_STRING);
        $priority = (int) $priority;
        echo 'Data is validated and sanitized, handle it ...';
    } else {
        echo 'Invalid input';
        exit;
    }
} else {
    // no form data has been posted
    echo 'No form data has been posted';
}
?>
<form action="test.php" method="post">
    <fieldset>
        <legend>Add Checklist Item</legend>
        <label for="item">Enter the checklist item</label>
        <input type="text" name="item" id="item" value="<?= htmlspecialchars($item); ?>">
        <label for="priority">Enter the priority</label>
        <input type="text" name="priority" id="priority" value="<?= htmlspecialchars($priority); ?>" >
        <input type="submit" value="Submit">
    </fieldset>
</form>
```
Example of a callback tree that produces output in different formats
* Uses anonymous functions
```
<?php
$arr = ['A' => 111,'B' => 222,'C' => 333];

$callbacks = [
	// arrow function works well here
	'json' => fn(array $data) => json_encode($data, JSON_PRETTY_PRINT),
	// needs multiple lines of code, so we use an anonymous function
	'html' => function (array $data) {
		$out = '<table>';
		foreach ($data as $key => $value)
			$out .= '<tr><th>' . $key . '</th><td>' . $value . '</td></tr>';
		$out .= '</table>';
		return $out; }
];

echo $callbacks['json']($arr);
echo "\n";
echo $callbacks['html']($arr);
echo "\n";
```
Anonymous functions examples:
* This example "stores" an SQL query for later use:
```
<?php
function get_select(string $table, string $where, PDO $pdo)
{
	$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $where;
	return function () use ($sql) {
		$stmt = $pdo->query($sql);
		$result = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		return $result;
	};
}
$select = get_select('orders', 'id = 1', $pdo);

// do something
// ...
// do something

foreach ($select() as $row) {
	// display the row
	// maybe using printf()
}
```
Typical production settings:
* https://github.com/dbierer/filecms-website/blob/main/bootstrap.php
```
<?php
// start session and define key global constants
define('BASE_DIR', __DIR__);
define('HTML_DIR', BASE_DIR . '/templates/site');
define('SRC_DIR', BASE_DIR . '/src');
// set up error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);   // change this to "1" during website development
ini_set('error_log', BASE_DIR . '/logs/error.log');
// uses Composer autoloader
require BASE_DIR . '/vendor/autoload.php';
// start session
session_start();
return require SRC_DIR . '/config/config.php';
```

## Update/Upgrade the VM
* For now, avoid upgrading Ubuntu. Leave it at version 20.*
* Follow these instructions:
  * https://opensource.unlikelysource.com/expanded_vm_instructions.pdf
* Upgrade/update:
```
sudo dpkg --configure -a
sudo apt -y update && sudo apt -f -y install && sudo apt -y full-upgrade
```

* Apache reconfig:
```
sudo apt-add-repository ppa:ondrej/apache2
sudo apt install libapache2-mod-php8.2
sudo a2dismod php8.0
sudo systemctl restart apache2
sudo a2enmod php8.2
sudo systemctl restart apache2
```

## Q & A
* Q: Instructions to add XAMPP php.exe to Windows system path:
* A: https://mikesmith.us/add-xampps-php-execution-path-to-environment-variables-in-windows-10-11/

* Q: Get better examples of:
	* anonymous and arrow function usage
	* match using anonymous or arrow functions as a value
* A: See: * https://github.com/dbierer/classic_php_examples/blob/master/basics/type_hint_anon_function_example.php
* A: Also see below


## Resources
Automatic documentation generation
* https://phpdoc.org/
* It also has the formal definition of a 'doc block'
Reserved constants:
* https://www.php.net/manual/en/reserved.constants.php
Packagist website:
* https://packagist.org/
WordPress packagist website:
* https://wpackagist.org/
File Upload example:
* https://github.com/dbierer/classic_php_examples/blob/master/web/f%E2%80%8Eile_upload.php
Cookie example:
* https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php
Session example:
* https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php
General Resource:
* https://github.com/dbierer/classic_php_examples/
Database rankings:
* https://db-engines.com/en/ranking

## Errata
* http://localhost:8881/#/5/7
  * Problem with the security function???

# PHP-I Jun 2021

## Homework Assignments
  * For Fri 25 Jun 2021: http://collabedit.com/mgfgu
  * For Mon 28 Jun 2021: use gists
* Jnangoli:
```
#1: Lab: Defining and Calling a Function
Define a function named getOrderTotal(...), which takes two arguments and returns the sum.
Call the function and output the result.

#2: Lab: F-Type Code Exercise
Complete the following:

Create code that opens a file as a resource with error handling.
Write something to the file resource.
Collect the bytes written, and echo the count.
Close the file.

#3: Lab: file_put_contents()
Complete the following:

Write code that uses file_put_contents() to create some string content.
Over write the contents of a file.
Test and echo for success.
```

* Katharina:
```
#1: Lab: Defining and Calling a Function
Define a function named getOrderTotal(...), which takes two arguments and returns the sum.
Call the function and output the result.

#2: Lab: Write Array Lab
Complete the following:

Create an array of text strings.
Write the array content to a file.
Using fopen(), create a resource.
Read each line from the resource, and output the third character.
```

* Lazarus:
```
#1 :OrderApp Introduction
Lab: Two Functions
Build two functions, one to get an array element of configuration, and one that takes an array and builds an HTML select/option list.

getConfig('some config'), returns an array of allowed statuses.
htmlSelectHtml($config), returns a string contains an HTML <select> element with the status options.
// Starting Code
function getConfig(array $configFile, string $config_key) {
    $config = include __DIR__ . '/config/' . $configFile;
    return ... // fill in the rest of this statement
}

function htmlSelectHtml( $config ) {
    $html = '<select>';
    // loop through key / value pairs to create <option> tags            ...
    $html .= '</select>';
    return $html;
}

#2: Lab: file_get_contents()
Complete the following:

Write code that uses file_get_contents(), and gets the contents of a file.
Output the result.
```

## Class Notes
Great explanation on how PHP works
* https://www.zend.com/blog/exploring-new-php-jit-compiler
An alternative way to run PHP is in "async" mode
* https://www.zend.com/blog/swoole
Default location for test programs:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
```
* To access from that directory:
```
http://sandbox/NAME_OF_PROGRAM.php
```
`Attributes` can be used in PHP 8 in place of docblocks
```
<?php
/**
 * Adds two integers
 *
 * @param int $a
 * @param int $b
 * @return int $result
 */
function add(int $a, int $b) : int
{
	return $a + $b;
}

echo add(2,2);
echo "\n";

#[description("Adds two integers") ]
#[int(a) ]
#[int(b) ]
#[returns(a - b)]
function sub(int $a, int $b) : int
{
	return $a - $b;
}

echo sub(2,2);
echo "\n";
```
You can also use words for logicals:
```
// you can use words instead of symbols:
$foo = 10;
$bar = 5;
echo ($foo == 10 and $bar == 5); // 1

$foo = 5;
$bar = 10;
echo ($foo != $bar or $foo > $bar); // 1
echo ($foo != $bar xor $foo > $bar); // 1
```
Recommended: use `shell_exec()` instead of back tics
```
<?php
// this will go away:
echo `ls -lha`;

// recommended
echo shell_exec('ls -lha');
```
Flattening or "unpacking" arrays:
```
<?php
$abc = ['A','B','C'];
$def = ['D','E','F'];
// this ends up with 2 element, each a sub-array
$foo = [$abc, $def];
// this "flattens" the two arrays and you end with
// a single 1 dimensioned array
$bar = [...$abc, ...$def];
var_dump($foo, $bar);
```
"Packing" an array by using the variadics operator as in the function signature
```
<?php
// Argument packing
$foo = 10;
$bar = 5;
$baz = 99;

// this use of the variadics operator
// has the effect of "packing" the array
function sum(...$args){
	// if you allow for an unlimited # arguments
	// you need to write you function to account for that
    return array_sum($args);
}
echo sum($foo, $bar, $baz, 9999); // 15
```
Arrays auto-assign indices as the next highest value.
The order of the indices has no bearing on the order elements are stored.
Elements are stored in the order received.
```
<?php
$a[1] = 'A';
$a[3] = 'B';
$a[2] = 'C';
$a[6] = 'D';
$a[]  = 'E';
$a[4] = 'F';
$a[]  = 'G';

var_dump($a);

// output:
/*
home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public/test.php:10:
array(7) {
  [1] =>
  string(1) "A"
  [3] =>
  string(1) "B"
  [2] =>
  string(1) "C"
  [6] =>
  string(1) "D"
  [7] =>
  string(1) "E"
  [4] =>
  string(1) "F"
  [8] =>
  string(1) "G"
}
 */
```
When assigning multi-dimensional arrays, if the values are known in advance, use this style:
```
<?php
// Build the crew
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
	]
];

// Output all elements
print_r($mission);
```
When rendering numeric values, PHP defaults to decimal (i.e. base 10)
If you want other formats, use one of these options:
* `NumberFormatter` class
* `number_format()` function
* `printf()` family of functions (uses a format string)


## HTTP Basics
*All* incoming data is suspect
* Filter validate and sanitize all suspect data
* Escape suspect data upon output
```
echo htmlspecialchars($name);
```
* Usually the web server is configured to recognize PHP in certain directories
  * In the VM: the config files are here:
```
/etc/apache2/sites-available
/etc/apache2/sites-enabled
```

## Control Structures
Use of null coalesce operator vs. ternary
```
<?php
// null coalesce operator
$id = $_GET['id'] ?? $_POST['id'] ?? $_SESSION['id'] ?? $_COOKIE['id'] ?? 0;

// same thing with nested ternary ops:
// in PHP 8 use of parentheses are mandatory
// NOT recommended!
$id = ((!empty($_GET['id']))
	? $_GET['id']
	: ((!empty($_POST['id']))
		? $_POST['id']
		: ((!empty($_SESSION['id']))
			? $_SESSION['id']
			: 0)));
```
Example of nested `foreach()` loops
```
<?php
$mission = [
    'STS395' => [
        ['firstName' => 'Fred', 'lastName' => 'Flintstone', 'specialty' => 'Caveman'],
        ['firstName' => 'Barney', 'lastName' => 'Rubble', 'specialty' => 'Caveman Assistant'],
    ],
    'STS396' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
    ],
];

foreach ($mission as $key => $value) {
	echo "Mission: $key\n";
	foreach ($value as $i => $entry) {
		echo $entry['firstName'] . ' ' . $entry['lastName'] . "\n";
	}
}
```
Example of unpacking an array into individual variables:
```
<?php
$mission = [
    'STS395' => [
        ['firstName' => 'Fred', 'lastName' => 'Flintstone', 'specialty' => 'Caveman'],
        ['firstName' => 'Barney', 'lastName' => 'Rubble', 'specialty' => 'Caveman Assistant'],
    ],
    'STS396' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
    ],
];

foreach ($mission as $key => $value) {
	echo "Mission: $key\n";
	foreach ($value as $i => list('firstName' => $first, 'lastName' => $last)) {
		echo $first . ' ' . $last . "\n";
	}
}

foreach ($mission as $key => $value) {
	echo "Mission: $key\n";
	foreach ($value as $i => $entry) {
		extract($entry);
		echo $firstName . ' ' . $lastName . "\n";
	}
}


$mission = [
    'STS395' => [
        ['Fred', 'Flintstone', 'Caveman'],
        ['Barney', 'Rubble', 'Caveman Assistant'],
    ],
    'STS396' => [
        ['Mark', 'Watney', 'Botanist'],
        ['Melissa', 'Lewis', 'Commander'],
        ['Beth', 'Johanssen', 'Computer Specialist'],
    ],
];

// unpack a numeric array in the foreach() directly
foreach ($mission as $key => $value) {
	echo "Mission: $key\n";
	foreach ($value as $i => list($first, $last, $specialty)) {
		echo "$first $last is a $specialty\n";
	}
}

// unpack a numeric array inside the foreach() loop
foreach ($mission as $key => $value) {
	echo "Mission: $key\n";
	foreach ($value as $i => $entry) {
		[$first, $last, $specialty] = $entry;
		echo "$first $last is a $specialty\n";
	}
}
```
Once the objective has been achieved: exit the loop.
In this example, once an 'ERROR' has been found, we're done!
```
<?php
$messages = [
	'Operation succeeded',
	'ERROR 402',
	'Parse ERROR',
	'Everything OK',
];

$found = 0;
$search = 'ERROR';
foreach ($messages as $item) {
    // "str_contains()" is only available in PHP 8!
	if (str_contains($item, $search)) {
		$found++;
		break;
	}
}
echo ($found)
	? 'ERROR found'
	: 'All OK';
echo "\n";
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
Use `declare(strict_types=1)` to enforce all type hints for that file
```
<?php
// if the following line is omitted, the type-hint acts like a filter (type-cast)
declare(strict_types=1);
// Example of function using "type hinting"
function add(int $a, int $b) : int
{
	return $a + $b;
}

echo "The sum of 2 and 2 is " . add(2, 2) . "\n";
echo "The sum of 33.33 and 22.22 is " . add(33.33, 22.22) . "\n";

```
Nullable type: `?string` === `string|null`
```
<?php
// union types were introduced in PHP 8

function get_full_name(string $first, string $last, string|null $middle = NULL)
{
	return ($middle) ? "$first $middle $last\n" : "$first $last\n";
}

echo get_full_name('Fred', 'Flintstone', 'John');
echo get_full_name('Barney', 'Rubble');

// prior to PHP 8, a hybrid type:
// ?string === string|null

function get_full_name2(string $first, string $last, ?string $middle = NULL)
{
	return ($middle) ? "$first $middle $last\n" : "$first $last\n";
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
    echo "\n";
    next($invoiceItems);
}
```
You can also assign a reference to a single array element
```
<?php
$mission = [
    'STS395' => [
        ['firstName' => 'Fred', 'lastName' => 'Flintstone', 'specialty' => 'Caveman'],
        ['firstName' => 'Barney', 'lastName' => 'Rubble', 'specialty' => 'Caveman Assistant'],
    ],
    'STS396' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
    ],
];

$name = &$mission['STS395'][1]['firstName'];
$name = 'Betty';

var_dump($mission);
```
Example using pass-by-reference for validation
```
<?php
function validate(array $data, string &$err_msg) : bool
{
	$error = 0;
	// checks for only alpha characters
	if (!ctype_alpha($data['name'])) {
		$err_msg .= "Only letters are allowed in the name\n";
		$error++;
	}
	if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
		$err_msg .= "Invalid email address\n";
		$error++;
	}
	return ($error === 0);
}

$data = [
	'name' => 12345,
	'email' => 'bad.email.address'
];
$message = '';
if (validate($data, $message)) {
	echo "All OK\n";
} else {
	echo $message;
}
```
Calling program for the Forms demo in VM:
```
<?php
// place this calling program into:
// /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public/form.php
// call from a browser: http://sandbox/form.php
$config = include __DIR__ . '/../../orderapp/config/config.php';
include __DIR__ . '/../../orderapp/src/Forms.php';
echo getForm($config, 'new_order', NULL);
```
Example of `vprintf` + `printf()`
```
<?php
$a = 5398;
printf('%016b', $a);
echo "\n";

$data =	[
	['Fred', 999.99, 'Caveman'],
	['Wilma', 888.88, 'Cavewoman'],
];

foreach ($data as $row)
	vprintf('Name: %12s : Amount %8.2f : Title: %12s' . "\n", $row);
```
Example of using `substr()` to extract a filename extension
```
<?php
$fn = 'whatever.php';
$allowed = ['jpg', 'png', 'gif'];
$ext = substr(trim($fn), -3);
echo (in_array($ext, $allowed)) ? 'Allowed' : 'Denied';
echo "\n";
// comes back as "Denied" because the extension is not on the allowed list
```
Sanitizing a filename
```
<?php
$alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
echo $alpha[0] . $alpha[2] . $alpha[4];

$path = '/home/vagrant//Zend/workspaces/DefaultWorkspace/sandbox/public';
$fn   = 'test.php';
// alternative syntax:
// if ($path[-1] === '/') {
if ($path[strlen($path) - 1] === '/') {
	$final = $path . $fn;
} else {
	$final = $path . '/' . $fn;
}
echo str_replace('//', '/', $final) . "\n";
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

## I/O
Example using `fopen()` and `fgetcsv()` to read a data file
```
<?php
// data source: https://download.geonames.org/export/dump/countryInfo.txt
$fn = '/home/vagrant/Downloads/countryInfo.txt';
$fh = fopen($fn, 'r');
$data = [];
while (!feof($fh)) {
	$temp = fgetcsv($fh, separator:"\t");
	if (empty($temp) || $temp[0][0] === '#') continue;
	$data[] = $temp;
}
var_dump($data);
```
Example accessing a remote website
```
<?php
$contents = file_get_contents('https://google.com');
$contents = str_ireplace('Google', 'Boogle', $contents);
echo $contents;
```
# PHP-I Class Notes

## HOMEWORK
* For Mon 11 Nov 2019
  * https://gist.github.com/dbierer/475743a8f0b658b71cef5f7287eada2c
  * https://github.com/rpuglia12/php1/blob/master/homework11-8-19
* For Fri 8 Nov 2019
  * Lab: The Mixed Array 1
  * http://collabedit.com/sjtx8

## CLASS NOTES
* Most widely used string functions also include:
  * `substr()`
  * `strpos()`
  * `str_replace()`

* Dealing with strings representing fixed-length records: https://www.php.net/manual/en/function.sscanf.php

* Conditionals:
&& || ! ^

* Ways to recapture memory:
  * Temporary memory limit increase:
```
ini_set('memory_limit', '1G');
```
  * Release memory from variables which have been `unset()`: https://www.php.net/manual/en/function.gc-collect-cycles.php
  * Use "generators" to "yield" results instead returning a single massive array: https://www.php.net/manual/en/language.generators.overview.php


* https://www.php.net/manual/en/reserved.constants.php

* Automatic documentation generation: https://www.phpdoc.org/git

* Turn on display errors in this file:
```
sudo gedit /etc/php/7.3/apache2/php.ini
sudo service apache2 restart
```

* Basic examples
```
<?php
$var = PHP_INT_MAX;
var_dump($var);
echo PHP_EOL;

$var++;
var_dump($var);
echo PHP_EOL;

$photo = file_get_contents('fon.jpg');
var_dump($photo);
$max = strlen($photo);
for ($x = 0; $x < $max; $x++) {
	echo $photo[$x];
}
```
* Examples of string usage
```
<?php
$name = 'Fred Flintstone';
echo "\tHis name is $name.\n";
echo "\t" . 'His name is ' . $name . ".\n";
echo '\tHis name is $name.\n';
echo PHP_EOL;
$test = TRUE;
echo $test;
```
* Arrays vs. Objects for storing data
```
<?php
$users = [
	101 => ['first' => 'Fred', 'last' => 'Flintstone'],
	102 => ['first' => 'Barney', 'last' => 'Rubble']
];
var_dump($users);

class User
{
	public $id;
	public $first;
	public $last;
	public function __construct($id, $first, $last)
	{
		$this->id = $id;
		$this->first = $first;
		$this->last = $last;
	}
	public function getFullName()
	{
		return $this->first . ' ' . $this->last;
	}
}

$users = [
	new User(101, 'Fred', 'Flintstone'),
	new User(102, 'Barney', 'Rubble')
];
foreach ($users as $obj) {
	echo $obj->getFullName();
	echo PHP_EOL;
}
```
* Array examples
```
<?php
$astronaut = ['Mark', 'Watney', 'Botanist'];
$astronaut[7] = 'Status';
$astronaut[] = 'Active';
$astronaut[4] = 'Male';
$astronaut[2] = 'Doctor';

var_dump($astronaut);

foreach ($astronaut as $key => $value) {
	echo $key . ':' . $value . PHP_EOL;
}

ksort($astronaut);
foreach ($astronaut as $key => $value) {
	echo $key . ':' . $value . PHP_EOL;
}

echo PHP_EOL;
$astronaut = ['firstName' => 'Mark', 5 => 'Watney', 'Botanist'];
var_dump($astronaut);
```
* Alternate ways to assign values to arrays:
```
<?php
// Build the crew: Approach #1
$astronaut[] = ['firstName' => 'Mark', 'lastName' => 'Watney',
        'specialty' => 'Botanist'];
$astronaut[] = ['firstName' => 'Melissa', 'lastName' => 'Lewis',
        'specialty' => 'Commander'];
$astronaut[] = ['firstName' => 'Beth', 'lastName' => 'Johanssen',
        'specialty' => 'Computer Specialist'];
$mission = ['STS395' => $astronaut];

// Build the crew: Approach #2
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
	],
];

// Output all the specialty for Melissa Lewis
echo $mission['STS395'][1]['specialty'];
echo PHP_EOL;
// overwrite assignment:
$mission['STS395'][1]['specialty'] = 'Captain';
echo $mission['STS395'][1]['specialty'];
echo PHP_EOL;
// whole thing
var_dump($mission);
```
* Nested `foreach()`
```
<?php
// nested foreach
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
	],
];

foreach ($mission as $key1 => $outer) {
	echo $key1 . PHP_EOL;
	foreach ($outer as $key2 => $astronaut) {
		echo "\n\tID: " . $key2;
		foreach ($astronaut as $key3 => $value) {
			echo "\n\t" . ucfirst($key3) . "\t" . $value;
		}
	}
}
```
* Use keyword `namespace` if you need to completely isolate a block of code
```
<?php
namespace MySpace;
use function strtoupper as phpupper;
function strtoupper(string $x)
{
	return 'X';
}

echo strtoupper('whatever');
echo PHP_EOL;
echo phpupper('whatever');
```
* Type checking + optional parameter
```
<?php
//declare(strict_types=1);

function test(array $test, string $name, int $status = 0)
{
	$output = "\nStatus:" . $status . ':' . $name . "\n";
	foreach ($test as $item) {
		$output .= $item . PHP_EOL;
	}
	return $output;
}

$name = 'Doug';
$xyz  = [1,2,3,4,5];
// this works all the time
echo test($xyz, $name, 1);
echo PHP_EOL;
// this works only if strict_types is not active
echo test($xyz, 12345);
echo PHP_EOL;
// this doesn't work any time
echo test(12345, 12345);
```
* Command Line processing of params
```
<?php
// split out key pairs from command line PHP
$params = [];
foreach ($argv as $item) {
    if (strpos($item, '=')) {
        [$key, $value] = explode('=', $item);
	$params[$key] = $value;
    } else {
	$params[] = $item;
    }
}
var_dump($params);
```
* Using references to access elements of a multi-dimensional array
```
<?php
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
	],
];

$lewis = &$mission['STS395'][1];
$lewis['specialty'] = 'Captain';
var_dump($mission);
```
* Beware of `strpos()`!  Have a look at the best way to frame a search:
```
<?php
$test = 'ERROR: file not found';
if (strpos($test, 'ERROR') !== FALSE) {
	echo 'This line reflects an error';
} else {
	echo 'Skip this line, all OK';
}
```
* Dangers of using `sort()`
```
<?php
// illustrates the danger of sort()

$test = ['A' => 1, 'D' => 4, 'C' => 3, 'B' => 2];
$save = $test;
var_dump($test);
sort($test);
// sort re-keys the array!
var_dump($test);
// use asort() to retain the keys
asort($save);
var_dump($save);
```
* Example of manipulating the PHP include path:
```
<?php
set_include_path(
	get_include_path()
	. PATH_SEPARATOR
	. __DIR__
	. DIRECTORY_SEPARATOR
	. 'Functions'
);

include 'Library.php';

echo whatever('lowercase');
```

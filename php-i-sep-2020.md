# PHP-I -- Sep 2020
# Class Notes

## Homework
* For Wed 23 Sep
  * http://collabedit.com/2rh98
* For Mon 21 Sep
  * http://collabedit.com/s8a65
	* Lab: The Mixed Array 1
	* Lab: The Mixed Array 2
	* Lab: The Multi Array
	* Lab: The Multi Configuration Array
	* Lab: Additional Crew Members
  
## TODO
* Example of loan amortization formula: https://www.vertex42.com/ExcelArticles/amortization-calculation.html

## Q & A
* Q: How do you increase the memory allocation for a PHP program
* A: `ini_set('memory_limit', 'XXX'); // where "XXX" is some number + "M" or "G"`

## Class Discussion
* Example of pagination using `while`
```
<?php
$test = [];

foreach (range(0, 30) as $index) {
	$test[] = range('A','F');
}

// pagination example:
$start = $_GET['start'] ?? 0;
$start = (int) $start;
$pages = 10;

// same thing but using a while() loop instead
$x = 0;
while ($x < $pages && ($x + $start) < count($test)) {
	echo 'Row ' . ($x + $start) . ': ';
	foreach ($test[$x + $start] as $letter) {
		echo $letter . ' ';
	}
	echo "<br>\n";
	$x++;
}
```
* Example of pagination using `for` loop
```
<?php
$test = [];

foreach (range(0, 30) as $index) {
	$test[] = range('A','F');
}

// pagination example:
$start = $_GET['start'] ?? 20;
$start = (int) $start;
$pages = 10;

// TODO: add some control to make sure we don't go off the end of the array!
for($x = 0; $x < $pages; $x++) {
	echo 'Row ' . ($x + $start) . ': ';
	foreach ($test[$x + $start] as $letter) {
		echo $letter . ' ';
	}
	echo "<br>\n";
}
```

* Variations on if / elseif / else
```
<?php
$light = 'green';

// testing status of light
if ($light === 'green') {
	$action = 'GO';
} elseif ($light === 'yellow') {
	$action = 'SLOW DOWN';
} else {
	$action = 'STOP';
}
echo $action . "\n";

// using ternary
$action = ($light == 'green') ? 'GO' : (($light == 'YELLOW') ? 'SLOW DOWN' : 'STOP');
echo $action . "\n";

// testing status of light using switch
switch ($light) {
	case 'green' :
		$action = 'GO';
		break;
	case 'yellow' :
		$action = 'SLOW DOWN';
		break;
	default :
		$action = 'STOP';
}
echo $action . "\n";

// using ternary to test for input
$status = (isset($_GET['status'])) ? strip_tags($_GET['status']) : 'DEFAULT';
echo $status . "\n";

// using null coalesce
$status = $_GET['status'] ?? 'DEFAULT';
echo $status . "\n";

// using null coalese to receive input from multiple sources
$status = $_GET['status'] ?? $_POST['status'] ?? $_COOKIE['status'] ?? $_SESSION['status'] ?? 'DEFAULT';
echo $status . "\n";

// using compressed ternary: returns an error if not set
/*
$status = $_GET['status'] ?: 'DEFAULT';
echo $status . "\n";
*/
```

* Example of refactoring for efficiency
```
<?php
$a = 'AAA';
$b = 'BBB';

// how can this be refactored for more efficiency?
$result = strcmp($a, $b);
if ($result === 0) {
	echo 'These strings are equal';
} else {
	echo 'These strings are NOT equal';
}
echo "\n";

// solution
if (strcmp($a, $b) === 0) {
	echo 'These strings are equal';
} else {
	echo 'These strings are NOT equal';
}
echo "\n";
```

* Example of assigning a multi-dimensional array
```
<?php
// Build the crew
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],	
	],
	'STS396' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
	],
];
// last name of the 3rd crew member of mission STS395
$mission_id = 'STS395';
echo $mission[$mission_id][2]['lastName'];
echo PHP_EOL;

// Output all elements	
print_r($mission);
```

* Example using constant as error or success messages
```
<?php
define('ERROR_ID', 'ERROR: id must be an integer');
define('SUCCESS_ID', 'SUCCESS: this is a valid ID');
$a = 999;
$b = 'Test';

if (is_int($b)) {
	echo SUCCESS_ID;
} else {
	echo ERROR_ID;
}

```

* Variables
```
<?php
$test = 123;
$Test = 456;
$TEST = 789;
var_dump($test, $Test, $TEST);

$_ = 'Works';
echo $_;

// doesn't work
$4abc = 'ABC';

```

* Docblocks
  * PHP Documenter Project: https://phpdoc.org/
* Comments badly placed:
```
<?php
$a = TRUE;
// correctly placed comment
if ($a) {
	echo 'TRUE';
} else {
	echo 'FALSE';
}
if ($a) // badly placed comment {
	echo 'TRUE';
} else {
	echo 'FALSE';
}
```

* Example of type coercion from URL params
* Also ends up performing input sanitization
```
<?php
var_dump($_GET);
$id = ($_GET['id'] ?? 0);
$id = (int) $id;
echo "Your ID is: $id";
```
* Simple hello world
```
<?php
echo 'Hello World';
echo PHP_EOL;
echo 'Max PHP Int Size: ' . PHP_INT_MAX;
echo PHP_EOL;
$name = 'Fred';
echo '\tHello my name is $name' . PHP_EOL;
echo "\t" . 'Hello my name is ' . $name . PHP_EOL;
echo "\tHello my name is $name\n";

$interp = <<<TAG
Hello my name is $name
I'm a caveman
TAG;

$non_interp = <<<'TAG'
Hello my name is $name
I'm a caveman
TAG;

echo $interp . PHP_EOL;
echo $non_interp . PHP_EOL;
```

* Examples of type-casting, and internally changed data types:
```
<?php
$int = PHP_INT_MAX;
var_dump($int);
$int++;
var_dump($int);
$str = 'Fred';
var_dump($str);
$str = FALSE;
var_dump($str);

$str = (string) $str;
if (is_string($str)) {
	echo "$str is a string\n";
} else {
	echo "$str is a :" . gettype($str);
}

$pi = 22/7;
$pi = (string) $pi;
var_dump($pi);
$pi = (float) $pi;
var_dump($pi);
$pi = (int) $pi;
var_dump($pi);
```
* Switch Lab:
```
//Lab: Switch Construct
// An application needs to determine the country of origin for an astronaut applicant. 
// Write a switch construct that evaluates multiple country use cases against a true boolean, 
// and sets a variable based on the condition evaluated.
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist', 'country' => 'US'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander', 'country' => 'UK'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist', 'country' => 'SE'],	
	],
	'STS397' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist', 'country' => 'US'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander', 'country' => 'UK'],
		['firstName' => 'Ha', 'lastName' => 'Vu', 'specialty' => 'Developer', 'country' => 'AU'],	
	],
];

foreach ($mission as $key => $sub) {
	echo "\nProcessing $key\n";
	foreach ($sub as $crew) {
		$country = $crew['country'];
		$name = $crew['firstName'];
		switch (TRUE) {
			case $country === 'US' :
			case $country === 'UK' :
			case $country === 'AU' :
				$lang = 'English';
				break;
			case $country === 'SE' :
				$lang = 'Swedish';
				break;
			default :
				$lang = 'Martian';
		}
		echo "The assumed language of $name is $lang\n";
	}
}
```
* Data typing (e.g. Type Hinting)
```
<?php
// by identifying the data type of the function argument:
// 1. It makes the code more readable
// 2. Easier to decipher later on
// 3. Allows you to quickly determine in the case of an error, if the error is inside or outside the function
function extractLanguage(array $mission)
{
	$output = '';
	foreach ($mission as $key => $sub) {
		$output .= "\nProcessing $key\n";
		foreach ($sub as $crew) {
			$country = $crew['country'];
			$name = $crew['firstName'];
			switch (TRUE) {
				case $country === 'US' :
				case $country === 'UK' :
				case $country === 'AU' :
					$lang = 'English';
					break;
				case $country === 'SE' :
					$lang = 'Swedish';
					break;
				default :
					$lang = 'Martian';
			}
			$output .= "The assumed language of $name is $lang\n";
		}
	}
	return $output;
}

/*
// simulated database query
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist', 'country' => 'US'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander', 'country' => 'UK'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist', 'country' => 'SE'],	
	],
	'STS397' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist', 'country' => 'US'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander', 'country' => 'UK'],
		['firstName' => 'Ha', 'lastName' => 'Vu', 'specialty' => 'Developer', 'country' => 'AU'],	
	],
];
*/
$mission = FALSE;

echo extractLanguage($mission);
```
* Functions and arguments
```
<?php
// strict_types only affects string, int, float or bool
declare(strict_types=1);
function getName(string $last, string $first, string $mi = '')
{
	$name = $first . ' ';
	$name .= ($mi) ? $mi . ' ' : '';
	$name .= $last;
	return $name . "\n";
}

echo getName('Flintstone', 'Fred');
echo getName('Rubble', 'Barney', 'B');
// this throws fatal error: ArgumentCountError
echo getName('Wilma');
```
* Example using `static` in a function to retain error messages
```
<?php
declare(strict_types=1);
function test(string $test)
{
	return strtolower($test);
}

function errorCapture($err = '')
{
	static $errors;
	$errors .= "\n" . $err;
	return $errors;
}

$values = [1234, 123.456, 'TEST', TRUE];
foreach ($values as $item) {
	try {
		echo test($item);
		echo "\n";
	} catch (Error $e) {
		errorCapture('Value Passed: ' . $item . ':' . $e->getMessage());
	}
}
echo errorCapture();
```

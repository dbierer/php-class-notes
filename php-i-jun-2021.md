# PHP-I Jun 2021

## Homework Assignments
  * For Fri 25 Jun 2021: http://collabedit.com/mgfgu
  * For Mon 28 Jun 2021: use gists
```
// Jnangoli
Lab: Conditional If
Will the following code work?

$foo = 10;
$bar = 5;
if ( $foo > $bar )
    echo "Foo is greater than bar";
    $foo = $bar;
    echo "The value for Foo has changed";
Which statement runs as part of the conditional?
```
Katharina:
```
Lab: Conditional If-Else Equality
What is the output from each if-else construct?

$valueA = "50";
$valueB = 50;

if ($valueA == $valueB) {
    echo "Equal <br>";
} else {
    echo "Not equal <br>";
}

if ($valueA === $valueB) {
    echo "Identical <br>";
} else {
    echo "Not identical <br>";
}
```
Jnangoli:
```
Lab: Conditional If-Else Exclusive OR
What is the output from each if/else construct?

$valueA = 10;
$valueB = 20;

if ($valueA >= 50 xor $valueB === '20') {
    echo "Apples <br>";
} else {
    echo "Oranges <br>";
}

if ($valueA >= '5' xor $valueB === 20) {
    echo "White <br>";
} else {
    echo "Black <br>";
}
```
Katharina:
```
Lab: Conditional If-ElseIf
Assume that people work in an office from Monday through Friday, and are off work on Saturday and Sunday.

Modify the code below to handle the response if the day is either Saturday or Sunday?

$dayOfWeek = "Monday";

if ($dayOfWeek === "Friday") {
    echo "See you on Monday";
} else {
    echo "See you tomorrow";
}
```
Jnangoli:
```
Lab: Switch Construct
An application needs to determine the country of origin for an astronaut applicant. Write a switch construct that evaluates multiple country use cases against a true boolean, and sets a variable based on the condition evaluated.
```
Katharina:
```
Lab: Foreach Loop
A launch sequence application needs to iterate a launch checklist.

Build a launch checklist with the six items.
Iterate the launch checklist using a foreach loop, using keys and values.
Conditionally test for a particular list item and build an output string.
Echo the output.
```
Jnangoli:
```
Lab: For Loop
This code is a prime number generator. Run and understand its execution.

$max = 100;
for ($x = 5; $x < $max; $x++)
{
    // This if evaluation checks to see if number is odd or even
    $test = TRUE;
    for($i = 3; $i < $x; $i++) {
        if(($x % $i) === 0) {
            $test = FALSE;
            break;
        }
    }
    if ($test) echo $x . ', ';
}
```
Katharina:
```
Lab: While Loop
An application has an invoicing system and must calculate a total for items in a list.

Construct an associative array of invoice items.
Instead of a foreach loop, which is used with arrays, construct a while loop and use it to iterate the associative array of list items, and add a tax value to each.
Output each updated values.
```
Jnangoli:
```
Lab: Do...While Loop
A new feature request has risen to top priority that requires showing a list of past purchases.

Create an associative array with past purchase dates and amounts.
Iterate the list using a do...while loop displaying the past purchases.
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

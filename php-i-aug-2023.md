# PHP Foundations -- Aug 2023

## TODO
* Last: http://localhost:8881/#/4/9
* Get better examples of:
	* anonymous and arrow function usage
	* match using anonymous or arrow functions as a value
* Ask Nicole about adding recording to the LMS
  * They're working on it!
* Ask Nicole about: the last day scheduled date is odd
* Instructions to add XAMPP php.exe to Windows system path:
  * https://mikesmith.us/add-xampps-php-execution-path-to-environment-variables-in-windows-10-11/
* XAMPP web server document root: `C:\xampp\htdocs`

## Homework
For Tues 15 Aug 2023
* https://collabedit.com/ggm6b

For Thurs 10 Aug 2023
* https://collabedit.com/u64qf

For Tues 8 Aug 2023
* https://collabedit.com/x6952

## Class Notes
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

// the spread op flattens the 2 sub-arrays into a single linear array
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
Example using the ternary operator to establish a default value when accessing URL params
```
<?php
$name = (!empty($_GET['name'])) ? strip_tags($_GET['name']) : 'Default';
echo '<h1>' . $name . '</h1>';
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

## Resources
Automatic documentation generation
* https://phpdoc.org/
* It also has the formal definition of a 'doc block'
Reserved constants:
* https://www.php.net/manual/en/reserved.constants.php


## Errata
* http://localhost:8881/#/5/7
  * Problem with the security function???

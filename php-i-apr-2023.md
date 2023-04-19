# PHP-I Apr 2023

## NOTE TO SELF:
* Find example of HTML SELECT using ternary operator to pre-select a value
* Find example of `continue` (Common\Data\BigCsv???)

## Homework
For Fri 21 Apr 2023
* https://collabedit.com/kkacn

For Wed 19 Apr 2023
* Update/Upgrade the VM as per Elliot:
```
// disable unattended updates first
$ sudo dpkg-reconfigue -plow unattended-upgrades
// reboot the vm
$ sudo dpkg --configure -a
$ sudo apt update && sudo apt -f install && sudo apt full-upgrade
// reenable automatic updater
$ sudo dpkg-reconfigure -plow unattended-upgrades
```
* For now, avoid upgrading Ubuntu. Leave it at version 20.*

## Foundation
Docblocks
* See: https://phpdoc.org/
* Also: https://docs.phpdoc.org/3.0/guide/references/phpdoc/basic-syntax.html#basic-syntax
Attributes
* Alternative to comments or docblocks
* The compiled right into the code
* Docblocks are ignored for the most part
* See: https://www.php.net/manual/en/language.attributes.overview.php
Concatenate operator and order or precedence is different between PHP 7 and PHP 8
```
<?php

$foo = 5;
$bar = 10;

// In PHP 8: line 8 is interpreted exactly as in line 11
// In PHP 7: line 8 is interpreted exactly as in line 14
echo "sum: " . $foo + $bar;

// Math operations have higher precedence
echo "sum: " . ($foo + $bar);

// Evaluated left-to-right results fatal
echo ("sum: " . $foo) + $bar;

```
Adding to arrays:
```
<?php

$astronaut = ['Mark', 'Watney', 'Botanist'];
$astronaut[] = 'ID101';

print_r($astronaut); // Array(0 => Mark, 1 => Watney, 2 => Botanist, 3 => ID101)

$astronaut = ['firstName' => 'Mark', 'LastName' => 'Watney', 'Specialty' => 'botanist'];
$astronaut['ID'] = 'ID101';

print_r($astronaut); // Array(firstName => Mark, lastName => Watney, Specialty => Botanist, ID => ID101)
echo $astronaut['ID']; // ID101

// actual output:
/*
Array
(
    [0] => Mark
    [1] => Watney
    [2] => Botanist
    [3] => ID101
)
Array
(
    [firstName] => Mark
    [LastName] => Watney
    [Specialty] => botanist
    [ID] => ID101
)
ID101
*/

```
Using the "spread" (variadics) operator to "flatten" two arrays into one
* NOTE: you could also just do this: `$days = array_combine($a, $b);`
```
<?php
$a = ['Mon','Tue','Wed','Thu'];
$b = ['Fri','Sat','Sun'];

// do something

$days = [$a, $b];
var_dump($days);

// output
/*
 * array(2) {
  [0]=>
  array(4) {
    [0]=>
    string(3) "Mon"
    [1]=>
    string(3) "Tue"
    [2]=>
    string(3) "Wed"
    [3]=>
    string(3) "Thu"
  }
  [1]=>
  array(3) {
    [0]=>
    string(3) "Fri"
    [1]=>
    string(3) "Sat"
    [2]=>
    string(3) "Sun"
  }
}
*/


$days = [...$a, ...$b];
var_dump($days);
 /*
  * array(7) {
  [0]=>
  string(3) "Mon"
  [1]=>
  string(3) "Tue"
  [2]=>
  string(3) "Wed"
  [3]=>
  string(3) "Thu"
  [4]=>
  string(3) "Fri"
  [5]=>
  string(3) "Sat"
  [6]=>
  string(3) "Sun"
}
*/
```
Example of assigning constants:
* See: https://github.com/dbierer/filecms-website/blob/main/bootstrap.php
A better way of assigning sub-arrays:
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

## Control Structures
An alternate "if" syntax is available:
```
<?php
$foo = 10;
$bar = 10;
if ( $foo > $bar ) :
    echo "Foo is greater than bar";
elseif ($foo < $bar) :
    echo "Foo is less than bar";
else :
    echo "Foo is equal to bar";
endif;
```
Example of the ternary operator extracting URL params
```
<?php
// URL: http://sandbox/first.php?name=Aurelio&location=Dallas
$name = (isset($_GET['name'])) ? strip_tags($_GET['name']) : 'Default';
$location = (isset($_GET['location'])) ? strip_tags($_GET['location']) : 'Some City';
echo htmlspecialchars($name . ' lives in ' . $location);
```
`match` also supports a default value:
```
<?php
// match does a *strict* comparison
// the example below returns "None of the above"
$result = match ('1') {
    0 => 'Foo',
    1 => 'Bar',
    default => 'None of the above'
};
echo $result . PHP_EOL;
```
Expanded example from homework:
```
<?php
$launch = array('Booster'    =>'Checked',
			    'Telemetry'  =>'Checked',
			    'Control'    =>'Bad',
				'Electrical' =>'Checked',
				'Network'    =>'Checked',
				'Fuel'       =>'Low');
$expected = count($launch);
$actual   = 0;
$problem  = '';
foreach($launch as $checklist => $status) {
    if ($status === 'Checked') {
		echo "$checklist is a go <br>\n";
		$actual++;
	} else {
		$problem .= $checklist . ':' . $status . PHP_EOL;
	}
}
if ($actual === $expected) {
	echo "Launch is a GO!<br />\n";
} else {
	echo "Launch aborted<br />\n";
	echo $problem;
}

```
`do/while` example
```
<?php
$items = array('CPU'  => 600,
			   'case' => 100,
			   'fan'  => 25,
			   'brush' => 0,
			   'GPU'  => 500 );
if (empty($items)) {
	echo "Sorry, no items!";
	exit;
}
reset($items);	// moves pointer to start
do {
	$item = key($items);
	$value = current($items);
	echo  "$item = $" . $value *1.85 .  "<br>\n";
} while (next($items) !== FALSE);
```
IMPORTANT: `each()` was removed in PHP 8.1!!!

## VM Notes
Info
* Username: `vagrant`
* Password: `vagrant`

Update everything!
* Open a terminal window and run this command:
```
sudo apt update
sudo apt -y upgrade
```
* NOTE: this task might take some time
* Do not update the version of Ubuntu: leave it at 20.04

Install phpMyAdmin
* Download the latest version from `https://www.phpmyadmin.net`
* Make note of the version number (e.g. `5.2.0`)
```
cd
VER=5.2.0
unzip Downloads/phpMyAdmin-$VER-all-languages.zip
sudo cp -r phpMyAdmin-$VER-all-languages/* /usr/share/phpmyadmin
sudo cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php
```
* Create the "blowfish secret"
```
sudo -i
export SECRET=`php -r "echo md5(date('Y-m-d-H-i-s') . rand(1000,9999));"`
echo "\$cfg['blowfish_secret']='$SECRET';" >> /usr/share/phpmyadmin/config.inc.php
exit
```
Set permissions
```
sudo chown -R www-data /usr/share/phpmyadmin
```

Snapshot
* Be sure to take a snapshot of the VM before you start any of the labs!

System Problem
* If you see this message: `System program problem detected`
* Do this:
```
sudo rm -r /var/crash*
```

## Class Notes
PHP Roadmap:
* https://wiki.php.net/rfc
Micro Frameworks
* https://docs.mezzio.dev/
* https://www.slimframework.com/
Predefined Constants
* https://www.php.net/manual/en/reserved.constants.php
Statistics
* Database engine rankings:
  * https://db-engines.com/en/ranking
* Programming language rankings:
  * https://w3techs.com/technologies/overview/programming_language
* Web server ranking:
  * https://news.netcraft.com/archives/category/web-server-survey/
* OS market share:
  * https://gs.statcounter.com/os-market-share
* PHP Landscape Report:
  * https://www.zend.com/resources/2022-php-landscape-report
General examples of many concepts covered in class
* https://github.com/dbierer/classic_php_examples
Great explanation on how PHP works
* https://www.zend.com/blog/exploring-new-php-jit-compiler
An alternative way to run PHP is in "async" mode
* https://www.zend.com/blog/swoole
* ReactPHP framework
  * https://reactphp.org/
* Also: many frameworks are async enabled
  * Just set a config setting
Request/Response
* https://www.php-fig.org/psr/psr-7/
PHP via Fast CGI
* https://www.php.net/manual/en/install.fpm.php
Lots of PHP 8 specific examples
* https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices
Default location for test programs:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
```
* To access from that directory:
```
http://sandbox/NAME_OF_PROGRAM.php
```
Array example:
```
$user = [
	'first_name' => 'Fred',
	'last_name'  => 'Flintstone',
	'email'      => 'fred@flintstone.com',
	'address'    => [
		'steet_num'   => 123,
		'street_name' => 'Main St',
		'city'        => 'Dallas',
		'state'       => 'TX',
	],
];
```
Example mixing HTML and PHP:
```
<?php
$a = ['A','B','C'];
?>
<ul>
<?php foreach ($a as $item) { ?>
<li><?= $item ?></li>
<?php } ?>
</ul>
```
You can use type coercion as a form of security
```
<?php
// reads a URL parameter "id"
$id = $_GET['id'] ?? 0;
$id = (int) $id;	// any scripting is removed
echo 'ID: ' . $id;
```
Formal "docblock" specification:
* https://docs.phpdoc.org/3.0/guide/getting-started/what-is-a-docblock.html

`Attributes` can be used in PHP 8 in place of docblocks
* https://www.php.net/attributes
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
You can use `and`, `or` and `xor` instead of symbols:
```
<?php
$foo = 10;
$bar = 5;
echo ($foo == 10 and $bar == 5); // 1

$foo = 5;
$bar = 10;
echo ($foo != $bar or $foo > $bar); // 1
echo ($foo != $bar xor $foo > $bar); // 1
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
Adding a new element to a crew member:
```
<?php
$mission = [
    'STS395' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
    ]
];

// add new crew member
$mission['STS395'][] = ['firstName' => 'Lada', 'lastName' => '--', 'specialty' => 'My Favorite Dog'];
// change specialty
$mission['STS395'][1]['specialty'] = 'Senior Commander';
// adds an "id" element to the 1st sub-array
$mission['STS395'][1]['id'] = 101;

var_dump($mission);
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
Example of ternary operator
```
<?php
$name = (isset($_GET['name'])) ? strip_tags($_GET['name']) : 'Unknown';
echo $name;
```

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
Match expression with a default:
```
<?php
$result = match ('1') {
    0 => 'Foo',
    1 => 'Bar',
    default => 'Unknown'
};

echo $result; // Unknown
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
Example using `file_get_contents()` to post form data
* https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch12/php8_chat_front_end.php
```
<?php
$target   = 'http://' . $host . '/ch12/php8_chat_ajax.php';
$response = 'Default';
if ($_POST) {
    $user = $_POST['from'] ?? '';
    $_SESSION['user'] = $user;
    $headers = [
        'Accept: text/html',
        'Content-type: application/x-www-form-urlencoded',
    ];
    $opts = [
        'http' => [
            'method'  => 'POST',
            'header'  => implode("\r\n", $headers),
            'content' => http_build_query($_POST)
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($target, FALSE, $context);
    $data = json_decode($response, TRUE);
}
```
Example from labs
```
<?php
$name = 'data.txt';
$textArray = ['Some ', 'text', 'abc', 'jiofsjij'];
$file = fopen($name, 'w+');
foreach($textArray as $text) {
  fwrite($file, $text . "\n");
}
rewind($file);
// another approach
echo substr(fread($file, 4096), 2, 2);
fclose($file);
$contents = file($name);
var_dump($contents);
```
Getting a list of files in a directory
```
<?php
// single directory
$path = __DIR__;
$list = glob($path . '/*');
foreach ($list as $fn) echo $fn . "\n";

// or grab an entire directory tree
// see: https://php.net/SPL
$iter = new RecursiveDirectoryIterator($path);
$all  = new RecursiveIteratorIterator($iter);
// $obj === SplFileInfo instance
foreach ($all as $fn => $obj) echo $fn . "\n";
```
PHP Packages
* Composer:
  * https://getcomposer.org/
* Package Websites:
  * https://packagist.org/
  * https://wpackagist.org/

## Web Concepts
* Use `parse_url()` to breakdown a URL into its parts
```
<?php
$url = 'https://mars-express.com/path/to/whatever?id=124&mission=STS395';
$parsed = parse_url($url);
var_dump($parsed);
// output
/*
 * array(4) {
  ["scheme"]=>
  string(5) "https"
  ["host"]=>
  string(16) "mars-express.com"
  ["path"]=>
  string(17) "/path/to/whatever"
  ["query"]=>
  string(21) "id=124&mission=STS395"
}
*/
```
* Also use `urlencode()` for any data added to the base URL
```
<?php
$url = 'https://mars-express.com/path/to/whatever?';
echo $url . urlencode('status=Is this going to work?');
```
To see what's coming into your PHP program from HTTP:
```
<?php
phpinfo(INFO_VARIABLES);
```
Various form styles
* Mainly HTML with PHP mixed in
* Includes example of validating the `name` field
```
<?php
$days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
$allowed = ['Mon','Tue','Wed','Thu','Fri'];
$error = 0;
$name = '';
$email = '';
$message = '';
$daySelect = '';
$dayCheck  = [];
if (!empty($_POST)) {
	// validate name
	$name = $_POST['name'] ?? '';
	if ($name) {
		if (strlen($name) > 16) {
			$message .= "Name must be 16 chars or less\n";
			$error++;
		}
		if (!ctype_alpha($name)) {
			$message .= "Name must have only letters\n";
			$error++;
		}
		// example of filtering
		$name = strip_tags($name);
	}
	// validate day_select
	$daySelect = $_POST['day_select'] ?? '';
	if (!in_array($daySelect, $allowed)) {
		$message .= "Day was not included in the set of allowed days\n";
		$error++;
	}
}
$message .= ($error === 0) ? "Form data is valid\n" : "Form data has errors\n";
?>
<form method="post">
Name: <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" />
<br />Email: <input type="email" name="email" />
<br />Date: <input type="date" name="date" />
<br /><select name="day_select">
<?php foreach ($days as $day) echo '<option>' . $day . '</option>'; ?>
</select>
<br />
<?php
foreach ($days as $day) {
	echo '<input type="checkbox" name="day_check[]" value="' . $day . '" />' . $day . '&nbsp;';
}
?>
</select>
<br /><input type="submit" />
</form>
<?= nl2br($message); ?>
<?php phpinfo(INFO_VARIABLES); ?>
```
Example from file labs
```
<?php
// single directory
$path = __DIR__;
$list = glob($path . '/*');
echo '<table>';
echo '<tr><th>Name</th><th>Size in Bytes</th><th>Lines</th></tr>';
foreach ($list as $fn) {
	echo '<tr>';
	echo "<td>" . basename($fn) . "</td>";
	echo '<td>' . filesize($fn) . '</td>';
	$lines = count(file($fn)) - 1;
	echo "<td>$lines</td>";
	echo '</tr>';
}
echo "</table>\n";
```
Example of cookie usage:
* https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php
Example of session usage:
* https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php

## Database Operations
Basic query example
```
<?php
$conn = mysqli_connect('localhost', 'vagrant', 'vagrant', 'phpcourse');
$result = mysqli_query($conn, 'SELECT * FROM customers');
$num_rows = mysqli_row_count($result);	// especially useful for INSERT, UPDATE and DELETE
// gives results 1 row at a time
// use this if you anticipate a large result set
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	var_dump($row);
}


// gives you all rows at once
// use this is expected return is no more than 1000 to 2000 rows
// $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

```

## Miscellaneous
Highly recommended JavaScript library
* https://jquery.com/

## Basic
* Testing for TRUE/FALSE
```
<?php
$offline = 1;
$status = (empty($offline)) ? 'ONLINE' : 'OFFLINE';
echo "The system is $status\n";
$status = ($offline === 0) ? 'ONLINE' : 'OFFLINE';
echo "The system is $status\n";
$status = ($offline) ? 'ONLINE' : 'OFFLINE';
echo "The system is $status\n";
```
* Using objects to store multiple properties
```
<?php
class CaveMan
{
	// PHP 7 syntax
	public string $first;
	public string $last;
	public function __construct(string $first, string $last)
	{
		$this->first = $first;
		$this->last  = $last;
	}
	// PHP 8 syntax
	/*
	public function __construct(
		public string $first,
		public string $last) {}
	*/
}
$whatever[] = new CaveMan('Fred','Flintstone');
$whatever[] = new CaveMan('Wilma','Flintstone');
$whatever[] = new CaveMan('Barney','Rubble');
$whatever[] = new CaveMan('Betty','Rubble');
var_dump($whatever);

```
* Unicode escape characters
```
<?php
// see: https://unicode-table.com/en/sets/top-emoji/
$emoji = "\u{1F602}"
	   . "\u{1F60D}"
	   . "\u{1F923}"
	   . "\u{1F60A}"
	   . "\u{1F60E}"
	   . "\u{1F606}"
	   . "\u{1F601}"
	   . "\u{1F609}"
	   . "\u{1F914}"
	   . "\u{1F605}"
	   . "\u{1F614}"
	   . "\u{1F644}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.34.1" />
</head>
<body>
<?= $emoji ?>
</body>
</html>
```
* Running an OS command using "back ticks"
```
<?php
$path = 'C:\Users\ACER\Repos\classic_php_examples';
$cmd  = 'ls -l ' . $path;
if (PHP_OS_FAMILY === 'Windows') {
	$out  = `dir *.*`;
} else {
	$out  = `ls -l *`;
}
echo $out;
```
* Using the "spread" operator (also called "splat" operator) to flatten two arrays
```
<?php
$a = [111, 222, 333];
$b = [444, 555, 666];
$c = [...$a, ...$b];
echo $c[5]; // would like to see "666"
var_dump($c);

// gives the same results as $c
$d = array_merge($a, $b);
echo $d[5]; // would like to see "666"
var_dump($d);
```
* Example using the "spread" operator to "pack" arguments into an array
```
<?php
function sum_of_values($label, ...$a)
{
	return $label . ' ' . array_sum($a);
}

echo sum_of_values('The sum is', 1, 2, 3, 4, 5, 6);
echo "\n";
echo sum_of_values('The total is', 11, 22, 33);
```
* Alternate array assignment example
```
<?php
// Build the crew
$mission = [
	'STS395' => [
		2176 => ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		3294 => ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		1122 => ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
	]
];

// Output all elements
echo $mission['STS395'][2176]['lastName'];
```
* Searching for a value in a multi-dimensional array
```
// Build the crew
$mission = [
    'STS395' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
        // use this approach if pre-assigning values
        ['firstName' => 'Betty', 'lastName' => 'Rubble', 'specialty' => 'Cavewoman'],
    ]
];
// typical for a progammatic add someplace in your code at runtime
$mission['STS395'][] = ['firstName' => 'Fred', 'lastName' => 'Flintstone', 'specialty' => 'Caveman'];
echo "\n {$mission['STS395'][4]['firstName']}  {$mission['STS395'][4]['lastName']}\n"; // output: Fred Flintstone
var_dump($mission);
echo "\n" . __LINE__ . "\n";

// extract the last names from the multi-dim array:
$lastNames = array_column($mission['STS395'], 'lastName');
var_dump($lastNames);
// locate the key of the last name specified:
$key = array_search('Flintstone', $lastNames);
if (!empty($key)) echo implode(',',$mission['STS395'][$key]);
```
* Nested `foreach()` loops
```
<?php
$missions = [
    'STS395' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
    ]
];

foreach($missions as $mission => $astronauts) {
	echo 'Processing mission: ' . $mission . PHP_EOL;
	foreach($astronauts as $y => $row) {
		echo 'Crew Member: ' . ($y + 1) . PHP_EOL;
		foreach ($row as $x => $item) {
			echo $x . "\t" . $item . "\n";
		}
	}
}
```
* Example from homework accepting URL parameter "day"
```
$allowed   = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
$dayOfWeek = $_GET['day'] ?? '';
$key = array_search($dayOfWeek, $allowed);
if ($key !== FALSE) {
	$dayOfWeek = $allowed[$key];
} else {
	$dayOfWeek = date('D');
}

if ($dayOfWeek === 'Fri') {
    echo 'See you on Monday';
} elseif ($dayOfWeek === 'Sat') {
    echo 'See you on Monday';
} else {
    echo 'See you tomorrow';
}
```
Example of `for` loop using return value of a function as a condition
```
function misc()
{
	return rand(0,99);
}

for ( $i = 1; $i < misc(); $i *= 2) {
    echo $i . ' ';
}
```
Example using `continue`: reads from a CSV file
* https://github.com/dbierer/filecms-core/blob/main/src/Common/Data/Csv.php

* Using `list()` to unpack an array into variables in a `foreach()` loop:
```
<?php
$mission = [
	'STS395' => [
		2176 => ['Mark', 'Watney', 'Botanist'],
		3294 => ['Melissa', 'Lewis', 'Commander'],
		1122 => ['Beth', 'Johanssen', 'Computer Specialist']
	]
];

foreach ($mission['STS395'] as list($first, $last, $spec)) {
	echo "$first $last is a $spec\n";
}

$mission = [
	'STS395' => [
		2176 => ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		3294 => ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		1122 => ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
	]
];

foreach ($mission['STS395'] as list('firstName' => $first, 'lastName' => $last, 'specialty' => $spec)) {
	echo "$first $last is a $spec\n";
}

// conventional approach:
foreach ($mission['STS395'] as $val) {
	$first = $val['firstName'] ?? '';
	$last = $val['lastName'] ?? '';
	$spec = $val['specialty'] ?? '';
	echo "$first $last is a $spec\n";
}

```
* Why you need to use type-hinting
```
<?php
function parse1($arr)
{
	$out = '';
	foreach ($arr as $key => $val)
		$out .= $key . ':' . $val . "\n";
	return $out;
}

// this works
$whatever = ['AAA' => 111, 'BBB' => 222, 'CCC' => 333];
echo parse1($whatever);

// Without type hinting, the error leads you to the wrong place
// The problem is not in the `foreach()` loop, the problem is on line 17!
// PHP Warning:  foreach() argument must be of type array|object, string given on line 5
echo parse1('ABC');

// use type hinting to protect vulnerable statements inside the function
// in this case it's the `foreach()` loop:
function parse2(iterable $arr)
{
	$out = '';
	foreach ($arr as $key => $val)
		$out .= $key . ':' . $val . "\n";
	return $out;
}

// With type hinting, the error points to the correct place
// Fatal error: Uncaught TypeError: parse2(): Argument #1 ($arr) must be of type iterable,
// string given, called in test.php on line 32 ...
echo parse2('ABC');
```
* Example using a lookup array for static list of state codes
```
<?php
$states = [
	'CA' => 'California',
	'NY' => 'New York',
	'RI' => 'Rhode Island',
	'MA' => 'Massachusetts',
	'NJ' => 'New Jersey',
];

$code = $_GET['state'] ?? '';
// validate the input
if (!isset($states[$code])) {
	error_log('Invalid state code input');
	exit('Not found');
}
echo $states[$code];
```
* Example using named parameters to set a cookie with the `httponly` flag
```
<?php
setcookie('test', 111, httponly: TRUE);
```
* FYI: you can use the `__destruct()` method as a way to clean up old files
  * See: https://github.com/dbierer/filecms-core/blob/main/src/Common/Image/Captcha.php
* `php.ini` settings:
  * https://www.php.net/manual/en/ini.list.php
* Setting limits on memory usage and form postings:
  * https://www.php.net/manual/en/ini.core.php#ini.post-max-size
* NOTE: `session_destroy()` only wipes out session data
  * Also need to unset the session cookie
  * See: https://www.php.net/manual/en/function.session-destroy.php
* To check if a session is active:
```
if (session_status() === PHP_SESSION_ACTIVE) {
  // good to go!
}
```
## Functions
Example using unlimited number of args
```
<?php
function sum(...$args)
{
	return array_sum($args);
}

echo sum(1,2,3,4,5,6,7,8,9);
echo PHP_EOL;
echo sum(111,222);
echo PHP_EOL;
```
Calling functions example:
```
<?php
function random() : int
{
	return rand(0,999);
}

function sum(int $a) : int
{
	// calling one function from inside another
	return $a + random();
}

echo sum(123);
echo PHP_EOL;
// the return from random() becomes the arg passed to sum()
echo sum(random());
echo PHP_EOL;

```
Example of return by reference
* Form data validation
```
<?php
function validate(array $inputs, array &$messages) : bool
{
	$ok = TRUE;
	if (!isset($inputs['name'])) {
		$messages[] = 'Missing name';
		$ok = FALSE;
	} else {
		if (!ctype_alpha($inputs['name'])) {
			$messages[] = 'Name must have only alpha characters';
			$ok = FALSE;
		}
	}
	return $ok;
}

$inputs = $_GET;
$messages = [];
if (validate($inputs, $messages)) {
	// OK to process
	echo 'OK';
} else {
	echo implode('<br />', $messages);
}
```

## Web Stuff
To output a PDF `/path/to/file.pdf`
```
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="file.pdf");
readfile('/path/to/file.pdf');
exit;
```
Using `stripos()` to detect OS and browser
```
<?php
$agent = $_SERVER['HTTP_USER_AGENT'];
switch (TRUE) {
	case stripos($agent, 'linux') :
		$os = 'Linux system detected';
		break;
	case stripos($agent, 'windows') :
		$os = 'Windows system detected';
		break;
	default :
		$os = 'Unknown';
}
switch (TRUE) {
	case stripos($agent, 'chrome') :
		$browser = 'Chrome browser detected';
		break;
	case stripos($agent, 'firefox') :
		$browser = 'Firefox browser detected';
		break;
	case stripos($agent, 'safari') :
		$browser = 'Firefox browser detected';
		break;
	default :
		$browser = 'Unknown';
}
echo "We have detected the following:<br />\n";
echo $browser . "<br />\n";
echo $os . "<br />\n";

```
Anonymous functions examples:
* https://github.com/dbierer/classic_php_examples/blob/master/basics/type_hint_anon_function_example.php
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
## I/O
Package that goes directly to Excel:
* https://github.com/PHPOffice/PhpSpreadsheet
Reading pre-formatted blocks from an I/O source:
* https://www.php.net/fscanf
Example that scans all files in a directory and returns lines containing `$search`
```
<?php
$path = __DIR__ . '/*.txt';
$search = 'printf';
$list = glob(__DIR__ . '/*.php');
foreach ($list as $fn) {
	$contents = file($fn);
	foreach ($contents as $num => $line) {
		if (strpos($line, $search) !== FALSE) {
			echo $fn . PHP_EOL;
			printf("%4d : %s\n", $num, $line);
		}
	}
}
```
Example from the "f" labs:
```
<?php
$path = __DIR__;
$filename = $path . '/Text3.txt';
// open in "append" mode
// add "+" if you need to later read the file as well
$handler = fopen($filename, 'a+');
if (!$handler) {
	echo 'Cannot open file.';
} else {
//  don't need to do this:
//	fseek($handler,SEEK_END);
	$data = 'Another day in paradise!';
	$text = $data .PHP_EOL ;
	$bytes = fwrite($handler,$text);
	echo $bytes . ' bytes written.';
	echo "File contents:\n";
	// moves file pointer to start
	rewind($handler);
	// echoes entire file
	fpassthru($handler);
	echo PHP_EOL;
	fclose($handler);
}
```
IMPORTANT: the entire file will be in memory at one point when using `file_get_contents()`

Another example:
```
<?php
$path = __DIR__;
$filename = $path . '/Text3.txt';
//$data = file_get_contents($filename);
$data = 'New line3 added.' . PHP_EOL;
file_put_contents( $filename, $data, FILE_APPEND);
//echo file_get_contents($filename);
readfile($filename);
```
If you need to increase the runtime memory allocation:
```
// IMPORTANT: use with extreme caution!
// default RAM allocation for a single PHP run == 128M
ini_set('memory_limit', '256M');	// increases run limit to 256 MB of RAM
ini_set('memory_limit', '1G');	// increases run limit to 1 GB of RAM
```
All directives: https://www.php.net/manual/en/ini.list.php
* See: https://www.php.net/manual/en/ini.core.php#ini.memory-limit

Example of file info using `printf()`:
```
<?php
printf('%50s : %5s : %3s' . PHP_EOL, 'Filename', 'Size', 'Num');
$pattern = '%50s : %5d : %3d' . PHP_EOL;
foreach (glob("*.php") as $filename) {
	printf($pattern, $filename, filesize($filename), count(file($filename)));
}
```

## Web Stuff
Example of receiving data via "GET"
```
<?php
// data is received from the browser via the URL
$first = $_GET['first'] ?? '';
$last  = $_GET['last'] ?? '';
?>
<form method="get">
First Name: <input type="text" name="first" value="<?= $first ?>"/>
<br />
Last Name: <input type="text" name="last"  value="<?= $last ?>"/>
<br />
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
```
Example of receiving data via "POST"
```
<?php
// data is received from the browser in the *body* of the request
$first = $_POST['first'] ?? '';
$last  = $_POST['last'] ?? '';
?>
<form method="post">
First Name: <input type="text" name="first" value="<?= $first ?>"/>
<br />
Last Name: <input type="text" name="last"  value="<?= $last ?>"/>
<br />
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
```
Same thing with added security
```
<?php
// received from the browser in the *body* of the request
// IMPORTANT: all inputs should also be filtered, validated and sanitized
$first = trim(strip_tags($_POST['first'] ?? ''));
$last  = trim(strip_tags($_POST['last'] ?? ''));
?>
<form method="post">
<!-- "escape" the output using htmlspecialchars() for security reasons -->
First Name: <input type="text" name="first" value="<?= htmlspecialchars($first); ?>"/>
<!-- example of actual output: &lt;script&gt;alert(&#039;hahaha&#039;);&lt;/script&gt; -->
<br />
Last Name: <input type="text" name="last"  value="<?= htmlspecialchars($last); ?>"/>
<br />
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
```
CSS tutorial
* See: https://www.w3schools.com/Css/
JavaScript
* Look into jQuery (https://jquery.com)
File upload example:
* See: https://github.com/dbierer/classic_php_examples/blob/master/web/f%E2%80%8Eile_upload.php
```
<?php
// received from the browser in the *body* of the request
// IMPORTANT: all inputs should also be filtered, validated and sanitized
$first = trim(strip_tags($_POST['first'] ?? ''));
$last  = trim(strip_tags($_POST['last'] ?? ''));
?>
<form method="post" enctype="multipart/form-data">
<!-- "escape" the output using htmlspecialchars() for security reasons -->
First Name: <input type="text" name="first" value="<?= htmlspecialchars($first); ?>"/>
<!-- example of actual output: &lt;script&gt;alert(&#039;hahaha&#039;);&lt;/script&gt; -->
<br />
Last Name: <input type="text" name="last"  value="<?= htmlspecialchars($last); ?>"/>
<br />
File Upload: <input type="file" name="upload" />
<br />
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
```
Cookies:
* See: https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php
Sessions:
* See: https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php
* Re: `session_regenerate_id()`
  * If you use the `TRUE` flag, it also recreates the data, however this is resource intensive and takes time
  * Best to use this as is: `session_regenerate_id()` (i.e. don't supply the `TRUE` argument)

For HTML forms:
* Use `method="GET"` if you want the user to bookmark the form posting (i.e. site search)
* Use `method="POST"` if you have a large amount of data to be posted in the form
  * Mandatory if you do a file upload!
## Database
Rankings: https://db-engines.com/en/ranking

PostGreSQL: https://www.postgresql.org/download/

## Miscellaneous
Use `var_export($data, TRUE)` to return a string that can be placed into the error log
* https://www.php.net/var_export

## Q & A
* Q: Example of using `<=>`?
* A: https://github.com/dbierer/classic_php_examples/blob/master/basics/spaceship_operator.php
* A: https://github.com/dbierer/classic_php_examples/blob/master/basics/spaceship_operator_usort_example.php

* Q: How do I represent an octal number?
* A: https://www.php.net/manual/en/language.types.integer.php

* Q: How do you detect mobile devices?
* A: Check the contents of `$_SERVER['HTTP_USER_AGENT']`

* Q: Good examples of `printf`
* A: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch06/php8_printf_vs_vprintf.php
* A: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch08/php8_each_replacements.php

* Q: Examples of arrow functions?
* A: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch02/php8_arrow_func_1.php
* A: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch02/php8_arrow_func_3.php


## ERRATA
\
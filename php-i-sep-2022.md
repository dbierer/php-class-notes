# PHP-I Jun 2022

Last Slide: http://localhost:8881/#/6/25

## IMPORTANT!
PHP 7.4 EOL date is 28 Nov 2022
* https://www.zend.com/blog/planning-php-7-4-eol

## TODO
* Lookup Doctrine article on attributes
  * https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/reference/attributes-reference.html
* Lookup RFC about deprecating back tics
  *
* Get latest slides.pdf to Stefan (before Oct 4)
* Documentation on date format codes
  * https://www.php.net/manual/en/datetime.format.php

## Homework
For Tue 04 Oct 2022
* Lab: Read Directories
  * Also, try using this: `RecursiveDirectoryIterator`
  * https://www.php.net/recursivedirectoryiterator
* Lab: Embedded PHP
  * Mainly HTML with some PHP embedded
  * Develop a simple login form:
    * Email, username, password
* Lab: Embedded PHP
  * Pure PHP script that completely generates the HTML
* Lab: Secure Input Handling
  * Combine this with the previous 2 labs
* Lab: Escaping Exercise
For Wed 21 Sep 2022
* Lab: F-Type Code Exercise
* Lab: Write Array Lab
  * Suggestion: try working with CSV files
* Lab: file_get_contents()
* Lab: file_put_contents()
* Lab: Defining and Calling a Function
* Lab: Recursive Function Exercise
* OrderApp Introduction
  * Lab: Two Functions
* Custom Assignment:
Given this starting array:
```
$colors = [
	'red' => [111,222,333,444],
	'green' => ['AAA','BBB','CCC','DDD'],
	'blue' => [555, 'EEE', 666, 'FFF']
];
```
* Randomly pick 'red','green' or 'blue'
* Out of the sub-array, pull a value, display it, and remove from the sub-array
* Possible functions it use:
  * `array_rand()`
  * `shuffle()`
  * `array_pop()`

For Fri 16 Sep 2022
* https://collabedit.com/hcv2c
For Mon 19 Sep 2022
Lab: Conditional If
```
Will the following code work?

$foo = 10;
$bar = 5;
if ( $foo > $bar )
    echo "Foo is greater than bar";
    $foo = $bar;
    echo "The value for Foo has changed";
Which statement runs as part of the conditional?
```
Lab: Conditional If-Else Equality
```
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
Lab: Conditional If-Else Exclusive OR
```
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
Lab: Conditional If-ElseIf
```
Assume that people work in an office from Monday through Friday, and are off work on Saturday and Sunday.

Modify the code below to handle the response if the day is either Saturday or Sunday?

$dayOfWeek = "Monday";

if ($dayOfWeek === "Friday") {
    echo "See you on Monday";
} else {
    echo "See you tomorrow";
}
```
Lab: Switch and MatchConstruct
```
An application needs to determine the country of origin for an astronaut applicant. Write a switch construct that evaluates multiple country use cases against a true boolean, and sets a variable based on the condition evaluated.
Once you've create the switch{} construct, do the same thing but use "match" instead.

```
Lab: For Loop
What does this program do?

```
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
Lab: While Loop
```
An application has an invoicing system and must calculate a total for items in a list.

Construct an associative array of invoice items.
Instead of a foreach loop, which is used with arrays, construct a while loop and use it to iterate the associative array of list items, and add a tax value to each.
Output each updated values.
```
Lab: Do...While Loop
```
A new feature request has risen to top priority that requires showing a list of past purchases.

Create an associative array with past purchase dates and amounts.
Iterate the list using a do...while loop displaying the past purchases.
```

## VM Notes
Info
* Username: `vagrant`
* Password: `vagrant`

OS Updates:
* When you first open the VM wait for "apt-check" to finish
  * Takes less than 5 minutes
* When prompted "A new version of Ubuntu is available"
  * Select "Don't Upgrade"
* When prompted "Updated software is available for this computer"
  * Select "Install Now"
  * NOTE: this task might take some time
    * 1 to 3 hours depending on your hardware and Internet speed
* It might be faster to select "Ask Me Later" and then do this:
  * Open a terminal window and run this command:
```
sudo apt update
sudo apt -y upgrade
```
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
sudo rm /var/crash/*
```

## Class Notes
Most PHP Packages reside here:
* https://packagist.org/

If you need to run an OS command, use `shell_exec()`
* https://www.php.net/shell_exec
String concatenation example:
```
$title = 'TEST';
$html = '<html>'
      . '<head>'
      . '<title>'
      . $title
      . '</title>'
      . '</head>'
      . '</html>';
echo $html;
```
Better example of `instanceof`
```
<?php
class Person {}
$human = new Person;
echo ($human instanceof Person) ? 'TRUE' : 'FALSE';
```
Variadics Operator
```
<?php
// Operator unpacking
$a = [1, 2, 3];
$b = [4, 5, 6];
$twoDimArr = [$a, $b];
$oneDimArr = [...$a, ...$b];
print_r($twoDimArr); //[ 0 => [1, 2, 3], 1 => [4, 5, 6]]
print_r($oneDimArr); //[1, 2, 3,4, 5, 6]

// Argument packing
$foo = 10;
$bar = 5;

function sum(...$args){
    return var_export($args, TRUE);
}
echo sum(1, 2, 'A', 'B');
echo PHP_EOL;
/* Output:
array (
  0 => 1,
  1 => 2,
  2 => 'A',
  3 => 'B',
)
*/
```
Deconstructing an array into variables:
```
<?php
$a = ['Fred', 'Flintstone'];
list($first, $last) = $a;
echo "Hello $first $last\n";

// available as of PHP 7:
[$first, $last] = $a;
echo "Hello $first $last\n";
```
PHP 7.4 End-of-Life
* https://www.zend.com/blog/planning-php-7-4-eol
Performance enhancements for PHP
* https://www.zend.com/blog/exploring-new-php-jit-compiler
* https://www.zend.com/blog/swoole
Formal definition of "doc blocks":
* https://phpdoc.org/
New version of PHP:
* ZendPHP
PHP Road Map:
* https://wiki.php.net/rfc
Micro Frameworks
* https://docs.mezzio.dev/
* https://www.slimframework.com/
Constants
  * Pre-defined
	* https://www.php.net/manual/en/reserved.constants.php
  * Magic Constants
    * https://www.php.net/manual/en/language.constants.magic.php
Statistics
* Database engine rankings:
  * https://db-engines.com/en/ranking
* Programming language rankings:
  * https://w3techs.com/technologies/overview/programming_language
* Web server ranking:
  * https://news.netcraft.com/archives/category/web-server-survey/
* OS market share:
  * https://gs.statcounter.com/os-market-share
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
Boolean FALSE:
```
<?php
$list = [
	// these interpolate as FALSE:
	0,
	'',
	"0",
	[],
	NULL,
	FALSE,
	// everything else is TRUE, including:
	' ',
	1,
	-1,
	['something']
];

foreach ($list as $item) {
	var_dump((bool) $item);
	echo PHP_EOL;
}

```
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

If vs. ternary
```
<?php
// https://website.com?name=Doug
// both examples yield the same results:

// Using "if"
$name = $_GET['name'];
if (empty($name)) $name = 'Default';

// Using ternary
$name = (empty($_GET['name'])) ? 'Default' : $_GET['name'];

```
Match expression with a default
```
<?php
$result = match (1) {
    0 => 'Foo',
    1 => 'Bar',
    default => 'Default'
};
echo $result;
```


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

$data = [
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
$num_rows = mysqli_row_count($result);  // especially useful for INSERT, UPDATE and DELETE
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
* Enumerations:
  * https://www.php.net/manual/en/language.enumerations.php
* Examples of outputing array values
```
<?php
// all three outputs are the same
// An astronaut array assignment
$astronaut = ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'];

// Not very performant
echo "{$astronaut['firstName']} {$astronaut['lastName']} will initially be left behind on Mars\n";

// highly performant
echo $astronaut['firstName'] . ' ' . $astronaut['lastName'] . ' will initially be left behind on Mars';
echo PHP_EOL;

// slightly more readable
printf('%s %s will initially be left behind on Mars', $astronaut['firstName'], $astronaut['lastName']);
echo PHP_EOL;
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

echo 'Here are the Crew Members of STS395:' . '<br>';
foreach ($mission as $x => $x_val) {
    foreach ($x_val as $y => $y_val) {
        echo '"' . implode('","', $y_val) . '"' . PHP_EOL;
    }

}

echo 'Here are the Crew Members of STS395:' . '<br>';
foreach ($mission as $x => $x_val) {
    foreach ($x_val as ['firstName' => $f, 'lastName' => $l, 'specialty' => $s]) {
        echo "\"$f\",\"$l\",\"$s\"\n";
    }

}

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
* Ternary vs. standard if/then:
```
<?php
$foo = 10;

// approach #1
if ($foo > 10) {
        echo 10;
} else {
        echo 'Null';
}

// approach #2
echo ($foo > 10) ? 10 : 'Null';

// #1 is logically equivalent to #2
// BUT ... #1 allows for multiple statement execution
//         #2 only allows a single command to be executed
```
* Example using Null Coalesce Operator
```
<?php
$name = $argv[1] ?? $_GET['name'] ?? $_POST['name'] ?? $_COOKIE['name'] ?? $_SESSION['name'] ?? 'No Name';
echo htmlspecialchars($name);   // safeguards when you echo from an untrusted source
echo "\n";
```
* Example using Ternary to produce HTML or JSON (using an anonymous functions
```
<?php
$flag = FALSE;
$arr  = [1,2,3,4,5];
$html = function ($arr) { return '<ul><li>' . implode('</li><li>', $arr) . '</li></ul>'; };
$json = function ($arr) { return json_encode($arr); };
echo ($flag) ? $html($arr) : $json($arr);
```

* Examples using the `list()` (or `[]`) in a `foreach()` loop
```
<?php
// all three examples produce the same results
$data = [
        ['Fred', 'Flintstone','Caveman'],
        ['Wilma','Flintstone','Cavewoman'],
];

//
foreach ($data as [$first,$last,$role])
        echo "$first $last is a $role\n";

$data = [
        ['first' => 'Fred', 'last' => 'Flintstone', 'role' => 'Caveman'],
        ['first' => 'Wilma','last' => 'Flintstone','role' => 'Cavewoman'],
];
//
foreach ($data as ['first' => $first,'last' => $last,'role' => $role])
        echo "$first $last is a $role\n";

// this makes more sense:
foreach ($data as $row)
        echo "{$row['first']} {$row['last']} is a {$row['role']}\n";

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
// in PHP 7 you have to specify *all* params to get to the last one
setcookie('test', 12345, 0, '', '', FALSE, TRUE);

// in PHP 8 you can use named params
setcookie('test', 12345, httponly:TRUE);
```
* Unlimited arguments example:
```
<?php
// older approach
function add()
{
	$vals = func_get_args();
	return array_sum($vals);
}

echo add(1,2,3,4,5,6,7,8,9,10,11,12,13,14);
echo PHP_EOL;

// newer approach (recommended) uses the variadics operator
function add2(...$vals)
{
	return array_sum($vals);
}

echo add2(1,2,3,4,5,6,7,8,9,10,11,12,13,14);

```
Different looping examples
```
<?php
$invoices = [
    'January' => 2601,
    'February' => 698,
    'March' => 5601,
    'April' => 999,
    'May' => 8741,
    'June' => 12,
    'July' => 132,
];

// this works ok
$numberOfInvoices = array_keys($invoices);
while (!empty($numberOfInvoices)) {
    $key = array_pop($numberOfInvoices);
    echo $key . ': Net = ' . $invoices[$key] . ' | Gross = ' . ($invoices[$key]*1.19) . '<br />';
}
echo PHP_EOL;

// using array "navigation" functions;

reset($invoices);	// pointer to the top
while ($key = key($invoices)) {
    $val = current($invoices);
    echo $key . ': Net = ' . $val . ' | Gross = ' . ($val * 1.19) . '<br />';
	next($invoices);
}
echo PHP_EOL;

// using ArrayIterator
$iter = new ArrayIterator($invoices);
while ($iter->valid()) {
	$key = $iter->key();
    $val = $iter->current();
    echo $key . ': Net = ' . $val . ' | Gross = ' . ($val * 1.19) . '<br />';
	$iter->next();
}
echo PHP_EOL;
```
Example using `array_rand()`
```
<?php
$carousel = [
	'Don\'t Miss Our Year End Sale',
	'Special on Coffee Makers',
	'Something Else, Hey!!!',
];
$key = array_rand($carousel);
echo $carousel[$key];
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
* Example of pre-loading form fields
  * Calling program `test.php`:
```
<?php
$name = 'Fred';
$email = 'whatever@zend.com';
include 'html_form.php';
```
  * Form program `html_form.php`;
```
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.34.1" />
</head>
<body>
<form>
        Name: <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>" />
        <br />
        Email: <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
</form>
</body>

</html>
```
* Post data sanitization using pass-by-reference
```
<?php
$post = [
        'name' => '<script>hahaha</script>',
        'email' => 'test@zend.com',
];

function sanitize(array &$data)
{
        $expected = count($data);
        $actual   = 0;
        foreach ($data as $key => $value) {
                $clean = strip_tags($value);
                $data[$key] = $clean;
                $actual += (int) ($clean === $value);
        }
        return ($actual === $expected);
}

if (sanitize($post)) {
        echo 'Data is clean';
} else {
        echo 'Dirty data';
}
echo "\n";
var_dump($post);
```
* Dealing with trailing commas:
```
<?php

$arr = ['A','B','C','D'];
$out = '';
foreach ($arr as $value)
        $out .= $value . ',';

echo substr($out, 0, -1);
// output: "A,B,C,D"

```
* Example using anonymous functions in a callback tree for form data processing
```
<?php
$post = [
        'name'  => '<script>hahaha</script>',
        'email' => 'test;@zend.com',
        'pwd'   => 'password<script></script>',
];
$callbacks = [
        'name'  => function ($name) { return strip_tags($name); },
        'email' => function ($email) { return filter_var($email, FILTER_SANITIZE_EMAIL); },
        'pwd'   => function ($pwd) { return $pwd; }
];
function sanitize(array &$data, array $callbacks)
{
        $expected = count($data);
        $actual   = 0;
        foreach ($data as $key => $value) {
                $clean = $callbacks[$key]($value);
                $data[$key] = $clean;
                $actual += (int) ($clean === $value);
        }
        return ($actual === $expected);
}

sanitize($post, $callbacks);
var_dump($post);

```
* Same as above but using "arrow function" syntax
```
$callbacks = [
        // key     array value == a callback
        // ---     ------------------------------------------------------
        'name'  => fn($name)  => strip_tags($name),
        'email' => fn($email) => filter_var($email, FILTER_SANITIZE_EMAIL),
        'pwd'   => fn($pwd)   => $pwd
];
```
* Example of a "storage" class that reads/writes data in various formats:
  * CSV: https://github.com/dbierer/filecms-core/blob/main/src/Common/Data/Strategy/Csv.php
  * Driver: https://github.com/dbierer/filecms-core/blob/main/src/Common/Data/Storage.php
  * Clicks: https://github.com/dbierer/filecms-core/blob/main/src/Common/Stats/Clicks.php
* Reads from a CSV file and returns an array:
```
<?php
$fn = __DIR__ .'/demo.csv';
$fh = fopen($fn, 'r');
$data = [];
while($row = fgetcsv($fh)) {
	$data[] = $row;
}
fclose($fh);
var_dump($data);
```
* Another CSV file example based on the lab
```
<?php
define('SRC_FN', __DIR__ . '/names.csv');
if (file_exists(SRC_FN)) unlink(SRC_FN);

$customers = [
    ['1', 'Stefan' ,'', 'Passerschröer'],
    ['2', 'Doug', '', 'Bierer'],
    ['3', 'Max', 'Martin', 'Mayer'],
    ['4', 'Tao', 'Tao', 'Tao Tao']
];

if (!$customerdb = fopen(SRC_FN, 'a+')) exit('Unable to open file');

foreach ($customers as $line) {
    echo fputcsv($customerdb,$line) . PHP_EOL;
}

fclose($customerdb);

$data = [];
if (!$customerdb = fopen(SRC_FN, 'r')) exit('Unable to open file');
while($line = fgetcsv($customerdb)) {
	if (!empty($line) && count($line) > 0) $data[] = $line;
    echo $line[0] ?? 'Unknown';
    echo PHP_EOL;
}
var_dump($customers,$data);

```
* Another way to count lines w/out concern for large file sizes
```
$filepath = "funny.txt";
$fh = fopen($filepath, 'r');
$lines = 0;
while (!feof($fh)) {
	$line = fgets($fh);
	$lines++;
}
fclose($fh);
echo $lines;
```

* Modified Fibonacci program
```
<?php
function fibonacci($n, &$seed = [])
{
	$value = NULL;
	$seed = [0, 1, 1];
	if ($n < 4 && $n > 0) return $seed[$n - 1];
	for ($x = 3; $x < $n; $x++) {
		$value = $seed[$x - 1] + $seed[$x - 2];
		$seed[$x] = $value;
	}
	return $value;
}

$n = readline('Enter desired Fibonacci position: ');
$seed = [];
echo fibonacci($n, $seed);
echo PHP_EOL;
//var_dump($seed);
```
* HTML Select Function + other stuff
```
<?php
if (!empty($_POST)) {
	phpinfo(INFO_VARIABLES);
}
function htmlSelectHtml( $config ) {
	$html = '';
    $html .= '<select name="gender">';
    foreach ($config['select'] as $key => $value) {
        $html .=  '<option value="' . $key . '">' . $value . '</option>';
    }
    $html .=  '</select>';
    return $html;
}
function htmlCheckbox( $config )
{
	$html = '';
    foreach ($config['checkbox'] as $key => $value) {
        $html .=  '<input name="checkbox[]" type="checkbox" value="' . $key . '" />' . $value . '&nbsp;';
    }
	return $html;
}
$config = [
	'select' => ['M' => 'Male', 'F' => 'Female', 'X' => 'Other'],
	'checkbox' => ['A' => 'AAA', 'B' => 'BBB', 'C' => 'CCC'],
];
$dropdown = htmlSelectHtml($config);
$checkbox = htmlCheckbox($config);
$title    = 'Hello World';
$name     = 'Fred Flintstone';
include __DIR__ . '/../template.phtml';
```
* Here's the template file:
```
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.34.1" />
</head>
<body>
<h1><?= $title ?></h1>
Welcome <?= $name ?>
<form method="post" action="/index.php">
<?= $dropdown ?>
<br /> <?= $checkbox ?>
<br /><input type="submit" />
</form>
</body>
</html>
```
* `parse_url()` example:
```
<?php
$url = parse_url('http://user:password@mars-express.com/this/is/the/path?id=124&mission=STS395');
var_dump($url);
// output:
/*
array(6) {
  ["scheme"]=>
  string(4) "http"
  ["host"]=>
  string(16) "mars-express.com"
  ["user"]=>
  string(4) "user"
  ["pass"]=>
  string(8) "password"
  ["path"]=>
  string(17) "/this/is/the/path"
  ["query"]=>
  string(21) "id=124&mission=STS395"
}
*/
```
* Built in PHP web server:
```
 php -S localhost:9999 -t /path/to/document/root
```
* Cookie Example: https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php
* Session Example: https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php
* To check for an active session:
```
$active = (bool) (session_status() === PHP_SESSION_ACTIVE_);
```
Make an AJAX request from front-end using jQuery to the PHP back-end
```
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
function show(id)
{
    console.log(id);
    $.ajax({
        url: "<?= $ajax_url; ?>" + "?grid=" + id,
        type: "GET",
        dataType: "html",
        success: function (data) {
            $('#grid').html(data);
        }
    });
}
</script>
```
Session Example:
```
<?php
session_start();
$name = $_POST['name'] ?? $_SESSION['name'] ?? '';
$_SESSION['name'] = strip_tags($name);
?>
<form method="post">
	<input type="text" name="name" value="<?= htmlspecialchars($name) ?>" />
	<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
```
Serialization example:
```
<?php
class Test
{
	public $name = 'Doug';
	public $age  = 65;
	public $country = 'TH';
	public function getInfo()
	{
		return get_object_vars($this);
	}
}

// native PHP: used to store objects etc.
$test = new Test();
$str = serialize($test);
echo $str . PHP_EOL;

// JSON mainly for lightweight data exchange
$json = json_encode($test, JSON_PRETTY_PRINT);
echo $json . PHP_EOL;

$obj = unserialize($str);
var_dump($obj->getInfo());

$obj = json_decode($json);
var_dump($obj->getInfo());

```
## MySQLi
The Object class methods mirror the procedural functions:
* https://www.php.net/manual/en/mysqli.summary.php

To safeguard against SQL injection, use `mysqli_prepare($sql)` and then `mysqli_execute()`
* Prepare takes an SQL statement with placeholders
  * https://www.php.net/manual/en/mysqli.prepare.php
* Next you need to bind parameters
  * https://www.php.net/manual/en/mysqli-stmt.bind-param.php
* Finally, you execute the bound statement
  * https://www.php.net/manual/en/mysqli-stmt.execute.php

## Misc
Xdebug: https://xdebug.org/
* Enhances `var_dump()` and any error messages displayed
Use `error_log()` inside your code to track the status of variables
* Example
```
// some code
error_log(__FILE__ . ':' . __LINE__ . ':' . var_export($variable, TRUE));
```
File Upload Process
```
// process file upload
$error = [];
$path = realpath(__DIR__ . '/../data');
if (!empty($_FILES)) {
	$tmp = $_FILES['upload']['tmp_name'] ?? '';
	if (empty($tmp)) {
		$error['file'] = 'No temporary file';
	} elseif (!is_uploaded_file($tmp))  {
		$error['file'] = 'Not a valid uploaded file';
	} else {
		$error_code = $_FILES['upload']['error'] ?? 999;
		if ($error_code !== 0) {
			$error['file'] = 'File upload error';
		} else {
			$name  = $_FILES['upload']['name'] ?? 'temp.jpg';
			// optionally apply additional filter criteria to avoid uploaded PHP code!
			$final = $path . '/' . strip_tags(basename($name));
			move_uploaded_file($tmp, $final);
			$error['file'] = 'File uploaded successfully!';
		}
	}
}
```

## Update Notes
Things to watch out for when migrating from PHP 7 to 8
* Order of precedence for concatenate operartor has been *demoted* in PHP 8!
  * Solution: use parentheses to be clear
* In PHP 8 constants are *only* case sensitive whereas in PHP 7, the 3rd arg to `define()` lets you switch that
  * Look for any code using `define()` with *three arguments* === DANGER
* `each()` has been *removed* in PHP 8!
  * Most likely use the `...` to unpack rather than `each()`

## ERRATA
* http://localhost:8888/#/5/7
  * Revise this slide
* http://localhost:8881/#/3/24
  * s/be $days
* http://localhost:8881/#/4/13
  * Equivalent to:
```
// equivalent to: $ln = isset($user['lastname']) ? $user['lastname'] : 'not applicable';
```
* http://localhost:8881/#/8/24
  * s/be `$config['db']['host']` not `$config['db']['dsn']`
* Lab: Two Functions
  * Need to make instructions more clear



# PHP-I Nov 2021

## TO DO
* Track down contents of `php1` folder and make available
* Example of Fibonacci sequence code

## Homework
* For Fri 12 Nov 2021
  * http://collabedit.com/22wkm
* For Wed 10 Nov 2021
  * Review the "OrderApp"
  * Come to class with any questions
* For Mon 8 Nov 2021
  * http://collabedit.com/vubjm
  * Extra: build a PHP program `select.php` that generates an HTML SELECT element (dropdown list)
    * Do this in the VM
        * Create the `select.php` program in `/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public`
* For Fri 5 Nov 2021
  * http://collabedit.com/g4bnj
* For Weds 3 Nov 2021
  * Create a `hello.php` program in `/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public`
    * You use `echo` to output something
    * Run it from the browser (in the VM): `http://sandbox/hello.php`


## Q & A
* Q: Provide reference to `open_basedir` directive
* A: Limit the files that can be accessed by PHP to the specified directory-tree, including the file itself.
* A: https://www.php.net/manual/en/ini.core.php#ini.open-basedir

* Q: Provide links to suggested editors.  All of these support PHP. NetBeans and Eclipse are Java oriented, but support PHP.  PHPStorm is specifically designed for PHP, but is not free.  Geany is the fastest.
* A: Geany (open source, free): https://geany.org/
* A: VSCode (Microsoft, free for now): https://code.visualstudio.com/
* A: NetBeans (Apache Software Foundation, open source, free): https://netbeans.apache.org/
* A: Eclipse: (Eclipse Foundation, open source, free): https://www.eclipse.org/eclipseide/
* A: PhpStorm: (Jetbrains, not free): https://www.jetbrains.com/phpstorm/

* Q: Why is this not working?
```
<?php
$a = '11';
$b = 2;
if (ctype_digit($a) && ctype_digit($b)) {
    $c = $a + $b;
    var_dump($a, $b, $c);
} else {
    echo 'Invalid data encountered';
}
```
* A: If a numeric argument is supplied, ctype_digit() converts it to an ASCII character if it's between -128 and 255 and then checks to see if the ASCII character is within range of "0-9"
* A: Have a look at this example:
```
<?php
// Best Practice: only supply data type "string" as an argument to ctype_digit()
// See: https://www.php.net/ctype_digit

$a = ['1111', 49, '99.99', 'xxx', 42];
foreach ($a as $item) {
    echo "$item does ";
    echo (ctype_digit($item)) ? '' : 'NOT';
    echo " contain only digits\n";
}
// output:
/*
1111 does  contain only digits
49 does  contain only digits
99.99 does NOT contain only digits
xxx does NOT contain only digits
42 does NOT contain only digits
 */
```

## Class Notes
PHPMailer: https://github.com/PHPMailer/PHPMailer
SQL Tutorial: https://www.w3schools.com/sql/
PHP Examples: https://github.com/dbierer/classic_php_examples
Web Server Survey: https://news.netcraft.com/archives/category/web-server-survey/
Handling file uploads:
* https://www.php.net/manual/en/features.file-upload.php
* https://github.com/dbierer/classic_php_examples/blob/master/web/f%E2%80%8Eile_upload.php
Array Unpacking:
```
<?php
$foo = [1, 2, 3];
$baz = [4, 5, 6];
$bar = [$foo, $baz];
print_r($bar); //[1, 2, 3]
$bat = [...$foo, ...$baz];
print_r($bat); //[1, 2, 3]
$boo = array_merge($foo, $baz);
print_r($boo); //[1, 2, 3]
```
Different ways of assigning multi-dimensional arrays:
```
<?php
// Plan A
$mission = [
        'STS395' => [
                ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
                ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
                ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
        ]
];

// Output all elements
print_r($mission);

// Plan B
$mission = [
        'STS395' => [
                'botanist' => ['firstName' => 'Mark', 'lastName' => 'Watney'],
                'commander' => ['firstName' => 'Melissa', 'lastName' => 'Lewis'],
                'computer specialist' => ['firstName' => 'Beth', 'lastName' => 'Johanssen'],
        ]
];

// Output all elements
print_r($mission);
```

Predefined constants:
* https://www.php.net/manual/en/reserved.constants.php
Virtual Host Settings
* Apache: https://httpd.apache.org/docs/2.4/vhosts/examples.html
* Nginx: https://docs.nginx.com/nginx-ingress-controller/configuration/virtualserver-and-virtualserverroute-resources/
* In the VM: `/etc/apache2/sites-available`

Example of validating data prior to performing an operation:
```
<?php
$a = '11';
$b = 2;
if (filter_var($a, FILTER_VALIDATE_INT) && filter_var($b, FILTER_VALIDATE_INT)) {
    $c = $a + $b;
    var_dump($a, $b, $c);
} else {
    echo 'Invalid data encountered';
}
```
Forced typecasting is also a form of security:
```
<?php
$a = $_GET['a'] ?? 0;
$b = $_GET['b'] ?? 0;
$a = (float) $a;
$b = (float) $b;
$c = $a + $b;
echo "The sum of $a and $b is $c";
```
* If the input for `$b` is `http://sandbox/test.php?a=111&b=%3Cscript%3Ealert(%27test%27);%3C/script%3E`
  * The JavaScript is converted to (int) 0, no harm done

Form data acquisition and validation
```
<?php
// acquire data
$name = $_GET['name'] ?? '';
$age  = $_GET['age']  ?? 0;
$title = $_GET['title'] ?? '';
// validation
$expected = 3;
$valid = 0;
if (ctype_alpha($name)) $valid++;
if ((int) $age > 0) $valid++;
if (ctype_alpha($title)) $valid++;
// validation outcome
if ($expected === $valid) {
        echo 'Valid Data';
} else {
        echo 'Data is invalid';
}
```
Example of `ternary` operation
```
<?php
$gender = $_GET['gender'] ?? 'M';
$text = ($gender === 'F') ? 'She' : 'He';
echo $text . ' said that today is ' . date('l');
```
Takes the first non-NULL value:
```
<?php
$token = $_GET['token'] ?? $_POST['token'] ?? $_COOKIE['token'] ?? 'xxx';
```
Nested ternary construct requires parentheses in PHP 8
```
<?php
$gender = $_GET['gender'] ?? 'X';
$text = ($gender === 'F') ? 'She' : (($gender === 'M') ? 'He' : 'He/She');
echo $text . ' said that today is ' . date('l');
```

Good overview of the actual PHP program process
* https://www.zend.com/blog/exploring-new-php-jit-compiler
Statistics
* Database engine rankings:
  * https://db-engines.com/en/ranking
* Programming language rankings:
  * https://w3techs.com/technologies/overview/programming_language
* Web server ranking:
  * https://news.netcraft.com/archives/2021/06/29/june-2021-web-server-survey.html
* OS market share:
  * https://gs.statcounter.com/os-market-share
General examples of many concepts covered in class
* https://github.com/dbierer/classic_php_examples
Great explanation on how PHP works
* https://www.zend.com/blog/exploring-new-php-jit-compiler
An alternative way to run PHP is in "async" mode
* https://www.zend.com/blog/swoole
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
Example of `match` expression
```
<?php
$case = $_GET['case'] ?? 1;
$case = (int) $case;
$data = $_GET['data'] ?? 'Default';
$data = match($case) {
    0 => strtolower($data),
    1 => strtoupper($data),
    default => $data
};
echo $data;
```
How to do a redirect in PHP:
```
header('Location: ' . $url);
exit;
```
Using `foreach()` to generate an HTML `SELECT` element
```
<?php
$donuts = [
    'glazed' => 'Glazed Donuts',
    'choco'  => 'Chocolate Donut',
    'cherry' => 'Cherry Filled',
    'creme'  => 'Creme Filled',
];
$html = '';
$html .= '<select name="donut">';
foreach ($donuts as $key => $val) {
        $html .= '<option value="' . $key . '">' . $val . '</option>';
}
$html .= '</select>';
?>
<form method="post">
<?= $html ?>
<br />
<input type="submit" />
</form>
```
Example of `for()` loop
```
<?php
$alpha = range('A', 'Z');
$start = 13;
$length = 6;
for ($x = $start; $x < ($start + $length); $x++) {
    echo $alpha[$x];
}
```
Example of `while()` loop using `time()` as the criteria
```
<?php
$interval = 5;
$start    = time();
$end      = $start + $interval;
$count    = 0;
while (time() < $end) {
    echo '.';
    $count += 1;
}
echo "We just displayed $count number of dots in $interval seconds\n";
```
Example of `continue` as part of a form sanitization example
```
<?php
$post = $_POST;
$hash = bin2hex(random_bytes(8));
$clean = [];
foreach ($post as $key => $value) {
    if ($key === 'hash') continue;
    $clean[$key] = trim(strip_tags($value));
}
var_dump($clean);
?>
<form method="post">
<br>First: <input type="text" name="first" />
<br>Last: <input type="text" name="last" />
<br>City: <input type="text" name="city" />
<input type="hidden" name="hash" value="<?= $hash ?>" />
<br><input type="submit" />
</form>
```
Using `list()` to unpack an inner array
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

foreach ($mission as $id => $astronauts) {
        echo "Processing $id\n";
        foreach ($astronauts as list('firstName' => $first, 'lastName' => $last, 'specialty' => $special)) {
                echo "$first $last $special\n";
        }
}
```
Ticks
* https://www.php.net/manual/en/control-structures.declare.php#control-structures.declare.ticks
* This is used by certain PHP Async frameworks such as ReactPHP

The primary reason why you must provide type-hints is if a component in the function is sensitive to a particular data-type
* Example: the `foreach()` loop requires an `array` or an "iterable" equivalent:
```
<?php
function sum(array $arr) : float
{
    $sum = 0;
    foreach ($arr as $item) $sum += $item;
    return $sum;
}

echo sum(1,2,3,4,);
```
Homework example from Marc rewritten slightly:
```
<?php
$pastPurchases = [
    '001' => [
        'product' => 'Swimming Pool',
        'price' => 1000,
        'amount' => 2,
        'date' => time()
    ],
    '002' => [
        'product' => 'Car',
        'price' => 25000,
        'amount' => 1,
        'date' => time()
    ],
    '003' => [
        'product' => 'Rocket Launcher',
        'price' => 10,
        'amount' => 20,
        'date' => time()
    ],
    '004' => [
        'product' => 'Coffee Robot',
        'price' => 25,
        'amount' => 10,
        'date' => time()
    ]
];
$i = 0;
$max = count($pastPurchases);
do {
	$orderNum = key($pastPurchases);
	$orderInfo = current($pastPurchases);
	echo "\n\n\nOrder number: $orderNum contains \n";
	foreach ($orderInfo as $key => $value){
		echo "$key:   $value \n";
	}
	next($pastPurchases);
    $i++;
} while ($i < $max);

// OOP style:
$iterator = new ArrayIterator($pastPurchases);
do {
	$orderNum = $iterator->key();
	$orderInfo = $iterator->current();
	echo "\n\n\nOrder number: $orderNum contains \n";
	foreach ($orderInfo as $key => $value){
		echo "$key:   $value \n";
	}
	$iterator->next();
} while ($iterator->valid());
```
Type hinting
* If `declare(strict_types=1);` is not set, the type for float, int, boolean and string serves as a type-cast only
* If you do set strict types, the type hint is strictly enforced
```
<?php
// if this is not in effect, the example works:
declare(strict_types=1);
function sum(int $a, int $b) : int
{
	return $a + $b;
}
echo sum('88', '22');
```
In PHP 7 and below to add `NULL` as a type hint, just precede the existing type hint with a `?`
```
<?php
declare(strict_types=1);
// "?string" is the same as "string|null"
function welcome(?string $arg = 'JavaScript',) :string {
    return "Welcome to the wonderful world of $arg coding";
}

echo welcome();
echo welcome('PHP');
echo welcome(NULL);
```
In PHP 8 and above, you can skip intermediary params (if they have defaults) and name only the one you want:
```
<?php
// this works in PHP 8
setcookie('test', date('Ymd'), httponly:TRUE);

// in PHP 7, you'd have to do this:
setcookie('test', date('Ymd'), 0, '', '', FALSE, TRUE);
```
Example of unlimited args:
```
<?php
// older way to define a function with unlimited args:
function superVarDump()
{
	$args = func_get_args();
	var_dump(...$args);
}
// this approach does the same thing, but is preferred:
function superVarDump2(...$args)
{
	var_dump(...$args);
}


$a = [1,2,3];
$b = 'TEST';
$c = TRUE;
$d = 111.222;

superVarDump($a, $b, $c, $d);
echo "\n";
superVarDump2($a, $b, $c, $d);
```
Example using `substr()` to secure output of sensitive data
```
<?php
function process($ccNum, $amount)
{
	// do something
	return TRUE;
}

$payments = [
	'1111-2222-3333-4444' => 99.99,
	'2222-3333-4444-5555' => 99.99,
	'3333-4444-5555-6666' => 99.99,
];

foreach ($payments as $ccNum => $amount) {
	if (process($ccNum, $amount)) {
		// takes the substring counting from the beginning:
		// $secure = '****-****-****-' . substr($ccNum, 15);
		// takes the substring counting from the end:
		$secure = '****-****-****-' . substr($ccNum, -4);
		echo "$secure successfully process $amount\n";
	}
}
```
Another approach using `explode()` to split the CC number by the `-`
```
foreach ($payments as $ccNum => $amount) {
	if (process($ccNum, $amount)) {
		$ccData = explode('-', $ccNum);
		$secure = '****-****-****-' . array_pop($ccData);
		echo "$secure successfully process $amount\n";
	}
}
```

For representings date based upon locale, use this class:
* https://www.php.net/IntlDateFormatter
To get info on incoming information:
```
<?php
phpinfo(INFO_VARIABLES);
```
Example using Anonymous Functions as a form post data filtering mechanism
```
<?php
$clean = [];
$filter = [
    'trim' => function ($data) { return trim($data); },
    'strip'=> function ($data) { return strip_tags($data); },
];
if (!empty($_POST)) {
    foreach ($_POST as $key => $item) {
        foreach ($filter as $filt => $func) {
            $item = $func($item);
    	}
    	$clean[$key] = $item;
    }
}
?>
<form method="post">
Name: <input type="text" name="name" />
<br />City: <input type="text" name="city" />
<br />Email: <input type="email" name="email" />
<br />Date: <input type="date" name="date" />
<br /><input type="submit" />
</form>
<?= implode('< br/>', $clean) ?>
```
Same example, but rewritten using "arrow functions"
```
$filter = [
    'trim' => fn ($data) => trim($data),
    'strip'=> fn ($data) => strip_tags($data),
];
```
Using `geonames.org` post code data to lookup a city based upon postcode
```
<?php
// assumes the geonames file has been downloaded
function getCityFromPostCode(string $input)
{
	$fn = __DIR__ . '/../data/NL_full.txt';
	$fh = fopen($fn, 'r');
	while ($row = fgetcsv($fh, 1024, "\t")) {
		if (!empty($row[1])) {
			$postCode = trim($row[1]);
			$city     = trim($row[2]);
			if ($postCode === $input) {
				echo $city . "\n";
				break;
			}
		}
	}
	fclose($fh);
}
$input = $_GET['postcode'] ?? '';
if (!empty($input)) getCityFromPostCode($input);
?>
<form method="GET">
Please enter a postcode:
<input type="text" name="postcode" />
<input type="submit" />
</form>
```
Example using `file_get_contents()` and `str_ireplace()` to "re-purpose" a website:
```
<?php
$text = file_get_contents('https://google.com');
$text = str_ireplace('Google', 'Boogle', $text);
echo $text;
```
Example using various HTML input types
```
<?php
$clean = [];
$filter = [
    'trim' => fn ($data) => trim($data),
    'strip'=> fn ($data) => strip_tags($data),
];
if (!empty($_POST)) {
    foreach ($_POST as $key => $item) {
        foreach ($filter as $filt => $func) {
           if (is_array($item)) {
           	foreach ($item as $a => $b) {
           		$item[$a] = $func($b);
           	}
           } else {
           	$item = $func($item);
           }
    	}
    	$clean[$key] = $item;
    }
}
$marital = ['M' => 'Married', 'S' => 'Single', 'I' => 'In-Between'];
$interests = ['R' => 'Reading', 'C' => 'Cinema', 'S' => 'Sports', 'M' => 'Music'];
?>
<form method="post">
Name: <input type="text" name="name" />
<br />City: <input type="text" name="city" />
<br />Email: <input type="email" name="email" />
<br />Date: <input type="date" name="date" />
<br />
<?php foreach ($marital as $key => $val) : ?>
<input type="radio" name="marital" value="<?= $key ?>"><?= $val ?>
<?php endforeach; ?>
<br />
<?php foreach ($interests as $key => $val) : ?>
<input type="checkbox" name="interest[]" value="<?= $key ?>"><?= $val ?>
<?php endforeach; ?>
<br /><input type="submit" />
</form>
<pre> <?= var_dump($clean) ?> </pre>
 <?php phpinfo(INFO_VARIABLES) ?>
 ```
Example of performing an `INSERT` followed by `SELECT` statements:
```
<?php
$config = require __DIR__ . '/../../orderapp/config/config.php';
$db     = mysqli_connect($config['db']['dsn'],
			  $config['db']['username'],
			  $config['db']['password'],
			  $config['db']['database']);
$ins_sql = "INSERT INTO customers (firstname,lastname) VALUES ('Fred', 'Flintstone')";
$num_rows = mysqli_query($db, $ins_sql);
if ($num_rows > 0) {
    echo "Success!\n";
} else {
    echo "Problem!\n";
    error_log(mysqli_error($db));
}
$sql = 'SELECT * FROM customers';
$result = mysqli_query($db, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    var_dump($row);
}
```

## Miscellaneous
Highly recommended JavaScript library
* https://jquery.com/
How do you get rid of `System Program Error Detected` messages in the VM?
* Run this command:
```
sudo rm /var/crash/*
```
* The `sudo` password is `vagrant`

## Example of uploading a file and sending it as an email attachment
* Note: assumes PHPMailer is installed
* Follow directions on https://github.com/PHPMailer/PHPMailer
```
<?php
include __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
if (!empty($_FILES)) {
   if ( $_FILES['upload']['error'] == UPLOAD_ERR_OK ) {
	if ( is_uploaded_file ($_FILES['upload']['tmp_name'] ) ) {
           $tmp_name = $_FILES['upload']['tmp_name'] ?? '';
           if (!empty($tmp_name)) {
           	$fn = __DIR__ . '/../data/' . basename($_FILES['upload']['name']);
           	if (move_uploaded_file($tmp_name, $fn)) {
           	    // at this point, just follow the "Simple Example" on the Github PHPMailer page
           	    // https://github.com/PHPMailer/PHPMailer
           	    $mail = new PHPMailer(true);
		    $mail->setFrom('from@example.com', 'Mailer');
		    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
		    $mail->addAttachment($fn);         //Add attachments
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = 'Here is the subject';
		    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		    $mail->send();
               }
           } else {
               echo "Problem with temporary name";
           }
       } else {
           echo "Not an uploaded file";
       }
   }
}
?>
<form method="post" enctype="multipart/form-data">
File: <input type="file" name="upload" />
<input type="submit" />
</form>
```
## Errata
* http://localhost:8888/#/4/14
  * S/be as follows:
```
```
* http://localhost:8888/#/5/26
  * As written, the `mysqli_connect()` return value is not assigned, therefore it's useless
  * s/be
```
$connect = mysqli_connect(xxx, yyy, etc.);
```
* OrderApp generates error upon entering new order
* http://localhost:8888/#/7/24
  * `if ($_POST` missing closing parenthesis and opening {
* http://localhost:8888/#/7/25
  * Same note as above
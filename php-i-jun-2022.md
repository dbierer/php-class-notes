# PHP-I Jun 2022

## Homework
For Fri 8 Jul 2022
* https://collabedit.com/pf4d4
For Wed 6 Jul
* https://collabedit.com/hsyq7
For Tues 5 Jul 2022
* https://collabedit.com/s8b8e
For Fri 1 Jul 2022
* Create a "Hello World" program
  * Put it under `sandbox/public`
* https://collabedit.com/gpvud

## TODO
NOTE: we'll deal with phpMyAdmin later!
Send email to Nicole re: follow-on August class for PHP II

## Q & A
* Demonstrate sorting different in PHP 8 where duplicate values are retained in their original add order (stable sort)
  * Discussion: https://wiki.php.net/rfc/stable_sorting
  * Example: https://github.com/dbierer/classic_php_examples/blob/master/basics/sort_stable.php
* Get the "php1" source code (code from the slides)
  * I'll give you the URL in class for opensource/php1.zip
  * Unzip in the VM into `Zend/workspaces/DefaultWorkspace`
* Find Dilbert with Spaghetti code guy
  * https://dilbert.com/strip/1994-06-10
* Black screen VM problem
  * Update VirtualBox
  * If you get a black screen
    * Select "Reset" from the VirtualBox top left menu
    * If that doesn't work, do you get an Ubuntu Boot Menu?
    * If so, select "Advanced Boot Options"
      * Run file system check
      * Run anything else that looks like it will repair the file system
      * Select "Resume Normal Boot"
  * It might also be simple monitor/resolution issue. Try getting out of "scaled mode" and see if that works. Or switch monitors if available.
  * If all else fails, erase the VM and all files and rebuild using `vagrant up`

### ZendPHP instructions
* Remove existing PHP installation
```
sudo apt remove php8.0
```
* When prompted remove phpMyAdmin database and configuration
* Install the `zendphpctl` utlity
```
curl -L https://repos.zend.com/zendphp/zendphpctl -o zendphpctl
curl -L https://repos.zend.com/zendphp/zendphpctl.sig -o zendphpctl.sig
echo "$(cat zendphpctl.sig) zendphpctl" | sha256sum --check
rm zendphpctl.sig
chmod +x zendphpctl
sudo mv zendphpctl /usr/local/sbin
```
* Test to make sure `zendphpctl` is working ok
```
sudo zendphpctl
```
* Install repository
```
sudo zendphpctl repo-install
```
* Install PHP 8.1
```
sudo zendphpctl php-install 8.1
```
* Check the version
```
php --version
```
### PHP-FPM Installation
* Install the php-fpm package
```
sudo apt-get install php8.1-zend-fpm
```
* Enable Apache bindings
```
sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php8.1-zend-fpm
```
* Start the php-fpm pool and Apache2:
```
sudo systemctl start php8.1-zend-fpm
sudo systemctl restart apache2
```
* Test from the VM browser: `http://sandbox/`

NOTE: full instructions are here:
* https://help.zend.com/zendphp/current/content/installation/linux_installation_zendphpctl.htm

## Other TODO
* Upload the files for the PHP1 folder
  * Will do that in-class
* Example of web server config file for PHP-FPM
```
# /etc/apache2/conf-enabled/php8.1-zend-fpm.conf
# Redirect to local php-fpm if mod_php is not available
<IfModule !mod_php8.c>
<IfModule proxy_fcgi_module>
    # Enable http authorization headers
    <IfModule setenvif_module>
    SetEnvIfNoCase ^Authorization$ "(.+)" HTTP_AUTHORIZATION=$1
    </IfModule>

    <FilesMatch ".+\.ph(ar|p|tml)$">
        SetHandler "proxy:unix:/run/php/php8.1-zend-fpm.sock|fcgi://localhost"
    </FilesMatch>
    <FilesMatch ".+\.phps$">
        # Deny access to raw php sources by default
        # To re-enable it's recommended to enable access to the files
        # only in specific virtual host or directory
        Require all denied
    </FilesMatch>
    # Deny access to files without filename (e.g. '.php')
    <FilesMatch "^\.ph(ar|p|ps|tml)$">
        Require all denied
    </FilesMatch>
</IfModule>
</IfModule>
```
* Example of unicode escape syntax
 * See: https://github.com/dbierer/classic_php_examples/blob/master/basics/unicode_escape_characters.php

## Homework
* For Weds 29 Jun 2022
  * Update the VM to PHP 8.1 using ZendPHP (instructions to be provided via email)
```
sudo a2dismod php8.0
```
  * Update phpMyAdmin (instructions to be provided via email)

## Class Notes
If you need to run an OS command, use `shell_exec()`
* https://www.php.net/shell_exec

Performance enhancements for PHP
* https://www.zend.com/blog/exploring-new-php-jit-compiler
* https://www.zend.com/blog/swoole
Formal definition of "doc blocks":
* https://phpdoc.org/
New version of PHP:
* ZendPHP (see
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
echo htmlspecialchars($name);   // safeguards when you echo from an untrustes source
echo "\n";
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

# PHP-I Class Notes

## HOMEWORK
* For Fri 21 Nov 2019
  * https://gist.github.com/dbierer/c68c1e6ffe96666f938aafcccff54415
  * To access the database in the VM: open a terminal window and then:
```
mysql -u vagrant -p
```
  * From the `mysql` command prompt:
```
help [<command>];
help show;
show databases;
use phpcourse;
show tables;
show create table <name of table>;
--when finished:
exit;
```
* For Wed 19 Nov 2019
  * https://gist.github.com/dbierer/39ef3a69bae952a7f6645131becce0da
* For Mon 17 Nov 2019
  * https://gist.github.com/dbierer/5eb9f74f02dc6e98f69a9b95d02cb62e
  * https://github.com/rpuglia12/php1/blob/master/homework%2011-18-19
* For Fri 15 Nov 2019
  * https://gist.github.com/dbierer/961007eabe0da28e402b94b7998adfe9
  * https://github.com/rpuglia12/php1/blob/master/homework%2011-15-19
* For Wed 13 Nov 2019
  * https://gist.github.com/dbierer/9a1a957c16af5cd92b8d52fcf0a39272
  * https://github.com/rpuglia12/php1/blob/master/homework%2011-13-19
  * For the file labs: here's how you can set permissions for both web + command line vagrant user:
```
sudo chown vagrant:www-data /path/to/directory
sudo chmod 775 /path/to/directory
```

* For Mon 11 Nov 2019
  * https://gist.github.com/dbierer/475743a8f0b658b71cef5f7287eada2c
  * https://github.com/rpuglia12/php1/blob/master/homework11-8-19
* For Fri 8 Nov 2019
  * Lab: The Mixed Array 1
  * http://collabedit.com/sjtx8

## CLASS NOTES
* Resources:
  * https://www.packtpub.com/catalogsearch/result/?q=html
  * Check out O'Reilly
  * W3Schools
* Tools to test for security weaknesses in your application:
  * Looks for SQL Injection vulnerabilities: http://sqlmap.org/
  * General vulnerability tester: OWASP ZED Attack Proxy
* PHP DB2 Manual: https://www.php.net/manual/en/book.ibm-db2.php
* To work with URLs, etc.:
  * Parse a URL: https://www.php.net/parse_url
  * Build a query string: https://www.php.net/manual/en/function.http-build-query.php
  * To encode URL for transmission: https://www.php.net/manual/en/function.urlencode.php
  * HTTP Status Codes: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
* HTTP requests info
  * Use `phpinfo(INFO_VARIABLES);` in your script to test incoming requests; erase afterwards!!!
* JavaScript Libraries:
  * Library of classes and functions: https://jquery.com/
  * Complete Front End: https://reactjs.org/
* Additional PHP software: https://packagist.org/
* `fopen()` can also be used with a number of different protocols:
  * See: https://www.php.net/manual/en/wrappers.php
  * To send metadata along with your payload, create a "context" using `stream_context_create`
  * See: https://www.php.net/stream_context_create
* If you need to create a zero byte file entry use `touch($fn)`
* Communicating with remote systems:
  * `fsockopen()`
  * `stream_socket_client()`
  * Using the `cURL` extension: https://www.php.net/curl
* To build relative directory path:
```
// example of writing to a dir "data" 2 levels up from here
$path = realpath(__DIR__ . '/../../data');
```
* The file commands write a string to the filesystem.  What about writing arrays or objects?
  * Use either `json_encode()` or `serialize()` to first convert the array or to a string
  * Use `json_decode()` or `unserialize()` to reverse and get the original data back
* If you need to increase the amount of RAM allocated for a program run:  this example sets the limit to 1 GB:
```
ini_set('memory_limit', '1G');
```

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
* Modified homework example returning an associative array
```
<?php
function getOrderTotal(int $operand1,int $operand2) {

  $sum = $operand1 + $operand2;

  return array('sum' => $sum, 'op1' => $operand1, 'op2' => $operand2);
}

$returnarray = getOrderTotal(1,3);
foreach ($returnarray as $key => $value) {
  echo $key . ':' . $value;
  echo PHP_EOL;
}
```
* Example of a hit count + using `glob()`
```
<?php
function getCount( $counter )
{
    if (!file_exists($counter)) touch($counter);
    $fh = fopen( $counter, 'r+' );  // bi-directional mode
    $num = (int) fread( $fh, 10 );  // get the current count
    rewind( $fh );                  // reset file pointer
    fwrite( $fh, ++$num, 10 );      // pre-increment and write new count
    fclose( $fh );                  // close the handle
    return $num;
}
$path = realpath(__DIR__ . '/../../php1/src/ModIOAndLibraries');
$list = glob($path . '/*');
echo 'Hit count: ' . getCount(__DIR__ . '/../data/counter.txt') . PHP_EOL;
echo '<br><pre>';
var_dump($list);
echo '</pre>';
```
* Example of function to create SELECT
```
<?php
// Functions to get config
$config = include __DIR__ . '/../config/config.php';

function htmlSelectHtml( $config, $current ) {
    $html = '<select>' . PHP_EOL;
      foreach ($config as $value) {
	$selected = ($value == $current) ? 'selected ' : '';
        $html .=  '<option value="'.$value.'" ' . $selected . '>'.$value.'</option>' . PHP_EOL;
      }
    $html .= '</select>';
    return $html;
}

echo '<!DOCTYPE html><html><body>';
echo htmlSelectHtml($config['status_codes'], 'open');
echo '<br>';
echo htmlSelectHtml($config['security'], 'pending');
echo '<br>';
echo '</body></html>';
```
* File Ops involving PHP `serialize()` vs. `json_encode()` etc.
```
<?php
define('FILE_JSON', __DIR__ . '/json.js');
define('SERIAL_FILE', __DIR__ . '/serial.txt');

class User
{
    public $first;
    public $last;
    public function __construct($first, $last)
    {
	$this->first = $first;
	$this->last  = $last;
    }
    public function getFullName()
    {
	return $this->first . ' ' . $this->last;
    }
}

$user = new User('Fred','Flintstone');
echo $user->getFullName();

file_put_contents(FILE_JSON, json_encode($user,  JSON_PRETTY_PRINT |  JSON_FORCE_OBJECT));
file_put_contents(SERIAL_FILE, serialize($user));

$serialUser = unserialize(file_get_contents(SERIAL_FILE));
$jsonUser = json_decode(file_get_contents(FILE_JSON));

echo PHP_EOL;
var_dump($serialUser);
var_dump($jsonUser);
echo $serialUser->getFullName();
echo PHP_EOL;
echo $jsonUser->getFullName();
```
* Example of HTML with embedded PHP
```
<?php
function addAttribs($config, $name) {
    echo ' name="' . $name . '"';
    foreach ($config[$name] as $key => $value) {
	echo ' ' . $key . '="' . $value . '"';
    }
};
$config = [
    'username' => [
	'type' => 'text',
	'size' => 40,
	'class' => 'user_class',
	'placeholder' => 'Enter Username',
	'title' => 'Username must only be alpha numeric: no special characters',
    ],
    'password' => [
	'type' => 'password',
	'size' => 20,
	'class' => 'pwd_class'
    ],
];?>
<!DOCTYPE html>
<html>
<title> HTML homework assignment </title>
<form>
  User Name:
  <br><input <?= addAttribs($config, 'username'); ?> />
  <br>Password:
  <br><input <?= addAttribs($config, 'password'); ?> />
  <input type="submit" value="Submit" />
</form>
</html>
```
* PHP producing all the HTML
```
<?php
function addAttribs($config, $name) {
    $attribs = '';
    $attribs .= ' name="' . $name . '"';
    foreach ($config[$name] as $key => $value) {
	$attribs .= ' ' . $key . '="' . $value . '"';
    }
    return $attribs;
};
$config = [
    'username' => [
	'type' => 'text',
	'size' => 40,
	'class' => 'user_class',
	'placeholder' => 'Enter Username',
	'title' => 'Username must only be alpha numeric: no special characters',
    ],
    'password' => [
	'type' => 'password',
	'size' => 20,
	'class' => 'pwd_class'
    ],
];
$output = '<!DOCTYPE html>';
$output .= '<html>';
$output .= '<head>';
$output .= '<title> HTML homework assignment </title>';
$output .= '</head>';
$output .= '<body>';
$output .= '<form>';
$output .= '  User Name:';
$output .= '  <br><input ' . addAttribs($config, 'username') . '/>';
$output .= '  <br>Password:';
$output .= '  <br><input ' . addAttribs($config, 'password') . '/>';
$output .= '  <input type="submit" value="Submit" />';
$output .= '</form>';
$output .= '</body>';
$output .= '</html> ';
echo $output;
```
* Examples of filtering and validation of username
```
<?php
// form data validation
// username: example of regulations: mandatory, length 6 - 8 chars, alphanumeric
$points   = 0;
$expected = 3;
$username = '';
$message  = '';
// example of validation:
if (!isset($_POST['username'])) {
    $message = 'Username is not set';
} else {
    $points++;
    // check length
    if (strlen($_POST['username']) >= 6 and strlen($_POST['username']) <= 8) {
	$points++;
    } else {
	$message .= '<br>Invalid length' . PHP_EOL;
    }
    // alphanumeric check
    if (ctype_alnum($_POST['username'])) {
	$points++;
    } else {
	$message .= '<br>Name contains non alphanumerics';
    }
    if ($points == $expected) {
	// example of filtering:
	$username = strip_tags($_POST['username']);
	$message  = 'Username Meets Criteria';
    }
}
// escape any suspect output:
echo 'Username: ' . htmlspecialchars($username);
echo '<br>Message: ' . $message;
phpinfo(INFO_VARIABLES);
```
* Login / New Account form example
```
<?php // login.php ?>
<!DOCTYPE html>
<html>
<head>
<title> User, Password and Email Form </title>
<!-- Use PHP to build a custom javascript function -->
</head>
<body>
<form action="login_submit.php" method="post">
  User Name:<input type="text" name="username" size=10 placeholder="Enter username." title="Username must be alphanumeric, no special characters."><br><br>
  Email Address:<input type="email" name="emailaddr" size=64 placeholder="Enter email address." title="Enter a valid email address."><br><br>
  Password:<input type="password" name="pswd" size=20><br><br>
  New Account? <input type="checkbox" name="new_acct" value="1" /><br><br>
  <input type="submit" value="Submit">
</form>
</body>
</html>
```
* Login / New Account target PHP program
```
<?php
// login_submit.php
$points   = 0;
$expected = 5;
$username = $_POST['username']  ?? '';
$email    = $_POST['emailaddr'] ?? '';
$password = $_POST['pswd']      ?? '';
$new_acct = $_POST['new_acct']  ?? '';
$message  = '';

// validate username - must be entered
if (!$username) {
    $message .= '<br><br>Username is not set.';
} else {
    $points++;
    // length must be 6 - 10 characters
    if (strlen($username) >= 6 and strlen($username) <= 10) {
	$points++;
    } else {
	$message .= 'Invalid length.  ' . PHP_EOL;
    }
    // alphanumeric check
    if (ctype_alnum($username)) {
	$points++;
    } else {
	$message .= 'Name contains non alphanumerics.  ';
    }
    if ($points == $expected) {
	// filter username
	$username = strip_tags($username);
    } else {
        // escape any suspect output and display message
        $message .= 'Username: ' . htmlspecialchars($username);
    }
    // validate email
    if (!$email) {
        $message .= '<br><br>Email address is not set.';
    } else {
        $points++;
        // filter password
        $email_addr = strip_tags($email);
    }
    if (!$password) {
        $message .= 'Password is not set.';
    } else {
	$points++;
    }
}

// validate password if it's a new account only
if ($new_acct) {
    $expected += 3;
    $pswd = '';
    // password must be entered
    if (!$password) {
        $message .= 'Password is not set.';
    } else {
        $points++;
        // length must be 8 - 20 characters
        if (strlen($password) >= 8 and strlen($password) <= 20) {
	    $points++;
        }
        // uppercase, lowercase, number and special character check
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if($uppercase && $lowercase && $number && $specialChars) {
            $points++;
	    $password = password_hash($password);
        } else {
	    $message .= 'For new accounts, please set your password according the guidelines on our New Accounts Page.';
	}
    }
}

if ($points == $expected) {
    echo 'Valid Login.';
    if ($new_acct) {
	// at this point you would store all collected user info
	// store the password HASH, not plain text!
    }
} else {
    echo 'Invalid Login.';
}
echo '<br>' . $message;
echo '<br>';
phpinfo(INFO_VARIABLES);
```
* Example iterating through the `customers` table in the VM:
```
<?php
// Gets a connection to the database
$conn = mysqli_connect('127.0.0.1', 'vagrant', 'vagrant', 'phpcourse');
// Queries the database with the specified query
$result = mysqli_query($conn, "SELECT * FROM customers");
// Fetches a row a data based on the query
while ( $row = mysqli_fetch_assoc($result)) {
    var_dump($row);
}
// close
mysqli_close($conn);
```
* Database Lab
```
<?php
try {
	// connect to the DB
	$conn = mysqli_connect('127.0.0.1', 'vagrant', 'vagrant', 'accounts');

	if ($conn->connect_error) {
            throw new Exception('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
	}

	//set parameter markers and execute sql
	$name = $_GET['name'] ?? '';
	$avatar = $_GET['avatar'] ?? '';
	$language = $_GET['language'] ?? '';

	if ($name && $avatar && $language) {

	    // filter, validate and sanatize inputs
	    $name = strtolower(strip_tags($name));
	    $avatar = strip_tags($avatar);
	    $language = strip_tags($language);

	    // to protect against SQL injection: filter out certain characters (e.g. ";")
	    $name = str_replace(';', '', $name);
	    $avatar = str_replace(';', '', $avatar);
	    $language = str_replace(';', '', $language);

	    // as a further layer of security, use parameterized query
	    // prepare sql statment
	    $stmt = $conn->prepare("update profile set avatar = ?, language = ? where name = ?");
	    $stmt->bind_param('sss', $avatar, $language, $name);
	    $stmt->execute();
	}

	// fetch all rows
	$result = $conn->query("select * from profile");
	// Fetches a row a data based on the query
	if ($result) {
	    while ( $row = mysqli_fetch_assoc($result)) {
		var_dump($row);
	    }
	} else {
	    echo "No results";
	}
	// close
	mysqli_close($conn);

} catch (Throwable $t) {
	echo $t->getMessage();
}
```

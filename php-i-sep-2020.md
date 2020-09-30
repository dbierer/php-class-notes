# PHP-I -- Sep 2020
# Class Notes

## Homework
* For Fri 02 Oct
  * http://collabedit.com/mbnby
* For Wed 30 Sep
  * http://collabedit.com/44443
* For Mon 28 Sep
  * http://collabedit.com/e4qna
* For Fri 25 Sep
  * http://collabedit.com/3ykhb
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
* Provide benchmarks that show performance of `file*()` vs. `fopen()` family of I/O functions
* Database tech survey?

## Q & A
* Q: How do you increase the memory allocation for a PHP program
* A: `ini_set('memory_limit', 'XXX'); // where "XXX" is some number + "M" or "G"`
* Q: Most popular location for PHP packages?
* A: https://packagist.org/
  A: Managed by Composer (getcomposer.org)

## Class Discussion
* Example using the `http` wrapper:
```
<?php
$url = 'https://google.com/';
$contents = file_get_contents($url);
$contents = str_replace('Google', 'Boogle', $contents);
echo $contents;
```
* File Ops
  * Wrappers: https://www.php.net/manual/en/wrappers.php
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
* Simple HTML form + PHP
```
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Test</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>

<form method="post">
	Name: <input type="text" name="name" />
	<br>Age: <input type="text" name="age" />
	<br>Email: <input type="email" name="email" />
	<br>Date: <input type="date" name="date" />
	<br><input type="submit" name="submit" value="Do It" />
</form>

</body>
</html>
```
* Example using `fopen()`
```
<?php
$fn = __DIR__ . '/gettysburg.txt';
$fh = fopen($fn, 'r');
if ($fh) {
	while (!feof($fh)) {
		$line = fgets($fh);
		echo $line;
	}
	fclose($fh);
} else {
	echo 'Error opening file';
}
```
* Example of reading a CSV file and producing output from it
```
<?php	
// reads a CSV and returns a multi-dimensional array
$path = '/home/vagrant/Zend/workspaces/DefaultWorkspace/php1/src/ModIOAndLibraries/';
$file = $path . 'bitcoin.csv';
$fh   = fopen($file, 'r');
$data = [];
$headers = [];
while (!feof($fh)){
	$line = fgetcsv($fh);
	if (!$headers) {
		$headers = $line;
	} else {
		$data[] = $line;
	}
}

// output using the sprintf() family
vprintf("%3s : %6s : %6s : %8s : %s\n", $headers);
foreach ($data as $line) {
	if ($line && is_array($line) && count($line) === 5) {
		vprintf("%3d : %6d : %6d : %8.2f : %s\n", $line);
	}
}
```
* Benchmark `fopen()` vs. `file()`
  * Conclusion: peformance ratio `fopen*`:`file*` is 3:2
```
<?php	
// very_large_file.txt == 1.2M of lorem ipsum from https://www.lipsum.com

$max   = 1000; // iterations
$file  = __DIR__ . '/very_large_file.txt';

// testing fopen
$start = microtime(TRUE);
$total = 0;
for ($x = 0; $x < $max; $x++) {
	$fh = fopen($file, 'r');
	while (!feof($fh)) {
		$line = fgets($fh);
		$total += str_word_count($line);
	}
	fclose($fh);
}
$end = microtime(TRUE);
$run = ($end - $start) * 1000; 
echo "fopen\n";
echo 'Time Elapsed    : ' . $run . " ms\n";
echo "Words Processed : $total\n";

// testing file
$start = microtime(TRUE);
$total = 0;
for ($x = 0; $x < $max; $x++) {
	$fh = file($file);
	foreach ($fh as $line) {
		$total += str_word_count($line);
	}
}
$end = microtime(TRUE);
$run = ($end - $start) * 1000; 
echo "file\n";
echo 'Time Elapsed    : ' . $run . " ms\n";
echo "Words Processed : $total\n";

// Output
/*
fopen
Time Elapsed    : 11320.692062378 ms
Words Processed : 182400000
file
Time Elapsed    :  7901.5920162201 ms
Words Processed : 182400000
*/
```
* Example of directory recursion using `RecursiveDirectoryIterator`
```
<?php	
// read dir structure using RecursiveDirectoryIterator

$dirIter = new RecursiveDirectoryIterator(__DIR__ . '/../../php1');
$recurse = new RecursiveIteratorIterator($dirIter);

foreach ($recurse as $name => $info) {
	if ($info->isDir()) {
		echo $name;
	} else {
		echo $info->getBasename() . "\n";
	}
}
```
* How to simulate a "fake" DNS entry: add <ip address>   <fake host> to the local "hosts" file:
  * Windows: `C:\Windows\System32\drivers\etc\hosts`
  * Linux: `/etc/hosts`
* NetCraft web server survey:
  * https://news.netcraft.com/archives/2020/07/27/july-2020-web-server-survey.html
* Excellent quality, non advertising driven search engine: 
  * https://duckduckgo.com
* Sample Program to generate a form using a hybrid approach:
```
// test.php
<?php
$error_count = 0;
$title = 'Test Page';
$form = [
	'name' => ['label' => 'Name', 'type' => 'text', 'name' => 'name', 'error' => '', 'value' => ''],
	'email' => ['label' => 'Email', 'type' => 'email', 'name' => 'email', 'error' => '', 'value' => ''],
	'submit' => ['label' => 'Submit', 'type' => 'submit', 'name' => 'submit', 'value' => 'Process'],
];
if ($_POST) {
	$email = $_POST['email'] ?? '';
	$name  = $_POST['name'] ?? '';
	if (!empty($email)) {
		// validate
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$form['email']['error'] = 'Bad email address';
			$error_count++;
		}
		// sanitize
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$form['email']['value'] = $email;
		// do the same for name (code not shown)
	} else {
		$form['email']['error'] = 'Email address is mandatory';
		$error_count++;
	}
	// sanitize the name
	// NOTE: should also validate
	$name = strip_tags($name);
	$form['name']['value'] = $name;
}
include __DIR__ . '/html_some_php.php';
```
* Second program to display the form:
```
<!-- html_some_php.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?= $title; ?></title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>

<form method="post">
	<?php foreach ($form as $element) : ?>
		<br><?= $element['label'] . ':'; ?>
		<input type="<?= $element['type'] ?>" name="<?= $element['name']?>" 
		       value="<?php if (!empty($element['value'])) echo $element['value']; ?>"  />
		<?php if (isset($element['error']) && $element['error']) echo $element['error']; ?>
	<?php endforeach; ?>
</form>

</body>
</html>
```
## HTML and PHP
```
<?php
define('FIELD_USER', 'username');
define('FIELD_PWD', 'pwd');
$dbFake = ['test' => 'password', 'whatever' => 'whatever'];
$message = '';

// capture username
$username = $_POST[FIELD_USER] ?? '';

// sanitize the name
$username = strip_tags($username);

// validate the name
// assume all usernames must only contain alphanumeric characters
if (ctype_alnum($username)) {
	$message .= "Username accepted\n";
}

// capture password
$password = $_POST[FIELD_PWD] ?? '';

// validate password via simulated database lookup
$valid = FALSE;
if (isset($dbFake[$username])) {
	if ($dbFake[$username] === $password) {
		$valid = TRUE;
		$message .= "Password accepted\n";
	}
}	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>HTML with PHP</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
<form method="post">    
    <label >username: </label>
    <input name="<?= FIELD_USER ?>" value="<?= $username ?>" />
    <br>
    <label>password: </label>
    <input name="<?= FIELD_PWD ?>" type="password" />
    <br>
    <input type="submit" name="login" value="login" />
</form>
<?= $message ?>
</body>
</html>
```
* Example of page visit tracking using cookies
```
<?php
$visits = $_COOKIE['visits'] ?? 0;
setcookie('visits', ++$visits, time() + 3600);
echo "You have visited this page $visits times\n";
```
* Example of page visit tracking using session
```
<?php
session_start();
$visits = $_SESSION['visits'] ?? 0;
$_SESSION['visits'] = ++$visits;
echo "You have visited this page $visits times\n";
```
## Database Access
* Simple query
```
<?php
function getCustomers($conn) {
    // Build the query
    $query = "SELECT id, CONCAT(firstname, ' ', lastname) AS customer_name FROM customers ORDER BY firstname"; 
    $results = [];
    // Set the query
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) $results[] = $row;
    return $results;
}
$config = [
	'dsn' => '127.0.0.1',
	'username' => 'vagrant',
	'password' => 'vagrant',
	'database' => 'phpcourse'
];
$conn = mysqli_connect(
	$config['dsn'], 
	$config['username'], 
	$config['password'], 
	$config['database']);
foreach(getCustomers($conn) as $customer) {
    echo "{$customer['id']} {$customer['customer_name']}\n";
}
```
* Mysqli Security precautions
  * Use prepre / execute
  * See: https://www.php.net/manual/en/mysqli-stmt.execute.php

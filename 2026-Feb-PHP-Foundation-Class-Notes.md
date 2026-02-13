# Class Notes -- PHP Foundation -- Feb 2026
http://localhost:8881/#/5

# TODO
* Find a good example using `match` with multiple statements as a return value
  * https://github.com/dbierer/classic_php_examples/blob/master/basics/match_with_callbacks.php
* Provide examples of using cookies and sessions
  * https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php
  * https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php
* Class on OOP file handling -- in course yet or not?
  * https://training.zend.com/learn/courses/625/php-free-oop-file-handling

# Homework
Fri 13 Feb 2026
* Lab: Embedded PHP
* Lab: PHP Form String
* Lab: Secure Input Handling
* Lab: Escaping Exercise

Wed 11 Feb 2026
* Lab: Defining and Calling a Function
* Lab: Recursive Function Exercise
* Lab: HTML Select and Checkbox Functions
  * Optional Challenge: see if you can fit your new functions into the OrderApp
* Lab: F-Type Code Exercise
* Lab: Write Array Lab
* Lab: file_get_contents()
* Lab: file_put_contents()
* Lab: Read Directories
Fri 6 Feb 2026
* Lab: Array Key Value Access
* Lab: Array Last Value Access
* Lab: The Multi-Dimensional Array
* Lab: The Multi-Configuration Array
* Lab: First Program 
  * Put your code in `/home/vagrant/Zend/sandbox/public/PROGRAM_NAME.php`
  * Access from the VM browser using `http://sandbox/PROGRAM_NAME.php`
* Lab: Additional Crew Members
* Lab: Conditional If
* Lab: Conditional If-Else Equality
* Lab: Conditional If-Else Exclusive OR
* Lab: Conditional If-ElseIf
* Lab: Switch Construct
* Lab: Match Construct
* Lab: Foreach Loop
* Lab: For Loop
* Lab: While Loop
* Lab: Do...While Loop

# Notes
* Use `number_format()` to produce a specific number of decimal places
  * It also does rounding
  * Return value is a string
  * Accepts args for the "thousands" separator and the decimal separator
* Working example of `continue` in a `while ()` loop:
  * https://github.com/dbierer/filecms-core/blob/main/src/Common/Data/CsvBase.php
* Using `list()` can easily go overboard -- a simpler approach might be a better choice:
```
<?php 
$array = [1 => 2, 2 => 4, 'eight' => 8];

// Instead of this:
// list(1 => $oneInt, 2 => $twoInt, 'eight' => $threeInt) = $array;

// Use this instead:
$oneInt = $array[1];
$twoInt = $array[2];
$threeInt = $array['eight'];

echo $oneInt . PHP_EOL . $twoInt . PHP_EOL . $threeInt;
```
* Using `array_rand()` to extract random letters
````
<?php
$str = ''; 
$arr = range('A','Z');
for ($x = 0; $x < 12; $x++) {
	$str .= $arr[array_rand($arr)];
}
echo $str . PHP_EOL;
```
* Using `array_find()` and `array_all()`
```
<?php
$arr = [111 => 11.11, 222 => -22.22, 333 => 33.33];
if (array_all($arr, function ($val) { return $val > 0; })) {
    echo 'All amounts are above zero.';
} else {
    echo 'At least one amount is equal or below zero.' . PHP_EOL;
    echo array_find($arr, function ($val) { return $val < 0; }) . PHP_EOL;
}
```
* Example using `usort()` with an anonymous function:
```
<?php
$a = [3, 2, 5, 6, 1];
usort($a, function ($a, $b) { return ($a <=> $b); });
foreach ($a as $key => $value) {
    echo $key . ': ' . $value . PHP_EOL;
}
```
* Negative offsets in `substr()`
```
<?php
$fn = __DIR__ . '/';
echo $fn;		// /home/vagrant/Zend/sandbox/public/
echo PHP_EOL;
echo substr($fn, 0, -1);	// /home/vagrant/Zend/sandbox/public
echo PHP_EOL;

echo substr(basename(__FILE__), -3);	// php
echo PHP_EOL;
```
* Example of an arrow function:
```
<?php
$a = [3, 2, 5, 6, 1];
usort($a, fn($a, $b) => ($a <=> $b));
foreach ($a as $key => $value) {
    echo $key . ': ' . $value . PHP_EOL;
}
```
* Using `is_resource()` might be a problem in the future:
```
<?php
$fh = fopen(__DIR__ . '/index.php', 'r');
// using `is_resource()` may become problematic in the future
// i.e. if (is_resource($fh)) ...
// use `!empty($fh)` instead:
if (!empty($fh)) {
	echo 'File is open';
} else {
	echo 'Failed to open file';
}
fclose($fh);
```
* Reading a binary file
```
<?php
$fh = fopen(__DIR__ . '/avatars/avatar_01.png', 'rb');
// using `is_resource()` may become problematic in the future
// i.e. if (is_resource($fh)) ...
// use `!empty($fh)` instead:
header('Content-Type: image/png');
while (!feof($fh)) {
	echo fread($fh, 16048);
}
```
* Same as above except using `fpassthru()`
```
<?php
$fh = fopen(__DIR__ . '/avatars/avatar_01.png', 'rb');
// using `is_resource()` may become problematic in the future
// i.e. if (is_resource($fh)) ...
// use `!empty($fh)` instead:
header('Content-Type: image/png');
fpassthru($fh);
```
* Scraping a web page:
```
<?php
$html = file_get_contents('https://google.com');
$html = str_ireplace('Google', 'Boogle', $html);
echo $html;
```
* Dumping a PDF file to the browser:
```
<?php
$fn = __DIR__ . '/test.pdf';
header('Content-Type: application/pdf');
readfile($fn);
exit;
```
# Homework Modifications
* "F" file labs
```
<?php
// Starting Code
function htmlSelectHtml(array $data) : string {
	$html = '<select name="days">';
	foreach ($data as $value => $label) {
		$html .= "<option value=\"$value\">$label</option>\n";
	}
	return $html . '</select>';
}

function htmlCheckbox(array $data) : string {
	$html = '';
	foreach($data as $value => $label) {
		$html.= "<input type =\"checkbox\" name=\"os[]\" value=\"$value\" />$label\n";
	}
	return $html;
}
$config = [
  'days' => [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri'],
  'os' => ['W' => 'Windows', 'L' => 'Linux', 'M' => 'Mac'],
];
$dropdown = htmlSelectHtml($config['days']);
$checkbox = htmlCheckbox($config['os']);
echo "<form>$dropdown<br />$checkbox<br /><input type=\"submit\" /></form>";
phpinfo(INFO_VARIABLES);
```
* Next one
```
<?php
$filename = __DIR__ . '/1.txt';
$file = fopen ($filename, 'w');
if ($file === false) {
	die('cannot open file');
}
$content = 'Hello this is my first file write test.';
$bytesWritten = fwrite($file, $content);
if (empty($bytesWritten)) {
	die ('error');
}
echo 'Bytes written:' . $bytesWritten . PHP_EOL;
fclose($file);
```
* Write an array to a file
```
<?php
$filename = __DIR__ . '/array_data.txt';
$textArray = [
	'apple',
	'banana',
	'cherry',
	'dragonfruit'
];
file_put_contents($filename, implode(PHP_EOL, $textArray));
$file = fopen ($filename, 'r');
if ($file === false) {
	die ('error cannot open');
}
while (($line = fgets($file)) !== false) {
	$line = trim($line);
	if (strlen($line) >= 3) {
		echo $line[2] . PHP_EOL;
	} else {
		echo 'line too short' . PHP_EOL;
	}
}
fclose ($file);
```
* Lab: Read Directories Fri 6 Feb 2026 
```
<?php
$path = __DIR__;
$list = glob($path . '/*');
foreach ($list as $fn) {
	if (is_dir($fn)) continue;
	$name = $fn . "\t";
	$size = filesize($fn) . "\t";
	// Approach #1
	// $contents = file_get_contents($fn);
	// $count = 0;
	// str_replace(PHP_EOL, ' ', $contents, $count);
	// Approach #2
	$count = count(file($fn));
	printf('%50s | %6d | %d' . PHP_EOL, $name, $size, $count);
}
```
* Example of a form that adds a "GET" parameter along with any form POST submission:
```
<?php
$fn = basename(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Test</title>
<meta name="generator" content="Geany 2.0" />
</head>
<body>
<form action="<?= $fn ?>?something=nothing" method="post">
Name <input type="text" name="name" />
<br />
Email <input type="email" name="email" />
</br >
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
</body>
</html>
```
* Example of form handling:
```
<?php
$fn = basename(__FILE__);
if (!empty($_POST)) {
	$name = strip_tags(str_replace(';', ' ', $_POST['name'] ?? ''));
	$email = strip_tags($_POST['email'] ?? '');
	echo $name . ':' . $email;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Test</title>
<meta name="generator" content="Geany 2.0" />
</head>
<body>
<form action="<?= $fn ?>?something=nothing" method="post">
Name <input type="text" name="name" />
<br />
Email <input type="email" name="email" />
</br >
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
</body>
</html>
```
 
# Change Requests
http://localhost:8881/#/3/6 -- link problem
http://localhost:8881/#/4/52 -- why use "&" ???
http://localhost:8881/#/5/7 -- not working?

# PHP-I -- Sep 2020
# Class Notes

## TODO
* Example of loan amortization formula

## Q & A
* Q: How do you increase the memory allocation for a PHP program
* A: `ini_set('memory_limit', 'XXX'); // where "XXX" is some number + "M" or "G"`

## Class Discussion
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

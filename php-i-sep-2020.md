# PHP-I -- Sep 2020
# Class Notes

## Examples:
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

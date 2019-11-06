# PHP-I Class Notes

## HOMEWORK
* For Fri 8 Nov 2019
  * Lab: The Mixed Array 1
  * http://collabedit.com/sjtx8

## CLASS NOTES
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

// Output all elements
print_r($mission);
echo PHP_EOL;

// Build the crew: Approach #2
$mission = [
	'STS395' => [
		['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
		['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
		['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist']
	],
];

// Output all elements
print_r($mission);
```

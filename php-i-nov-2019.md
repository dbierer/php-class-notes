# PHP-I Class Notes

## CLASS NOTES
* https://www.php.net/manual/en/reserved.constants.php

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


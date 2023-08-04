# PHP Foundations -- Aug 2023

## TODO
* Last slide: http://localhost:8881/#/3
* Ask Nicole about adding recording to the LMS
* Instructions to add XAMPP php.exe to Windows system path:
  * https://mikesmith.us/add-xampps-php-execution-path-to-environment-variables-in-windows-10-11/
* XAMPP web server document root: `C:\xampp\htdocs`

## Homework
For Tues 8 Aug 2023
* https://collabedit.com/x6952

## Class Notes
How PHP actually works:
* https://www.zend.com/blog/exploring-new-php-jit-compiler

Pre-assigning default values that match the data type:
```
<?php
$a = '';	// string
$b = 0;		// int
$c = 0.0;	// float
$d = TRUE;	// bool

var_dump($a, $b, $c, $d);
```

Example using the modulus operator to determine remaining minutes:
```
<?php
$min = 795;
$hours = (int) ($min / 60);
$remain = $min % 60;
echo "$min is $hours hours and $remain minutes\n";

```
Determining the datatype at runtime
```
<?php
// use is_* functions to check the data type
$astronaut = ['Mark', 'Watney', 'Botanist'];
if (is_array($astronaut)) {
	print_r($astronaut);
} elseif (is_string($astronaut)) {
	echo $astronaut;
} else {
	echo 'Unknown';
}
// use gettype() to reveal the data type
echo gettype($astronaut);

```
Using the spread operator to flatten two sub-arrays
```
<?php
$business = ['Mon','Tue','Wed','Thu','Fri'];
$weekend  = ['Sat','Sun'];
$days     = [$business, $weekend];
var_dump($days);
// actual output:
/*
 * array(2) {
  [0]=>
  array(5) {
    [0]=>
    string(3) "Mon"
    [1]=>
    string(3) "Tue"
    [2]=>
    string(3) "Wed"
    [3]=>
    string(3) "Thu"
    [4]=>
    string(3) "Fri"
  }
  [1]=>
  array(2) {
    [0]=>
    string(3) "Sat"
    [1]=>
    string(3) "Sun"
  }
}
*/

// the spread op flattens the 2 sub-arrays into a single linear array
$days     = [...$business, ...$weekend];
var_dump($days);
// actual output:
/*
 * array(7) {
  [0]=>
  string(3) "Mon"
  [1]=>
  string(3) "Tue"
  [2]=>
  string(3) "Wed"
  [3]=>
  string(3) "Thu"
  [4]=>
  string(3) "Fri"
  [5]=>
  string(3) "Sat"
  [6]=>
  string(3) "Sun"
*/

```
Packing arguments
```
<?php
// example using ... to pack an array

function test(...$a)
{
	return array_sum($a);
}

echo test(1,2,3,4,5);
echo PHP_EOL;
echo test(6,7,8,8,10,11,12,13,14,15);
// output: 15
//         104


```
Adding elements to a multi-dimensional array
```
<?php
$mission = [
    'STS395' => [
        ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
        ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
        ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist 2'],s
        // here's how to add as part of the initial assignment
        ['firstName' => 'Fernanda', 'lastName' => 'Fernandes', 'specialty' => 'Computer Specialist 1'],
    ]
];

// here's how to add *after* the initial assignment
$mission['STS395'][] = ['firstName' => 'William', 'lastName' => 'Hodge', 'specialty' => 'Drupal Specialist'];

// here's how to make specific direct assignments
$mission['STS395'][5]['firstName'] = 'William';
$mission['STS395'][5]['lastName']  = 'Hodge';
$mission['STS395'][5]['specialty'] = 'Drupal Specialist';

// overwrite existing values
$mission['STS395'][2]['specialty'] = 'WordPress Specialist';

print_r($mission);

```

## Update/Upgrade the VM
* For now, avoid upgrading Ubuntu. Leave it at version 20.*
* Follow these instructions:
  * https://opensource.unlikelysource.com/expanded_vm_instructions.pdf
* Upgrade/update:
```
sudo dpkg --configure -a
sudo apt -y update && sudo apt -f -y install && sudo apt -y full-upgrade
```

* Apache reconfig:
```
sudo apt-add-repository ppa:ondrej/apache2
sudo apt install libapache2-mod-php8.2
sudo a2dismod php8.0
sudo systemctl restart apache2
sudo a2enmod php8.2
sudo systemctl restart apache2
```

## Resources
Automatic documentation generation
* https://phpdoc.org/
* It also has the formal definition of a "doc block"
Reserved constants:
* https://www.php.net/manual/en/reserved.constants.php

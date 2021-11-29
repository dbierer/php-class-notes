# PHP Fundamentals II - Dec 2021

## TODO
* Get vhost definition to sandbox in VM to use as a website

## Homework
* For 1 Dec 2021: http://collabedit.com/5qf73
Lab: Namespace
* Have a look at the OrderApp in the course VM.
* Identify the namespaces used
* How is autoloading initiated?
Lab: Create a Class
* Complete the following:
  * Create a class definition that represents or models something. Give it a constant, some properties, and a few methods. Set appropriate visibilities for each.
  * Instantiate a couple of objects, and execute the methods created producing some output.
  * Create something which is realistic and appropriate to a current or future application for your domain.
Lab: Create an Extensible Super Class
* Complete the following:
  * Using the code created in the previous exercise, create an extensible superclass definition. Set the properties and methods that subclasses will need.
  * Create one or more subclasses that extend the superclass with constants, properties and methods specific to the subclass.
  * Instantiate a couple of objects from the subclasses and execute the methods producing some output.

## Class Notes
Example of properties and constants with default assignments
  * https://github.com/dbierer/FileCMS/blob/main/src/Common/Image/SingleChar.php
Example of a simple class in a directory `A\X` filename `Xyz.php`
```
<?php
namespace A\X;
class Xyz
{
	public string $fname = '';
	public string $lname = '';
	public function getDate()
	{
		return date('Y-m-d');
	}
	public function getInfo()
	{
		$str = $this->getDate() . "\n";
		$str .= $this->fname . ' ' . $this->lname;
		return $str;
	}
}
```
Example of program file that uses the class
* Does not use an autoloader in this example as there's only 1 class and file
```
<?php
require_once __DIR__ . '/A/X/Xyz.php';
use A\X\Xyz;
$temp = new Xyz();
$temp->fname = 'Fred';
$temp->lname = 'Flintstone';
echo $temp->getInfo();
```

## Resources
Repo for this class:

Previous class repos:
* https://github.com/dbierer/php-ii-aug-2021
* https://github.com/dbierer/php-ii-mar-2021
* https://github.com/dbierer/php-ii-nov-2020


## Errata
* http://localhost:9999/#/2/15
  * `$this->firstname` s/be `$this->firstName`

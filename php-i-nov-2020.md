# PHP -I Nov 2020

## Homework
  * For Fri 6 Nov
    * Create a "Hello World" program such at you can see it as follows: `http://sandbox/hello_world.php`
      * Hint: use this: `echo 'Hello World';`
## VM Notes
* You can create sample program files in this path:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
```
* You can then run the scripts from a terminal window, or
  * From a browser: `http://sandbox/`
* The `sandbox` folder is mapped through the web server using this config file:
  * `/etc/apache2/sites-available`
```
     <VirtualHost *:80>
         ServerName sandbox
         DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
         <Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public/>
             Options Indexes FollowSymlinks MultiViews
             AllowOverride All
             Require all granted
         </Directory>
     </VirtualHost>
```
## Class Notes
* Excellent JavaScript library: https://jquery.com/
* Standings for web dev languages: https://w3techs.com/
* Web design tool: https://www.adobe.com/products/dreamweaver.html
* Pre-Defined Constants
  * Determined when PHP is installed on a server
  * See: https://www.php.net/manual/en/reserved.constants.php
* Great data source: https://www.geonames.org/
* If you need to confirm the data type, use one of the `is_*()` functions
  * Example: https://www.php.net/is_string
* Settings that control PHP's behavior: https://www.php.net/manual/en/ini.list.php

## Code Examples
* Simple data type assignments:
```
<?php
$a = 'This is a string';
$b = "This is a string with $a\n";
$c = PHP_INT_MAX;
$d = 123.456;
$e = TRUE;
$f = $c + 1;
var_dump($a, $b, $c, $d, $e, $f);
```
* Array assignments examples:
```
<?php
$names = ['Donald','Boris','Joe','Kamala'];
var_dump($names);

$db = [
	'db_user' => 'admin',
	'db_pwd'  => 'password',
	'db_name' => 'events',
	'db_host' => '192.168.3.16',
];

echo "The name of the database is {$db['db_name']}\n";
```
* Simple object example:
```
<?php
class Person {	
    public $firstname = 'Fred';
    public $lastname  = 'Flintstone';
    public function getFirstName() {
        return $this->firstname;
    }	
}
$person = new Person();
echo $person->getFirstName();
$person->firstname = 'George';
echo $person->getFirstName();
```
* Example of data type changing on the fly
```
<?php
$a = 12345;
// comes back as integer
var_dump($a);
$a = $a . ' is the current number';
// comes back as string
var_dump($a);
```
* Example of enforcing strict data types:
```
<?php
declare(strict_types=1);
class Test {
	public int $a = 12345;
}
$test = new Test();
// comes back as integer
var_dump($test->a);
$test->a = $test->a . ' is the current number';
// comes back as string
var_dump($test->a);
```
* Mixing PHP and HTML
```
<?php
$welcome = '<h1>Welcome</h1>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.32" />
</head>
<body>
<?= $welcome ?>
</body>
</html>
```
* Examples of type juggling
```
<?php
$a = 123;
$b = '456';
$c = $a + $b;
$d = $a . $b;
var_dump($a,$b,$c,$d);

$a = 123;
$b = (string) 456;
$c = $a + $b;
$d = $a . $b;
var_dump($a,$b,$c,$d);

$a = 123;
$b = 'xxx456';
$c = $a + $b;
$d = $a . $b;
var_dump($a,$b,$c,$d);
```
* Example of using type casting to enforce data type + add security
```
<?php
$id = $_GET['id'] ?? 0;
// you could also sanitize inputs using "strip_tags()"
$id = (int) $id;
echo "ID: $id";
```
* Increase memory allocation
```
<?php
// allocates 1 G of RAM for this script execution
ini_set('memory_limit', '1G');
```

# PHP-Exp Aug 2021

## Homework

## Class Notes
* Data types, max int size, etc.
```
<?php
class Test
{
	public int $neg = 0;
	public int $max = 0;
	public float $float = 0.0;
	public function getInfo()
	{
		$vars = get_object_vars($this);
		foreach ($vars as $key => $value)
			var_dump($this->$key);
	}
}
$test = new Test();
$test->getInfo();

$test->neg = -9999;
$test->max = PHP_INT_MAX; // max allowed size for an integer
$test->float = 99.99;
$test->getInfo();

// this results in an ERROR
var_dump(++$test->max);
```
* `php.ini` directives: https://www.php.net/manual/en/ini.list.php
* If you have a long-running, memory intensive program, use `ini_set()` to override these settings:
```
ini_set('memory_limit', '1G');
ini_set('max_execution_time', 30);	// 30 seconds
```
* Comments can be expressed as `Attributes` in PHP 8
  * Part of the language
  * Don't require extra effort to introspect
  * See: https://www.php.net/manual/en/language.attributes.syntax.php
* Assignments create copies except for objects which are by reference
```
<?php 
$a = new ArrayIterator(['A' => 111, 'B' => 222, 'C' =>333]);
// all object assignments are by reference
$b = $a;
$b->offsetSet('D', 444);
// $a now include offset 'D'
var_dump($a);

$c = ['A' => 111, 'B' => 222, 'C' =>333];
// all other types not by reference
$d = $c;
$d['D'] = 444;
// $c doesn't have 'D'
var_dump($c);
```
* Example of multi-dimensional array and de-referencing it
```
<?php
$books = [
	1 => [
		'title' => "Ender's Game",
		'publisher' => 'Tor',
		'author' => 'Orson Scott Card',
	],
	2 => [
		'title' => 'Tarzan of the Apes',
		'publisher' => 'Ballantine',
		'author' => 'Edgar Rice Burroughs',
	]
];

echo $books[2]['author'];
```
* Determining class type
```
<?php
$a = new ArrayIterator([1,2,3]);

echo ($a instanceof ArrayIterator) ? 'TRUE' : 'FALSE';
echo "\n";
echo (get_class($a) === 'ArrayIterator') ? 'TRUE' : 'FALSE';
echo "\n";

````
* Array "unpacking" using the splat operator
```
<?php
$foo = [1, 2, 3];
$bar = [4, 5, 6];	
$baz = [$foo, $bar];
print_r($baz);

$baz = array_merge($foo, $bar, [7,8,9]);
print_r($baz);

$baz = [...$foo, ...$bar, 7,8,9];
print_r($baz);
```
* Examples of constants
```
<?php
define('BASE_DIR', __DIR__);
const ABC = 'XYZ';
class Test
{
	const ABC = 'DEF';
	public function getDir()
	{
		return BASE_DIR;
	}
	public function getAbc()
	{
		return ABC . self::ABC;
	}
}

$test = new Test();
echo $test->getDir();
echo PHP_EOL;
echo $test->getAbc();
echo PHP_EOL;
```

## Resources
Previous class notes:
* https://github.com/dbierer/php-class-notes/blob/master/php-exp-jun-2021.md

## VM Setup
Download the source code.  From a terminal window in the VM:
```
cd ~/Zend/workspaces/DefaultWorkspace
wget https://opensource.unlikelysource.com/php-exp-src.zip
unzip php-exp-src.zip
```
Set up the `sandbox` as an Apache virtual host
```
sudo cp /etc/apache2/sites-available/orderapp.conf /etc/apache2/sites-available/sandbox.conf
```
Apache vhost definition:
```
<VirtualHost *:80>
	 ServerName sandbox
	 DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox
	 <Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/>
		 Options Indexes FollowSymlinks MultiViews
		 AllowOverride All
		 Require all granted
	 </Directory>
 </VirtualHost>
```
Enable the virtual host
```
sudo a2ensite sandbox.conf 
sudo service apache2 restart
```
Add an entry to the `/etc/hosts` for `sandbox`
```
sudo gedit /etc/hosts
127.0.0.1 sandbox
```


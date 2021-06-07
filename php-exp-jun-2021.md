# PHP-Exp Jun 2021

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

## Class Notes
Simple class example using PHP 8 `__construct()` syntax
```
<?php
class Person{
	public function __construct(
		public $firstname = '',
		public $lastname  = '')
	{}
	public function getFullName()
	{
		return $this->firstname . ' ' . $this->lastname;
	}
}
$person = new Person('Fred', 'Flintstone');
echo $person->getFullName();
echo "\n";
$person->firstname = 'Betty';
echo $person->getFullName();
```
Example of Class Property strict types
* Available in PHP 7.4 and above:
```
<?php
declare(strict_types=1);
class Person{
	public int $status = 0;
	public string $firstname = '';
	public string $lastname  = '';
	public function __construct(
		int $status, 
		string $firstname = '',
		public string $lastname  = '')
	{
		$this->status = $status;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
	}
	public function getFullName()
	{
		return $this->firstname . ' ' . $this->lastname;
	}
}
$person = new Person('Fred', 'Flintstone');
echo $person->getFullName();
echo "\n";
$person->firstname = 'Betty';
// NOTE: this generates a Fatal Error
$person->status = '1';
echo $person->getFullName();
```
Example mixing PHP and HTML
```
<?php
$amount = 99.99;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>untitled</title>
<meta name="generator" content="Geany 1.36" />
</head>
<body>
Amount Is: <?= $amount ?>
</body>
</html>
```
Example of "pure" PHP that generates HTML
```
<?php
$amount = 99.99;
echo '<!DOCTYPE html><html><head><title>Test</title></head><body>';
echo "Amount is: $amount";
echo '</body></head></html>';
```
Example of type coercion
```
<?php
$a = 123;
$b = 'This value is: ' . $a;
var_dump($a, $b);
```
Forcing the data type is a good way to sanitize data + allow numerics ops to continue
```
<?php
// Assignment
$foo = '<script>you been hacked</script>99';
$foo = (int) $foo; 
// Output response
echo 5 + $foo;
```
Force garbage collection to free memory in long-running programs
```
https://www.php.net/gc_collect_cycles
```
To increase the amount of memory available for a given program run
```
https://www.php.net/ini-set
ini_set('memory_limit', '1G');
```
List of `php.ini` file settings: https://www.php.net/manual/en/ini.core.php

Use PHP 8 `Attributes` in place of `doc blocks` to improve performance
* https://www.php.net/manual/en/language.attributes.syntax.php
* Not available in PHP 7 or below!


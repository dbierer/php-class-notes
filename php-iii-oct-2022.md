# PHP III - Oct 2022

## TODO
* Example of where Interfaces are used as type hints instead of classes

## Homework
For Thu 12 Oct 2022
* VM Setup (update/upgrade + phpMyAdmin)
  * phpMyAdmin: use the directions below
* JMeter Setup
* Jenkins Setup

## VM Update
* After the VM first comes up, if you're not prompted to update, reboot the VM
* After reboot: Select yes to "Update System Software" if you're prompted
* Open a terminal window
* Upgrade everything:
```
sudo apt -y upgrade
```
  * If asked to retain the database configuration select "OK"
NOTE: this could take some time!
### Install phpMyAdmin

Download the latest version from https://www.phpmyadmin.net
Make note of the version number (e.g. 5.2.0)
* From a terminal window:
```
cd /tmp
set VER=5.2.0
mv Downloads/phpMyAdmin-$VER-all-languages.zip .
unzip Downloads/phpMyAdmin-$VER-all-languages.zip
sudo cp -r phpMyAdmin-$VER-all-languages/* /usr/share/phpmyadmin
sudo cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php
```
Create the "blowfish secret"
```
sudo -i
export SECRET=`php -r "echo md5(date('Y-m-d-H-i-s') . rand(1000,9999));"`
echo "\$cfg['blowfish_secret']='$SECRET';" >> /usr/share/phpmyadmin/config.inc.php
exit
```
Set permissions
```
sudo chown -R www-data /usr/share/phpmyadmin
```

## Interfaces
### Traversable 
`Traversable` connects the old approach (`Iterator`) with a newer approach (`IteratorAggregate`)
```
<?php
class Test implements IteratorAggregate
{
	protected $name = 'Doug';
	protected $country = 'Thailand';
	protected $language = 'EN';
	public function getIterator()
	{
		return new ArrayIterator(get_object_vars($this));
	}
}

$test = new Test();
foreach($test as $key => $value) echo $key . ':' . $value . PHP_EOL;
```
### Stringable (new in PHP 8)
Anytime you implement `__toString()`
``
<?php
class Test
{
	protected $name = 'Doug';
	protected $country = 'Thailand';
	protected $language = 'EN';
	public function __toString()
	{
		return var_export(get_object_vars($this), TRUE);
	}
}

$test = new Test();
echo $test;
echo PHP_EOL;
$reflect = new ReflectionObject($test);
echo $reflect;
echo PHP_EOL;

// output
/*
 * Object of class [ <user> class Test implements Stringable ] {
  @@ C:\Users\azure\Desktop\test.php 2-11

  - Constants [0] {
  } 
  ...
*/
```
### ArrayAccess Interface
It's treated just like an array
```
<?php
$user = [
	'user' => 'joe',
	'email'  => 'joe@company.com',
	'address' => '123 Main Street',
	'city' => 'Utrecht',
	'country' => 'NL',
];

$user = new ArrayObject($user);
$user['status'] = 'OK';

echo 'Name  :' . $user['user'] . PHP_EOL;
echo 'Email :' . $user['email'] . PHP_EOL;
echo 'City  :' . $user['city'] . PHP_EOL;
echo 'Status:' . $user['status'] . PHP_EOL;
```

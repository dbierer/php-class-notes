# PHP Fundamentals II - Dec 2021

## Homework
* For 3 Dec 2021: http://collabedit.com/awsnh
Lab: Magic Methods
Complete the following:

Using the code from the previous exercises, add four magic methods, one of which is the magic constructor.
The magic constructor should accepts parameters and set those parameters into the object on instantiation.
Create an index.php file.
Load, or autoload, the created classes.
Instantiate object instances, and exercise the magic methods implemented.
Lab complete.


Lab: Abstract Classes
Complete the following:

Turn a superclass into an abstract class.
In the abstract superclass, define an inheritable abstract method declaration that will instantiate an object of another class, and returns it.
Extend the abstract superclass with a concrete subclass implementing the inherited abstract method.
Instantiate a subclass instance.
Call the method and retrieve the object it builds.
Lab is complete.


* For 1 Dec 2021: http://collabedit.com/5qf73

## TODO
Get example of using `__call()` to implement a "plugin" architecture
Get example from WP-CLI using `__invoke()` + other examples if available

## Class Notes
Get vhost (virtual host) definition to sandbox in VM to use as a website
* From a terminal window (command prompt):
  * Run `gedit` as the root user:
```
sudo gedit
```
  * Open the file `/etc/hosts`
  * Add an entry to the local hosts file to simulate a server named "sandbox"
```
127.0.0.1 sandbox
```
  * Save the file
  * Open a new file (press the "+" icon next to "Open")
  * Paste this into the editor:
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
  * Save as `/etc/apache2/sites-available/sandbox.conf`
  * Exit `gedit`
  * Test the new simulated server
```
ping -c3 sandbox
```
  * Enable the new vhost
```
sudo a2ensite sandbox
```
  * Restart Apache
```
sudo service apache2 restart
```
  * Access `sandbox` from the VM browser: `http://sandbox`

* Example of properties and constants with default assignments
  * https://github.com/dbierer/FileCMS/blob/main/src/Common/Image/SingleChar.php
* Example of a simple class in a directory `A\X` filename `Xyz.php`
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
* Example of program file that uses the class
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
* Example of an anonymous class: https://github.com/dbierer/FileCMS/blob/main/src/Common/Page/Edit.php
* Example of a "universal" class with unlimited properties
```
<?php

class Universal {
	protected array $whatever = [];
    public function __set($prop, $value)
    {
		$this->whatever[$prop ] = $value;
    }
    public function __get($prop)
    {
		return $this->whatever[$prop ] ?? '';
    }
}

$uni = new Universal();
$uni->firstName = 'Fred';
$uni->lastName = 'Flintstone';
echo $uni->firstName . ' ' . $uni->lastName;
var_dump($uni);
```
* Unlimited getters and setters: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_call_unlimited_getters_setters.php
* Example of interfaces, abstract class, and two variant child classes
```
<?php
interface EncryptInterface
{
	public function encrypt() : string;
}
interface DecryptInterface
{
	public function decrypt(string $text) : string;
}
abstract class Security implements EncryptInterface, DecryptInterface
{
	const SUPPORTED_ALGOS = ['reverse','openssl'];
	public function __construct(
		public string $text,
		public string $algo)
	{}
}
class Reverse extends Security
{
	public function encrypt() : string
	{
		return strrev($this->text);
	}
	public function decrypt(string $text) : string
	{
		return strrev($text);
	}
}
class OpenSsl extends Security
{
	public function encrypt() : string
	{
		return openssl_encrypt($this->text);
	}
	public function decrypt(string $text) : string
	{
		return openssl_decrypt($text);
	}
}
$security = new Reverse('The quick brown fox jumped over the fence', 'reverse');
$encrypted = $security->encrypt();
echo $security->decrypt($encrypted);

```
## Resources
Previous class repos:
* https://github.com/dbierer/php-ii-aug-2021
* https://github.com/dbierer/php-ii-mar-2021
* https://github.com/dbierer/php-ii-nov-2020


## Errata
* http://localhost:9999/#/2/15: "Class Property"
  * `$this->firstname` s/be `$this->firstName`
* http://localhost:9999/#/2/45: "Final Declaration"
  * Should appear as follows:
```
class GuestUser extends UserEntity {
    // **** NOT ALLOWED!!! **** //
    public function setFirstName($firstName, $mi = null) {
        $this->firstname = ($mi) ? $firstName . ' ' . $mi : $firstName;
    }
}
```

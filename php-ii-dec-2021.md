# PHP Fundamentals II - Dec 2021

## VM
To get rid of the message "System Problem Detected"
```
sudo rm /var/crash/*
```
To install Composer: have a look here: https://getcomposer.org

## Homework
* For 6 Dec 2021: http://collabedit.com/p8ram
ALSO: please look over course module 3: OrderApp
Lab: Type Hinting
Complete the following:

Create a new class with some properties and methods.
Add a constructor.
Type hint in the constructor for the interface created in the last exercise.
Instantiate an object from one of your previous subclasses.
Add it as a dependent object to the new object created in step one, and store it.
Lab is complete.

Lab: Build Custom Exception Class
Complete the following:

Create a file and build a custom exception class with a constructor that accepts parameters.
Call the parent Exception constructor.
Add some new functionality in the custom exception constructor.
Add a try/catch/catch/finally block set.
In the try portion, throw an instance of the Exceptions object, and an instance of the custom exception class.
Handle both by logging in the associated catch blocks.
Echo something in the finally block.
Lab is complete.

Lab: Traits
Complete the following:

In separate files, create two traits, each with two methods, one of the methods named the same in both traits.
In another file, create a class that uses the two traits.
Resolve the naming collision, and change the method visibilities.
Instantiate an instance of the class and execute the trait methods.
This lab is complete.

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

## Q & A
Get example of using `__call()` to implement a "plugin" architecture
* https://github.com/laminas/laminas-mvc/blob/master/src/Controller/AbstractController.php
  * Look for `Laminas\Mvc\Controller\AbstractController::__call()`
  * S/be around line 277
* Example of using `__call()` in the `Laravel Illuminate\Broadcasting\BroadcastManager` class to call the default driver:
  * See: https://github.com/laravel/framework/blob/master/src/Illuminate/Broadcasting/BroadcastManager.php
  * On line 379 note the use of `__call()` to call the default driver instance
Get example from WP-CLI using `__invoke()` + other examples if available
* See: https://make.wordpress.org/cli/handbook/guides/commands-cookbook/#required-registration-arguments
* https://github.com/dbierer/php-ii-aug-2021/blob/main/callable_examples.php
* Have a look at the classes shown here: https://github.com/dbierer/FileCMS/tree/main/src/Transform
  * This set of classes is used by the `Transform` class here: https://github.com/dbierer/FileCMS/tree/main/src/Common/Transform

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
* Discussion on late static binding: https://www.php.net/manual/en/language.oop5.late-static-bindings.php
* Example of polymorphism
```
<?php
interface T
{
	const WHATEVER = 'whatever';
	public function getName() : string;
}
class A implements T
{
	public string $name = 'TEST';
	public function getName() : string
	{
		return $this->name;
	}
}
class B extends A
{
	public string $status = 'OK';
}
class C extends B
{
	public float $amount = 99.99;
}
class X implements T
{
	public string $xyz = 'XYZ';
	public function getName() : string
	{
		return $this->xyz;
	}
}

function test(T $a)
{
	echo $a->getName() . "\n";
}

$a = new A();
test($a);

$b= new B();
test($b);

$c = new C();
test($c);

$x = new X();
test($x);

// output:
/*
TEST
TEST
TEST
XYZ


------------------
(program exited with code: 0)
 */
```
* Example of trait usage in a Laminas component: matching trait + interface combination:
  * https://github.com/laminas/laminas-eventmanager/blob/master/src/EventManagerAwareInterface.php
  * https://github.com/laminas/laminas-eventmanager/blob/master/src/EventManagerAwareTrait.php

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

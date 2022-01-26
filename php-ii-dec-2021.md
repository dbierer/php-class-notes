# PHP Fundamentals II - Dec 2021

## TODO
Example of `preg_replace_callback_array()`
* Code converter: Converts PHP 5 to PHP 7
* https://github.com/dbierer/php7cookbook/blob/master/source/Application/Parse/Convert.php

## Homework
* For 10 Dec 2021
Lab: Prepared Statements
```
Complete the following:

Create a prepared statement script.
Add a try/catch construct.
Add a new customer record binding the customer parameters.
```

Lab: Stored Procedure
```
Complete the following:

Create a stored procedure script.
Add the SQL to the database.
Call the stored procedure with parameters.
```

Lab: Transaction
```
Complete the following:

Create a transaction script.
Execute two SQL statements.
Handle any exceptions.
```

Lab: Validate an Email Address
```
Use preg_match() to validate an email address
```

* For 6 Dec 2021: http://collabedit.com/p8ram
* For 3 Dec 2021: http://collabedit.com/awsnh
* For 1 Dec 2021: http://collabedit.com/5qf73

## VM
To get rid of the message "System Problem Detected"
```
sudo rm /var/crash/*
```
To install Composer: have a look here: https://getcomposer.org

Instructions to update phpMyAdmin in the VM???
* In the VM, open a terminal window and do this:
```
// NOTE: work in progress
cd \tmp
wget https://files.phpmyadmin.net/phpMyAdmin/5.1.1/phpMyAdmin-5.1.1-all-languages.zip
sudo unzip phpMyAdmin-5.1.1-all-languages.zip -d /usr/share
sudo mv /usr/share/phpMyAdmin-5.1.1-all-languages /usr/share/phpmyadmin
```

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
* Example of building an SQL statement from a User entity instance
  * Assumes you have created a method `getArrayCopy()`
```
<?php
$sql = 'Insert into User (firstName, lastName, phoneNumber, gender) values (';
foreach ($userDetails->getArrayCopy() as $value) $sql .= "'" . $value . "',";
$sql = substr($sql, 0, -1);
$sql .= ');';
```
* Same example as above, but using prepared statements
```
<?php
$sql = 'Insert into User (firstName, lastName, phoneNumber, gender) values (?,?,?,?)';
$stmt = $this->pdo->prepare($sql);
$result = $stmt->execute($userDetails->getArrayCopy());
```
* Example from Marc's codebase
```
<?php
namespace MX\Models\DB;
use PDO;
use PDOException;
use Throwable;
class DB
{
	public string $servername;
	public string $username;
	public string $password;
	public string $dbname;
	// this needs to be supplied by the calling program
	public function dbConnection(array $config)
	{
		$servername = $config['servername'];
		$username = $config['username'];
		$password = $config['password'];
		$dbname = $config['dbname'];
		$dsn = 'mysql:host=localhost;dbname=' . $dbname;
		try {
		    $conn = new PDO($dsn, $username, $password);\
		    // for PHP 7.4 only:
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Throwable $t) {
		   error_log($t->getMessage());
		   $conn = FALSE;
		}
		return $conn;
	}
}
```
* Using the PDO instance (`$conn`)
```
// from UserController
    public function DisplayUsers(array $config)
    {
	      $db = new DB($config);
	      $db = $db->dbConnection();
	      $sql = "SELECT * FROM users";
	      $result = $conn->query($sql);
	      return $result;	// this will be a PDOStatement instance
    }
```
* Display the results
```
<!-- comes from UserController::displayUsers() -->
<?php while($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
<!-- display the results from the array -->
<?php endwhile;?>
```
REST Examples
* Using CURL: https://github.com/dbierer/classic_php_examples/blob/master/web/curl.php
Output Escaping:
```
<?php
$data = '<script>alert("test");</script>The Rest of the Data';
echo htmlspecialchars($data);

// output:
// &lt;script&gt;alert(&quot;test&quot;);&lt;/script&gt;The Rest of the Data
```


## Resources
Previous class repos:
* https://github.com/dbierer/php-ii-aug-2021
* https://github.com/dbierer/php-ii-mar-2021
* https://github.com/dbierer/php-ii-nov-2020
Testing: https://phpunit.de
Documentation: https://phpdoc.org
Attributes: https://www.php.net/manual/en/language.attributes.syntax.php

Web services examples:
* https://github.com/dbierer/classic_php_examples/tree/master/web
Alternative WP installation using Composer:
* https://wpackagist.org/
* NOTE: you can start with a core WP installation using "Bedrock"
Some notes on JSON
```
<?php
class Test
{
	public string $name = 'Fred';
	protected int $status = 123;
	public function getStatus()
	{
		return $this->status;
	}
}

$test = new Test();
echo $test->getStatus() . "\n";
var_dump($test);

// problem #1: can't access non-public properties
$json = json_encode($test, JSON_PRETTY_PRINT);
echo $json . "\n";

// problem #2: the original object class is not restored
$obj = json_decode($json);
var_dump($obj);
```
SOAP vs. REST: https://www.ateam-oracle.com/post/performance-study-rest-vs-soap-for-mobile-applications

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
* http://localhost:9999/#/4/41: "Stored Procedure: Loading"
  * s/be `DefaultWorkspace/php2/src/ModDB/*`
* http://localhost:9999/#/6/5: "Positioning"
  * s/b `\Z` : Absolute end
* http://localhost:9999/#/6/10: "Custom Character Classes"
  * Duplicates previous slide
* http://localhost:9999/#/6/12: "Quantifiers"
  * Last regex should be:
    * `/http(s)?:\/\/\w*/`
    * `!http(s)?://\w*!`
* http://localhost:9999/#/6/13: "Precision Quantifiers"
  * Last example s/be: `/([A-Z]\d[A-Z] \d[A-Z]\d)|([A-Z]{1,2}\d{1,2} \d{1,2}[A-Z]{2})/i`
* http://localhost:9999/#/8/12
  * S/b: `Laminas\Http\Client`
* http://localhost:9999/#/8/22
  * Laminas API Tools
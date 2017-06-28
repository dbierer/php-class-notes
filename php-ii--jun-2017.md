----------------------------------------------------------------------------------------------------------------------------
# PHP II Class Notes -- June 2017
----------------------------------------------------------------------------------------------------------------------------

## ERRATA
* p.  78: Fatal error when code is run; changed type-hint from "integer" to "int"
* p. 148: DML and DDL are mixed
* p. 162: "lastInsertId()" s/be off $pdo
* p. 251: when making an XML request, change the $url to "xxx/api/geocode/xml" instead of "json"
NOTE: page references are from "slides.pdf"

----------------------------------------------------------------------------------------------------------------------------
## Q & A
----------------------------------------------------------------------------------------------------------------------------

* Q: How can I get the Apigility demo to work on the VM?
* A: You need to install the php zip extension
```
sudo apt-get install php7.1-zip
```

* Q: from Carl to All Participants:	react has made react.native. is php going to have anything like that?
* A: Zend has an initiative which shows how to develop mobile apps which access a PHP app:
   See: [http://www.zend.com/en/products/zendonthego](http://www.zend.com/en/products/zendonthego)
   Generates mobile javascript code from PHP: [https://www.kikapptools.com/](https://www.kikapptools.com/) 
   Scripting layer for Android lets you run PHP directly on Android devices: [https://github.com/damonkohler/sl4a](https://github.com/damonkohler/sl4a)
   Mobile App development using Zend Studio: [https://www.sitepoint.com/mobile-app-development-zend-studio/](https://www.sitepoint.com/mobile-app-development-zend-studio/)
   Create mobile app using Laravel: [http://softeng.oicr.on.ca/brice_aminou/2017/03/07/Mobile-app-with-Laravel/](http://softeng.oicr.on.ca/brice_aminou/2017/03/07/Mobile-app-with-Laravel/)

* Q: from James to All Participants: noticed in PHPMailer some of the files had '.phps' extensions....  .php vs .phps?
* A: "phps" is not an "officially" recognized PHP extension (although you could set up an apache directive to treat it as PHP).
   It's basically used to trick the web server into just displaying the source code and not handing it off to the PHP engine.
   See: [https://stackoverflow.com/questions/41689479/what-is-the-file-extension-phps-and-what-is-it-used-for](https://stackoverflow.com/questions/41689479/what-is-the-file-extension-phps-and-what-is-it-used-for)
   Other "recognized" PHP extensions: php, phtml, php3, php4, php5
   
----------------------------------------------------------------------------------------------------------------------------
## Mon 5 Jun 2017
[http://collabedit.com/4u8he](http://collabedit.com/4u8he)
----------------------------------------------------------------------------------------------------------------------------

```
// amanda

Create a Class Exercise
Create a class definition that represents something. Give it a constant and a few properties and methods. Set appropriate visibilities for each.
Instantiate a couple of objects and execute the methods created producing some output.
Create something which is realistic and appropriate to a current or future application

// code goes here:
<?php
class HTML5Template
{
    const BLING = 'Blingin Baubles';
    private $titleTag = '';
    //Set the value of the HTML title tag
    public function setTitleTag($titleTag)
    {
        $this->titleTag = $titleTag.BLING;
        return $this;
    }
    
    //Get the value of the HTML title tag
    public function getTitleTag()
    {
        if ((is_null($this->titleTag)) || (strlen($this->titleTag) == 0))
        {
            return 'Welcome to'.BLING;
        }
        else
        {
            return $this->titleTag;
        }
    }
    
    public function __construct($titleTag = NULL)
    {
        if (empty($titleTag))
        {
            $this->titleTag = 'Welcome';
        }
        else {
            $this->titleTag = $titleTag;
        }
        
    }
    //Build and return the page header
    public function renderHeader()
    {
        $header  = '<!DOCTYPE html>';
        $header .= '<html>';
        $header .= '<head>';
        $header .= '<meta charset="UTF-8">';
        $header .= '<title>' . $this->getTitleTag() . '</title>';
        $header .= '</head>';
        return $header;
    }
    
}

$newTemplate = new HTML5Template('Hello There');
echo $newTemplate->renderHeader();

// ***** END *****

// eddie

Create an Extensible Super Class Exercise
Using the code created in the previous exercise, create an extensible superclass definition. Set the properties and methods that subclasses will need.
Create one or more subclasses that extend the superclass with constants, properties and methods specific to the subclass
Instantiate a couple of objects from the subclasses and execute the methods producing some output.

// code goes here:
<?php

<?php 
class Base
{
    
    public $wheels ;
    public $engine;
    public $doors;
    public function __construct($wheels, $doors, $engine)
    {
        $this->wheels = $wheels;
        $this->engine = $engine;
        $this->doors = $doors;
    }

    public function getType()
    {
        return $this->type;
    }
    
    public function getWheels() 
    {
        
        return $this->wheels;
        
    }
    
    public function getDoors() 
    {
        
        return $this->doors;
        
    }
    
    public function getEngine() 
    {
        
        return $this->engine;
        
    }
    
    
}

class Plane extends Base
{
    public $wings;
    public function __construct($wheels, $doors, $engine, $wings)
    {
        parent::__construct($wheels, $doors, $engine);
        $this->wings = $wings;
    }
    public function getWings()
    {
        return $this->wings;
    }
}

$vehicle['plane'] = new Plane(10, 2, 2, 2);
$vehicle['truck'] = new Base(8, 2, 1);
$vehicle['motorcycle'] = new Base(2, 0, 1);

echo '<pre>';
var_dump($vehicle);
echo '</pre>';

// ***** END *****
```

----------------------------------------------------------------------------------------------------------------------------
## Wed 7 Jun 2017
[http://collabedit.com/m823g](http://collabedit.com/m823g)
----------------------------------------------------------------------------------------------------------------------------

* Example of abstract class w/ methods which are optional
[https://github.com/zendframework/zend-mvc/blob/master/src/Controller/AbstractRestfulController.php](https://github.com/zendframework/zend-mvc/blob/master/src/Controller/AbstractRestfulController.php)
* Look at AbstractRestfulController::delete()

* You could mark ```isValid()``` method as abstract, which forces the developer to implement it
[https://github.com/zendframework/zend-validator/blob/master/src/AbstractValidator.php](https://github.com/zendframework/zend-validator/blob/master/src/AbstractValidator.php)

```
// carl

Magic Methods Exercise
Using the code from the previous exercises, add four magic methods.
Add a magic constructor that accepts parameters and set those parameters into the class on instantiation.
Create an index.php file, load the classes, create subclass object instances and execute method calls to the subclass objects.

// BEGIN CODE --------------------------

//I have built classes to process employee PTO (Paid Time Off) request.
/*index.php********************************************************************************************************/

include 'PTO.php';
include 'PtoRequest.php';
$request = ['days'=>'6-10,6-11', 'hours' => 4];
$ptoRequest = new PtoRequest(67413, $request);
$ptoRequest->evaluateRequest();
echo $ptoRequest->message;

$ptoRequest->reason = 'vacation';
if (isset($ptoRequest->department)) {

}
unset ($ptoRequest->company);

printR($ptoRequest);

function printR($val) {
    print '<pre>';
    print_r($val);
    print '</pre>';
}

/*PtoRequest.php****************************************************************************************************/

<?php
class PtoRequest extends PTO
{
    public $request;
    public $approved;
    public $message;
    public $extraData;
    
    public function __construct($employee, $request)
    {
        parent::__construct($employee);
        $this->request = $request;
    }
    
    public function __set($name, $value)
    {
        echo __METHOD__;
        $this->extraData[$name] = $value;
    }
    
    public function __get($name)
    {
        echo __METHOD__;
        return $this->extraData[$name] ?? '';
    }
    
   public function __isset($name)
    {
        echo __METHOD__;
        return isset($this->extraData[$name]);
    }
    
    public function __unset($name)
    {
        echo __METHOD__;
        unset($this->extraData[$name]);
    }
    
    public function evaluateRequest()
    {
        if ($this->request['hours'] <= $this->available) {
            $this->approved = TRUE;
            $this->processApprovedRequest();
            $this->message = "Your request to use {$this->request['hours']} hours is approved.";
        } else {
            $this->approved = FALSE;
            $this->message = "Sorry, you have requested to use {$this->request['hours']} hours but only have {$this->available} remaining. Request Denied.";
        }
    }
    
    private function processApprovedRequest() : void
    {
        if ($this->approved) {
            $this->used += $this->request['hours'];
            $this->available -= $this->request['hours'];
        }
    }
    
}

interface Queue
{
}

/*PTO.php*************************************************************************************************************/

class PTO
{
    const BLACKOUT_DAYS = ['11-28', '12-24', '12-26'];
    public $employee;
    public $allowed;
    public $used;
    public $available;
    public $manager;

    public function __construct($employee)
    {
        $this->employee= $employee;
        $this->getPtoNumbers($employee);

    }

    public function getPtoNumbers($employee)
    {
        //would pull data from database
        $this->allowed = 60;
        $this->used = 53;
        $this->available = 7;
    }

}

// END CODE --------------------------

// eleanor

Abstract Class Exercise
Turn your superclass into an abstract class.
Add a static property and method that builds another object.
Call the static method and retrieve the object it builds.

Example: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_singleton_getinstance_example.php

// BEGIN CODE --------------------------

See: https://github.com/zendframework/zend-validator/blob/master/src/AbstractValidator.php
See: https://github.com/zendframework/zend-validator/blob/master/src/ValidatorInterface.php
See: https://github.com/zendframework/zend-validator/blob/master/src/EmailAddress.php

// END CODE --------------------------

// james

Interface Exercise
Create an object interface with two methods.
Implement the interface in your superclass.
Add some code to the index.php file that calls one of the superclass methods implemented.

// BEGIN CODE --------------------------

// a lightweight queue

// Queue.php
interface Queue {    
    public function addJob($job); // add a job at the END of the queue
    public function delJob(); // delete a job at the START of the queue
    public function jobCount(); // get a current count of jobs in queue
}

// TodoQueue.php
require_once('Queue.php');

class TodoQueue implements Queue 
{
    
    private $stack = array();

    // add jobs to the end of the queue only
    public function addJob($job)
    {
        array_push($this->stack, $job);
        return $this->stack;
    }

    // remove jobs from the beginning of the queue only
    public function delJob()
    {
        array_shift($this->stack);
        return $this->stack; //return the updated queue
    }

    public function jobCount()
    {
        return count($this->stack);
    }    
}

// fridayHW.php
require_once 'TodoQueue.php';

$myQueue = new TodoQueue;

echo 'Current queue size: ' . $myQueue->jobCount() . PHP_EOL;

print_r($myQueue->addJob("do PHP homework"));
print_r($myQueue->addJob("cut the grass"));
print_r($myQueue->addJob("push website to production"));

echo 'Current queue size: ' . $myQueue->jobCount() . PHP_EOL;

print_r($myQueue->delJob());

echo 'Current queue size: ' . $myQueue->jobCount() . PHP_EOL;
// END CODE --------------------------
```


* NOTE: there is a built-in queue class in the SPL which you can use as well
see: [http://php.net/manual/en/class.splqueue.php](http://php.net/manual/en/class.splqueue.php)

----------------------------------------------------------------------------------------------------------------------------
## Fri 9 Jun 2017
[http://collabedit.com/a7cwq](http://collabedit.com/a7cwq)
----------------------------------------------------------------------------------------------------------------------------

* example of trait + interface
https://github.com/zendframework/zend-eventmanager/blob/master/src/EventManagerAwareInterface.php
https://github.com/zendframework/zend-eventmanager/blob/master/src/EventManagerAwareTrait.php

* very very simple autoloader: goes in index.php
```
function __autoload($class)
{
    require_once __DIR__ . '/' . $class . '.php';
}
```
* autoloader which uses namespacing
```
function __autoload($class)
{
    $baseDir = realpath(__DIR__ . '/..');
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once $baseDir . DIRECTORY_SEPARATOR . $filename;
}
```

* modified index.php:
```
use PTO\Request\PtoRequest as Req;
$request = ['days'=>'6-10,6-11', 'hours' => 4];
$ptoRequest = new Req(67413, $request);
```

* modified PTO and PtoRequest
```
<?php
namespace PTO;
class PTO
{
    const BLACKOUT_DAYS = ['11-28', '12-24', '12-26'];
    public $employee;
// etc.
```

* PtoRequest:
```
<?php
namespace PTO\Request;
use PTO\PTO;
class PtoRequest extends PTO
{
    public $request;
    public $approved;
// etc.
```

* clone example
```
<?php
$today = new DateTime('now');
$next  = clone $today;
$next->add(new DateInterval('P90D'));
echo $today->format('l, d M Y');
echo PHP_EOL;
echo $next->format('l, d M Y');
echo PHP_EOL;
var_dump($today, $next);
```


```
// steve

Type Hint Exercise
Create a new class with some properties and methods.
Add a constructor.
Type hint in the constructor for the interface created in the last exercise.
Instantiate an object from one of your previous subclasses.
Add it as a dependent object to the new object created in step one, and store it.

//  BEGIN -------------------------------------------------------------------------
/* 
This is type-hinted user creation and admin creation. 
*/

// index.php
<?php
//I have built classes to process employee PTO (Paid Time Off) request.
/*index.php********************************************************************************************************/

function __autoload($class)
{
    $baseDir = realpath(__DIR__);
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once $baseDir . DIRECTORY_SEPARATOR . $filename;
}
//we hire clark kent
$user = new ActiveUser("Clark","Kent");
// we promote clark kent
$editor = new AdminRole($user,1,"Perry White","Metahuman Affairs");
var_dump($editor);

<?php

class ActiveUser
{
    
    protected $firstName;
    protected $lastName;
    protected $dateCreated;
    
    function __construct (string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateCreated = new DateTime('now');
    }
    
    public function buildName($firstName, $lastName)
    {
        return (trim($this->firstName) . trim($this->lastName));
    }
    
    public function getDateCreated()
    {
        return $this->dateCreated->format('l, d M Y');
    }
}

<?php
declare(strict_types=1);
class AdminRole
{
    
    private const EDITOR = '1';
    private const ADMIN = '2';
    public $admin;
    protected $role;
    protected $manager;
    protected $dept;
    
    public function __construct(ActiveUser $user, int $role = 0, string $manager, string $dept)
    {
        $this->admin = $user;
        $this->setRole($role);
        $this->setManager($manager);
        $this->setDept($dept);
    }
    
    public function isAuthorized()
    {
        if($this->role == AdminRole::EDITOR || $this->role == self::ADMIN) {
            return true;
        } else {
            return false;
        }
    }
    
    public function setRole($role)
    {
        $this->role = $role;
    }
    
    public function setManager($manager)
    {
        $this->manager = $manager;
    }
    
    public function setDept($dept)
    {
        $this->dept = $dept;
    }
    
    
}


//  END ---------------------------------------------------------------------------

// carl

Namespace Exercise

Define namespaces for your classes defined in previous exercises.
Use the namespace of one of your previously defined subclasses in another one of your previously defined subclasses, assign it an alias.
In the subclass where the use statement resides, qualify a call to a method in the used subclass namespace.

//  BEGIN -------------------------------------------------------------------------

<?php
namespace PTO;

trait EmployeeTrait
{
    public function getEmployeeDetails($employeeId)
    {
        //database call looks up $employeeId
        $employee = array(
            'id' => 67413,
            'department' => 'IT',
            'manager' => 'Tim',
            'hireDate' => '3/3/1014'
        );
        
        return $employee;
    }
}

/**public/index.php*********************************************************************************/
<?php
//I have built classes to process employee PTO (Paid Time Off) request.
/*index.php********************************************************************************************************/

use PTO\Request\PtoRequest;

function __autoload($class)
{
    $baseDir = realpath(__DIR__ . '/..');
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once $baseDir . DIRECTORY_SEPARATOR . $filename;
}

$request = ['days'=>'6-10,6-11', 'hours' => 4];
$ptoRequest = new PtoRequest(67413, $request);
$ptoRequest->evaluateRequest();
echo $ptoRequest->message;

$ptoRequest->reason = 'vacation';
if (isset($ptoRequest->department)) {
    
}
unset ($ptoRequest->company);

printR($ptoRequest);

function printR($val) {
    print '<pre>';
    print_r($val);
    print '</pre>';
}

/**PTO/PtoRequest.php*********************************************************************************/
<?php
namespace PTO\Request;
use PTO\PTO;
class PtoRequest extends PTO
{
    public $request;
    public $approved;
    public $message;
    public $extraData;
    
    public function __construct($employee, $request)
    {
        parent::__construct($employee);
        $this->request = $request;
    }
    
    public function __set($name, $value)
    {
        echo __METHOD__;
        $this->extraData[$name] = $value;
    }
    
    public function __get($name)
    {
        echo __METHOD__;
        return $this->extraData[$name] ?? '';
    }
    
    public function __isset($name)
    {
        echo __METHOD__;
        return isset($this->extraData[$name]);
    }
    
    public function __unset($name)
    {
        echo __METHOD__;
        unset($this->extraData[$name]);
    }
    
    public function evaluateRequest()
    {
        if ($this->request['hours'] <= $this->available) {
            $this->approved = TRUE;
            $this->processApprovedRequest();
            $this->message = "Your request to use {$this->request['hours']} hours is approved.";
        } else {
            $this->approved = FALSE;
            $this->message = "Sorry, you have requested to use {$this->request['hours']} hours but only have {$this->available} remaining. Request Denied.";
        }
    }
    
    private function processApprovedRequest() : void
    {
        if ($this->approved) {
            $this->used += $this->request['hours'];
            $this->available -= $this->request['hours'];
        }
    }
    
}

/**PTO/PTO.php*********************************************************************************/
<?php
namespace PTO;
class PTO
{
    const BLACKOUT_DAYS = ['11-28', '12-24', '12-26'];
    public $employee;
    public $allowed;
    public $used;
    public $available;
    public $manager;
    use EmployeeTrait;    
    public function __construct($employeeId)
    {
        $this->employee = $this->getEmployeeDetails((int) $employeeId);
        $this->getPtoNumbers($employeeId);
    }
    
    public function getPtoNumbers($employeeId)
    {
        //would pull data from database
        $this->allowed = 60;
        $this->used = 53;
        $this->available = 7;
    }
    
}
//  END ---------------------------------------------------------------------------
```


----------------------------------------------------------------------------------------------------------------------------
## Mon 12 Jun 2017
[http://collabedit.com/xum9h](http://collabedit.com/xum9h)
----------------------------------------------------------------------------------------------------------------------------

* this shows the use of exceptions:
[https://github.com/dbierer/oauth.unlikelysource.org/blob/master/module/AuthOauth/src/AuthOauth/Adapter/GoogleAdapter.php](https://github.com/dbierer/oauth.unlikelysource.org/blob/master/module/AuthOauth/src/AuthOauth/Adapter/GoogleAdapter.php)

// END -------------------------------------------------------------------------------

----------------------------------------------------------------------------------------------------------------------------
## Wed 14 Jun 2017 and Thu 15 Jun 2017
[http://collabedit.com/xum9h](http://collabedit.com/xum9h)
----------------------------------------------------------------------------------------------------------------------------

* MongoDB examples:
[https://github.com/dbierer/classic_php_examples/tree/master/mongoDB](https://github.com/dbierer/classic_php_examples/tree/master/mongoDB)

``
// amanda
SQL Statements Exercise
Identify the result of each of the following SQL statements:

SELECT * FROM users; //Retrieves all of the records from the users table
SELECT firstname, lastname FROM users AS u WHERE u.id = 25; //Selects only the first and last name from the users table (which is aliased to 'u') for the user with the id of 25
INSERT INTO users (firstname, lastname) VALUES(James, Bond); //Inserts James into the firstname column and Bond into the lastname column for the users table
UPDATE users SET firstname=Rube, lastname=Goldberg WHERE users.id=420; //Updates the first and last name of the user with an id of 420 within the users table to Rube (firstname column) Goldberg (lastname column)
DELETE FROM users WHERE firstname=Rube; //Deletes any user from the users table if their first name matches Rube within the firstname column
SELECT * FROM users ORDER BY lastname DESC; //Selects all of the records from the users table and orders the results by the lastname column and in descending order
```

* ORM libraries written in PHP:
  * [http://doctrine-project.org/](http://doctrine-project.org/)
  * [http://propelorm.org/](http://propelorm.org/)
* Example using Doctrine
  *  [https://github.com/dbierer/demystifying-doctrine/tree/master/after/module/Application/src/Application/Entity](https://github.com/dbierer/demystifying-doctrine/tree/master/after/module/Application/src/Application/Entity)


* PDO
  * [http://php.net/manual/en/book.pdo.php](http://php.net/manual/en/book.pdo.php)

* Use another file to hold database config
```
<?php 
// ../config.php
return [
    'dsn' => 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course',
    'username' => 'vagrant',
    'password' => 'vagrant',
    'options'  => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
];
```
* Then include the config file when building your PDO database connection
```
<?php 
// test.php
$config = include __DIR__ . '/../config.php';

try {
    
    $pdo = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
    // Execute a one-off SQL statement and get a statement object
    $stmt = $pdo->query('SELECT * FROM orders');
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'ArrayObject');
    // Returns an associative array indexed by column name
    $results = $stmt->fetchAll();
    
    // Output the results
    echo '<pre>';
    print_r($results);
    echo '</pre>';
} catch (PDOException $e){
    //Handle error
}
```

```
<?php 
$config = include __DIR__ . '/../config.php';

try {
    
    $pdo = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
    // Execute a one-off SQL statement and get a statement object
    $stmt = $pdo->query('SELECT * FROM orders');
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'ArrayObject');
    // Returns an associative array indexed by column name
    echo '<pre>';
    while ($row = $stmt->fetch()) {
        // Output the results
        echo $row->id . ':' 
            . $row->date . ':' 
            . $row->status . ':' 
            . $row->amount . ':' 
            . $row->description . ':' 
            . $row->customer
            . PHP_EOL;
    }
    echo '</pre>';
} catch (PDOException $e){
    //Handle error
}
```

----------------------------------------------------------------------------------------------------------------------------
## Fri 16 Jun 2017
[http://collabedit.com/by38d](http://collabedit.com/by38d)
----------------------------------------------------------------------------------------------------------------------------

### database discussion

* To view stored procedures in phpMyAdmin click on "Routines" (assumes you have at least 1 created)
* Using MySQL command line:
``` 
show procedure status;
show procedure code <name_of_proc>;
```

* If you use ```error_log()``` in the VM, here is how you see the tail end of it:
```
 sudo tail /var/log/apache2/error.log
```
 
### internet communication discussion
```
<?php
$color = 'yellow';
if (isset($_GET['box']['red'])) {
    $color = 'red';
} elseif (isset($_GET['box']["'green'"])) {
    $color ='green';
}
?>
<form>
<input type="checkbox" name="box['red']" />Red
<input type="checkbox" name="box['green']" />Green
<input type="submit" />
</form>
<hr>
<?= $color; ?>
<?php phpinfo(INFO_VARIABLES); ?>

 // corrected insert example
 <?php 
$config = include __DIR__ . '/../config.php';

try {
    $pdo = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
    // Setup a one-off SQL statement and get a statement object
    $time = time();
    $sql  = 'INSERT INTO orders '
            . '( date,status,amount,description,customer ) '
            . "VALUES ('$time','active','300','whatever',99);";
    $stmt = $pdo->query($sql);
    $id = $pdo->lastInsertId(); // Get last insert ID
    
    // Retrieve the update
    if ($id) {
        $stmt = $pdo->query( 'SELECT * FROM orders WHERE id = ' . $id );
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Get the new entry by associative array
        print_r( $result ); // Output the result
    } else {
        echo 'Insert did not suceed';
    }
} catch (PDOException $e){
    error_log(__FILE__ . ':' . __LINE__ . ':' . date('Y-m-d H:i:s') . ':' . $e->getMessage());
    echo $e->getMessage();
}

// modified delete
<?php 
$config = include __DIR__ . '/../config.php';

try {
    $pdo = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
    // Setup a one-off SQL statement and get a statement object
    $id = 11;
    $sql = "DELETE FROM orders WHERE id= " . $pdo->quote($id);
    echo $sql . '<br>';
    $stmt = $pdo->query( $sql );
    
    // Get the number of rows affected (should be 1)
    $affected = $stmt->rowCount();
    
    // Get the records and see the update
    if (!$affected) echo 'Delete did not suceed';
    
    // Get the records and see the deletion
    $stmt = $pdo->query( 'SELECT * FROM orders' );
    
    // Get the rows including the new insert as an associative array by column name
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r( $result ); // Output the result
} catch (PDOException $e){
    //Handle error
}
```


```
// carl
Prepared Statements Exercise
Create a prepared statement script.
Add a try/catch construct.
Add a new customer record binding the customer parameters.

// BEGIN -----------------------------------------------------------------------------------------------

$config = include __DIR__ . '/../config/database.php';

try {
    $pdo = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
    $sql='INSERT INTO customers
        (firstname,lastname)
        VALUES (?,?)';
        
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute(array('Carl','Gettinger')); 
    
} catch (PDOException $e){
    error_log(__FILE__ . ':' . __LINE__ . ':' . date('Y-m-d H:i:s') . ':' . $e->getMessage());
    echo $e->getMessage();
}


// END -------------------------------------------------------------------------------------------------


// eddie
Stored Procedure Exercise
Create a stored procedure script.
Add the SQL to the database.
Call the stored procedure with parameters.
NOTE: look at sandbox/ModDB/storedProc.sql

// BEGIN -----------------------------------------------------------------------------------------------

//procedure 1 //

DROP PROCEDURE IF EXISTS course.newCustomer;
DELIMITER $
CREATE PROCEDURE course.newCustomer(
    p_firstname varchar(50),
    p_lastname varchar(50))
BEGIN
    insert into customers (firstname, lastname) values (p_firstname,p_lastname);
   
END
$
DELIMITER ;


//procedure 2//

DROP PROCEDURE IF EXISTS course.newOrder;
DELIMITER $
CREATE PROCEDURE course.newOrder(
    n_date int,
    n_status varchar(50),
    n_amount int,
    n_description varchar(50),
    n_customer int)
BEGIN
    insert into orders (date,status,amount,description,customer) values (n_date,n_status,n_amount,n_description,n_customer);
   
END
$
DELIMITER ;

// program to call "newOrder"
$conf = require_once __DIR__ . '/../config.php';

try {
    // Get the connection instance
    $conn = new PDO($conf['dsn'], $conf['username'], $conf['password']);

    // Set error mode attribute
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // make a call to "newOrder" stored procedure
    //  insert into orders (date,status,amount,description,customer)
    $sql = 'CALL newOrder(:date,:status,:amt,:descrip,:cust)';
    $statement = $conn->prepare($sql);
    $statement->execute([':date' => time(),':status' => 'pending',
                           ':amt' => 8888,':descrip' => 'TEST',':cust' => 3]);

} catch (PDOException $e) {
    $conn->rollBack();
    error_log('Exception encountered: ' . $e . PHP_EOL);
}


// END -------------------------------------------------------------------------------------------------

// james
Transaction Exercise
Create a transaction script.
Execute two SQL statements.
Handle any exceptions.

// BEGIN -----------------------------------------------------------------------------------------------

<?php

$conf = require_once __DIR__ . '/../config/config.php';

try {
    // Get the connection instance
    $conn = new PDO($conf['dsn'], $conf['username'], $conf['password']);

    // Set error mode attribute
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin the transaction
    $conn->beginTransaction();

    // insert new item into orders table 'Photo Paper'
    $sql = 'INSERT INTO orders (date, status, amount, description, customer) VALUES (UNIX_TIMESTAMP(now()),?,?,?,?)';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('open','14','Photo Paper',3));
    
    // update orders.id=4's amount to 20 (spliting products)
    $sql = 'UPDATE orders SET amount=? WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(20,4));

    // Commit success
    $conn->commit();
    echo "success!!!";
} catch (PDOException $e) {
    $conn->rollBack();
    error_log('Exception encountered: ' . $e . PHP_EOL);
}


// END -------------------------------------------------------------------------------------------------
```

----------------------------------------------------------------------------------------------------------------------------
## 19 Jun 2017
[http://collabedit.com/rweyv](http://collabedit.com/rweyv)
----------------------------------------------------------------------------------------------------------------------------

### internet comm discussion

* COOKIE Example: [https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php](https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php)
* SESSION Example: [https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php](https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php)
* ETAG Example: [https://github.com/dbierer/classic_php_examples/blob/master/web/etag.php](https://github.com/dbierer/classic_php_examples/blob/master/web/etag.php)

```
// steve
Cookie Exercise
Write a class and method that sets a cookie for some data.
Write a second method that processes the cookie.

// BEGIN -------------------------------------------------------------------
//index.php
<?php
function __autoload($class)
{
    require_once __DIR__ . '/' . $class . '.php';
}

//Due to the nature of cookie creation, you have to refresh the page after its first run

$result = new CookieClass("Whatnot","Test data");
$result2 = new CookieClass("Hullaballo","Another test");
echo $result->status;
echo "<br>";
echo $result2->status;

echo "<br>";
var_dump($_COOKIE);
echo "<br>";

$result2->destroy();
echo $result2->status;
echo "<br>";
var_dump($_COOKIE);
echo "<br>";

?>

//CookieClass.php
<?php

class CookieClass {
    public $name;
    public $value;
    public $expire;
    public $status;
    
    
    function __construct($test, $value, $expire = null)
    {
        $this->name = $test;
        $this->value = $value;
        if($expire == null)
        {
            $this->expire = time() + (60 * 60);
        }
        setcookie($this->name, $this->value, $this->expire);
        $this->status = $this->confirmation();
    }
    
    function destroy()
    {
        unset($_COOKIE[$this->name]);
        setcookie($this->name, $this->value, time() - (60 * 60));
        $this->status = "Cookie ". $this->name . " has been destroyed.";
    }
    
    function confirmation()
    {
        return("Cookie " . $this->name . " was created");
    }
}


// END ---------------------------------------------------------------------

// amanda
Session Exercise
Write a index.php file that receives login form post data. Hard code the post data if desired.
Write a model class that interfaces the user database and authenticate the user.

Example of Autoloader: [https://github.com/PHPMailer/PHPMailer/blob/master/PHPMailerAutoload.php](https://github.com/PHPMailer/PHPMailer/blob/master/PHPMailerAutoload.php)

// BEGIN -------------------------------------------------------------------
//Had to alter customers table
//ALTER TABLE `customers` ADD `username` VARCHAR(255) NOT NULL AFTER `lastname`;

// file name: test.php

<?php
use Amanda\Model\LoginForm;

define('BASE', __DIR__ . '/../src/');
spl_autoload_register(function ($LoginForm)
{
    $formDisplay = BASE . str_replace('\\', '/', $LoginForm) . '.php';
    require_once($formDisplay);
}
);
// TODO:
/*
 * 0. Modify the database as per:
 * ALTER TABLE `customers` ADD `username` VARCHAR(255) NOT NULL AFTER `lastname`;
 * and create directory structure "Amanda" under orderapp/src
 * 1. Define an autoloader which assumes namespace "Amanda" starts at BASE 
 * 2. Display the login form (LoginForm::showForm())
 * 3. Capture $_POST data and run LoginForm::inputScreening(<with params as indicated)
 * 4. Display any messages from $_SESSION['message']
 */
//Start the session
session_start();

$db = require_once BASE . '../config/config.php';
$formModel = new LoginForm();
echo $formModel->showForm();

$data = [$_POST['username'], $_POST['password']];
$formModel->inputScreening($data, $db);

// file name: Amanda/Model/LoginForm.php

<?php
namespace Amanda\Model;
use Amanda\Validate\User;
class LoginForm
{
    const ERROR_INVALID = "Username and/or password is not valid.";
    const SUCCESS_VALID = 'Login was successful';
    const SESSION_USERNAME = 'username';
    const SESSION_FIRST_NAME = 'firstname';
    const SESSION_LAST_NAME = 'laststname';
    
    public function showForm($username = NULL, $password = NULL) 
    {
        $output = '';
        $output .= '<form action="test2.php" method="post">';
        $output .= '<label for="username">Username:</label>';
        $output .= '<input name="username" type="text" id="username" value="' . $username . '">';
        $output .= '<br>';
        $output .= '<label for="password">Password:</label>';
        $output .= '<input name="password" type="password" id="password" maxlength="8" value="' . $password . '">';
        $output .= '<br>';
        $output .= '<input name="submit" type="submit" id="submit" value="Login">';
        $output .= '</form>';
        return $output;
    }

    public function inputScreening($data, $config)
    {
        if (!empty($data['username'])) {
            $username = strip_tags($data['username']);
        }
        
        $userValid = new User($config);
        if (!$userValid->userValidation($username, $password))
        {
            $_SESSION['message'][]= self::ERROR_INVALID;
            $success = FALSE;
        }
        else
        {
            
            //Store session variables
            $_SESSION['message'][] = self::SUCCESS_VALID;
            $_SESSION[self::SESSION_USERNAME]   = $row['username'];
            $_SESSION[self::SESSION_FIRST_NAME] = $row['firstname'];
            $_SESSION[self::SESSION_LAST_NAME]  = $row['lastname'];
            $success = TRUE;
        }
        return $success;
    }    
}

// file name: Amanda/Validate/User.php

<?php
namespace Amanda\Validate;

class User
{
    protected $conn;
    public function __construct(array $db)
    {
        try
        {
            $this->conn = new PDO($db['db']['dsn'], $db['db']['username'], $db['db']['password']);
        }
        catch (PDOException $e)
        {
            error_log(__FILE__ . ':' . __LINE__ . ':' . date('Y-m-d H:i:s') . ':' . $e->getMessage());
            echo $e->getMessage();
        }
        
    }
    public function userValidation($username, $password)
    {
        //Check if username and password were entered
        if (empty($username))
        {
            error_log('This field is required. Please enter a valid username.' . PHP_EOL, 3, 'error.log');
            return false;
        }
        
        if (empty($password))
        {
            error_log('This field is required. Please enter a valid password.' . PHP_EOL, 3, 'error.log');
            return false;
        }
        
        //Check if username meets alphanumeric requirement
        if (!ctype_alnum($username))
        {
            error_log('Incorrect username format. Please try again.' . PHP_EOL, 3, 'error.log');
            return false;
        }
        
        //Check if password meets length requirement
        if (!strlen($password, 8))
        {
            error_log('Invalid password. Please try again.' . PHP_EOL, 3, 'error.log');
            return false;
        }
        
        //Make new db class to call and check if user exists
        //To keep this simple, I'm only checking username and not worrying with password
        try
        {
            $stmt = $this->conn->query('SELECT * FROM customers WHERE username = ' . $username);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row)
            {
                $result = $row;
                $_SESSION['message'][]= "SUCCESS: Information found.";
            }
            else
            {
                $_SESSION['message'][]= "ERROR: No information was found.";
                $result = FALSE;
            }
        }
        catch (PDOException $e)
        {
            error_log(__FILE__ . ':' . __LINE__ . ':' . date('Y-m-d H:i:s') . ':' . $e->getMessage());
            $_SESSION['message'][]= "ERROR: " . $e->getMessage();
            $result = FALSE;
        }
        return $result;
    }
    
}

// file name: test2.php
<?php
define('BASE', __DIR__ . '/../src/');
spl_autoload_register(function ($LoginForm)
{
    $formDisplay = BASE . str_replace('\\', '/', $LoginForm) . '.php';
    require_once($formDisplay);
}
);
use Amanda\Model\LoginForm;

$validInfo = new LoginForm();
echo $validInfo->inputScreening();

// END ---------------------------------------------------------------------
```

----------------------------------------------------------------------------------------------------------------------------
## Wed 21 Jun 2017
[http://collabedit.com/jumbj](http://collabedit.com/jumbj)
----------------------------------------------------------------------------------------------------------------------------

### class discussion

* PHPMailer: [https://github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)

* Labs for everyone
  *  Install Composer Exercise
  *  Install Composer in the course virtual machine.
  *  Install composer locally. Use the local link for instruction.
  *  Install composer globally . Use the global link for instruction.
  *  see: [https://getcomposer.org/](https://getcomposer.org/)

* Composer with OrderApp Exercise
  *  Add composer to the OrderApp project.
  *  Edit the composer.json file to match the JSON shown in the Order Application sample in the previous slide.
  *  Execute Composer and install the specified dependencies.
  *  Please go ahead and install composer + guzzlehttp/guzzle (Guzzle HTTP Client)

----------------------------------------------------------------------------------------------------------------------------
## Fri 23 Jun 2017
[http://collabedit.com/jumbj](http://collabedit.com/jumbj)
----------------------------------------------------------------------------------------------------------------------------

* Streams Wrappers: [http://php.net/manual/en/wrappers.php](http://php.net/manual/en/wrappers.php)

### Using ```file_get_contents()``` to make web service requests
```
<?php
// Make a request for JSON
$url = 'http://maps.googleapis.com/maps/api/geocode/%s'
     . '?address=350+5th+Avenue+New+York,+NY&sensor=false';
$json = file_get_contents(sprintf($url, 'json'));

// Decode into a standard class object
$resultsObj = json_decode($json);

// Decode into an array
$resultsArr = json_decode($json, true);

// Make a request for XML
$xml = file_get_contents(sprintf($url, 'xml'));

// Load a SimpleXmlElement object
$smplxml = simplexml_load_string($xml);

// Output something
var_dump($resultsArr);
echo $smplxml->asXml();
```

### examples of regex
```
<?php
// extracts phone number
$text = 'Phone number is 111-222-3333, but my phone number in Thailand is +66 (44) 888999 or you can try 66.222.333333';
$pattern = '/(\d{3}-\d{3}-\d{4})|(\+\d{1,3} \(\d{2}\) \d+? )/';
preg_match_all($pattern, $text, $matches);
var_dump($matches);
echo PHP_EOL;

// extracts the URL from a href tag
$text = 'Click <a href="http://www.zend.com/training">Here</a> for Training Info';
$pattern = '/<a.*?href=("|\')(.*?)("|\').*?>/';
preg_match_all($pattern, $text, $matches);
var_dump($matches);
echo PHP_EOL;

// validates a hex number
$text = '098f6bcd4621d373cade4e832627b4f6';
$pattern = '/^[0-9a-f]*$/';
preg_match_all($pattern, $text, $matches);
var_dump($matches);
echo PHP_EOL;

```

----------------------------------------------------------------------------------------------------------------------------
## Form / Validation / Authentication Lab Solution
----------------------------------------------------------------------------------------------------------------------------

* You can view the posted solution files here: [https://github.com/dbierer/classic_php_examples/tree/master/web](https://github.com/dbierer/classic_php_examples/tree/master/web)
  *  web/Lab/Authentication/Status.php
  *  web/Lab/AutoLoader/Loader.php
  *  web/Lab/Db/Connection.php
  *  web/Lab/Db/CustomerTable.php
  *  web/Lab/Login/FormGen.php
  *  web/Lab/Login/FormValidator.php
  *  web/Lab/customers.sql
  *  web/login_form_lab.php
  *  web/login_form_lab_config.php
  *  web/login_form_lab_setup.php

* Here is the revised database structure:
```
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `products_purchased` varchar(128) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `password` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
```

* config file ```login_form_lab_config.php```
```
<?php
$config = [
    'form' => [
        'form' => [
            'login' => [
                'method' => 'post',
                'id' => 'login'
            ],
        ],
        'elements' => [
            'username' => [
                'label' => 'Email Address: ',
                'type' => 'email',
                'id' => 'username',
                'title' => 'Enter your email address to login',
            ],
            'password' => [
                'label' => 'Password: ',
                'type' => 'password',
                'id' => 'password',
                'title' => 'Enter your password',
            ],
            'login' => [
                'type' => 'submit',
                'name' => 'login',
                'value' => 'Login'
            ],
            'logout' => [
                'type' => 'submit',
                'name' => 'logout',
                'value' => 'Logout'
            ]
        ]
    ],
    'validator' => [
        'elements' => [
            // template
            'username' => [
                ['trim' => []],
                ['stripTags' => []],
                ['email' => []],
            ],
            // NOTE: in production you will most likely NOT validate a password entry!
            //       ... has the potential to give away too much information to an attacker
            'password' => [
                ['trim' => []],
                ['strlen' => ['min' => 1, 'max' => 8]],
                ['regex' => ['pattern' => '/[A-Za-z!0-9]/']],
            ],
        ]
    ],
    'database' => [
        'dbname' => 'zend',
        'host' => 'localhost',
        'username' => 'test',
        'password' => 'password',
    ],
];

return $config;
```

* calling program ```login_form_lab.php```
```
<?php
/*
 * All passwords == 'password'
 * Valid email logins to test:
 * 
 * gstevenson@nationaltech.net
 * jlevitz@northwestcomm.com
 * schu@consolidatedtelco.com
 * twhite@nationalmedia.net
 * mwhitney@southerntech.com
 * 
 */
function loggedInMessage($status, $message)
{
    $message[] = 'Logged In As: ' . $status->email;
    $message[] = 'Last Login: ' . $status->lastLogin;
    return $message;
}

require __DIR__ . '/Lab/AutoLoader/Loader.php';
$autoLoader = new \Lab\AutoLoader\Loader(__DIR__);

use Lab\Db\ { Connection, CustomerTable };
use Lab\Login\ { FormGen, FormValidator };
use Lab\Authentication\Status;

$message = [];
$config = include __DIR__ . '/login_form_lab_config.php';

// setup form object
$form = new FormGen($config['form']);

// check for post
$status = new Status();
if (isset($_POST['logout'])) {
    $status->clearStatus();
} elseif (isset($_POST['login'])) {

    if ($status->getStatus()) {
        $message = loggedInMessage($status, $message);
    } else {
        $validator = new FormValidator($config['validator']);
        if ($validator->validate($_POST, $form)) {
            $message[] = 'Form is Valid';
            // do database lookup
            $table = new CustomerTable(new Connection($config['database']));
            $info = $table->findCustomerByEmail($form->getValue('username'));
            if ($info) {
                if (password_verify($form->getValue('password'), $info['password'])) {
                    $info['lastLogin'] = date('l, d M Y H:i:s');
                    $status->storeStatus($info);
                    $message = loggedInMessage($status, $message);
                } else {
                    $message[] = 'Unable to process login at this time.  Code: ' . __LINE__;
                }
            } else {
                $message[] = 'Unable to process login at this time.  Code: ' . __LINE__;
            }
        } else {
            $form->setErrors($validator->getErrors());
            $message[] = 'Form is NOT Valid.  Code: ' . __LINE__;
        }
    }
}
if ($message) {
    echo '<h1>Message(s)</h1><ul><li>' . implode('</li><li>', $message) . '</li></ul>';
} else {
    echo '<hr>Enter your login name (1st letter of your first name, and entire last name)<hr>';
}
echo $form->theWholeForm();

```

* Autoloader class
```
<?php
namespace Lab\AutoLoader;

class Loader
{
    protected $path = array();
    public function __construct($path)
    {
        if (is_array($path)) {
            $this->path = $path;
        } else {
            $this->path[] = $path;
        }
        spl_autoload_register([$this, 'loadFromPath']);
    }
    public function loadFromPath($class)
    {
        $filename = str_ireplace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        foreach ($this->path as $dir) {
            $fullName = $dir . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($fullName)) {
                require_once $fullName;
                break;
            }
        }
    }
    public function addToPath($dir)
    {
        $this->path[] = $dir;
    }
}
```

* Form generation and validation classes
```
<?php
namespace Lab\Login;
// example of an HTML form generation class
// NOTE: works with validation example: ../security/login_form_validation.php

class FormGen
{
    const ERROR_NEED_FORM      = 'ERROR: need to define a top config key "form"';
    const ERROR_NEED_FORM_NAME = 'ERROR: need to define a top config key "form[name]"';
    const ERROR_NEED_ELEMENTS  = 'ERROR: need to define a top config key "elements"';
    const DEFAULT_TYPE         = 'text';
    const DEFAULT_PREFIX       = 'generated_';
    const DEFAULT_SEPARATOR    = '<br>';
    const LABEL_SEPARATOR      = '&nbsp;&nbsp;';

    protected $config;
    protected $rand = 0;
    protected $errors = array();
    
    public function __construct(array $config)
    {
        if (!isset($config['form'])) {
            throw new InvalidArgumentException(self::ERROR_NEED_FORM);
        } elseif (!isset($config['form'])) {
            throw new InvalidArgumentException(self::ERROR_NEED_FORM);
        } elseif (!isset($config['elements'])) {
            throw new InvalidArgumentException(self::ERROR_NEED_ELEMENTS);
        }
        $this->config = $config;
    }
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }
    public function setValue($name, $value)
    {
        if (!in_array($this->config['elements'][$name]['type'], ['select','checkbox','radio'])) {
            $this->config['elements'][$name]['value'] = $value;
        } else {
            $this->config['elements'][$name]['selected'] = $value;
        }
    }
    public function makeErrorHtml($name)
    {
        $output = '';
        if (isset($this->errors[$name])) {
            $output .= '<ul>';
            foreach ($this->errors[$name] as $message) {
                $output .= '<li>' . $message . '</li>' . PHP_EOL;
            }
            $output .= '</ul>';
            $output .= PHP_EOL;
        }
        return $output;
    }
    public function makeSelect($type, $name, $attribs, $close = TRUE)
    {
        $html = $this->placeLabel('', $attribs);
        if (isset($attribs['value']) && is_array($attribs['value'])) {
            $values = $attribs['value'];
            unset($attribs['value']);
            $html .= $this->makeTag('select', $name, $attribs, FALSE, self::DEFAULT_SEPARATOR, FALSE);
            foreach ($values as $key => $value) {
                $html .= '<option value="' . $key . '">'
                       . $value
                       . '</option>' . PHP_EOL;
            }
            $html .= '</select>' . PHP_EOL;
        }
        $html .= $this->makeErrorHtml($name);
        $html .= self::DEFAULT_SEPARATOR;
        return $html;
    }
    public function makeRadioCheck($type, $name, $attribs, $close = TRUE)
    {
        $html = $this->placeLabel('', $attribs);
        if (isset($attribs['value']) && is_array($attribs['value'])) {
            $values = $attribs['value'];
            $id     = ($attribs['id']) ? $attribs['id'] . '_' : $name . '_';
            $num    = 0;
            foreach ($values as $key => $value) {
                $sub = $attribs;
                $sub['value'] = $key;
                $sub['label'] = $value;
                $sub['id'] = $id . $num++;
                $html .= $this->makeTag('input', $name . '[]', $sub, TRUE, self::LABEL_SEPARATOR, FALSE);
            }
        }
        $html .= self::DEFAULT_SEPARATOR;
        $html .= PHP_EOL;
        $html .= $this->makeErrorHtml($name);
        return $html;
    }
    public function placeLabel($input, &$attribs)
    {
        if (isset($attribs['label'])) {
            $input .= $attribs['label'] . self::LABEL_SEPARATOR;
            unset($attribs['label']);
        }
        return $input;
    }
    public function makeTag($type, $name, $attribs, $close = TRUE, $separator = self::DEFAULT_SEPARATOR, $showError = TRUE)
    {
        $input = $this->placeLabel('', $attribs);
        $input .= '<' . $type . ' name="' . $name . '" ';
        foreach ($attribs as $key => $value) {
            if ($key != 'label') $input .= sprintf('%s="%s" ', $key, $value);
        }
        $input .= ($close) ? ' />' : ' >';
        $input .= $separator;
        $input .= PHP_EOL;
        $input .= ($showError) ? $this->makeErrorHtml($name) : '';
        return $input;
    }
    public function getValue($key)
    {
        return $this->config['elements'][$key]['value'] ?? NULL;
    }
    public function theWholeForm()
    {
        $html = '';
        foreach ($this->config['form'] as $name => $attribs) {
            $html .= $this->makeTag('form', $name, $attribs, FALSE);
        }
        foreach ($this->config['elements'] as $name => $attribs) {
            if (!isset($attribs['type'])) {
                $attribs['type'] = self::DEFAULT_TYPE;
            } else {
                $attribs['type'] = strtolower($attribs['type']);
            }
            if ($attribs['type'] == 'checkbox') {
                $html .= $this->makeRadioCheck('checkbox', $name, $attribs, TRUE);
            } elseif ($attribs['type'] == 'radio') {
                $html .= $this->makeRadioCheck('radio', $name, $attribs, TRUE);
            } elseif ($attribs['type'] == 'select') {
                $html .= $this->makeSelect('select', $name, $attribs, TRUE);
            } else {
                $html .= $this->makeTag('input', $name, $attribs, TRUE);
            }
        }
        $html .= '</form>';
        return $html;
    }
}
```
<?php
namespace Lab\Login;

// NOTE: does filtering as well as validation

class FormValidator
{
    
    const CORE_MESSAGE = 'core';
    const ERROR_NEED_ELEMENTS  = 'ERROR: need to define a top config key "elements"';
    const NOT_ALNUM = 'Input must be only letters or numbers';
    const NOT_MAX_STRLEN = 'The length for this field cannot exceed ';
    const NOT_MIN_STRLEN = 'The length for this field must be at least ';
    const NOT_REGEX = 'Input does not meet the required pattern';
    const NOT_EMAIL = 'Invalid email address';
    const NOT_DEFINED = 'There are no validators defined for this element';
    
    protected $config;
    protected $messages = array();
    protected $data = array();
    
    public function __construct(array $config)
    {
        if (!isset($config['elements'])) {
            throw new InvalidArgumentException(self::ERROR_NEED_ELEMENTS);
        }
        $this->config = $config;
    }
    // Core Validation --------------------------------------------------------
    // TODO: figure out how to return validation data
    public function validate(array $data, &$form = NULL)
    {
        $valid = TRUE;
        foreach ($data as $key => &$value) {
            $element = $this->config['elements'][$key] ?? FALSE;
            if ($element) {
                foreach ($element as $callback) {
                    $method = key($callback);
                    $params = current($callback);
                    if (method_exists($this, $method)) {
                        $test = $this->$method($key, $value, $params);
                        // check to see if result is from a validator
                        if (is_bool($test)) {
                            if (!$test) {
                                $valid = FALSE;
                            }
                        // otherwise assume value is from filter
                        } else {
                            $value = $test;
                        }
                    }
                }
                // if form object is present, set value
                if ($form) $form->setValue($key, $value);
            }
        }
        return $valid;            
    }
    public function getErrors()
    {
        return $this->messages;
    }
    // Validators -------------------------------------------------------------
    public function strlen($fieldName, $value, $params)
    {
        $valid = TRUE;
        if (strlen($value) > $params['max']) {
            $valid = FALSE;
            $this->messages[$fieldName][] = self::NOT_MAX_STRLEN . $params['max'];
        } elseif (isset($params['min'])) {
            if (strlen($value) < $params['min']) {
                $valid = FALSE;
                $this->messages[$fieldName][] = self::NOT_MIN_STRLEN . $params['min'];
            }        
        }
        return $valid;
    } 
    public function regex($fieldName, $value, $params)
    {
        $valid = FALSE;
        if (preg_match($params['pattern'], $value)) {
            $valid = TRUE;
        } else {
            $this->messages[$fieldName][] = self::NOT_REGEX;
        }
        return $valid;
    }
    public function email($fieldName, $value)
    {
        $valid = FALSE;
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $valid = TRUE;
        } else {
            $this->messages[$fieldName][] = self::NOT_EMAIL;
        }
        return $valid;
    }
    // Filters ----------------------------------------------------------------
    public function trim($fieldName, $value)
    {
        return trim($value);
    } 
    public function stripTags($fieldName, $value)
    {
        return strip_tags($value);
    } 
}
```

* Database connection / table model classes
```
<?php
namespace Lab\Db;

use PDO;
class Connection
{
    protected $pdo;
    /**
     * Creates a PDO connection
     *
     * @throws PDOException if PDO instance fails
     */     
    public function __construct(array $config)
    {
        $dsn = 'mysql:dbname=' . $config['dbname'] . ';host=' . $config['host'];
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getConnection()
    {
        return $this->pdo;
    }
}
```
```
<?php
namespace Lab\Db;

use PDO;
/**
 * Process operations on "customers" table
 * 
 * @throws PDOException if any of the operations fail
 */
class CustomerTable
{
    const TABLE = 'customers';
    protected $pdo;
    public function __construct(Connection $conn)
    {
        $this->pdo = $conn->getConnection();
    }
    /**
     * @return PDOStatement
     */
    public function findAll()
    {
        $sql = 'SELECT * FROM ' . self::TABLE;
        $this->logSql($sql);
        return $this->pdo->query($sql);
    }
    public function findCustomerByEmail($email)
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE email = ?';
        $this->logSql($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateById($id, $data)
    {
        $sql = 'UPDATE ' . self::TABLE . ' SET ';
        foreach ($data as $key => $value) {
            // create named placeholders
            $sql .= $key . '= :' . $key . ',';
        }
        // remove trailing comma
        $sql = substr($sql, 0, -1);
        $sql .= ' WHERE id = :id';
        $this->logSql($sql);
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    public function save($data)
    {
        $sql = 'INSERT INTO ' . self::TABLE . ' ( ';
        foreach ($data as $key => $value) {
            $sql .= $key . ',';
        }
        // remove trailing comma
        $sql = substr($sql, 0, -1);
        $sql .= ' ) VALUES ( ';
        foreach ($data as $key => $value) {
            // create named placeholders
            $sql .= ':' . $key . ',';
        }
        // remove trailing comma
        $sql = substr($sql, 0, -1);
        $sql .= ' )';
        $this->logSql($sql);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    protected function logSql($sql)
    {
        error_log(date('Y-m-d H:i:s') . ':' . __METHOD__ . ':' . $sql);
    }
}
```

* Authentication status / storage class
```
<?php
namespace Lab\Authentication;

class Status
{
    const SESSION_KEY = 'authentication-status';
    const DEFAULT_ITEM = 'Unknown';
    public function __construct()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
    public function storeStatus($info)
    {
        $_SESSION[self::SESSION_KEY] = $info;
    }
    public function getStatus()
    {
        return $_SESSION[self::SESSION_KEY] ?? NULL;
    }
    public function clearStatus()
    {
        $_SESSION[self::SESSION_KEY] = NULL;
        session_destroy();
        session_unset();
    }
    public function __get($key)
    {
        return $_SESSION[self::SESSION_KEY][$key] ?? self::DEFAULT_ITEM;
    }
}
```

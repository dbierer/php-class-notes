# PHP II NOTES

Left Off With: http://localhost:8080/#/8/16

## ERRATA
* http://localhost:8080/#/3/1: Settting
* http://localhost:8080/#/4/16: accessability  
* http://localhost:8080/#/4/21: parent ::   ???
* http://localhost:8080/#/4/59: s/be ¨use CarTruckTrait;¨

## for Wed 9 Aug 2017
http://collabedit.com/xvyaq

* http://php.net/manual/en/ini.list.php

```
sudo gedit /etc/php/7.1/apache2/php.ini
sudo service apache2 restart
```

```
<?php
// example of __construct() with dependency
class Logger
{
    public $logFile;
    public function __construct($logFile)
    {
        $this->logFile = $logFile;
    }
    public function write($message)
    {
        $message = date('d-M-Y H:i:s') . ' ' . $message;
        file_put_contents($this->logFile, $message . PHP_EOL, FILE_APPEND);
    }
    public function read()
    {
        return file_get_contents($this->logFile);
    }
}

$logger = new Logger(__DIR__ . '/test.log');
$logger->write('TEST');
echo '<pre>' . $logger->read() . '</pre>';
```

```
<?php
// example of why you need protected
class Logger
{
    const DATE_FORMAT = 'd-M-Y H:i:s';
    public $logFile;
    protected $today;
    public function __construct($logFile)
    {
        $this->logFile = $logFile;
        $this->today = new DateTime();
    }
    public function write($message)
    {
        $message = $this->today->format(self::DATE_FORMAT) . ' ' . $message;
        file_put_contents($this->logFile, $message . PHP_EOL, FILE_APPEND);
    }
    public function read()
    {
        return file_get_contents($this->logFile);
    }
    public function setDate($date)
    {
        if (is_string($date)) {
            $this->today = new DateTime($date);
        } elseif ($date instanceof DateTime) {
            $this->today = $date;
        } else {
            $this->today = new DateTime();
        }
        // note: if you return $this, you can "chain" your setters, etc.
        return $this;
    }
}

$logger = new Logger(__DIR__ . '/test.log');
$logger->setDate(date('d-M-Y H:i:s'))->write('TEST');
echo '<pre>' . $logger->read() . '</pre>';
```


### homework for everybody
* Create a Class Exercise
* Create a class definition that represents something. Give it a constant and a few properties and methods. Set appropriate visibilities for each.
* Instantiate a couple of objects and execute the methods created producing some output.
* Create something which is realistic and appropriate to a current or future application

### philip
```
<?php
/**
 * file: pBrown20170808.php
 * Class to Make Location Json
 * User: philip
 * Date: 2017 08 08
 * Time: 5:33 PM
 */

class Location
{
    public $locationID;
    public $lat;
    public $long;
    public $city;
    public $state;
    public $zip;

    public function __construct($locationID, $lat, $long, $city, $state, $zip)
    {
        $this->locationID = $locationID;
        $this->lat = $lat;
        $this->long = $long;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }
    public function getLocation()
    {
        return "Location ID : " . $this->locationID . "<br>" . "Lat : " . $this->lat . "<br>" . "Long : " .          $this->long . "<br>" . "City,State : " . $this->city . ", " . $this->state . "<br>" . "Zip : " . $this->zip . "<br>";
    }

    public function makeJson()
    {
        $json = array($this->locationID, $this->lat, $this->long, $this->city, $this->state, $this->zip);
        return json_encode($json);
    }
}

$_00001 = new Location("00001", "29.00", "-98.00", "New Braunfels", "TX", "78130");

// echo $_00001->getLocation();

// echo "<pre>";
// var_dump($_00001);
// echo "</pre>";

// echo "<pre>";
// echo "json =  " . json_encode($_00001);
// echo "</pre>";

echo $_00001->makeJson();

// ["00001","29.00","-98.00","New Braunfels","TX","78130"]

?>
```

### Nichole

```
<?php
class Breadcrumb
{
    
    protected const LINK_COLOR = '#337ab7';
    
    // private instance variables
    protected $text;
    protected $href;
    protected $target;
    
    /**
     *
     * @param string $text - the text to display for this link
     * @param string $href -
     * @param string $target
     */
    public function __construct($text = "", $href = "#", $target = "_blank")
    {
        $this->text = $text;
        $this->href = $href;
        $this->target = $target;
    }
    
    public function display()
    {
        return sprintf('<ol class="breadcrumb"><li><a style="color:%s;" target="%s" href="%s">%s</a></li></ol>',
            self::LINK_COLOR, $this->target, $this->href, $this->text);
    }
    
}
```

```
<?php
// part of the index page (left out the junk) 
function __autoload($class)
{
    include __DIR__ . '/' . $class . '.php';
}

$breadcrumb = new BreadCrumb("Home", "/");
echo $breadcrumb->display();
$breadcrumb2 = new BreadCrumb("About", "/about");
echo $breadcrumb2->display();
```

### charlie's code below
```
class ScholarlyResource 
{
    public const PROX = "http://fastproxy.example.com?uri=";
    private $uri;
    private $name;
    private $id;
    
    public function __construct($uri, $name) 
    {
        $this->uri = $uri;
        $this->name = $name;
        $this->setUniqueID();
    }
    
    public function htmlPrint()
    {
        $html = "<a name=\"$this->id\"href=\"";
        $html .= self::PROX;
        $html .= $this->uri;
        $html .= "\">";
        $html .= $this->name;
        $html .= "</a>";  
        
        return $html;
    }
    
    private function setUniqueID()
    {
        $this->id = uniqid();
    }
}


$databases[] = new ScholarlyResource('http://example.com/1', 'Web of Science');
$databases[] = new ScholarlyResource('http://example.com/2', 'JSTOR');
$databases[] = new ScholarlyResource('http://example.com/3', 'IEEE Explor');


foreach ($databases as $database) {
    echo $database->htmlPrint() . "<br>";
} 
// charlie's code above 
```

## for Friday 11 Aug 2017
http://collabedit.com/qy2bf

* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_singleton_getinstance_example.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_call_unlimited_getters_setters.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_get_set.php
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_invoke_and_tostring.php
* http://www.php-fig.org/psr/psr-7/]

### nichole
Create an Extensible Super Class Exercise
Using the code created in the previous exercise, create an extensible superclass definition. Set the properties and methods that subclasses will need.
Create one or more subclasses that extend the superclass with constants, properties and methods specific to the subclass
Instantiate a couple of objects from the subclasses and execute the methods producing some output.

```
// BEGIN ---------------------------------------------------------------------------------------------------
<?php 
class BreadCrumb 
{
 protected const LINK_COLOR = "#337ab7";
 protected $text;
 protected $href;
 protected $target;
 
 public function __construct($text = "", $href = "#", $target = "_blank")
 {
    $this->text = $text;
    $this->href = $href;
    $this->target = $target;
 }
 
 public function display()
 {
   return sprintf('<ol class="breadcrumb"><li><a style="color:%s;" target="%s" href="%s">%s</a></li></ol>', 
                  self::LINK_COLOR, $this->target, $this->href, $this->text);
  }
}
```

```
/**
 * This class is only instantiated if user credentials are verified
 *
 * @author vagrant
 *
 */
class AdminBreadCrumb extends BreadCrumb 
{
    public function __construct($text = "", $href = "#", $target = "_blank")
    {
        $href = $href . DIRECTORY_SEPARATOR . "admins";
        parent::__construct($text, $href, $target);
    } 
}
```

```
class AuthClass
{
    public function isAdminUser()
    {
        return TRUE;
    }
}
// normally the code below would be in the control program (often index.php)

$authClass = new AuthClass();
$b = new BreadCrumb("Home", "/");
echo $b->display();  // works
if ($authClass->isAdminUser()){
    $b2 = new AdminBreadCrumb("Admin", "/about");
    echo $b2->display(); // doesn't print a title at all, but doesn't throw an error?
}
     

// END -----------------------------------------------------------------------------------------------------
```


### pedram
Magic Methods Exercise
Using the code from the previous exercises, add four magic methods.
Add a magic constructor that accepts parameters and set those parameters into the class on instantiation.
Create an index.php file, load the classes, create subclass object instances and execute method calls to the subclass objects.

// BEGIN ---------------------------------------------------------------------------------------------------



// END -----------------------------------------------------------------------------------------------------

### philip
Abstract Class Exercise
Turn your superclass into an abstract class.
Add a static property and method that builds another object.
Call the static method and retrieve the object it builds.

// BEGIN ---------------------------------------------------------------------------------------------------
```
<?php
/**
 * file: pBrown20170811.php
 * Abstract Class to make array, Json, and html
 * User: philip
 * Date: 2017 08 10
 *
 */
interface LocationInterface
{
    // abstract method only needs to define the required arguments
    public function makeArray();
    public function makeJson();
    public function makeHtml();
}

abstract class LocationAbstract implements LocationInterface
{
    // abstract method only needs to define the required arguments
    public function makeArray()
    {
        return get_object_vars($this);
    }
}
```

```
class LocationPoint extends LocationAbstract
{
    public $locationID;
    public $lat;
    public $long;
    public $city;
    public $state;
    public $zip;
    
    public function __construct($locationID, $lat, $long, $city, $state, $zip)
    {
        $this->locationID = $locationID;
        $this->lat = $lat;
        $this->long = $long;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }
    
    public function makeJson()
    {
        return json_encode($this->makeArray());
    }
    
    public function makeHtml()
    {
        $out = '<ul style="list-style: none;">';
        foreach(($this->makeArray()) as $key => $elem){
            if(!is_array($elem)){
                $out .= "<li><span>$key:  $elem</span></li>";
            }
            else $out .= "<li><span>$key</span>".makeHtml()($elem)."</li>";
        }
        $out .= "</ul>";
        return $out;
    }
}
```

```
echo '<pre>';
$_00001 = new LocationPoint("00001", "29.00", "-98.00", "New Braunfels", "TX", "78130");
echo $_00001->makeJson();
echo "<br>";
echo $_00001->makeHtml();
echo "<br>";
var_dump($_00001->makeArray());
var_dump($_00001 instanceof LocationInterface);
echo '</pre>';

// {"locationID":"00001","lat":"29.00","long":"-98.00","city":"New Braunfels","state":"TX","zip":"78130"}

//   locationID: 00001
//    lat: 29.00
//    long: -98.00
//    city: New Braunfels
//    state: TX
//    zip: 78130

?>
// END -----------------------------------------------------------------------------------------------------
```

### shaleha
Interface Exercise
Create an object interface with two methods.
Implement the interface in your superclass.
Add some code to the index.php file that calls one of the superclass methods implemented.

```
// BEGIN ---------------------------------------------------------------------------------------------------

<?php

/* define two functions */
interface checkPassword
{
    public function check($pwd);
}

// Define abstract class Login
abstract class Login implements checkPassword
{
    
    const MAX_PASS_LENGTH = 15;
    const MIN_PASS_LENGTH = 8;
    
    protected $_password = '';
    protected $_errors = array();
    
    public function check($a)
    {
        $this->_errors = array();
        if (preg_match('/\s/', $this->_password)) {
            $this->_errors[] = "Password can't contain spaces";
        }
        
        if (strlen($this->_password) < self::MIN_PASS_LENGTH) {
            $this->_errors[] = 'Password must be at least larger than ' . self::MIN_PASS_LENGTH;
        }
        
        if(strlen($this->_password) > self::MAX_PASS_LENGTH){
            $this->_errors[] =  'Password must be less then ' . self::MAX_PASS_LENGTH . ' characters';
        }
        
        return ($this->_errors) ? FALSE : TRUE;
        
    }
    
}
```

```
class User extends Login
{
    
    const PASSWORD_OK = 'Password checks out OK';
    
    public function setPassword($password)
    {
        if ($this->check($password)) {
            $this->_password = $password;
        }
    }
    
    public function getErrors()
    {
        $html = '';
        if (count($this->_errors)) {
            $html .= '<ul><li>';
            $html .= implode('</li><li>', $this->_errors);
            $html .= '</li></ul>';
        }
        return ($html) ? $html : self::PASSWORD_OK;
    }
    
    public function __toString()
    {
        return $this->getErrors();
    }
}
```

```
$user = new User();
$user->setPassword('12345');
echo $user;
echo "<br/>";

$user->setPassword('12345abcdef');
echo $user;
echo "<br/>";

// END -----------------------------------------------------------------------------------------------------
```


## For Mon 14 Aug 2017
http://collabedit.com/7vfd9

```
// array type hint
<?php 

class Test
{
    public function makeSelect(array $values)
    {
        $html = '<select name="days">';
        foreach ($values as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
}

$data = ['mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday'];
$test = new Test();
echo $test->makeSelect($data);
echo '<br>';
echo $test->makeSelect(['jan'=>'January','feb'=>'Feburary','mar'=>'March']);
```

```
// Interface Typehint
<?php 
interface ConvertableInterface
{
    public function getArray();
}
class Data implements ConvertableInterface
{
    protected $values;
    public function __construct($values)
    {
        $this->values = $values;
    }
    public function getArray()
    {
        if ($this->values instanceof ArrayObject) {
            return $this->values->getArrayCopy();
        } elseif (is_array($this->values)) {
            return $this->values;
        } else {
            return (array) $this->values;
        }
    }
}
class Special implements ConvertableInterface
{
    protected $values;
    public function __construct(array $values)
    {
        $this->values = $values;
    }
    public function getArray()
    {   
        return $this->values;
    }
}
class Test
{
    public function buildDays()
    {
        $days = array();
        $date = new DateTime('2017-10-1');
        for ($x = 0; $x < 7; $x++) {
            $date->add(new DateInterval('P1D'));
            $days[$date->format('d')] = $date->format('l');
        }
        return $days;
    }
    public function buildMonths()
    {
        $months = array();
        $date = new DateTime('2017-1-1');
        for ($x = 0; $x < 12; $x++) {
            $months[$date->format('m')] = $date->format('M');
            $date->add(new DateInterval('P1M'));
        }
        return $months;
    }
    public function makeSelect(ConvertableInterface $data)
    {
        $html = '<select name="days">';
        foreach ($data->getArray() as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
}

$test    = new Test();
$special = new Special($test->buildDays());
$data    = new Data($test->buildMonths());

echo $test->makeSelect($special);
echo '<br>';
echo $test->makeSelect($data);
```

```
// return value typing
<?php 
class Test
{
    public function getInput($value) : string {
        return $value;
    }
    
    public function setOptions( array $options ) : ArrayObject {
        return new ArrayObject($options);
    }
    
    public function isAutoFocus($value) : bool {
        return $value;
    }
}

echo '<pre>';
$test = new Test();
var_dump($test->getInput('test'));
var_dump($test->getInput(99.99));
var_dump($test->setOptions(range('a','f')));
var_dump($test->isAutoFocus(FALSE));
var_dump($test->isAutoFocus('test'));
echo '</pre>';
```

### banu
Type Hint Exercise
Create a new class with some properties and methods.
Add a constructor.
Type hint in the constructor for the interface created in the last exercise.
Instantiate an object from one of your previous subclasses.
Add it as a dependent object to the new object created in step one, and store it.

```
// BEGIN ----------------------------------------------------------------------
<?php

interface StudentInterface 
{
    public function validateID();
    public function display();
}

abstract class Student implements StudentInterface
{
    const MIN_ID_LENGTH = 1;
    const MAX_ID_LENGTH = 5;
    
    protected $id;
    protected $fullName;
    protected $affiliation;
    
    public function __construct($id, $fullName)
    {
        $this->id = $id;
        $this->fullName = $fullName;
    }
    public function validateID() 
    {
        return (strlen($this->id) >= self::MIN_ID_LENGTH &&
            strlen($this->id) < self::MAX_ID_LENGTH &&
            filter_var($this->id, FILTER_VALIDATE_INT) !== FALSE);
    }
    //abstract public function display();
    public function display()
    {
        return 'Student ID: ' . ($this->validateID() ? $this->id : 'INVALID' ). '<br>' . 
            'Student Name: ' . $this->fullName . '<br>' .
            'Student Type: ' . $this->affiliation;
    }
}
```

```
class GraduateStudent extends Student
{
    const AFFILIATION = 'GR';
    
    public function __construct($id, $fullName)
    {
        parent::__construct($id, $fullName);
        $this->affiliation = self::AFFILIATION;
    }
}
```

```
class UnderGraduateStudent extends Student
{
    const AFFILIATION = 'UG';
    
    public function __construct($id, $fullName)
    {
        parent::__construct($id, $fullName);
        $this->affiliation = self::AFFILIATION;
    }
}
```

```
class StudentReport
{   
    const DATE_FORMAT = 'd-M-Y';
    
    protected $student;
    protected $date;
    
    public function __construct(StudentInterface $student)
    {
        $this->student = $student;
        $this->date = new DateTime();
    }
    public function __toString()
    {
        return $this->student->display() . '<br>' . 
            'Report Date: ' . $this->date->format(self::DATE_FORMAT) . '<br>';
    }
}
```

```
$students[] = new GraduateStudent('1', 'Andrew Bird');
$students[] = new UnderGraduateStudent('2', 'Bon Iver');
$students[] = new UnderGraduateStudent('3.1', 'James Blake');

foreach ($students as $student) {
    $report = new StudentReport($student);
    echo $report . '<br>';
}

echo new StudentReport('test');
// END ------------------------------------------------------------------------
```


### nichole
Trait Exercise
Create two traits, each with two methods, one of the methods named the same in both traits.

Use the trait in a subclass created thus far. Specify a new visibility and deal with the naming conflict.

```
// BEGIN (Sorry for the formatting, not sure if line count is an issue? ----------------------------------------------------------------------
class User 
{
    use LinkHelper;
    protected $id;
    public function __construct(array $args) {
        $this->id = $args['id'];
    }    
}
```

```
class Employee extends User 
{
    use LinkHelper, EmployeeHelper {
        EmployeeHelper::display insteadof LinkHelper;
    }
    protected $name;
    public function __construct(array $args) {
        $this->name = $args['name'];
        parent::__construct($args);
    }
}
```

```
trait LinkHelper {
    protected function getId(){
        return $this->id;
    }
    protected function display(){
        return "<a href='show.php?id=" . $this->id . "'>Link!</a>";
    }
}
```

```
trait EmployeeHelper {
    protected function getName(){
        return $this-name;
    }
    // Displays a link to employee's personal page instead of the usual link?
    public function display(){
        return "<a href='employeePage.php?id=" . $this->id . "'>" . $this->name . " home page</a>";
    }
}
```

```
$args = array('id' => '213', 'name' => 'Nichole');
$employee = new Employee($args);
echo $employee->display();
// END ------------------------------------------------------------------------
```


## for Wed 16 Aug 2017
http://collabedit.com/3v6tx

* http://www.php-fig.org/psr/psr-4/]

```
// simple spl_autoload_register() example
<?php 
spl_autoload_register(function ($full) {
    include __DIR__ . '/../' . str_replace('\\', DIRECTORY_SEPARATOR, $full) . '.php';
});

use Generic\Form\Build;
use Generic\Data\ {Data, Special};

$test    = new Build();
$special = new Special($test->buildDays());
$data    = new Data($test->buildMonths());

echo $test->makeSelect($special);
echo '<br>';
echo $test->makeSelect($data);
```


```
// another approach
<?php 
include __DIR__ . '/../Generic/Loader.php';
spl_autoload_register('\\Generic\\Loader::autoload');

use Generic\Form\Build;
use Generic\Data\ {Data, Special};

$test    = new Build();
$special = new Special($test->buildDays());
$data    = new Data($test->buildMonths());

echo $test->makeSelect($special);
echo '<br>';
echo $test->makeSelect($data);
```

```
// Loader.php
<?php
namespace Generic;

class Loader
{
    public static function autoload($full) 
    {
        include __DIR__ . '/../' . str_replace('\\', DIRECTORY_SEPARATOR, $full) . '.php';
    }
}
```

```
// the PREFERRED approach (aside from using the Composer autoloader!)

<?php 
include __DIR__ . '/../Generic/Loader.php';
$loader = new \Generic\Loader();

use Generic\Form\Build;
use Generic\Data\ {Data, Special};

$test    = new Build();
$special = new Special($test->buildDays());
$data    = new Data($test->buildMonths());

echo $test->makeSelect($special);
echo '<br>';
echo $test->makeSelect($data);
```


```
<?php
namespace Generic;

class Loader
{
    public function __construct()
    {
        spl_autoload_register([$this, 'autoload']);
    }
    public function autoload($full) 
    {
        require_once __DIR__ . '/../' . str_replace('\\', DIRECTORY_SEPARATOR, $full) . '.php';
    }
}
```

```
// example of needing clone
<?php 
$today = new DateTime();
for ($x = 30; $x < 100; $x += 30) {
    $days[$x] = clone $today;
    $days[$x]->add(new DateInterval("P{$x}D"));
}

echo '<ul>';
foreach ($days as $date) {
    echo '<li>' . $date->format('Y-m-d') . '</li>';
}
echo '</ul>';
echo '<pre>' . var_export($days, TRUE) . '</pre>';
```


### philip
Namespaces
Namespace Exercise

Define namespaces for your classes defined in previous exercises.
Use the namespace of one of your previously defined subclasses in another one of your previously defined subclasses, assign it an alias.
In the subclass where the use statement resides, qualify a call to a method in the used subclass namespace.

```
// BEGIN -------------------------------------------------------------
<?php
/**
 * file: projauto\index.php
 * requires file: projauto\Classes\Location.php
 * Very Simple Namespace & spl_autoload
 * User: philip
 * Date: 2017 08 15
 */

$callback = function ($class) {
    $namespaces = ['Classes' => __DIR__ . '/../', 'Generic' => __DIR__ . '/../'];
    $parts = explode('\\', $class);
    $top   = $parts[0];
    $className = array_pop($parts);
    require $namespaces[$top] . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
};
```

```
spl_autoload_register($callback);
use Classes\Location;
use Generic\Form\Build;

$loc01 = new Location("00001", "29.00", "-98.00");
echo $loc01->getLocation();

$build = new Build();
var_dump($build->buildDays());
```


```
<?php
/**
 * file: projauto\Classes\Location.php
 * requires file: projauto\index.php
 * Very Simple Namespace & spl_autoload
 * User: philip
 * Date: 2017 08 15
 */

namespace Classes;
class Location
{
    public $locationID;
    public $lat;
    public $long;

    public function __construct($locationID, $lat, $long) {
        $this->locationID = $locationID;
        $this->lat = $lat;
        $this->long = $long;
    }

    public function getLocation() {
        return "Location ID : " . $this->locationID . "<br>" . "Lat : " . $this->lat . "<br>" . "Long : " . $this->long;
    }



}


// END ---------------------------------------------------------------
```

### shaleha
Exception Exercise
Add a constructor that accepts parameters.
Call the parent constructor.
Add some new functionality in the constructor
Add a try/catch/catch/finally block in the index.php file.
In the try portion, throw an instance of the Exceptions object, and an instance of your custom exception class.
Handle both in the associated catch blocks.
Log some data in the finally block.

```
// BEGIN -------------------------------------------------------------
<?php
/**
* checks the title length
* checks if pagecount is numeric
* error log  directory my-errors.log
* @param int $pageCount

*/
class BookLibrary
{
  protected $_type;
  protected $_title;

  public function __construct($type, $title )
  {
    $this->_type =$type ;
    $this->_title = $title;
  }
  public function getBookType()
  {
    return $this->_type;
  }
  public function getTitle()
  {
    return $this->_title;
  }
}
```

```
class Book extends BookLibrary
{

  protected $_pageCount;
  public function __construct($type, $title, $pageCount){
     $this->_type =$type ;

     if(!is_numeric($pageCount) ||$pageCount<1) {
       throw new ValueOutOfBoundsException("Page count is not positive");
     }

     $this->_pageCount = (int) $pageCount;

     if(strlen($title) < 4){
       throw new LengthTooShortException("Title too short");
     }

     $this->_title = $title;
  }

  public  function getPageCount(){

    return $this->_pageCount;
  }

}
```

```
class LengthTooShortException extends LengthException
{
}
```

```
class ValueOutOfBoundsException extends Exception
{
}
```

```
echo"<pre>";

//$book = null;

try {
  $book = new Book('Book' , 'PHP Cookbook, 3rd Edition' , -1);
  echo '<p> Book type: ' . $book->getBookType(). ' has  title : ' . $book->getTitle() . ' with ' .$book->getPageCount()  .' pages</p>';
} catch (LengthTooShortException $e) {
  echo $e->getMessage();
} catch (ValueOutOfBoundsException $e) {
  echo $e->getMessage();
} finally {
  error_log("Error message log", 3, "my-errors.log");
}

echo "</pre>";

// END ---------------------------------------------------------------
```



# for Fri 18 Aug 2017
http://collabedit.com/vvec9

### PDO DSN String Syntax

* Driver Specific: look up the driver docs
* Example for IBM DB2 via ODBC: http://php.net/manual/en/ref.pdo-odbc.connection.php
* Example for MySQL: http://php.net/manual/en/ref.pdo-mysql.connection.php


### Everybody
Create a PHP script which displays all rows from the "customers" table off the "course" database using PDO
Use OrderApp::config/config.php to see connection info

### nichole
```
// BEGIN ---------------------------------------------------------------------------------------------------
try {
        $db = new PDO("mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course",'vagrant', 'vagrant', array(PDO::ATTR_PERSISTENT => true));
    }
    catch(Exception $e){
        echo $e->getMessage();
        exit();
    }
    $sql = "SELECT * from customers";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($customers);
// END -----------------------------------------------------------------------------------------------------
```

###shaleha
```
//BEGIN
<?php

$dsn = 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course';

try
{
$db = new PDO($dsn, 'vagrant', 'vagrant');

}
catch (PDOException $e)
{
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

$sql = $db->prepare('SELECT * FROM customers');

$sql->execute();

/* FetchAll*/
print(" FetchAll get all results:\n");
$result = $sql->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($result);
echo "</pre>";
//END----------------------------------------------------------
```

###banu
```
//BEGIN ---------------------------------------------------------------------------------------------------
<?php

try {
    $pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'vagrant', 'vagrant');
    $stmt = $pdo->query('SELECT id, firstname, lastname from customers');
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<pre>";
    print_r($results);
    echo "</pre>";
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $logEntry = time() . '|' . get_class($e) . ':' . $e->getMessage() . PHP_EOL;
    error_log($logEntry, 3, 'error_log.php'); 
}
//END ---------------------------------------------------------------------------------------------------
```

## PHP-II for Mon 21 Aug 2017
http://collabedit.com/nvmpj

## 3rd Party ORM Software
* http://propelorm.org/
* http://doctrine-project.org/

```
// example of fetching an array of User objects
<?php 
class User
{
    // here you would place useful methods
}
try {
    $pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'vagrant', 'vagrant');
    $stmt = $pdo->query('SELECT * FROM customers');
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
    echo "<pre>";
    while ($results = $stmt->fetch()) {
        print_r($results);
    }
    echo "</pre>";
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $logEntry = time() . '|' . get_class($e) . ':' . $e->getMessage() . PHP_EOL;
    error_log($logEntry, 3, 'error_log.php'); 
}

## Web Stuff
* http://php.net/manual/en/ref.sockets.php
* Key Generation: http://php.net/manual/en/function.openssl-pbkdf2.php
* Random Bytes if you don't have PHP 7: http://php.net/manual/en/function.openssl-random-pseudo-bytes.php

```
// example generating a token
<?php 
$bytes = random_bytes(16);
echo base64_encode($bytes);
echo '<br>';
echo bin2hex($bytes);
echo '<br>';

$bytes = openssl_random_pseudo_bytes(16);
echo base64_encode($bytes);
echo '<br>';
echo bin2hex($bytes);
```


## Homework

### charlie
Prepared Statements Exercise
Create a prepared statement script.
Add a try/catch construct.
Add a new customer record binding the customer parameters.

```
// BEGIN ---------------------------------------------------------------------------------------------

<?php
// charlie
define('ERROR_PDO', 'Unable to access data [code 22]');
$dsn = 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course';
$username = 'vagrant';
$password = 'vagrant';

try {
    $pdo = new PDO($dsn, $username, $password);
    $statement = $pdo->prepare('INSERT INTO customers (firstname,lastname) VALUES (:firstname,:lastname)');
    
    $fname = 'Homer';
    $lname = 'Simpson';
    
    $statement->bindParam(':firstname', $fname);
    $statement->bindParam(':lastname', $lname);
    
    //$statement->execute();
    
} catch (PDOException $e) {
    
    echo '<p style="font-family: monospace; background: red; color: white; padding: 20px; font-size: 1.25em;">';
    echo ERROR_PDO;
    echo "</p>";
    
    $now = new DateTime();
    $error_body = $e->getFile() . ' on line ' . $e->getLine() . ': ' . $e->getMessage();
    error_log($now->format('M d Y H:i:s') . " " . $error_body, 3, 'error.log');
}

// END -----------------------------------------------------------------------------------------------
```

### nichole

Stored Procedure Exercise
Create a stored procedure script.
Add the SQL to the database.
Call the stored procedure with parameters.

```
// BEGIN 
-----------------------------------------------------------------------------------------------------
# Uppecase all first and last names that are inserted into the database
DROP PROCEDURE IF EXISTS course.createCustomer;
DELIMITER $
CREATE PROCEDURE course.createCustomer(
    p_firstname varchar(50),
    p_lastname varchar(50))
BEGIN
    insert into customers (firstname, lastname) values (UPPER(p_firstname),UPPER(p_lastname));
    
END
$
DELIMITER ;


// Now try it
try {
    $pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');
        $stmt = $pdo->prepare( 'CALL createCustomer (?,?)' );
        $fname = 'Bart';
        $lname = 'Simpson';
        if ($stmt->execute([$fname, $lname])) {
            echo "New user $fname $lname says "; 
        } 
}
catch(Exception $e){
    echo $e->getMessage();
}
// END -----------------------------------------------------------------------------------------------
```

### philip
```
<?php 
/**
 * file: pBrownTransAction.php
 * Multiple SQL in Transaction
 * User: philip
 * Date: 2017 08 20
 * 
 */
   
<?php 
try {
    $pdo = new PDO("mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course",'vagrant', 'vagrant');
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->beginTransaction();
    
    //Query 1
    $sql = "INSERT INTO customers (firstname, lastname) VALUES (?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['Fred', 'Flintstone']);
    //Query 2
    $stmt->execute(['Wilma', 'Flintstone']);
    
    //Query 3 with Return
    $sql = "SELECT * from customers";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Added <pre>";
    print_r($results);
    echo "</pre><br><br>";
    
    //Query 4 Delete 1
    $sql = "DELETE FROM customers WHERE (firstname, lastname) = (?,?)";
    $stmt = $pdo->prepare($sql);
    //$stmt->execute(['Fred', 'Flintstone']);
    //$stmt->execute(['Wilma', 'Flintstone']);

    // this will cause the program run to fail ... which means Wilma Flintstone is not retained in the db
    $sql = 'This is not an SQL statement';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $pdo->commit();
    
} catch (PDOException $e) {
    
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
    $logEntry = time() . '|' . get_class($e) . ':' . $e->getMessage() . PHP_EOL;
    error_log($logEntry, 3, 'error_log.php');
    
}



$sql = "SELECT * from customers";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Removed <pre>";
print_r($results);
echo "</pre>";
```

## for Wed 23 Aug 2017
http://collabedit.com/agv3r

## Cookies
see: https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php

### Session
see: https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php

### Etag
see: https://github.com/dbierer/classic_php_examples/blob/master/web/etag.php

### Email
see: http://www.postfix.org/

### Composer
see: https://packagist.org/
see: https://getcomposer.org/

### banu
Form Class Exercise
Build a Form class that abstracts form creation.
Create a login form from the Form class.
Write code to validated the login form elements.
Optional: add unique hash
Optional: CAPTCHA
// Unfortunately, I did not have enough time to implement optionals 

// BEGIN ----------------------------------------------------------
//config.php
$config = [
    'form' => [
        'name' => 'loginForm',
        'id' => 'loginForm',
        'method' => 'post',
        'action' => 'index.php',
    ],
    'elements' => [
        'username' => [
            'label' => 'Username: ',
            'type' => 'text',
            'id' => 'username',
            'maxlength' => 10
        ],
        'password' => [
            'label' => 'Password: ',
            'type' => 'password',
            'id' => 'password',
            'maxlength' => 8
        ],
        'login' => [
            'type' => 'submit',
            'name' => 'login',
            'value' => 'Login'
        ],
    ],
    'filters' => [
        'trim' => ['username', 'password'],
        'stripTags' => ['username']
     ],
    'validators' => [
        'minLength8' => ['username', 'password'],
        'alnum' => ['username'],
    ]
];

return $config;

// Form Class
<?php
namespace Classes;

class Form
{
    protected $config;
    protected $output = '';
    protected $messages;
    
    public function __construct(array $config) 
    {
        if (!isset($config['elements'])) {
            throw new Exception('Missing config for form elements');
        }
        if (!isset($config['form'])) {
            throw new Exception('Missing config for form tag');
        }
        
        $this->config = $config;
        $this->addElements($config['elements']);
        $this->addFormTag($config['form']);
    }
    
    public function addElements(array $elements) 
    {
        $html = '';
        foreach ($elements as $name => $element) {
            if (isset($element['label'])) {
                $html .= '<label for = "' . $element['id'] . '">' . $element['label']. '</label>';
            }
            $html .= '<input name = "' . $name .'" ';
            foreach ($element as $attribute => $value) {
                $html .= $attribute . '="' . $value . '" ';
            }
            $html .= '/><br>';
        }
        $this->output .= $html;
    }
    
    public function addFormTag(array $formTag) 
    {
        $html = '<form ';
        foreach ($formTag as $attribute => $value) {
            $html .= $attribute . '="' . $value . '" ';
        }
        $html .= '>';
        $this->output = $html . $this->output . '</form>';
    }
    
    public function __toString()
    {
        return $this->output;
    }
    
    public function validate(array $data) 
    {
        $valid = TRUE;
        if (isset($this->config['filters'])) {
            $filters = $this->config['filters'];
            foreach ($filters as $filter => $elements) {
                foreach ($elements as $element) {
                    if (isset($data[$element])) {
                        $data[$element] = $this->{$filter}($data[$element]);
                    }
                }
            }
        }
        if (isset($this->config['validators'])) {
            $validators = $this->config['validators'];
            foreach ($validators as $validator => $elements) {
                foreach ($elements as $element) {
                    if (isset($data[$element])) {
                        $result = $this->{$validator}($element, $data[$element]);
                        if (!$result) {
                            $valid = FALSE;
                        }
                    }
                }
            }
        }
        return $valid;
    }
    
    public function minLength8($field, $value)
    {
        if (strlen($value) < 8) {
            $this->messages[] = $field . ' should be at least 8 characters!';
            return FALSE;
        }
        return TRUE;
    }
    
    public function alnum($field, $value)
    {
        if (!ctype_alnum($value)) {
            $this->messages[] = $field . ' should be alphanumeric!';
            return FALSE;
        }
        return TRUE;
    }
    
    public function trim($value)
    {
        return trim($value);
    }
    
    public function stripTags($value)
    {
        return strip_tags($value);

    }
    
    public function getMessages()
    {
        return $this->messages;
    }
}

//index.php
<?php

include __DIR__ . '/../Classes/Loader.php';
$loader = new \Classes\Loader();

use Classes\Form;

// Generate form
$config = include __DIR__ . '/../config/config.php';
$loginForm = new Form($config);
echo $loginForm;

// Validate form
$isValid = FALSE;
if (isset($_POST['login'])) {
    $isValid = $loginForm->validate($_POST);
    
    if ($isValid) {
        echo 'Login information is valid';
    } else {
        echo implode('<br>', $loginForm->getMessages());
    }
}

// END ------------------------------------------------------------

### charlie
Cookie Exercise
Write a class and method that sets a cookie for some data.
Write a second method that processes the cookie.

// BEGIN ----------------------------------------------------------

// Too much code for just this spot. See the following
// https://git.psu.edu/cdm32/zend-training-php2/blob/master/public/index.php
// https://git.psu.edu/cdm32/zend-training-php2/blob/master/src/charliemorris/CookieBaker.php
// https://git.psu.edu/cdm32/zend-training-php2/blob/master/src/charliemorris/Database.php

// brief explanation: I setup a tracking cookie to record the resource clicked and display it
// to a user when the user returns to the site

// This is the cookie class
class CookieBaker
{
    public $client_ip;
    protected $cookies = [];

    public function __construct($client_ip)
    {
        $this->client_ip = hash('sha256', $client_ip);
    }
    
    public function bakeCookie($key, $value)
    {
        setcookie("$this->client_ip-$key", $value, time()+60*60*24*3);
        return $this;
    }
    
    public function eatCookie($key)
    {
        if (isset($_COOKIE["$this->client_ip-$key"])) {
            return $_COOKIE["$this->client_ip-$key"];
        } 

    }
}

// END ------------------------------------------------------------

### philip
Session Exercise
Write a index.php file that receives login form post data. Hard code the post data if desired.
Write a model class that interfaces the user database and authenticate the user.

// BEGIN ----------------------------------------------------------
### What a Mis-Mash, No Errors, but Won't Show Success Page - Good Luck
<!-- 
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `users` (`user_id`, 'name', 'email', `username`, `password`) VALUES  
(1, 'Fred', 'fred@flintstones.gone', 'admin', 'admin'); 
-->


<?php

session_start();

define('HOST', 'localhost'); // Database host name ex. localhost
define('USER', 'vagrant'); // Database user. ex. root ( if your on local server)
define('PASSWORD', 'vagrant'); // Database user password  (if password is not set for user then keep it empty )
define('DATABASE', 'course'); // Database Database name

include __DIR__ . '/../Generic/Loader.php';
$loader = new \Generic\Loader();

use Classes\UserLogin;

$app = new UserLogin();

$login_error_message = '';

// check Login request
if (!empty($_POST['btnLogin'])) {
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if ($username == "") {
        $login_error_message = 'Username field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        //echo 'else 2';
        $user_id = $app->Login($username, $password); // check user login
        if($user_id > 0)
        {
            //echo 'session';
            $_SESSION['user_id'] = $user_id; // Set Session
            header('Location: /');
            exit;
        }
        else
        {
            $login_error_message = 'Invalid login details!';
        }
    }
}

?>


<!doctype html>
<head>
    <title>Home</title>
</head>
<body>

 <h2>PHP Session Login</h2>

<?php
  if ($login_error_message != "") {
      echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
  }
?>

  <?php echo (isset($_SESSION['user_id'])) ? 'Already Logged In!' : ''; ?>
  <br>
  <form action="index.php" method="post">
      
      <label for="">Username</label>
      <input type="text" name="username" class="form-control"/>
      <br>
      
      <label for="">Password</label>
      <input type="password" name="password" class="form-control"/>
      <br>
      <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
      
  </form>                              

</body>
</html>

<?php 
namespace Classes;
class UserLogin
{
    protected $db;    
    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD);
        } catch (PDOException $e) {
            return "Error!: " . $e->getMessage();
            die();
        }
    }
    public function Login($username, $password)
    {
        try {
            $query = $this->db->prepare("SELECT user_id FROM users WHERE (username=:username OR email=:username) AND password=:password");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->user_id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }    
}


## for Fri 25 Aug 2017
http://collabedit.com/ubg2g

NOTE TO SELF: use json_encode to encode an array of objects

## Class Discussion
### Passwords
see: http://php.net/manual/en/function.password-hash.php

### SOAP
see: https://github.com/dbierer/classic_php_examples/blob/master/web/soap_client.php

### JSON
<?php
include __DIR__ . '/../Generic/Loader.php';
$loader = new \Generic\Loader();

use Classes\Test;

$test[] = new Test('Marge', 99.99);
$test[] = new Test('Lisa', 88.88);
$test[] = new Test('Crusty the Clown', -99.99);

$string = serialize($test);
echo $string;
$obj = unserialize($string);
echo '<br><pre>' . var_export($obj, TRUE) . '</pre>';
/*
$json = '[';
foreach ($test as $item) {
    $json .= json_encode($item);
    $json .= ',';
}
$json .= substr($json, 0, -1) . ']';
echo $json;
*/

<?php 
namespace Classes;
class Test
{
    protected $name;
    protected $amount;
    public function __construct($name, $amount)
    {
        $this->name = $name;
        $this->amount = $amount;
    }
    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return the $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param field_type $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

}



## Homework

### for Everybody!!!
Install Composer Exercise
Install Composer in the course virtual machine.
Install composer locally. Use the local link for instruction.
Install composer globally . Use the global link for instruction.

### for Everybody!!!
Composer with OrderApp Exercise
Add composer to the OrderApp project.
Edit the composer.json file to match the JSON shown in the Order Application sample in the previous slide.
Execute Composer and install the specified dependencies.

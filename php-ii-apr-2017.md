-----------------------------------------------------------------------------------------------------------------------
# PHP-II CLASS NOTES: April 2017
-----------------------------------------------------------------------------------------------------------------------

Zaid:    30 points
Jake:    25 points
Susan:   25 points
Heather: 20 points

-----------------------------------------------------------------------------------------------------------------------
## ERRATA
-----------------------------------------------------------------------------------------------------------------------
NOTE: page numbers refer to the course PDF
* p. 042:  "accessable" should be "accessible:
* p. 104:  missing "." in catch block.  Should be: 
         echo get_class($e) . ':' . $e->getMessage() . PHP_EOL;
* p. 107:  link shoulb be "http://ph* p.net/manual/en/language.oop5.anonymous.php"
* p. 154:  Description of PDO::FETCH_ASSOC should state:
         "Returns an associative array indexed by column name"
* p. 164:  no space between : and the named param:
         VALUES (:firstname,:lastname )' );
* p. 179:  Description of "TCP" should read: "Transport Control Protocol"
* p. 185:  2nd line of form should be:
         <input type="hidden" name=" csrf_token " value="ajfqei2#2fTdTTI" />
* p. 206:  No space after "$".  4th to the last line of code:
         $etag = $current - $oneWeek;
* p. 248:  Modify the code block as follows:
         Add this:
         $url = 'http://maps.googleapis.com/maps/api/geocode/xml?address=350+5th+Avenue+New+York,+NY&sensor=false';
         before this line:
         $xml = file_get_contents($url);
* p. 267:  Last bullet should read:
         \Z: Absolute end

// to get PHP hints from Zend Studio:
// place the following XML into a file ".buildpath" 
// at the root of sandbox and orderapp project folders
```
<?xml version="1.0" encoding="UTF-8"?>
<buildpath>
    <buildpathentry kind="con" path="org.eclipse.php.core.LANGUAGE"/>
    <buildpathentry kind="src" path=""/>
    <buildpathentry kind="con" path="org.zend.php.framework.CONTAINER"/>
    <buildpathentry kind="con" path="com.zend.php.phpunit.CONTAINER"/>
</buildpath>
```

TO INSTALL SOAP in VM:
```
sudo apt-get update
// installs on the command line:
sudo apt-get install php-soap --fix-missing
// to get it running on the web server:
sudo service apache2 restart
```

-----------------------------------------------------------------------------------------------------------------------
## Wed 5 Apr 2017
-----------------------------------------------------------------------------------------------------------------------
[http://collabedit.com/xq7n9](http://collabedit.com/xq7n9)

Q: Can you use reserved names if you also use namespaces?
A: No: does not work!

```
// Class Examples
<?php

class RGB {
    private $r = 0;
    private $g = 0;
    private $b = 0;
    
    public function __construct($r, $g, $b) {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }
    
    public function __toString() {
        return sprintf('#%02x%02x%02x', $this->r, $this->g, $this->b);
    }
}

class Color {
    private $_rgb;
    private $_name = "";
    
    public function __construct($name = null, $r = null, $g = null, $b = null) {
        $this->setName($name);
        $this->setRGB($r, $g, $b);
    }
    
    public function __toString() {
        $output = $this->_name . ":" . PHP_EOL;
        $output .= $this->_rgb;
        $output .= PHP_EOL;
        return $output;
    }
    
    public function setName($myName) {
        $this->_name = $myName;
    }
    
    public function setRGB($r, $g, $b) {
        $this->_rgb = new RGB($r, $g, $b);
    }
    public function red()
    {
        $this->setName('red');
        $this->setRGB(255,0,0);
        return $this->_rgb;
    }
    public function blue()
    {
        $this->setName('blue');
        $this->setRGB(0,0,255);
        return $this->_rgb;
    }
    public function green()
    {
        $this->setName('green');
        $this->setRGB(0,255,0);
        return $this->_rgb;
    }
}

$rgb = new Color();
echo '<span style="color:' . $rgb->red() . '">RED TEST</span>';
echo '<span style="color:' . $rgb->green() . '">GREEN TEST</span>';
echo '<span style="color:' . $rgb->blue() . '">BLUE TEST</span>';
```

```
<?php

class Test
{
    public function doIt(callable $callback, array $params)
    {
        return $callback($params);
    }
}

$test = new Test();
$add = function ($p) { return $p[0] + $p[1]; };
$sub = function ($p) { return $p[0] - $p[1]; };
$mul = function ($p) { return $p[0] * $p[1]; };

echo $test->doIt($add, [3, 4]);
echo PHP_EOL;

echo $test->doIt($sub, [3, 4]);
echo PHP_EOL;

echo $test->doIt($mul, [3, 4]);
echo PHP_EOL;
```

-----------------------------------------------------------------------------------------------------------------------
## Fri 7 Apr 2017
-----------------------------------------------------------------------------------------------------------------------

[http://collabedit.com/5wy56](http://collabedit.com/5wy56)

// Homework for Monday
// Magic Methods Exercise == Susan
// Abstract Class Exercise == Zaid
// Interface Exercise == Heather
// Type Hint Exercise == Jake

```
// class examples
<?php

class Test
{
    public function doIt(callable $callback, array $params)
    {
        return $callback($params);
    }
}

$test = new Test();
$add = function ($p) { return $p[0] + $p[1]; };
$sub = function ($p) { return $p[0] - $p[1]; };
$mul = function ($p) { return $p[0] * $p[1]; };

echo $test->doIt($add, [3, 4]);
echo PHP_EOL;

echo $test->doIt($sub, [3, 4]);
echo PHP_EOL;

echo $test->doIt($mul, [3, 4]);
echo PHP_EOL;
```


```
<?php

class Test
{
    /*
    protected $firstName;
    protected $lastName;
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setFirstName($n)
    {
        $this->firstName = $n;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName($n)
    {
        $this->lastName = $n;
    }
    public function init($params)
    {
        $this->firstName = $params[0];
        $this->lastName = $params[1];
    }
    public function __call($name, $params)
    {
        return 'You tried to call undefined method: ' . $name;
    }
    */
    protected $values;
    public function init($params)
    {
        $this->values['FirstName'] = $params[0];
        $this->values['LastName'] = $params[1];
    }
    public function __call($name, $params)
    {
        if (strpos($name, 'set') === 0) {
            $this->values[substr($name, 3)] = $params[0];
        } elseif (strpos($name, 'get') === 0) {
            $key = substr($name, 3);
            return (isset($this->values[$key])) ? $this->values[$key] : NULL;
        }
    }
    public function __set($name, $value)
    {
        echo 'SET';
        echo PHP_EOL;
        $this->values[$name] = $value;
    }
    public function __get($name)
    {
        echo 'GET';
        echo PHP_EOL;
        return (isset($this->values[$name])) ? $this->values[$name] : NULL;
    }
}

$test = new Test();
$test->init(['Fred', 'Flintstone']);
echo $test->getFirstName() . ' ' . $test->getLastName();

echo PHP_EOL;
$test->xyz = 'ABC';
echo $test->xyz;
```


// from Heather

```
<?php

class Member
{
    const TABLE = 'member';
    public $firstname;
    public $lastname;
    public $screenname;
     
    public function __construct($firstname, $lastname, $screenname) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->screenname = $screenname;
    }
    
    public function getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }
    
    
}
    $member1 = new Member ('Mason', 'Felice', 'Mason100');
    $member2 = new Member ('Reed', 'Nelson', 'Rnelson');
    $member3 = new Member ('Harmony', 'Trudle', 'HarmonyT');
    
    echo $member1->getFullName();
    
<?php

class Teacher extends Member {
    public $email;
    public $teacherID;
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getTeacherId() {
        return $this->teacherID;
    }

    public function __construct ($firstname, $lastname, $screenname, $email, $teacherID) {
        parent::__construct($firstname, $lastname, $screenname);
        $this->email = $email;
        $this->teacherID = $teacherID;
    }
}

$teacher1 = new Teacher ('Felicia', 'Natel', 'fNatel100', 'fNatel100@gmail.com', 50);
$teacher2 = new Teacher ('Autumn', 'Dull', 'ADull', 'ADull@whoknows.com', 51);
$teacher3 = new Teacher ('Troy', 'Parfit', 'Tparfit', 'TParfit@yahoo.com', 52);

echo $teacher1->getFullName();
```



-----------------------------------------------------------------------------------------------------------------------
## Mon 10 Apr 2017
-----------------------------------------------------------------------------------------------------------------------
[http://collabedit.com/q7y59](http://collabedit.com/q7y59)

// Homework for Weds

// Traits Lab == Heather
// Namespace lab == Jake

```
// class examples
<?php
/*
 * Assumes you have a subdirectories ./A and ./A/X
 * and a file ./A/X/Test.php as follows:
 
namespace A\X;

class Test {
    public $name = 'X';
}

 */
//function __autoload($className)
function myAutoloader($className)
{
    $classFile = __DIR__ . DIRECTORY_SEPARATOR . str_ireplace('\\', DIRECTORY_SEPARATOR, $className) . '.php'; 
    echo $className . ':' . $classFile . PHP_EOL;
    require_once $classFile;
}
spl_autoload_register('myAutoLoader');

use A\X\ { Test, Whatever};
$a = new Test();
$b = new Whatever();
echo $a->getName();
echo PHP_EOL;
echo $b->abc;
echo PHP_EOL;
echo serialize($a);
```

```
<?php

class User
{
    public $firstName;
    public $lastName;
    public function setFirstName($name) {
        $this->firstName = $name;
        return $this;
    }
    public function setLastName($name) {
        $this->lastName = $name;
        return $this;
    }

}

//require 'User.php';
$user1 = new User();
$user1->setFirstName('Fred')->setLastName('Flintstone');
// $user2 is now a "backup" with the original values

$user2 = clone $user1;
var_dump($user1, $user2);
// $user1 can now be modified with desired values

$user1->setFirstName('Julia')->setLastName('Roberts');
var_dump($user1, $user2);


// assign by reference 
$user1 = new User();
$user1->setFirstName('Fred')->setLastName('Flintstone');
// $user2 is now a "backup" with the original values

$user2 = $user1;
var_dump($user1, $user2);
// $user1 can now be modified with desired values

$user1->setFirstName('Julia')->setLastName('Roberts');
var_dump($user1, $user2);
```

// Homework for Monday

```
// Abstract Class Exercise == Zaid
<?php 

abstract class Counter 
{

    public static $counter = 0;
    public static function count_counter($counter = NULL)
    {
        self::$counter = $counter ?? ++self::$counter;
        return self::$counter;
    }
}

abstract class Book 
{
    public abstract function whatsMyLine();
}

class GenericBook extends Book 
{

    public function whatsMyLine() {
        $number = Counter::count_counter();
        return "This is the book number $number from the method " . __METHOD__;
    }

}

$a = new GenericBook();
$b = new GenericBook();
echo $a->whatsMyLine();
echo "<br>";
echo $b->whatsMyLine();
```

----------------------------------------- End Zaid


// Magic Methods Exercise == Susan

```
<?php 
class LitItem
{
    protected $values;     // array of properties
    
    // initialize class
    public function init($params)
    {
        $this->values['title']     = $params[0];
        $this->values['author']    = $params[1];
        $this->values['type']      = $params[2];
        $this->values['isbn13']    = $params[3];
        $this->values['copyright'] = $params[4];
    }
    
    // check first 3 characters of method called for set  
    // or get
    public function __call($name, $params)
    {
        if (strpos($name, 'set') === 0) {
            $this->values[substr($name, 3)] = $params[0];
        } elseif (strpos($name, 'get') === 0) {
            $key = substr($name, 3);
            return (isset($this->values[$key])) ? $this->values[$key] : NULL;
        }  // else error?
    }
    
    public function __set($name, $value)
    {
        echo 'SET method';
        echo PHP_EOL;
        $this->values[$name] = $value;
    }
    public function __get($name)
    {
        echo 'GET method';
        echo PHP_EOL;
        echo $this->values[$name];
        return (isset($this->values[$name])) ? $this->values[$name] : NULL;
    }
}

$book = new LitItem();
$book->init(['One Fish Two Fish Red Fish Blue Fish', 'Dr. Suess', 'childrens', 'aaabbb111222cccddd333444', '1950']);

echo $book->getTitle();
echo '<br>';
echo $book->author;
echo '<br>';
$book->CheckedOut = date('Y-m-d');
echo $book->CheckedOut;
echo '<br>';
echo $book->getCheckedOut();
```


// Type Hint Exercise == Jake

```
class Color 
{
    private $_rgb;
    private $_name = "";
    
    public function __construct(String $name, int $r, int $g, int $b) {
        $this->setName($name);
        $this->setRGB($r, $g, $b);
    }
}

$color = new Color("Red", 255, 0, 0);
```


// Interface Exercise == Heather

```
<?php 
interface TeacherInterface
{
    public function getLoginTime(); //get time of login
    public function setLoginTime(); //set time in db
}
```



//

```
class Member implements TeacherInterface
{
    const TABLE = 'member';
    public $loginDateTime;
    public $firstname;
    public $lastname;
    public $screenname;

    public function __construct($firstname, $lastname, $screenname) 
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->screenname = $screenname;
        $this->setLoginTime();
    }
    
    public function setLoginTime() 
    {
        $this->loginDateTime = new DateTime('NOW');
        return $this;
    }

    public function getLoginTime() 
    {
        return $this->loginDateTime;
    }

    public function getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }
    
}

$member1 = new Member ('Mason', 'Felice', 'Mason100');
$member2 = new Member ('Reed', 'Nelson', 'Rnelson');
$member3 = new Member ('Harmony', 'Trudle', 'HarmonyT');

$member1->setLoginTime();
echo $member1->getFullName();
echo '<br>';
echo $member1->getLoginTime()->format('Y-m-d H:i:s');
```



-----------------------------------------------------------------------------------------------------------------------
## Wed 12 Apr 2017
-----------------------------------------------------------------------------------------------------------------------
[http://collabedit.com/f5wua](http://collabedit.com/f5wua)

// Homework for Weds

// Traits Lab == Heather

```
<?php 
interface TeacherInterface
{
    public function getLoginTime(); //get time of login
    public function setLoginTime(); //set time in db
}

trait LoginTimeTrait
{
    protected $loginDateTime;
    public function setLoginTime()
    {
        $this->loginDateTime = new DateTime('NOW');
        return $this;
    }    
    public function getLoginTime()
    {
        return $this->loginDateTime;
    }
}
```

```
<?php 
class Member implements TeacherInterface
{
    use LoginTimeTrait;
    const TABLE = 'member';
    public $firstname;
    public $lastname;
    public $screenname;

    public function __construct($firstname, $lastname, $screenname) 
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->screenname = $screenname;
        $this->setLoginTime();
    }
    
    public function getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }
    
}

$member1 = new Member ('Mason', 'Felice', 'Mason100');
$member2 = new Member ('Reed', 'Nelson', 'Rnelson');
$member3 = new Member ('Harmony', 'Trudle', 'HarmonyT');

$member1->setLoginTime();
echo $member1->getFullName();
echo '<br>';
echo $member1->getLoginTime()->format('Y-m-d H:i:s');
```


// Namespace Lab == Jake

[https://github.com/jakefinkel/PrintManager](https://github.com/jakefinkel/PrintManager)

```
wget -O - https://raw.github.com/jakefinkel/PrintManager/master/install | sh
```

// Exceptions Lab == Susan


// Susan - Exceptions exercise
// parent class

```
<?php 
class LitItem
{
    protected $values;     // array of properties
    
    // initialize class
    public function __construct($itemTitle, $itemAuth, $itemType, $itemIsbn13, $itemDate)
    {
        $this->values['Title']     = $itemTitle;
        $this->values['author']    = $itemAuth;
        $this->values['type']      = $itemType;
        $this->values['isbn13']    = $itemIsbn13;
        $this->values['copyright'] = $itemDate;
    }
    
    // check first 3 characters of method called for set  
    // or get
    public function __call($name, $params)
    {
        if (strpos($name, 'set') === 0) {
            $this->values[substr($name, 3)] = $params[0];
        } elseif (strpos($name, 'get') === 0) {
            $key = substr($name, 3);
            return (isset($this->values[$key])) ? $this->values[$key] : NULL;
        }  // else error?
    }
    
    public function __set($name, $value)
    {
        echo 'SET method';
        echo PHP_EOL;
        $this->values[$name] = $value;
    }
    public function __get($name)
    {
        echo 'GET method';
        echo PHP_EOL;
        echo $this->values[$name];
        return (isset($this->values[$name])) ? $this->values[$name] : NULL;
    }
}
```
// ------  child class

```
<?php 
include_once 'LitItem.php';

class Book extends LitItem
{
  const ERROR_NON_ZERO_PAGE = 'Pages must be a non-zero integer value';
  const TABLE = 'books';
  const MAX_LOAN_LENGTH = 21;  // MAX NUMBER OF DAYS EACH LOAN, 0 IF NOT LOANABLE
  public $genre;               // comedy, drama, romance, documentary
  public $subject;
  public $topicKeys;           // array used to search maybe
  public $isbn13;              // 13 digits, could be broken down into parts if needed
  public $isbn10 = null;
  public $copyNum;             // seq ## for duplicate copies
  public $publisher;
  public $pages;               // must have a least 1 page?
  public $discipline;          // examples: history, politics, law, science, music
  public $format;              // paper, hard, ebook
  public $edition = ''; 
  
  private $price;
  private $loanable = 'Y';     // available for checkout  
  private $available = 'Y';
  private $holderID = '';      // patron who borrowed
  private $dateLoaned;
  private $dueDate;
  
  public function __construct($title, $author, $type, $isbn13, $copyright, $pages, $format) {
    parent::__construct($title, $author, $type, $isbn13, $copyright); 
    $this->title     = $title;
    $this->author    = $author;
    $this->type      = $type;    // book
    $this->copyright = $copyright;
    $this->isbn13    = $isbn13;
    $this->pages     = (int) $pages;
    if ($this->pages <= 0) {
        throw new Exception(self::ERROR_NON_ZERO_PAGE);
    }
    $this->loanable  = 'Y'; 
    $this->available = 'Y';     // when constructed, always starts at available
  }
  public function checkOut($patronId) {
    $this->available = 'N';
    $this->holderID  = $patronId;
  }
  public function checkIn($patronId) {
    $this->available = 'N';
    $this->holderID  = $patronId;
  }

}
```
//------- index.php file

```
<?php
include 'Book.php';

try {
    $myBook[] = new Book('Get Over Your Self', 'Romi Neustadt', 'self help', '978-0-9979482-1-9', 2012, 999, 'paper');
    $myBook[] = new Book('Really Get Over Your Self', 'Romi Neustadt', 'self help', '978-0-9979482-1-9', 2012, 99, 'paper');
    $myBook[] = new Book('Did You Really Get Over Your Self?', 'Romi Neustadt', 'self help', '978-0-9979482-1-9', 2012, 'less than a page', 'paper');
    foreach($myBook as $thisBook) {
       echo ($thisBook->title . '  by ' . $thisBook->author . '<br>');
       echo PHP_EOL;
    }
} catch(Exception $e) {
    echo $e->getMessage();
    echo PHP_EOL;
    error_log($e->getMessage(), 3, 'books_error_log.php');
} finally {
    file_put_contents('access.log', 'bookbs Access Attempted: ' .
    date('Y-m-d H:i:s'), FILE_APPEND);
}
```


// ------- end Susan ----------

-----------------------------------------------------------------------------------------------------------------------
## PHP-II Fri 14 Apr 2017
-----------------------------------------------------------------------------------------------------------------------
[http://collabedit.com/pnvtg](http://collabedit.com/pnvtg)

// examples
```
<?php

// Get the connection instance
$pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');

// Execute a one-off SQL statement and get a statement object
$stmt = $pdo->query('SELECT * FROM orders o JOIN customers c ON c.id = o.customer');

// Get a result set from the statement object
while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
    $date = new DateTime();
    $date->setTimestamp($result->date);
    echo $result->id . ':' . $date->format('Y-m-d H:i:s') 
        . ':' .$result->firstname . ' ' . $result->lastname .  '<br>';
}
```

// Heather
Prepared Statements Exercise
Create a prepared statement script.
Add a try/catch construct.
Add a new customer record binding the customer parameters.

// Susan
Stored Procedure Exercise
Create a stored procedure script.
Add the SQL to the database.
Call the stored procedure with parameters.

// Zaid
Transaction Exercise
Create a transaction script.
Execute two SQL statements.
Handle any exceptions.

```
try {
    // Get the connection instance
    $pdo = new PDO('mysql:host=localhost;dbname=course','vagrant','vagrant');

    // Set error mode attribute
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin the transaction
    $pdo->beginTransaction();

    // Series of SQL statements, all of which have to succeed

    // Commit success
    $pdo->commit();
} catch (PDOException $e ){
    $pdo->rollBack(); // Rollback in case of failure
    // log and communicate error
}
```

// example of form
```
<form method="post">
First Name: <input type="text" name="first" />
<br />
Last Name: <input type="text" name="last" />
<br />
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
```

-----------------------------------------------------------------------------------------------------------------------
## PHP-II Fri 14 Apr 2017
-----------------------------------------------------------------------------------------------------------------------
[http://collabedit.com/pnvtg](http://collabedit.com/pnvtg)

// to get PHP hints from Zend Studio:
// place the following XML into a file ".buildpath" 
// at the root of sandbox and orderapp project folders
```
<?xml version="1.0" encoding="UTF-8"?>
<buildpath>
    <buildpathentry kind="con" path="org.eclipse.php.core.LANGUAGE"/>
    <buildpathentry kind="src" path=""/>
    <buildpathentry kind="con" path="org.zend.php.framework.CONTAINER"/>
    <buildpathentry kind="con" path="com.zend.php.phpunit.CONTAINER"/>
</buildpath>
```

// examples
```
<?php

// Get the connection instance
$pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');

// Execute a one-off SQL statement and get a statement object
$stmt = $pdo->query('SELECT * FROM orders o JOIN customers c ON c.id = o.customer');

// Get a result set from the statement object
while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
    $date = new DateTime();
    $date->setTimestamp($result->date);
    echo $result->id . ':' . $date->format('Y-m-d H:i:s') 
        . ':' .$result->firstname . ' ' . $result->lastname .  '<br>';
}
```

// Heather
Prepared Statements Exercise
Create a prepared statement script.
Add a try/catch construct.
Add a new customer record binding the customer parameters.

```
<?php


try {
    $pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');
    
    $stmt = $pdo->prepare('INSERT INTO customers (firstname, lastname)
        VALUES (:firstname, :lastname )');
    
    $fname = 'Tara';
    $lname = 'Woiderski';
    
    $stmt->bindParam(':firstname', $fname);
    $stmt->bindParam(':lastname', $lname);
    
    $stmt->execute();
    
    // test results
    echo 'Rows Affected: ' . $stmt->rowCount();

} catch (PDOException $e){
    echo $e;
}
```

// Susan
Stored Procedure Exercise
Create a stored procedure script.
Add the SQL to the database.
Call the stored procedure with parameters.

// NOTE: this was written for Oracle, and probably has to be rewritten for MySQL
```
DELIMITER $
CREATE OR REPLACE PROCEDURE course.newOrder(
 p_id,
 p_stat,
 p_amount,
 p_desc,
 p_cust_id)
BEGIN
  v_cust_match := 0;
  
  IF p_cust_id > 0 THEN
    SELECT COUNT(*)
      INTO v_cust_match
      FROM CUSTOMERS
    WHERE AND ID = p_cust_id;

  IF v_cust_match = 0 THEN
     dbms_output.put_line('ERROR - NO SUCH CUSTOMER');
  ELSE
    IF p_desc IS NULL THEN
       dbms_output.put_line('ERROR - DESCRIPTON IS MISSING')
    ELSE
       IF p_stat IS NULL THEN
          dbms_output.put_line('ERROR - STATUS IS MISSING');
       ELSE
         IF p_amount > 0 THEN
            INSERT INTO orders (id,
                                date,
                                status,
                                amount,
                                description,
                                customer)
                        VALUES (p_id,
                                SYSDATE,
                                p_stat,
                                p_amount,
                                p_desc,
                                p_cust_id);
         END IF;
       END IF;
     END IF;
   END IF;
EXCEPTION
  WHEN OTHERS THEN
    dbms_output.put_line('ERROR: '|| SQLCODE || ' ' || SQLERRM);
END
$
DELIMITER ;
```

// example from sandbox/public/ModDB:
```
<?php
// Execute the storedProc.sql at the mysql> command line first, then run the below.

// Get the connection instance
$pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');

// Set error mode attribute
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare an SQL statement and get a statement object
$stmt = $pdo->prepare('CALL newCustomer(?,?)');

// Hard coded input parameters
$fname = 'Mark';
$lname = 'Watney';

// Execute the SQL statement
if($stmt->execute([$fname, $lname])){
    echo "New user $fname $lname added";
}
```


// Zaid
Transaction Exercise
Create a transaction script.
Execute two SQL statements.
Handle any exceptions.

```
try {
    // Get the connection instance
    $pdo = new PDO('mysql:host=localhost;dbname=course','vagrant','vagrant');

    // Set error mode attribute
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin the transaction
    $pdo->beginTransaction();

    // Series of SQL statements, all of which have to succeed

    // Commit success
    $pdo->commit();
} catch (PDOException $e ){
    $pdo->rollBack(); // Rollback in case of failure
    // log and communicate error
}
```

// example of form
```
<form method="post">
First Name: <input type="text" name="first" />
<br />
Last Name: <input type="text" name="last" />
<br />
<input type="submit" />
</form>
<?php phpinfo(INFO_VARIABLES); ?>
```


Zaid Transaction ------

Begin // I hoop i did something right..

```
<?php
// Execute the storedProc.sql at the mysql> command line first, then run the below.

$data = [
    ['Test', '777777'],
    ['Test', '888888'],
    ['Test', '999999'],
    //['This is not going to work'],
];

try {
    // Get the connection instance
    $pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');
    
    // Set error mode attribute
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->beginTransaction();   
    
    // prepare once
    $stmt = $pdo->prepare('INSERT INTO customers (firstname, lastname) VALUES (:firstname, :lastname)');
    
    // execute multiple times
    foreach ($data as list($first,$last)) {
        $stmt->bindParam(':firstname', $first);
        $stmt->bindParam(':lastname', $last);
        $stmt->execute();
    }
    $pdo->commit();
    
} catch (PDOException $e) {
    $pdo->rollBack();
    // normally you log the exceptions
    // for demo purposes we echo the message
    echo $e->getMessage();
}
```


End Zaid ---------------------------------------


// HOMEWORK for Weds

// Heather
Form Class Exercise
Build a Form class that abstracts form creation.
Create a login form from the Form class.
Write code to validated the login form elements.

// Jake
Registration Form
i.e. check for password strength etc.


// Susan
Cookie Exercise
Write a class and method that sets a cookie for some data.
Write a second method that processes the cookie.

// Zaid
Session Exercise
Write a index.php file that receives login form post data. Hard code the post data if desired.
Write a model class that interfaces the user database and authenticate the user.


-----------------------------------------------------------------------------------------------------------------------
## Wed 19 Apr 2017
-----------------------------------------------------------------------------------------------------------------------

// to get PHP hints from Zend Studio:
// place the following XML into a file ".buildpath" 
// at the root of sandbox and orderapp project folders
```
<?xml version="1.0" encoding="UTF-8"?>
<buildpath>
    <buildpathentry kind="con" path="org.eclipse.php.core.LANGUAGE"/>
    <buildpathentry kind="src" path=""/>
    <buildpathentry kind="con" path="org.zend.php.framework.CONTAINER"/>
    <buildpathentry kind="con" path="com.zend.php.phpunit.CONTAINER"/>
</buildpath>
```

// HOMEWORK for Weds

// Heather
Form Class Exercise
Build a Form class that abstracts form creation.
Create a login form from the Form class.
Write code to validated the login form elements.


//not at all complete
```
<?php
class MyForm
{
    protected $output = '';
    public function __construct(array $config)
    {
        if (!isset($config['form'])) {
            throw new Exception('Missing FORM config');
        }
        if (!isset($config['elements'])) {
            throw new Exception('Missing ELEMENT config');
        }
        $this->addElements($config['elements']);
        $this->formTag($config['form']);
    }
    public function addElements(array $config)
    {
        foreach ($config as $element) {
            $this->output .= '<br>';
            if (isset($element['label'])) {
                 $this->output .= $element['label'] . ' '; 
            }
            $this->output .= '<input ';
            foreach ($element as $attrib => $value) {
                $this->output .= $attrib . '="' . $value . '" ';
            }
            $this->output .= '/>';
        }
    }
    public function formTag(array $config)
    {
        $formTag = '<form ';
        foreach ($config as $attrib => $value) {
            $formTag .= $attrib . '="' . $value . '" ';
        }
        $formTag .= '>';
        $this->output = $formTag . $this->output . '</form>';
    }
    public function __toString()
    {
        return $this->output;
    }
}

$config = [
    'form' => [
        'name' => 'MyForm',
        'id' => 'form1',
        'method' => 'post',
        'action' => 'index.php',
    ],
    'elements' => [
        [
            'name' => 'firstName',
            'type' => 'text',
            'label' => 'First Name:',
        ],
        [
            'name' => 'lastName',
            'type' => 'text',
            'label' => 'Last Name:',
        ],
        [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email:',
        ],
        [
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Submit',
        ]
    ]
];

$form = new MyForm($config);
echo $form;
```


// Jake
Registration Form
i.e. check for password strength etc.
[https://github.com/jakefinkel/PrintManager](https://github.com/jakefinkel/PrintManager)


// Susan
Cookie Exercise
Write a class and method that sets a cookie for some data.
Write a second method that processes the cookie.


```
<?php

class CookieSetter
{
    public $cookieName;
    public $lastLogin;
    
    //  store this login time in cookie, to expire in 90 days for entire domain
    public function __construct($username) {
        $this->cookieName = $username;
        $this->lastLogin  = time();
        setcookie($this->cookieName, $this->lastLogin, time()+60*60*24*90, '/');
    }
}
```

// index.php
```
<?php
include 'CookieSetter.php';

if (isset($_COOKIE['fred'])) {
    $date = new DateTime();
    $date->setTimestamp($_COOKIE['fred']);
    echo 'Cookie is Already Set';
    echo '<br>Last Login: ' . $date->format('Y-m-d H:i:s');
} else {
    $setter = new CookieSetter('fred');
    echo 'Cookie is Now Set';
}
```



// Zaid
Session Exercise
Write a index.php file that receives login form post data. Hard code the post data if desired.
Write a model class that interfaces the user database and authenticate the user.


// Zaid  Begin -------

```
CREATE DATABASE `dblogin` ;
CREATE TABLE `dblogin`.`users` (
   `user_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `user_name` VARCHAR( 255 ) NOT NULL ,
     `user_pass` VARCHAR( 255 ) NOT NULL ,
    UNIQUE (`user_name`),
  ) ENGINE = MYISAM ;
```


```
<?php

session_start();

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "dblogin";

try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}


include_once 'class.user.php';
$user = new USER($DB_con);
```

Zaid End ------------------------------------------------------------------

* Create a users database and make sure you have a couple of sample users + passwords
* In index.php: use the MyForm class to present a login form with form action == 'login.php'
* In login.php: 
   *  Start the session
   *  Check $_POST for username + password + perform validation / sanitization!!! 
   *  Do database lookup on username
   *  Confirm that there is a match for username + password
   *  If there is a match: set $_SESSION variables + present welcome message with username
   *  If there is no match: (gently) give a POLITE message and maybe login again
   *  Log any fake entries (i.e. using error_log()) 

-----------------------------------------------------------------------------------------------------------------------
## Fri 21 Apr 2017
-----------------------------------------------------------------------------------------------------------------------
[http://collabedit.com/rapb7](http://collabedit.com/rapb7)

Install Composer Exercise
Install Composer in the course virtual machine.
Install composer locally. Use the local link for instruction.
Install composer globally . Use the global link for instruction.
https://getcomposer.org/

Install the "Guzzle" Http Client
[https://packagist.org/packages/guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle)

TO INSTALL SOAP in VM:
```
sudo apt-get update
// installs on the command line:
sudo apt-get install php-soap --fix-missing
// to get it running on the web server:
sudo service apache2 restart
```


// examples
```
<?php
// Make a request for JSON
$type = 'json';
$url = "http://maps.googleapis.com/maps/api/geocode/$type?address=350+5th+Avenue+New+York,+NY&sensor=false";
$json = file_get_contents($url);

// Decode into a standard class object
$resultsObj = json_decode($json);

// Decode into an array
$resultsArr = json_decode($json, true);

var_dump($resultsArr);

// Make a request for XML
$type = 'xml';
$url = "http://maps.googleapis.com/maps/api/geocode/$type?address=350+5th+Avenue+New+York,+NY&sensor=false";
$xml = file_get_contents($url);

// Load a SimpleXmlElement object
$smplxml = simplexml_load_string($xml);

// Output something
echo $smplxml->asXml();
```

// examples
```
<?php
$string = '<h1>TEST</h1><hr><p><ul><li>Apple</li><li>Banana</li><li>Cherry</li></ul></p>';
$pattern = '/<li>(.*?)<\/li>/i';

echo (preg_match_all($pattern, $string, $matches)) ? 'MATCH' : 'NO MATCH';
echo PHP_EOL;
var_dump($matches);
```

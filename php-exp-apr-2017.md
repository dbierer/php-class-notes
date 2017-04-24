-----------------------------------------------------------------------------------------------------------------------
# PHP for Experienced Programmers CLASS NOTES: April 2017
-----------------------------------------------------------------------------------------------------------------------

NOTE to Susie: get corrected version of PDF to students

-----------------------------------------------------------------------------------------------------------------------
## PHP for Experienced Programmers CLASS NOTES: April 2017
-----------------------------------------------------------------------------------------------------------------------
NOTE: page numbers refer to the course PDF
http://localhost:8080/#/3/8: s/be sat and sun for keys
http://localhost:8080/#/3/14: M3Ex6 out of order
http://localhost:8080/#/5/14: lots of redundant material
http://localhost:8080/#/10/12: s/be $pdo->lastInsertId();
http://localhost:8080/#/10/18: s/be first and last
http://localhost:8080/#/9/17: parent ::
http://localhost:8080/#/9/27: don't define code in abstract methods!
http://localhost:8080/#/12/8: example should match XML example previous
http://localhost:8080/#/12/16: need to swap "xml" for "json" in URL for 2nd example to work
http://localhost:8080/#/13/1: no discussion of ? * or +
http://localhost:8080/#/13/1: link s/be: http://php.net/manual/en/book.pcre.php
http://localhost:8080/#/13/4: middle pattern s/be: /<p>(.*?)<\/p>/
http://localhost:8080/#/13/5: \Z	Absolute end
http://localhost:8080/#/13/10: 2nd should be does NOT contain alpha chars
http://localhost:8080/#/13/13: need to escape inner "\"
Move Composer in front of web services section + make it not optional
Suggest to Cal this class to to 2.5 hours

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

INSTALL PHP SOAP IN VM:
```
sudo apt-get update
sudo apt-get install php-soap
sudo service apache2 restart
```

-----------------------------------------------------------------------------------------------------------------------
## http://collabedit.com/6wwe5
-----------------------------------------------------------------------------------------------------------------------

// PHP for Exp Programmers

// Homework for Wed 12 Apr 2017

// Robert
M2Ex6: Exercise
Create a multi-dimensional array to hold the cards and numbers indicated below. Be as code efficient as you can.
Use colors as the primary array key
Output one color and card number

(red, blue, green, yellow)
(1, 2, 3, 4)

// Sumitha
M2Ex3: Exercise
Declare an array that contains the following sentence with one word in each array element: Programming in PHP is fun!
Then, output the third element.

// Leslie
```
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 
         'Friday', 'Saturday', 'Sunday'];
$months = [ 'January'   => $days,
            'February'  => $days,
            'March'     => $days,
            'April'     => $days,
            'May'       => $days,
            'June'      => $days,
            'July'      => $days,
            'August'    => $days,
            'September' => $days,
            'October'   => $days,
            'November'  => $days,
            'December'  => $days
];
```

```
<?php
$status = $_GET['status'] ?? $_POST['status'] ?? 'DEFAULT';
$status = strip_tags($status);
echo '<pre>';
echo 'Your Status is: ' . htmlspecialchars($status);
echo '</pre>';
```

// Robert
M3Ex1: Exercise
What is the output from each if/else construct?

```
$valueA = "50";
$valueB = 50;

if ( $valueA == $valueB ) {
    echo "Equal <br>";
} else {
    echo "Not equal <br>";
}

if ( $valueA === $valueB ) {
    echo "Identical <br>";
} else {
    echo "Not identical <br>";
}
```


// Sumitha
M3Ex2: Exercise
Assume that people work in an office from Monday through Friday, and are off work on Saturday and Sunday.

Add an elseif clause to handle the response if the day is either Saturday or Sunday

Now try the same thing using switch

$dayOfWeek = "Monday";

```
if ( $dayOfWeek === "Friday" ) {
    echo "See you on Monday";
} else {
    echo "See you tomorrow";
}
```


// Leslie
M3Ex3: Exercise
What is the output?

```
$i = 6;

while ( $i > 0 ) {
    if ( $i === 4 ) break;
        echo "You only have $i chance(s) to get this right!<br>";
        $i--;
    }
}
```

// Robert
M3Ex4: Looping
Write code to count from 1 to 10 using each type of loop:

for
while
do-while

// Sumitha
M3Ex5: for Loop
What does this code do?

```
$max = 100;
echo '1, 2, 3, ';
for ($x = 5; $x < $max; $x++)
{
    // checks to see if number is odd or even
    if($x & 1) {
        $test = TRUE;
        for($i = 3; $i < $x; $i++) {
            if(($x % $i) === 0) {
                $test = FALSE;
                break;
            }
        }
        if ($test) echo $x . ', ';
    }
}
```


-----------------------------------------------------------------------------------------------------------------------
## http://collabedit.com/6wwe5
-----------------------------------------------------------------------------------------------------------------------
// from Wed 12 Apr 2017

// PHP for Exp Programmers

// Homework for Wed 12 Apr 2017

// Leslie 
 
M2Ex4: Exercise: What is the code to output the Tuesday in October?
----------------------------------------------
```
<!DOCTYPE html>
<html>
<body>
 
<?php
 
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday', 'Sunday'];
$months = [ 'January' => $days,
                                             'February' => $days,
                                             'March' => $days,
                                             'April' => $days,
                                             'May' => $days,
                                             'June' => $days,
                                             'July' => $days,
                                             'August' => $days,
                                             'September' => $days,
                                             'October' => $days,
                                             'November' => $days,
                                             'December' => $days
                                             ];
                             
echo 'Tuesday in October: ' . $months['October'][1];         
?>
</body>
</html>
```
------------------------------------------------
Output:
Tuesday in October:Tuesday
 
 
// Robert
M2Ex6: Exercise
Create a multi-dimensional array to hold the cards and numbers indicated below. Be as code efficient as you can.
Use colors as the primary array key
Output one color and card number

(red, blue, green, yellow)
(1, 2, 3, 4)
//----------------------- Solution ------------------------------
// This may not be the most the most efficient but it is readable. 
```
<?php
//A two dimentional array "$Cards"

$numbers = [1,2,3,4];
$cards = [
    'red' => $numbers,
    'blue' => $numbers,
    'green' => $numbers,
    'yellow' => $numbers,
    'purple' => $numbers
];

echo 'The color is ' . array_keys($cards)[0] . ' and the number is ' . $cards['red'][3] . '.'; 

?>
```





// Sumitha
M2Ex3: Exercise
Declare an array that contains the following sentence with one word in each array element: Programming in PHP is fun!
Then, output the third element.

Solution
--------
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

$sentence = ['Programming', 'in', 'PHP', 'is', 'fun!'];
var_dump($sentence);
echo PHP_EOL;
echo 'The third element of the sentence array is: ' . $sentence[2];
echo'</pre>';
```
----------------------------------------
// another solution:
```
<?php
$text = 'Programming in PHP is fun!';
var_dump(explode(' ', $text));
```
----------------------------------------

// Leslie
```
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 
         'Friday', 'Saturday', 'Sunday'];
$months = [ 'January'   => $days,
            'February'  => $days,
            'March'     => $days,
            'April'     => $days,
            'May'       => $days,
            'June'      => $days,
            'July'      => $days,
            'August'    => $days,
            'September' => $days,
            'October'   => $days,
            'November'  => $days,
            'December'  => $days
];
```

```
<?php
$status = $_GET['status'] ?? $_POST['status'] ?? 'DEFAULT';
$status = strip_tags($status);
echo '<pre>';
echo 'Your Status is: ' . htmlspecialchars($status);
echo '</pre>';
```




// Robert
M3Ex1: Exercise
What is the output from each if/else construct?  Answer: Equal followed by Not Identical

```
$valueA = "50";
$valueB = 50;

if ( $valueA == $valueB ) {
    echo "Equal <br>";           //Equal
} else {
    echo "Not equal <br>";
}

if ( $valueA === $valueB ) {
    echo "Identical <br>";
} else {
    echo "Not identical <br>";   // but not identical
}
```




// Sumitha
M3Ex2: Exercise
Assume that people work in an office from Monday through Friday, and are off work on Saturday and Sunday.

Add an elseif clause to handle the response if the day is either Saturday or Sunday

Now try the same thing using switch

```
$dayOfWeek = "Monday";

if ( $dayOfWeek === "Friday" ) {
    echo "See you on Monday";
} else {
    echo "See you tomorrow";
}
```

Solution
----------
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

$dayOfWeek = "Monday";
if ($dayOfWeek === "Friday") {
    echo 'See you on Monday';
}
elseif ($dayOfWeek == "Saturday" || $dayOfWeek == "Sunday") {
    echo 'You should be at home today';
}
else {
    echo 'See you tomorrow';
}
echo PHP_EOL;

switch ($dayOfWeek) {
    case "Friday":
        echo 'See you on Monday';
        break;
    case "Saturday":
    case "Sunday":
        echo 'You should be at home today';
        break;
    default:
        echo 'See you tomorrow';
        break;
}
echo'</pre>';
```
------------------------------------

// Leslie
M3Ex3: Exercise
What is the output?

```
$i = 6;

while ( $i > 0 ) {
    if ( $i === 4 ) break;
        echo "You only have $i chance(s) to get this right!<br>";
        $i--;
    }
}
```

M3Ex3: Exercise:
----------------------------
Output:
You only have 6 chance(s) to get this right!
You only have 5 chance(s) to get this right!
 

// Robert
M3Ex4: Looping
Write code to count from 1 to 10 using each type of loop:

for
while
do-while
//----------------------- Solution -----------------------------

```
<?php
echo 'For Loop<br>' ;
for ($w = 1; $w <= 10; $w++) {
    echo "number: $w <br>";
}
echo '<br>';

$x = 1; 
echo 'While Loop<br>' ;
while($x <= 10) {
    echo 'mumber: ' .  $x . ' <br>';
    $x++;
} 
echo '<br>';

$y = 1;
echo 'Do While Loop<br>' ;
do {
    echo 'number: ' . $y . ' <br>';
    $y++;
} while ($y <= 10);

?>
```





// Sumitha
M3Ex5: for Loop
What does this code do?

```
$max = 100;
echo '1, 2, 3, ';
for ($x = 5; $x < $max; $x++)
{
    // checks to see if number is odd or even
    if($x & 1) {
        $test = TRUE;
        for($i = 3; $i < $x; $i++) {
            if(($x % $i) === 0) {
                $test = FALSE;
                break;
            }
        }
        if ($test) echo $x . ', ';
    }
}
```

Answer
--------
Returns the prime numbers under 100.
Uses bit-wise comparison in the outer for loop. Inner for loop checks for a possible division by another lower number without a remainder.
1, 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97,
-------------------------------------------

-----------------------------------------------------------------------------------------------------------------------
## Wed 12 Apr 2017: http://collabedit.com/e2vnd
-----------------------------------------------------------------------------------------------------------------------

// examples

```
<?php

function getHourMinSec()
{
    return new class() { 
        public $hours;
        public $minutes;
        public $seconds;
        public function __construct()
        {
            $this->hours = date('H');
            $this->minutes = date('i');
            $this->seconds = date('s');
        }
    };
}

var_dump(getHourMinSec());
```


// example of callable + implementation of pub/sub design pattern
```
<?php
class EventSystem
{
    protected $events;
    function init($key, callable $c)
    {
        $this->events[$key] = $c;
    }
    function process($key, $a, $b)
    {
        return $this->events[$key]($a, $b);
    }
}

class AddSomething
{
    function __invoke($a, $b)
    {
        return $a + $b;
    }
}

$system = new EventSystem();
$system->init('add', new AddSomething());
$system->init('sub', function ($a, $b) { return $a - $b; });
$system->init('mul', function ($a, $b) { return $a * $b; });
$system->init('div', function ($a, $b) { return $a / $b; });

// some other code not shown

// trigger an event:
var_dump($system->process('add', 2, 3));
```

// bob
M4Ex1: Function Calling
Create a script that defines a function named getOrderTotal ($num1, $num2), which takes two arguments and returns the sum.

Call the function and output the result.
//---------------------solution--------------
```
<?php

function getOrderTotal($num1, $num2) {
    return $num1 + $num2;
}

$eggs = 3.84;
$rabbit = 11.8;

echo getOrderTotal($eggs, $rabbit);
?>
```

// sumitha
M4Ex2: Recursive Function Exercise
The Fibonacci sequence is a series of numbers in which each number is the sum of the previous two numbers, starting with 0.

0, 1, 1, 2, 3, 5, 8, 13, 21, 34

Write a function that returns the nth number in a Fibbonacci sequence.

Solution
---------
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

function fib($num) {
    if ($num == 0 || $num == 1) {
        return $num;
    }
    return (fib($num-1) + fib($num-2));
}

$testNum = 11;
echo "$testNum th number in the Fibonacci series is " . fib($testNum);
echo'</pre>';
```
-----------------------------------------------
11 th number in the Fibonacci series is 89
-----------------------------------------------

// bob
M4Ex3: Exercise
Build a function which takes an array and builds an HTML select/option list

htmlSelectHtml($config), returns a string contains an HTML <select> element with the status options

// Starting Code
```
$items = ['en' => 'English', 'fr' => 'francais',
          'de' => 'Deutsch', 'es' => 'Espanol'];
function htmlSelectHtml($items)
{
    $html = '<select>';
    // loop through key / value pairs to create <option> tags            ...
    $html .= '</select>';
    return $html;
}
```
//------------------------------ solution 
```
<?php 
$items = ['en' => 'English', 'fr' => 'francais',
    'de' => 'Deutsch', 'es' => 'Espanol'];
function htmlSelectHtml($items)
{
    //$html = '<select>';
    // now it works:
    $html = '<select name="lang">';
    //// loop through key / value pairs to create <option> tags
    foreach ($items as $key => $index){
        $html .= '<option value=' . $key . '>' . $items[$key] . '</option>';
    }
    $html .= '</select>';
    return $html;
}
echo htmlSelectHtml($items);

?>
```

-----------------------------------------------------------------------------------------------------------------------
## Fri 14 Apr 2017: http://collabedit.com/pfk7d
-----------------------------------------------------------------------------------------------------------------------

// weekend mystery: why does this not work???
// ANSWER: there is no "name" attribute in the <select> element!!!
```
<?php 
$items = ['en' => 'English', 'fr' => 'francais',
    'de' => 'Deutsch', 'es' => 'Espanol'];
function htmlSelectHtml($items)
{
    //$html = '<select>';
    // now it works:
    $html = '<select name="lang">';
    //// loop through key / value pairs to create <option> tags
    foreach ($items as $key => $index){
        $html .= '<option value="' . $key . '">' . $items[$key] . '</option>';
    }
    $html .= '</select>';
    return $html;
}
?>
<html>
<head>
</head>
<body>
<form method="post">
<?php echo htmlSelectHtml($items); ?>
<input type="submit" />
</form>
<?php var_dump($_POST); ?>
<?php phpinfo(INFO_VARIABLES); ?>
</body>
</html>
```

// class examples

```
<?php 
class OrderModel
{
    public function show()
    {
        return var_dump($this);
    }
}
echo '<pre>';
try {
    // Get the connection instance
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=course','root','vagrant', $options);
    // Set error mode attribute
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Statements ...
    $stmt = $pdo->query('select * from orders');
    $stmt->setFetchMode(PDO::FETCH_CLASS,'OrderModel');
    while ($row = $stmt->fetch()) {
        echo $row->show();
    }
} catch (PDOException $e ){
    // Handle exception...
}
echo '</pre>';
```


```
<?php 
echo '<pre>';
try {
    // Get the connection instance
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=course','root','vagrant', $options);
    // Set error mode attribute
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Statements ...
    $sql = "insert into customers (firstname, lastname) "
         . "values ('Barney','Rubble')";
    $pdo->query($sql);
    echo 'Latest ID: ' . $pdo->lastInsertId();
    echo PHP_EOL;
    $stmt = $pdo->query('select * from customers');
    $stmt->setFetchMode(PDO::FETCH_CLASS,'ArrayObject');
    while ($row = $stmt->fetch()) {
        var_dump($row);
        echo PHP_EOL;
    }
} catch (PDOException $e ){
    // Handle exception...
}
echo '</pre>';
```

// bob
M9Ex1: SQL Statements
Identify the result of each of the following SQL statements:

```
SELECT * FROM users;
SELECT firstname, lastname FROM users AS u WHERE u.id = 25;
INSERT INTO users (firstname, lastname) VALUES(James, Bond);
UPDATE users SET firstname=Rube, lastname=Goldberg WHERE users.id=420;
DELETE FROM users WHERE firstname=Rube;
SELECT * FROM users ORDER BY lastname DESC;
```

// sumitha
M9Ex2: Prepared Statements
Create a prepared statement script.

Add a try/catch construct.

Add a new customer record binding the customer parameters.

// bob
M9Ex3: Stored Procedures
Create a stored procedure script.

Add the SQL to the database.

Call the stored procedure with parameters.

// sumitha
M9Ex4: Transactions
Create a transaction script.

Execute two SQL statements.

Handle any exceptions.

Create a failed and a successful transaction

-----------------------------------------------------------------------------------------------------------------------
## Fri 14 Apr 2017: http://collabedit.com/pfk7d
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

* Open a terminal window (CTL+ALT+T)
* cd /home/vagrant/Zend/workspaces/DefaultWorkspace/oop | procedural/sandbox | orderapp
* gedit .buildpath
* paste in the XML above
* save
* in Zend Studio, select project and File -- Refresh

// class examples

```
<?php 
class OrderModel
{
    public function show()
    {
        return var_dump($this);
    }
}
echo '<pre>';
try {
    // Get the connection instance
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=course','root','vagrant', $options);
    // Set error mode attribute
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Statements ...
    $stmt = $pdo->query('select * from orders');
    $stmt->setFetchMode(PDO::FETCH_CLASS,'OrderModel');
    while ($row = $stmt->fetch()) {
        echo $row->show();
    }
} catch (PDOException $e ){
    // Handle exception...
}
echo '</pre>';
```


```
<?php 
echo '<pre>';
try {
    // Get the connection instance
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=course','root','vagrant', $options);
    // Set error mode attribute
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Statements ...
    $sql = "insert into customers (firstname, lastname) "
         . "values ('Barney','Rubble')";
    $pdo->query($sql);
    echo 'Latest ID: ' . $pdo->lastInsertId();
    echo PHP_EOL;
    $stmt = $pdo->query('select * from customers');
    $stmt->setFetchMode(PDO::FETCH_CLASS,'ArrayObject');
    while ($row = $stmt->fetch()) {
        var_dump($row);
        echo PHP_EOL;
    }
} catch (PDOException $e ){
    // Handle exception...
}
echo '</pre>';
```



// bob ----------------------------------------------
M9Ex1: SQL Statements
Identify the result of each of the following SQL statements:

```
SELECT * FROM users;
All rows and columns are selected from table "Users"

SELECT firstname, lastname FROM users AS u WHERE u.id = 25;
One row returned with the first and last name where the id is 25.

INSERT INTO users (firstname, lastname) VALUES(James, Bond);
(assuming quotes were used) A new row is added to the table "users" with the values 'James' and 'Bond'.

UPDATE users SET firstname=Rube, lastname=Goldberg WHERE users.id=420;
(assuming quotes were used)The firstname is assigned the value 'Rube' and the lastname is assigned the value 'Goldburg' where the ID is 420 in the table users

DELETE FROM users WHERE firstname=Rube;
(assuming quotes were used)ALL rows are deleted from the table users where the firstname = 'Rube'

SELECT * FROM users ORDER BY lastname DESC;
All rows are returned in descending order by lastname
```

// sumitha
M9Ex2: Prepared Statements
Create a prepared statement script.

Add a try/catch construct.

Add a new customer record binding the customer parameters.

==================================SOLUTION
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

try {
    // Get the connection instance
    //$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=course','root','vagrant');
    // Set error mode attribute
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo 'Successful connection';
    echo PHP_EOL;
    
    $stmt = $pdo->prepare('INSERT INTO customers (firstname, lastname) VALUES(?, ?)');
    
    $stmt->execute(array('Sumitha', 'Samy'));
    
    if ($stmt->rowCount()) {
        echo 'New customer added successfully';
    } else {
        echo 'Unable to add customer';
    }
    
} catch (PDOException $e ){
    // Handle exception...
    echo "Error: " . $e->getMessage();
}
echo'</pre>';
```

=========================================================
Added new customer successfully
=========================================================

// bob
M9Ex3: Stored Procedures
Create a stored procedure script.

Add the SQL to the database.

Call the stored procedure with parameters.


```
//-------------------- create the PROCEDURE
Drop proceedure If Exists library.newBook;
Delimiter $
Create Procedure library.newBook(
    p_Author varchar(100),
    p_Title varchar (255) )
BEGIN
Insert into Books(Author, Title) values(p_Author, p_Title);
END
$
DELIMITER ;
//------------------- call the procedure

$pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION):
$stmt = $PDO->prepare('CALL newBook (?,?)');
$Author = 'Bob Builder';
$Title = 'Treehouses';
If ($stmt->execute([$Author, $Title])) {
    echo " New Book $title added";
}
```

// sumitha
M9Ex4: Transactions
Create a transaction script.

Execute two SQL statements.

Handle any exceptions.

Create a failed and a successful transaction

=========================================================
SOLUTION: FAILURE SITUATION
=========================================================
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

try {
    // Get the connection instance
    //$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=course','root','vagrant');
    // Set error mode attribute
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo 'Successful connection';
    echo PHP_EOL;
    
    $pdo->beginTransaction();
    
    $sql = "INSERT INTO customers (firstname, lastname) VALUES('John', 'Cook')";
    $count = $pdo->exec($sql);
    
    $sql = "INSERT INTO customers (first, lastname) VALUES ('David', 'Coolidge')";
    $count = $pdo->exec($sql);
    
    $pdo->commit();
    
    echo "New customers added successfully";
    }
 catch (PDOException $e ){
    // Handle exception...
    echo "Error: " . $e->getMessage();
    $pdo->rollBack();
}
echo'</pre>';
```
================================================================================
RESULT: Successful connection
Error: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'first' in 'field list'
=================================================================================
SUCCESSFUL SITUATION
====================
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

try {
    // Get the connection instance
    //$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO('mysql:host=localhost;dbname=course','root','vagrant');
    // Set error mode attribute
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo 'Successful connection';
    echo PHP_EOL;
    
    $pdo->beginTransaction();
    
    $sql = "INSERT INTO customers (firstname, lastname) VALUES('John', 'Cook')";
    $count = $pdo->exec($sql);
    
    //$sql = "INSERT INTO customers (first, lastname) VALUES ('David', 'Coolidge')";
    $sql = "INSERT INTO customers (firstname, lastname) VALUES ('David', 'Coolidge')";
    $count = $pdo->exec($sql);
    
    $pdo->commit();
    
    echo "New customers added successfully";
    }
 catch (PDOException $e ){
    // Handle exception...
    echo "Error: " . $e->getMessage();
    $pdo->rollBack();
}
echo'</pre>';
```
======================================================================================
RESULT: Successful connection
New customers added successfully
======================================================================================

-----------------------------------------------------------------------------------------------------------------------
## Mon 17 Apr 2017: http://collabedit.com/re8xu
-----------------------------------------------------------------------------------------------------------------------

// leslie
M6Ex1: Exercise
Write code which writes the contents of an array to a CSV file.

```
<?php
// starting code
$data = [
    ['Fred','Flintstone','301 Cobblestone Way','Bedrock','70777'],
    ['Wilma','Flintstone','301 Cobblestone Way','Bedrock','70777'],
    ['Barney','Rubble','302 Cobblestone Way','Bedrock','70777'],
    ['Betty','Rubble','302 Cobblestone Way','Bedrock','70777']
];

$filehandler = fopen("addresses.csv","w");

foreach ($data as $fields) {
  fputcsv($filehandler, $fields);
}
/* which one works better?
foreach ($data as $line){
  fputcsv($filehandler,explode(',',$line));
  //fputcsv($filehandler, $line);
}
*/  
fclose($filehandler);
```
// OR
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

// starting code
$data = [
    ['Fred','Flintstone','301 Cobblestone Way','Bedrock','80888'],
    ['Wilma','Flintstone','301 Cobblestone Way','Bedrock','80888'],
    ['Barney','Rubble','302 Cobblestone Way','Bedrock','80888'],
    ['Betty','Rubble','302 Cobblestone Way','Bedrock','80888']
];

$obj = new SplFileObject('addresses.csv','w');

foreach ($data as $fields) {
  $obj->fputcsv($fields);
}

echo'</pre>';
```


// bob
M6Ex2: Exercise
```
Using file_get_contents(), get the contents of the zend.com website and display the result
<?php
$contents = file_get_contents('http://zend.com');
 if ($contents)
 {
    echo $contents;  
 }
 else 
 {
    echo '<h3>Site Not Found</h3>';
 }
```



// sumitha
M6Ex3: Exercise
Read the directories and files in the class project root and output the following:

File Name
File Size
Number of lines in the file

===========SOLUTION===========================
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

$path = realpath('');
$dir = opendir($path);
while ($file = readdir($dir)) {
    if (is_dir("$path/$file")) {
        if ($file != '.' && $file != '..') {
            echo 'Directory: ' . $file . PHP_EOL;
        }
    }
    else {
        echo 'File name: ' . $file . PHP_EOL;
        echo 'File size: ' . filesize("$path/$file") . PHP_EOL;
    }
}
echo'</pre>';
```
==============================================
================RECURSIVE ITERATOR===============
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

$path = realpath('');

<?php
ini_set('display_errors', 1);

echo '<pre>';

$path = __DIR__;
// Recursive Iterator
$objects = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($path), 
    RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $dir){
    if ($dir->isDir()) {         
        if ($dir != '.' && $dir != '..') {
            echo $dir->getFilename() . ' is a directory' . PHP_EOL;
            continue;
        }
    }
    else {
        echo $dir->getFilename() . ' is a file' . PHP_EOL;
        echo $dir->getSize() . ' is the file size' . PHP_EOL;
    }
}
echo'</pre>';
```
=================================================

// examples

```
<?php
function getCount( $counter )
{
    if (!file_exists($counter)) touch($counter);
    
    /*
    $fh = fopen( $counter, 'r' );
    //get the current count
    $num = (int) fread( $fh, 10 );
    fclose( $fh );
    */
    
    //$num = (int) file_get_contents($counter);

    $fObj = new SplFileObject($counter, 'r+');
    $num = (int) $fObj->fread(10);
    
    //write the new number
    /*
    $fh = fopen( $counter, 'w' );
    fwrite( $fh, ++$num, 10 );
    fclose( $fh );
    */
    
    //file_put_contents($counter, ++$num);

    $fObj->rewind();
    $fObj->fwrite(++$num, 10 );
    unset($fObj);
    
    return $num;
}
echo 'Hit count: ' . getCount('counter.txt') . PHP_EOL;
echo 'Hit count: ' . getCount('counter.txt') . PHP_EOL;
echo 'Hit count: ' . getCount('counter.txt') . PHP_EOL;
```


-----------------------------------------------------------------------------------------------------------------------
## Tue 18 Apr 2017 + Weds 19 Apr 2017: http://collabedit.com/dg2y9
-----------------------------------------------------------------------------------------------------------------------

// example form

```
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP for Exp Programmers</title>
</head>
<body>
<form method="post" action="http://oop-sandbox/test.php">
First Name: <input type="text" name="fname" />
<br>
Last Name: <input type="text" name="lname" />
<br>
Options #0: 
<input type="checkbox" name="options[0][]" value="f" />Facebook&nbsp;
<input type="checkbox" name="options[0][]" value="g" />Google&nbsp;
<input type="checkbox" name="options[0][]" value="t" />Twitter&nbsp;
<br>
Options #1: 
<input type="checkbox" name="options[1][facebook]" value="1" />Facebook&nbsp;
<input type="checkbox" name="options[1][google]" value="1" />Google&nbsp;
<input type="checkbox" name="options[1][twitter]" value="1" />Twitter&nbsp;
<br>
<input type="submit" />
</form>
</body>
</html>
```

```
<?php
ini_set('display_errors', 1);

// how do I confirm "google" is selected as an option?

echo 'Google Selected: ';
// y or n
echo (isset($_POST['options'][1]['google'])) ? 'Y' : 'N';
echo '<br>';
echo '<hr>';
phpinfo(INFO_VARIABLES);
```

```
<?php
ini_set('display_errors', 1);

$firstname = "<script>alert('document.cookie')</script>";
// example of filtering
$clean[0]['firstname'] = strip_tags($firstname);
// example of safeguarding ouput (i.e. output escaping)
$clean[1]['firstname'] = htmlspecialchars($firstname);
var_dump($clean);
```

// Leslie
M6Ex1: Exercise
Only using PHP, build a simple login form.

Output the HTML to the browser

// Starting Code
```
$html = '<form';

// code …

$html .= '</form>';
```

// Bob
M6Ex2: Exercise
Create a script that takes input from the login form (username, password, and email address). Filter and validate all inputs. Display a message for both invalid and valid input.


-----------------------------------------------------------------------------------------------------------------------
## Tue 18 Apr 2017: http://collabedit.com/dg2y9
-----------------------------------------------------------------------------------------------------------------------

// example form

```
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP for Exp Programmers</title>
</head>
<body>
<form method="post" action="http://oop-sandbox/test.php">
First Name: <input type="text" name="fname" />
<br>
Last Name: <input type="text" name="lname" />
<br>
Options #0: 
<input type="checkbox" name="options[0][]" value="f" />Facebook&nbsp;
<input type="checkbox" name="options[0][]" value="g" />Google&nbsp;
<input type="checkbox" name="options[0][]" value="t" />Twitter&nbsp;
<br>
Options #1: 
<input type="checkbox" name="options[1][facebook]" value="1" />Facebook&nbsp;
<input type="checkbox" name="options[1][google]" value="1" />Google&nbsp;
<input type="checkbox" name="options[1][twitter]" value="1" />Twitter&nbsp;
<br>
<input type="submit" />
</form>
</body>
</html>
```

```
<?php
ini_set('display_errors', 1);

// how do I confirm "google" is selected as an option?

echo 'Google Selected: ';
// y or n
echo (isset($_POST['options'][1]['google'])) ? 'Y' : 'N';
echo '<br>';
echo '<hr>';
phpinfo(INFO_VARIABLES);
```

```
<?php
ini_set('display_errors', 1);

$firstname = "<script>alert('document.cookie')</script>";
// example of filtering
$clean[0]['firstname'] = strip_tags($firstname);
// example of safeguarding ouput (i.e. output escaping)
$clean[1]['firstname'] = htmlspecialchars($firstname);
var_dump($clean);
```

// Leslie
M6Ex1: Exercise
Only using PHP, build a simple login form.

Output the HTML to the browser

// Starting Code
```
<?php

function htmlLogin(array $config, $action)
{
    $html = '<form ';
    $html .= 'id="login" method="post" action="' . $action. '" method="post" accept-charset="UTF-8">';
    foreach ($config as $element) {
        $html .= '<br>';
        if (isset($element['label'])) {
            $html .= '<label for="' . $element['name'] . '" >' . $element['label'] . '*:</label>';
        }
        $html .= '<input ';
        foreach ($element as $attrib => $value) {
            if ($attrib != 'label') {
                $html .= $attrib . '=' . $value . ' ';
            }
        }
        $html .= '/>';
    }
    $html .= '</form>';
    return $html;
}

$config = [
    ['label' => 'UserName', 'type' => 'text', 'name' => 'username', 'id' => 'username', 'maxlength' => 50],
    ['label' => 'Address', 'type' => 'text', 'name' => 'address', 'id' => 'address', 'maxlength' => 50],
    ['label' => 'City', 'type' => 'text', 'name' => 'city', 'id' => 'city', 'maxlength' => 30],
    ['label' => 'Postal', 'type' => 'text', 'name' => 'postal', 'id' => 'postal', 'maxlength' => 10],
    ['type' => 'submit', 'name' => 'Submit', 'value' => 'Submit'],
];

echo htmlLogin($config, 'http://oop-sandbox/test.php');
```


// Bob
M6Ex2: Exercise
Create a script that takes input from the login form (username, password, and email address). 
Filter and validate all inputs. Display a message for both invalid and valid input.

-------------oops My code is not ready for prime time fokes.  Sorry -----------------------------

// examples
```
<?php
class User
{
    protected $firstname;
    protected $lastname;
    protected $date;
    // -------- MAGIC METHOD -------- //
    public function __construct( $firstname , $lastname, $date = NULL )
    {
        $this->setFirstName($firstname);
        $this->lastname = $lastname ;
        $this->setDate($date);
    }
    // other methods not shown ...
    public function setFirstName($name)
    {
        $this->firstname = $name;
    }
    public function setDate($date)
    {
        if (is_string($date)) {
            $this->date = new DateTime($date);
        } elseif ($date instanceof DateTime) {
            $this->date = $date;
        } else {
            $this->date = new DateTime();
        }
    }
}
$user[] = new User ( 'Jack' , 'Ryan', '2016-01-01');
$user[] = new User ( 'Monte' , 'Python' );
$user[] = new User ( 'James' , 'Bond' );

var_dump($user);
```

// very simple autoloader example:
```
<?php
function __autoload($class)
{
    require_once $class . '.php';
}

$guest = new GuestUser('Fred', 'Flintstone', 'Caveman');
var_dump($guest);

// assumes we have class definitions in the same directory
// also assumes classname == filename
```



// homework for Thursday
M8Ex1: Create a Class
Create a class definition that represents something. Give it a constant and a few properties and methods. Set appropriate visibilities for each.
Instantiate a couple of objects and execute the methods created producing some output.
Create something which is realistic and appropriate to a current or future application

M8Ex2: Create an Abstract Super Class
Using the code created in the previous exercise, create an extensible superclass definition
Set the properties and methods that subclasses will need.
Create one or more subclasses that extend the superclass with constants, properties and methods specific to the subclass
Instantiate a couple of objects from the subclasses and execute the methods producing some output.
Mark the class as abstract


-----------------------------------------------------------------------------------------------------------------------
## Thu + Fri 20 + 21 Apr 2017: http://collabedit.com/trpb9
-----------------------------------------------------------------------------------------------------------------------

// examples
```
<?php
class Test
{
    protected $name;
    public function __construct($name) 
    {
        $this->name = $name;
    }
    public function __sleep()
    {
        file_put_contents('test.txt', __METHOD__);
        return ['name'];
    }
    public function __wakeup()
    {
        file_put_contents('test.txt', __METHOD__, FILE_APPEND);
    }
}

$a = new Test(__LINE__);
$b = new Test(__LINE__);
$c = new Test(__LINE__);

$s = serialize($a);
echo $s . PHP_EOL;
$d = unserialize($s);
var_dump($d);
echo PHP_EOL;
readfile('test.txt');
```

```
<?php
class Test
{
    protected $name;
    public function __construct($name) 
    {
        $this->name = $name;
    }
    public function __isset($var)
    {
        echo __METHOD__ . ' VAR: ' . $var;
    }
    public function __unset($var)
    {
        echo __METHOD__ . ' VAR: ' . $var;
    }
}

$a = new Test('test');
echo (isset($a->doesntExist)) ? 'TRUE' : 'FALSE';
echo PHP_EOL;
unset($a->doesntExist);
echo PHP_EOL;
```

[Magic get/set](https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_get_set.php)
[Unlimited getters/setters using __call](https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_call_unlimited_getters_setters.php)
[__invoke() + __toString()](https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_invoke_and_tostring.php)

See how AbstractController implements EventManagerAwareInterface
[ZF Ref](https://github.com/zendframework/zend-mvc/blob/master/src/Controller/AbstractController.php)

// often interfaces and traits go together
[EventManagerAwareInterface](https://github.com/zendframework/zend-eventmanager/blob/master/src/EventManagerAwareInterface.php)
[EventManagerAwareTrait](https://github.com/zendframework/zend-eventmanager/blob/master/src/EventManagerAwareTrait.php)

// homework

// Leslie
M8Ex3: Magic Methods
Using the code from the previous exercises, add four magic methods.

Add a magic constructor that accepts parameters and set those parameters into the class on instantiation.

Create an index.php file, load the classes, create subclass object instances and execute method calls to the subclass objects.

// Bob
M8Ex4: Interfaces
Create an object interface with two methods.

Implement the interface in your superclass.

Add some code to the index.php file that calls one of the superclass methods implemented.

// Sumitha
M8Ex5: Type Hints
Modify all methods in existing classes so that all parameters are defined using type hints

Modify all methods in existing classes so that the return values data types are defined

// Leslie
M8Ex6: Traits
Create two traits, each with two methods, one of the methods named the same in both traits.

Use the trait in a subclass created thus far. Specify a new visibility and deal with the naming conflict.

//Bob
M8Ex7: Namespaces
Define namespaces for your classes defined in previous exercises.

Build a directory structure which matches the namespace structure

Define an auto-loader for your new namespaced classes

// Sumitha - use PDO examples
M8Ex8: Exceptions
Add a constructor that accepts parameters.

Call the parent constructor.

Add some new functionality in the constructor

Add a try/catch/catch/finally block in the index.php file.

In the try portion, throw an instance of the Exceptions object, and an instance of your custom exception class.

Handle both in the associated catch blocks.

Log some data in the finally block.

-----------------------------------------------------------------------------------------------------------------------
## Thu + Fri 20 + 21 Apr 2017: http://collabedit.com/trpb9
-----------------------------------------------------------------------------------------------------------------------

// examples
```
<?php
class Test
{
    protected $name;
    public function __construct($name) 
    {
        $this->name = $name;
    }
    public function __sleep()
    {
        file_put_contents('test.txt', __METHOD__);
        return ['name'];
    }
    public function __wakeup()
    {
        file_put_contents('test.txt', __METHOD__, FILE_APPEND);
    }
}

$a = new Test(__LINE__);
$b = new Test(__LINE__);
$c = new Test(__LINE__);

$s = serialize($a);
echo $s . PHP_EOL;
$d = unserialize($s);
var_dump($d);
echo PHP_EOL;
readfile('test.txt');
```

```
<?php
class Test
{
    protected $name;
    public function __construct($name) 
    {
        $this->name = $name;
    }
    public function __isset($var)
    {
        echo __METHOD__ . ' VAR: ' . $var;
    }
    public function __unset($var)
    {
        echo __METHOD__ . ' VAR: ' . $var;
    }
}

$a = new Test('test');
echo (isset($a->doesntExist)) ? 'TRUE' : 'FALSE';
echo PHP_EOL;
unset($a->doesntExist);
echo PHP_EOL;
```

// homework

// Leslie
M8Ex3: Magic Methods
Using the code from the previous exercises, add four magic methods.
Add a magic constructor that accepts parameters and set those parameters into the class on instantiation.
Create an index.php file, load the classes, create subclass object instances and execute method calls to the subclass objects.

// NOTE: graceful way to handle illegal access to private properties
```
<?php
class Movies 
{
    private $title;
    private $actor;
    
    public function __construct($title, $actor)
    {
        $this->title = $title;
        $this->actor = $actor;
    }

    public function __get($property) 
    {
        echo 'Unable to read this property: ' . $property . PHP_EOL;
    }

    public function __set($property, $value) 
    {
        echo 'Cannot set ' . $property . ' to ' . $value . PHP_EOL;
    }
    
    public function __isset($name)
    {
        echo "__isset is called for $name\n";
    }
    
    public function __unset($name)
    {
        echo "__unset is called for $name\n";
    }
    
}

$myMovie = new Movies('Gone With the Wind', 'Clark Gable');
$myMovie->author = 'Margaret Mitchell';

echo $myMovie->title;
echo $myMovie->actor;
echo $myMovie->author;


unset($myMovie->title);
isset($myMovie->author);
```

// Bob
M8Ex4: Interfaces
Create an object interface with two methods.
Implement the interface in your superclass.
Add some code to the index.php file that calls one of the superclass methods implemented.


//============ See Namespaces Below

// Sumitha
M8Ex5: Type Hints
Modify all methods in existing classes so that all parameters are defined using type hints

Modify all methods in existing classes so that the return values data types are defined

===================SOLUTION========================
```
<?php
declare(strict_types=1);
ini_set('display_errors', 1);

echo '<pre>';

abstract class AbstractArticle
{
    const ARTICLECATEGORY = "Marine Life";
    const EXPIRYDATE = '2016-06-06';
    protected $articleTitle;
    protected $articleAuthor;
    protected $articleDate;
    protected $articleSubCategory;
        
    // -------- MAGIC METHOD -------- //
    public function __construct( string $articleTitle , string $articleAuthor, string $articleSubCategory, $articleDate = NULL )
    {
        $this->setArticleTitle($articleTitle);
        $this->setArticleAuthor($articleAuthor);
        $this->setArticleSubCategory($articleSubCategory);
        $this->setArticleDate($articleDate);
    }
    
    abstract protected function setArticleTitle(string $title);
    abstract protected function setArticleAuthor(string $author);
    abstract protected function setArticleSubCategory(string $subcategory);
    abstract protected function setArticleDate ($date);
    abstract protected function getArticletitle() : string;
    abstract protected function getArticleAuthor() : string;
    abstract protected function getArticleSubCategory() : string;
    abstract protected function getArticleDate() : string;
}
```

```
<?php
class MyArticle1 extends AbstractArticle {
    const MYNAME = 'I am Article1 sub-class';
    protected $tvChannel;
    
    public function __construct(string $articleTitle , string $articleAuthor, string $articleSubCategory, string $articleTVChannel, $articleDate = NULL) {
        parent::__construct($articleTitle , $articleAuthor, $articleSubCategory, $articleDate = NULL);
        $this->setTVChannel($articleTVChannel);
    }
    
    public function setArticleTitle(string $title)
    {
        $this->articleTitle = $title;
    }
    public function setArticleAuthor(string $author)
    {
        $this->articleAuthor = $author;
    }
    public function setArticleSubCategory(string $subcategory)
    {
        $this->articleSubCategory = $subcategory;
    }
    public function setArticleDate($date)
    {
        if (is_string($date)) {
            $this->articleDate = new DateTime($date);
        } elseif ($date instanceof DateTime) {
            $this->articleDate = $date;
        } else {
            $this->articleDate = new DateTime();
        }
    }
    
    public function setTVChannel(string $tvchannel) {
        $this->tvChannel = $tvchannel;
    }
    
    public function getArticleTitle() : string
    {
        return $this->articleTitle;
    }
    
    public function getArticleAuthor() : string
    {
        return $this->articleAuthor;
    }
    
    public function getArticleSubCategory() : string
    {
        return $this->articleSubCategory;
    }
    
    public function getArticleDate() : string
    {
        return $this->articleDate->format('Y-m-d H:i:s');
    }
    
    public function getMainArticleCat() {
        return parent::ARTICLECATEGORY;
        
    }
    public function hasExpired() : string
    {
        if ($this->articleDate < new DateTime(parent::EXPIRYDATE)) {
            return 'Expired';
        }
        else {
            return 'Active';
        }
    }
    
    public function getTVChannel() : string
    {
        return $this->tvChannel;
    }
}
```

```
<?php
$article1 = new MyArticle1 ( 'Swimming with the Dolphins' , 'Jack Smith', 'Intelligent Ones', 'Nat Geo Wild', '2016-01-01');
//$articles[] = new Article ( 'Should I touch them?' , 'Jane Kingsman', 'Sharks', '2017-04-01' );
//$articles[] = new Article ( 'Cute little pets' , 'Arthur Smith', 'Gold fish' );

echo 'Sub class name is: ' .$article1::MYNAME .PHP_EOL;
echo PHP_EOL;
echo 'The main category of the display articles is: ' . $article1->getMainArticleCat();
echo PHP_EOL;
echo PHP_EOL;
//var_dump($articles);
    echo 'Article Title: ' .$article1->getArticleTitle() .PHP_EOL;
    echo 'Article Author: ' .$article1->getArticleAuthor() .PHP_EOL;
    echo 'Article Date: ' .$article1->getArticleDate() .PHP_EOL;
    echo 'Article SubCategory: ' .$article1->getArticleSubCategory() .PHP_EOL;
    echo 'Article TV Channel: ' .$article1->getTVChannel() .PHP_EOL;
    echo 'Active/Expired: ' .$article1->hasExpired() .PHP_EOL;
    echo PHP_EOL;

echo'</pre>';
```
===============================================================================================
// Leslie
M8Ex6: Traits
Create two traits, each with two methods, one of the methods named the same in both traits.
Use the trait in a subclass created thus far. Specify a new visibility and deal with the naming conflict.
```
trait production
{
    private releaseDate;
    private cost;
    public function setTrueDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }
    public function getCost
    {
        return this->cost;
    }
}

trait showtime
{
    private showDate;
    private ticketRates;
    public function setTrueDate($showDate)
    {
        $this->showDate = $showDate;
    }
    public function getRates($ticketRates)
    {
        return this->ticketRates;
    }
}

class movies {
    private $title;
    public function __construct($title)
    {
        $this->title = $title;
    }
    use production, showtime
    {   
        showtime::setTrueDate insteadof production;
    }
}
```

//Bob
M8Ex7: Namespaces
Define namespaces for your classes defined in previous exercises.
Build a directory structure which matches the namespace structure
Define an auto-loader for your new namespaced classes

// ************* The code fails to run as I expected ********************************

//========================================== Interface & Superclass ========================
```
<?php
namespace Loader;

use Exception;
class Autoloader
{
    public static $dirs = [];
    public static function initDirs($dirs)
    {
        self::$dirs = $dirs;
    }
    public static function autoload($class)
    {   
        $fn = str_replace('\\', '/', $class) . '.php';
        foreach (self::$dirs as $dir) {
            if (file_exists($dir . '/' . $fn)) {
                require_once($dir . '/' . $fn);
                return true;
            }
        }
        throw new \Exception('Unable to load class');
    }
        
}
```

```
<?php
namespace Financial;
// code location ...workspaces\DefaultWorkspace\currency.php

// Superclass Implement the interface 
class Currency implements Icurrency
{
    protected $amount;
    protected $medium;
    public function __construct($amount)
    {
        $this->amount = $amount;
        $this->medium = 'Am I lucky that Wordpress will not be using classes';
    }
    public function setMedium($medium)
    {
        $this->medium = $medium;
    }

    public function getValue()
    {
        return $this->amount . ' ' . $this->medium;
    }
}
```

```
<?php
namespace Financial;
// code location ...workspaces\DefaultWorkspace\currency.php

// Declare the interface 'icurrencye'
interface Icurrency
{
    public function setMedium($medium);
    public function getValue();
}
```


```
<?php
require __DIR__ . '/Loader/Autoloader.php';
Loader\Autoloader::initDirs([__DIR__]);
spl_autoload_register('Loader\Autoloader::autoload');

$mycurrency = new Financial\Currency(99.99);
echo $mycurrency->getValue();

//phpinfo();
```




// Sumitha - use PDO examples
M8Ex8: Exceptions
Add a constructor that accepts parameters.

Call the parent constructor.

Add some new functionality in the constructor

Add a try/catch/catch/finally block in the index.php file.

In the try portion, throw an instance of the Exceptions object, and an instance of your custom exception class.

Handle both in the associated catch blocks.

Log some data in the finally block.

====================SOLUTION==== Did not get to complete the exercise ======================
```
<?php
ini_set('display_errors', 1);

echo '<pre>';

class AbstractDBConnection {
    protected $pdo;
    
    public function __construct (string $db, $userName, $password) {
        $this->setPdo($db, $userName, $password);
    }
    
    public function setPdo(string $db, string $userName, string $password) {
        $this->pdo = new PDO("mysql:host=localhost;dbname=' .$db .',' .$userName .',' .$password .'");
    }
}
            
class Customers extends AbstractDBConnection {
    const CONN_OPEN_FAIL = 'Error in opening DB connection';
    const QUERY_EXEC_FAIL = 'Error in running query';
    const SUCCESS_MSG = 'Successful';
    
    protected $sql;
    
    public function __construct(string $db, $userName, $password) {
        try {
            parent::__construct($db, $userName, $password);
        }
        catch (PDOException $e) {
            echo self::CONN_OPEN_FAIL . ' ' . $e->getMessage();
        }
    }
    
    public function setSql (string $statement) {
        $this->sql = $statement;
    }
    
    public function runQuery ()
    
}
```

// examples
```
<?php
ini_set('display_errors', 1);

session_start();
setcookie('test', date('Y-m-d H:i:s'), time()+300);

$_SESSION['test'] = date('Y-m-d H:i:s');

phpinfo(INFO_VARIABLES);
```

INSTALL PHP SOAP IN VM:
```
sudo apt-get update
sudo apt-get install php-soap
sudo service apache2 restart
```

```
<?php
// Make a request for JSON
$url = 'http://maps.googleapis.com/maps/api/geocode/json?address=350+5th+Avenue+New+York,+NY&sensor=false';
$json = file_get_contents($url);
// Decode into a standard class object
$resultsObj = json_decode($json);
// Decode into an array
$resultsArr = json_decode($json, true);
var_dump($resultsArr);

// Make a request for XML
$url = 'http://maps.googleapis.com/maps/api/geocode/xml?address=350+5th+Avenue+New+York,+NY&sensor=false';
$xml = file_get_contents($url);
// Load a SimpleXmlElement object
$smplxml = simplexml_load_string($xml);
// Output something
echo $smplxml->asXml();


// regex example
$data = ['<a href="http://zend.com">Test</a>', "<a href='https://unlikelysource.com'>Test</a>"];
$pattern = '/<a.*?href=("|\')(.*?)("|\').*?>/';

foreach ($data as $url) {
    preg_match($pattern, $url, $matches);
    var_dump($matches);
}
```

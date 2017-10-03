# PHP-I Notes September 2017

## ERRATA
* http://localhost:8080/#/9: Replace "Persistance" with "Persistence"
* http://localhost:8080/#/3/8:  s/be "whole numbers" and not "hole numbers"
* http://localhost:8080/#/4/36: missing single quote after 'IndexController'
* http://localhost:8080/#/5/12: inside ¨else¨ should read: Foo is less than or equal to bar
* http://localhost:8080/#/6/1: Referencing 2x
* http://localhost:8080/#/6/9: forgot ¨declare(strict_types=1)¨ at the top of the program
* http://localhost:8080/#/7/16: should probably not use a *.csv for this example
* http://localhost:8080/#/9/22: function is missing "}"

# NOTES Wed 6 Sep 2017

## Data Types
* Negative whole numbers are also data type int:
  * Example `-42`
* If you add ".0" to a number, it's considered `float`
  * Example: `123.0`

## PHP Tags
* If pure PHP no closing tag required
* If mixing HTML + PHP you need the closing tag:
  * Example: `<h1><?php echo 'Hello World!'; ?></h1>`

## To access the source code in the slides do this:
* Add an entry for `php1` in `/etc/hosts`
  * From a terminal window (CTL+ALT+T): `sudo gedit /etc/hosts`
  * Then enter this on a new line: `127.0.0.1  php1`
* Copy this text (below) into a new file `/etc/apache2/sites-available`
```
 <VirtualHost *:80>
     ServerName php1
     DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/php1
     <Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/php1>
         Options Indexes FollowSymlinks MultiViews
         AllowOverride All
         Require all granted
     </Directory>
 </VirtualHost>
```
* Enable the new virtual host: `sudo a2ensite php1.conf`
* Restart Apache: `sudo service apache2 restart`

## php1 Project Import
* Source code for code contained in the presentation slides
* Located in `/home/vagrant/Zend/workspaces/DefaultWorkspace/php1`
* From Zend Studio in the VM, proceed as follows:
  * File
  * Import
  * General
  * Projects from Folder or Archive
  * Next
  * Import Source: browse to `/home/vagrant/Zend/workspaces/DefaultWorkspace/php1`
  * Finish


// Build the crew
$astronaut1 = ['firstName' => 'Mark', 'lastName' => 'Watney',
        'specialty' => 'Botanist'];
$astronaut2 = ['firstName' => 'Melissa', 'lastName' => 'Lewis',
        'specialty' => 'Commander'];
$astronaut3 = ['firstName' => 'Beth', 'lastName' => 'Johanssen',
        'specialty' => 'Computer Specialist'];
$missions = ['STS395' => [$astronaut1, $astronaut2, $astronaut3]];

foreach($missions as $mission => $astronauts){
    if($mission === 'STS395'){
        foreach($astronauts as $astronaut){
            echo "{$astronaut['specialty']} {$astronaut['lastName']} on board".'<br>';
        }
    }
}

# Mon 11 Sep 2017
http://collabedit.com/wn2ug

## ERRATA
http://localhost:8080/#/4/36: missing single quote after 'IndexController'

## Example of Magic and Pre-Defined Constants:
```
<?php
$fullFileName = __DIR__ . DIRECTORY_SEPARATOR . basename(__FILE__);
echo $fullFileName;
```
### Unicode
```
echo "\u{0E01}"; // displays 1st letter in Thai alphabet
```

### Ternary vs. Compressed Ternary
```
<?php
ini_set('display_errors', 1);
$name = (isset($_GET['name'])) ? strip_tags($_GET['name']) : 'guest';
//$name = $_GET['name'] ?: 'guest';
echo '<h1>Welcome ' . htmlspecialchars($name) . '</h1>';
```
### Null Coalesce Operator
```
<?php
ini_set('display_errors', 1);
$name = $_GET['name'] ?? $_COOKIE['name'] ?? $_SESSION['name'] ?? 'guest';
$name = strip_tags($name);
echo '<h1>Welcome ' . htmlspecialchars($name) . '</h1>';
```

### Modified switch example
```
<?php
ini_set('display_errors', 1);

$colorChoice = $_GET['color'] ?? 'blue';
$message = 'We are in <span style="color: %s;">%s</span> condition';

switch ($colorChoice) {
    case 'red' :
        $color = 'red';
        break;
    case 'green' :
        $color = 'green';
        break;
    case 'blue' :
        $color = 'blue';
        break;
    default :
        $message = 'You chose %s. Please choose red, green, or blue';
        $color = 'black';
}
printf($message, $color, $color);

// variation of the above
```
<?php
ini_set('display_errors', 1);

$colorChoice = $_GET['color'] ?? 'blue';
$colorchoice = strip_tags($colorChoice);
$message = 'We are in <span style="color: %s;">%s</span> condition';

switch ($colorChoice) {
    case 'red' :
    case 'green' :
    case 'blue' :
        $color = $colorChoice;
        break;
    default :
        $message = 'You chose %s. Please choose red, green, or blue';
        $color = $colorChoice;
}
printf($message, $color, $color);
```

### break out of nested loops
```
<?php
ini_set('display_errors', 1);

for ($x = 0; $x < 10; $x++) {
    for ($y = 0; $y < 10; $y++) {
        for ($z = 0; $z < 10; $z++) {
            printf('<br>X: %d | Y: %d | Z: %d', $x, $y, $z);
            if ($z == 1) break 1; // breaks out 1 level to the $y loop
            //if ($z == 1) break 2; // breaks out 2 levels to the $x loop
            //if ($z == 1) break 3; // breaks out 3 levels to the echo statement
            //if ($z == 1) break 4; // breaks out 4 levels == early exit from the program
        }
    }
}
echo 'We are done';
```

### LABS
#### Lab: The Mixed Array
In the example below, what is the key required to obtain the last name value?

```
// An astronaut array assignment
$astronaut = ['firstName' => 'Mark', 'Watney', 5 => 'Botanist'];

// Access the last name value
echo $astronaut[0] . '<br>';
```

#### Lab: The Mixed Array
In the example below, what is the key required to obtain the last element value?

```
// An astronaut array assignment
$astronaut = ['firstName' => 'Mark', 6 => 'Watney', 5 => 'Botanist', 'STS395'];

// Access the last element value
echo $astronaut[7] . '<br>';
```

#### Lab: The Multi Array
In the below array, what is necessary to output the Computer Specialist's first name?

```
// Build the crew
$astronaut1 = ['firstName' => 'Mark', 'lastName' => 'Watney',
        'specialty' => 'Botanist'];
$astronaut2 = ['firstName' => 'Melissa', 'lastName' => 'Lewis',
        'specialty' => 'Commander'];
$astronaut3 = ['firstName' => 'Beth', 'lastName' => 'Johanssen',
        'specialty' => 'Computer Specialist'];
$mission = ['STS395' => [$astronaut1, $astronaut2, $astronaut3]];

// Access the Computer Specialist's first name
echo $mission['STS395'][2]['firstName'];
```


#### Lab: The Multi Configuration Array
What is the echo code to access the action?

```
$config = [
    'router' => [
        'routes' => [
            'market' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/market',
                    'defaults' => [
                        'controller' => 'IndexController',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
];
echo $config['router']['routes']['market']['options']['defaults']['action'];
```
#### Lab: First Program
Build a simple hello world program using one or two of the operators previously defined, and output something.

```
$hello = 'hello world'
$world = 'no hello'
if ($hello and $world) {
    echo $hello;
}else{
echo $world;
}

```

#### Lab: Additional Crew Members
Add additional crew members to an STS395 mission array and output a double-quoted string with embedded array values. Here's a start:

```
<?php
// Build the crew
ini_set('display_errors', 1);
$astronaut1 = ['firstName' => 'Mark', 'lastName' => 'Watney',
    'specialty' => 'Botanist'];
$astronaut2 = ['firstName' => 'Melissa', 'lastName' => 'Lewis',
    'specialty' => 'Commander'];
$astronaut3 = ['firstName' => 'Beth', 'lastName' => 'Johanssen',
    'specialty' => 'Computer Specialist'];
$astronaut4 = ['firstName' => 'Richard', 'lastName' => 'Hanson',
    'specialty' => 'Lab Specialist'];
$astronaut5= ['firstName' => 'Howard', 'lastName' => 'Chin',
    'specialty' => 'Mechanical Engineer'];
$mission = ['STS395' => [$astronaut1, $astronaut2, $astronaut3, $astronaut4, $astronaut5]];
echo  "The lab specialist is: {$mission ['STS395'][3]['firstName']} {$mission ['STS395'][3]['lastName']}";
```

## Homework for Weds: labs from module 4
### 1 == Dave
Lab: Conditional If
Will the following code work?
```
// ans: YES
$foo = 10;
$bar = 5;
if ( $foo > $bar )
    echo "Foo is greater than bar";
    $foo = $bar;
    echo "The value for Foo has changed";
```
Which statement runs as part of the conditional?
// ans: just the 1st echo

### 2 == Karen
Lab: Conditional If-Else Equality
What is the output from each if-else construct?
// explanation: == equals value, === equals value and type, $valueA is a data type string, $valueB is an integer

```
$valueA = "50";
$valueB = 50;

if ( $valueA == $valueB ) {
    echo "Equal <br>";
} else {
    echo "Not equal <br>";
}
// output:  // Equal

if ( $valueA === $valueB ) {
    echo "Identical <br>";
} else {
    echo "Not identical <br>";
}
// output: Not Identical
```


### 3 == Leonardo
Lab: Conditional If-Else Exclusive OR
What is the output from each if/else construct?

```
$valueA = 10;
$valueB = 20;

if ( ( $valueA >= 50 ) xor ( $valueB === '20') ) {
    echo "Apples <br>";
} else {
    echo "Oranges <br>";
}

if ( ( $valueA >= '5' ) xor ( $valueB === 20 ) ) {
    echo "White <br>";
} else {
    echo "Black <br>";
}

//Output: Oranges, black
```

### 4 == Mike
Lab: Conditional If-ElseIf
Assume that people work in an office from Monday through Friday, and are off work on Saturday and Sunday.

Modify the code below to handle the response if the day is either Saturday or Sunday?

```
$dayOfWeek = "Monday";

if ( $dayOfWeek === "Friday" ) {
    echo "See you on Monday";
} else {
    echo "See you tomorrow";
}

//solution:

$dayOfWeek = "Thursday";

echo "Today is $dayOfWeek.<br>";

if ($dayOfWeek == "Saturday") {
    echo "See you on Monday.<br><br>" ;
} elseif ($dayOfWeek == "Sunday") {
    echo "See you tomorrow.<br><br>" ;
} else {
    echo "Get back to work.<br><br>" ;
}
```



### 5 == Nathan
Lab: Switch Construct
An application needs to determine the country of origin for an astronaut applicant. Write a switch construct that evaluates multiple country use cases against a true boolean, and sets a variable based on the condition evaluated.

```
<?php
ini_set('display_errors', 1);

$code = $_GET['code'] ?? 'SI';
$country = 'Singapore';
$message = 'Astronaut applicant is from ';

switch (true) {
    case($code == 'US'):
        $country = 'United States of America';
        break; ;
    case($code == 'CA'):
        $country = 'Canada';
        break;
    case($code == 'MX'):
        $country = 'Mexico';
        break;
    default:
        $message = 'Applicant is not from North America';
        $country = '';
}

echo $message . $country;

```

### 6 == Patrik
Lab: Foreach Loop
An launch sequence application needs to iterate a launch checklist.

Build a launch checklist with the six items
Iterate the launch checklist using a foreach loop, using keys and values.
Conditionally test for a particular list item and build an output string.
Echo the output.

```
<?php
ini_set('display_errors', 1);

$launchChecklist = [
    'mission' => ['target' => 'Mars','objective' => 'Space Party','budget' => '$15 and a bag of Chips'],
    'staff' => [
        'astronauts' => ['Steve Jobs','Elon Musk','Mark Zuckerberg','Jesus'],
        'trained' => 'Almost',
    ],
    'requirements' => ['spaceship' => true, 'ready' => true]
];

// var_dump($launchChecklist);
$output = '';
foreach ($launchChecklist as $key => $subArray) {
    if ($key == 'mission') {
        $output .= 'Mission: ' . $subArray['objective'];
        $output .= '<br>';
        $output .= 'Target: ' . $subArray['target'];
        $output .= '<br>';
    }
    if ($key == 'staff') {
        $output .= 'The Crew: <br><ul>';
        foreach ($subArray['astronauts'] as $astronauts) {
            $output .= '<li>' . $astronauts . '</li>';
        }
        $output .= '</ul>';
        $output .= '<br>';
    }
}
$output .= 'Budget: <br>';
$output .= $launchChecklist['mission']['budget'];
$output .= '<br><br>';

$output .= 'Training complete? <br>';
$output .= $launchChecklist['staff']['trained'];
$output .= '<br><br>';

if ($launchChecklist['requirements']['spaceship']) {
    $output .= 'Spaceship ready';
    $output .= '<br><br>';
} else {
    $output .= 'Spaceship NOT ready';
}

if ($launchChecklist['requirements']['ready']
    && $launchChecklist['requirements']['spaceship']) {
        $output .= '<button>Launch Spaceship</button>';
} else {
    $output .= '<h1>Mission not ready to launch</h1>';
}
echo $output;
```



### 7 == Richard
Lab: For Loop
What does this code do?

// outputs prime numbers below 100

```
$max = 100;
for ($x = 5; $x < $max; $x++)
{
    // This if evaluation checks to see if number is odd or even
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

Lab: While Loop
An application has an invoicing system and must calculate a total for items in a list.

Construct an associative array of invoice items.
Instead of a foreach loop, which is used with arrays, construct a while loop and use it to iterate the associative array of list items, and add a tax value to each.
Output each updated values.

```
<?php
$items = [
    [
        'pens' => 7.50,
        'paper' => 8.00,
        'clips' => 1.59,
        'laptops' => 518.00,
        'desks' => 0.00,
        'chairs' => 0.00
    ],
    [
        'pens' => 0.00,
        'paper' => 18.00,
        'clips' => 0.00,
        'laptops' => 0.00,
        'desks' => 200.00,
        'chairs' => 400.00
    ],
];

$i = 0;
$total = count($items);
$tax = 0.08;
while ($i  <= $total )  {
    $subCount = count($items[$i]);
    foreach ($items[$i] as $key => $value) {
        $items[$i][$key] = (1 + $tax) * $value;
    }
    $i++;
}
print_r($items);
```

Lab: Do...While Loop
A new feature request has risen to top priority that requires showing a list of past purchases.

Create an associative array with past purchase dates and amounts.
Iterate the list using a do...while loop displaying the past purchases


# for Mon 18 Sep 2017
http://collabedit.com/c42sa

## Examples
https://github.com/dbierer/classic_php_examples/blob/master/basics/while_loop_example.php
https://github.com/dbierer/classic_php_examples/blob/master/basics/do_while_example.php

```
<?php
ini_set('display_errors', 1);
function showItemsAsUl(array $list)
{
    $output = '<ul>';
    foreach ($list as $item) {
        $output .= '<li>' . $item . '</li>';
    }
    $output .= '</ul>';
    return $output;
}

$test = ['dog', 'cat', 'bird', 'iguana', 'tookay'];

echo showItemsAsUl($test);
// as long as the function has a type hint of array, this will fail:
echo showItemsAsUl('this is not an array');
```

### Return data type example
```
<?php
ini_set('display_errors', 1);

$cards = [1,2,3,4];
$stack = ['red' => $cards, 'green' => $cards, 'blue' => $cards, 'yellow' => $cards];
// NOTE: you can also data-type the return value:
function drawCard(array $deck) : string {
    $suitKey = array_rand($deck);
    $suit = $deck[$suitKey];
    $cardKey = array_rand($suit);
    $card = $suit[$cardKey];
    unset($deck[$suitKey][$cardKey]);
    return "$suitKey $card";
}

echo drawCard($stack);
```

### Assigning array element by reference
```
<?php
ini_set('display_errors', 1);

$data = [
    'red'    => [1 => '',2 => '',3 => '',4 => ''],
    'yellow' => [1 => '',2 => '',3 => '',4 => ''],
    'green'  => [1 => '',2 => '',3 => '',4 => ''],
    'blue'   => [1 => '',2 => '',3 => '',4 => ''],
];

$data['red'][1] = 'X';
$data['yellow'][3] = 'Y';

$green4 = &$data['green'][4];
$green4 = 'Z';

var_dump($data);
```


## Lab: Defining and Calling a Function
Define a function named getOrderTotal(...), which takes two arguments and returns the sum.
Call the function and output the result.

// done two different ways

```
<?php
ini_set('display_errors', 1);

function getOrderTotal($value1 = 0, $value2 = 0)
{
    $sum = $value1 + $value2;
    return $sum;

}

echo getOrderTotal() . "<br><br>";
echo getOrderTotal(2,2) . "<br><br>";
echo getOrderTotal(99) . "<br><br>";

function getOrderTotalNow($value1, $value2)
{
    $sum = $value1 + $value2;
    return $sum;

}

echo getOrderTotalNow(10,7) . "<br><br>";
echo getOrderTotalNow(99) . "<br><br>";
```



## M5Ex2: Recursive Function Exercise
The Fibonacci sequence is a series of numbers in which each number is the sum of the previous two numbers, starting with 0.

0, 1, 1, 2, 3, 5, 8, 13, 21, 34

Write a function that returns the nth number in a Fibbonacci sequence.

```
// non-recursive example:
<?php
function fibonacci($n,$first = 0,$second = 1, &$fib = [])
{
    $val = 0;
    $fib = [$first,$second];
    for($i=1;$i<$n;$i++)
    {
        $val   = $fib[$i]+$fib[$i-1];
        $fib[] = $val;
    }
    return $val;
}
echo "<pre>";
$sequence = [];
echo fibonacci(50, 0, 1, $sequence);
print_r($sequence);
echo "</pre>";
```

```
// using rounding
function getFib($n)
{
    return round(pow((sqrt(5)+1)/2, $n) / sqrt(5));
}
// see: http://en.wikipedia.org/wiki/Fibonacci_number#Computation_by_rounding
```

```
// using recursion
<?php
function getFib($n, $fib, $max = 10, $count = 0)
{
    if ($count === 0) echo 0 . ' ';
    echo $fib . ' ';
    if ($count++ < $max) {
        getFib($fib, $n + $fib, $max, $count);
    } else {
        throw new Exception();
    }
}

echo 'The Fibonacci sequence from 0 to 10 is: ';
try {
    getFib(0, 1, 10);
} catch (Exception $e) {
}
echo '<br>' . PHP_EOL;

echo 'The Fibonacci sequence from 0 to 50 is: ';
try {
    getFib(0, 1, 50);
} catch (Exception $e) {
}
echo '<br>' . PHP_EOL;
```




## Lab: Two Functions
Build two functions, one to get an array element of configuration, and one that takes an array and builds an HTML select/option list.

```
getConfig('some config'), returns an array of allowed statuses
htmlSelectHtml($config), returns a string contains an HTML <select> element with the status options.
// Starting Code
function getConfig($configFile, 'config_key') {
    $config = include __DIR__ . '/config/' . $configFile;
    return ... // fill in the rest of this statement
}

function htmlSelectHtml( $config ) {
    $html = '<select>';
    // loop through key / value pairs to create <option> tags            ...
    $html .= '</select>';
    return $html;
}

// solution: have a look at the "orderapp" project: orderapp/src/HTML.php
```


# For Wed 20 Sep 2017
http://collabedit.com/javrx

## hit count modified to update as well as read
```
<?php
ini_set('display_errors', 1);

function getCount( $counter )
{
    if (!file_exists($counter)) touch($counter);
    $fh = fopen( $counter, 'r+' );
    //get the current count
    $num = (int) fread( $fh, 10 );
    rewind($fh);
    fwrite($fh, $num + 1);
    fclose( $fh );
    return $num;
}
echo 'Hit count: ' . getCount('counter.txt') . PHP_EOL;
```

### Leonardo == lab 1 in module 6
Lab: F-Type Functions
Write an example of:

Opening a file with error handling
Write something to the file
Close the file

```
<?php
ini_set('display_errors', 1);

if($fh = fopen('testFile.txt', 'a+')){
    $message = "\nNathan was here\n";
    fwrite($fh, $message);

    rewind($fh);
    $fileContent = '';
    while (!feof($fh)){
        $fileContent .= fread($fh,1024);
    }
    fclose($fh);
    echo $fileContent;
} else {
    exit('Unable to open file resource.');
}
```


### Mike == 2nd lab

Lab: file_get_contents()
Using file_get_contents(), get the contents of a file
Display the result

```
// Nathan
$page = file_get_contents("http://blog.portswigger.net");
echo $page;

// Leonardo
<?php
ini_set('display_errors', 1);

$filename = 'textFile.txt';
if($fh =fopen($filename, 'a'));
fwrite ($fh, 'test3' . PHP_EOL);
// fwrite ($fh, "test3\n");
fclose($fh);
$testContent = file_get_contents($filename);
echo $testContent;

// Richard
$jack = file_get_contents("http://www.google.com");
echo $jack;
```


### Nathan == 3rd

Lab: file_put_contents()
Using file_put_contents(), create some string content.
Over write the contents of a file.
Test and echo for success.

```
$page = file_get_contents("http://blog.portswigger.net");

$newFile = "newFile.html";
$message = file_put_contents($newFile, $page);
echo file_get_contents('newFile.html');
```

### Patrik == 4th

Lab: Write Array Lab
Write an array of text strings to a file.
Open the file using fopen().
read and output the third character from each line.

```
<?php
ini_set('display_errors', 1);

$filename = 'testing.txt';
$txt1 = ['Alpha', 'Beta', 'Delta', 'Ep'];

function outputThird($filename)
{
    $contents = file($filename);
    $output = '';
    foreach ($contents as $line) {
        $output .= $line[2] ?? '';
    }
    return $output;
}

// approach #1
// write the contents of the array to a file
$file = fopen($filename,'w');
foreach ($txt1 as $line) {
    fwrite($file, $line . PHP_EOL);
}
fclose($file);

// read and output 3rd char each line
// possible approach: read single chars using fgetc and take it from there

echo outputThird($filename);

// approach #2
$file = fopen($filename,'w');
fwrite($file, implode(PHP_EOL, $txt1));
fclose($file);

echo outputThird($filename);

// approach #3
file_put_contents($filename, serialize($txt1));
$array = unserialize(file_get_contents($filename));

$output = '';
foreach ($array as $line) {
    $output .= $line[2] ?? '';
}
echo $output;
```


### Karen == 5th
Read the directories and files in the class project root and output the following:
* File Name
* File Size
* Number of lines in the file

```
// Counts lines in a file
function countLines($filename) {
    $count = 0;
    if (file_exists($filename)) {
        $fh = fopen($filename, 'r');
        if ($fh) {
            while (!feof($fh)) {
                $a = fgets($fh);
                $count++;
            }
            fclose($fh);
        }
    }
    return $count;
}

function dirList($fileList) {
    // retrieve files in this directory
    static $output = '';
    $list = glob($fileList . '/*');
    // loop through list
    foreach ($list as $item) {
        // if it is directory, output and call this function again
        // **How can we do this to only print out filenames (not directories?)
        //**I tried the is_file function and it wouldn't work
        if (is_dir($item)) {
            $output .= "$item <br>";
            $output .= dirList($item);
        // otherwise print out filename
        } else {
            $size = filesize($item);
            $lines = countLines($item);
            $output .= sprintf("<br>%s %d %d ", basename($item), $size, $lines);
        }
    }
    return $output;
}  echo dirList('../');

// also: have a look at RecursiveDirectoryIterator: http://php.net/recursivedirectoryiterator
// see: https://github.com/dbierer/classic_php_examples/blob/master/file/recursive_directory_scan.php

```

# For Fri 23 Sep 2017
http://collabedit.com/wv853

```
## Example of multiple forms on one page:
<form action="test.php?form=1" method="post" >
<input type="text" name="test" />
<input type="hidden" value="form1" />
<input type="submit" name="submit" value="Test" />
</form>
<hr>
<form action="test.php?form=2" method="post" >
<input type="text" name="test" />
<input type="hidden" value="form2" />
<input type="submit" name="submit" value="Whatever" />
</form>

<?php phpinfo(INFO_VARIABLES); ?>
```

## Example of output escaping
```
<?php
$test = '';
if ($_POST) {
    $test = $_POST['test'] ?? '';
}
?>
<form action="test.php?form=1" method="post" >
<input type="text" name="test" value="<?= htmlentities($test)?>"/>
<input type="hidden" value="form1" />
<input type="submit" name="submit" value="Test" />
</form>
<hr>
<form action="test.php?form=2" method="post" >
<input type="text" name="test" value="<?= htmlentities($test) ?>" />
<input type="hidden" value="form2" />
<input type="submit" name="submit" value="Whatever" />
</form>

<?php phpinfo(INFO_VARIABLES); ?>
```

### Cookie / Session Examples
https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_counter.php
https://github.com/dbierer/classic_php_examples/blob/master/web/session_counter.php

Order for Homework:

Karen
Lab: Embedded PHP
Build an standard HTML form with embedded PHP
Account for
form tag attributes
input tags for both username and password
dynamic attributes for each input tags
a submit button

```
<?php

ini_set('display_errors', 1);

$inputAtt='username';
$passwordAtt ='password'; ?>
<!DOCTYPE="html">
<html>
<head>
</head>
<body>
<form action="youCantGoHere.com"
    method="post" name="Alumni Library Log In" id="Alumni Library Log In">
        <input id="referer" name="referer" value="https://alumni.libraries.psu.edu/databases" type="hidden">
        <fieldset class="fieldset">
            <legend>Access the Alumni Library Databases
            </legend><br><div class="row">
<div class="medium-6 columns">
<label>ID Number

<input id="username" name="<?php echo $inputAtt ?>" placeholder="10 digit ID number, no dashes" type="text">
</label>
</div>
<div class="medium-6 columns">
<label>Password
<input id="password" name="<?= $passwordAtt ?>" placeholder="Last Name, case sensitive" type="password">
</label>
</div>
</div>
<p> <input class="button" value="Submit" type="submit"></p>
</fieldset>
</form>
</body>
</html>
```


Leonardo

Lab: PHP Form String
Only using PHP, build a simple login form.

Output the HTML to the browser

```
// Starting Code
$html = '<form';

// code …

$html .= '</form>’;
```

```
<?php
// core.php
function createFormTag($form)
{
    $output = '';
    $output .= '<form ';
    foreach ($form['form'] as $key => $value) {
        $output .= ' ' . $key . '=' . $value;
    }
    $output .= '>';
    return $output;
}
function createInputTag($key, $elementSub)
{
    $output = '';
    $output .= '<br>' . ucfirst($key);
    $output .= '<input ';
    foreach ($elementSub as $key => $value) {
       $output .= ' ' . $key . '="' . $value . '"';
    }
    $output .= ' />';
    return $output;
}

/**
 * Builds the entire form
 * @param array $form == return value from the form config file
 * @string form HTML
 */

function buildForm($form)
{
    $output = '';
    $output .= createFormTag($form);
    foreach ($form['elements'] as $key => $elementSub) {
        $output .= createInputTag($key, $elementSub);
    }
    $output .= '</form>';
    return $output;
}
```

```
<?php
// index.php
include __DIR__ . '/core.php';
$form = include __DIR__ . '/../config/form_config.php';
echo buildForm($form);
```
```
//variable assignments as necessary
// form_config.php
<?php
// form_conf
$form = [
    'form' => [
        'name' => 'someForm',
        'method' => 'post',
        'action' => 'xyz.php',
    ],
    'elements' => [
        'username' => [
            'type' => 'text',
            'name' => 'username',
        ],
        'password' => [
            'type' => 'password',
            'name' => 'credential',
        ],
        'submit' => [
            'type' => 'submit',
            'value' => 'Login',
        ]
    ]
];
return $form;
```

# For Mon 25 Sep 2017
http://collabedit.com/97xxr

## MongoDB Examples
https://github.com/dbierer/classic_php_examples/tree/master/mongoDB

## SQL
https://www.w3schools.com/sql/

## Poor Man or Woman's debugger:

echo __FILE__ . ':' . __LINE__ . ':' . var_export($var, TRUE); exit;

## Security
https://www.owasp.org/index.php/Main_Page

### Last Day Labs

Lab: Secure Input Handling
Create a script that takes input from a login form (username, password, and email address).
Filter and validate all inputs
Display a message for both invalid and valid input.

Lab: Escaping Exercise
Update the email sanitizing script you wrote in a previous exercise, escaping the output.

```
<?php
// this starts output buffering; buffer is auto-flushed upon program end
ob_start();
define('TITLE', 'Login page');

$header = '<h1>' . TITLE . '</h1>';

$form = '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
$form .= '<div>';
$form .= '<label>Username</label>';
$form .= '<input type="text" name="username" />';
$form .= '</div>';
$form .= '<div>';
$form .= '<label>Password</label>';
$form .= '<input type="password" name="password" />';
$form .= '</div>';
$form .= '<input type="submit" name="submit" value"Login" />';
$form .= '</form>';
echo $header . $form;

// OR:
// if ($_SERVER['REQUEST_METHOD'] == 'post') {}
if (isset($_POST['submit'])) {

    // alt for php 5.6 and below (also works in PHP 7)
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';
    // this works in PHP 7+
    $password = $_POST['password'] ?? '';
    $email = 'info@mail.com';


    //filter username
    if (ctype_alnum($username)) {
        echo htmlspecialchars("$username consists of all letters or digits.\n");
    } else {
        echo htmlspecialchars("$username does not consist of all letters or digits.\n");
    }

    //filter password
    if (strip_tags($password)) {
        echo "$password will work.\n";
    } else {
        echo "$password won't work.\n";
    }

    //filter email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
        echo htmlspecialchars("$email is a valid email address");
    } else {
        echo htmlspecialchars("$email is not a valid email address");
    }
}
```

* M8Ex1: Exercise
  * Using the phpMyAdmin web interface, or the SQL entry editor.
  * Create a new database called Accounts.
  * Create a new table called profile with columns for id, email, password, avatar, and language.
  * Insert three records into the new table.
  * Retrieve the second record
  * The email == login name

```
CREATE TABLE `accounts`.`profile` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `email` VARCHAR(254) NOT NULL , `password` VARCHAR(64) NOT NULL , `avatar` VARCHAR(253) NULL , `language` CHAR(5) NULL DEFAULT 'en_US' , PRIMARY KEY (`id`), UNIQUE `unique_email` (`email`)) ENGINE = InnoDB;

INSERT INTO `profile` (`id`, `email`, `password`, `avatar`, `language`) VALUES (NULL, 'clark@zend.com', '$2y$10$WnITT6s82WhGZwoKhK7iIei195Pfswf6VM8bOkXk8l01ttWHyxPeq', NULL, 'en_US');
```

### PHP program to retrieve all entries from Accounts::profile

```
<?php
// config.php
return [
    'host' => 'localhost',
    'user' => 'vagrant',
    'pwd'  => 'vagrant',
    'db'   => 'accounts'
];
```

```
<?php
// test.php
// using mysqli return all entries from accounts::profile
define('DB_ERROR', 'Database Error');
$config = include __DIR__ . '/../config/config.php';
$sql    = 'SELECT * FROM profile';

// procedural style
$conn   = mysqli_connect($config['host'],$config['user'],$config['pwd'],$config['db']);
if ($conn) {
    $result = mysqli_query($conn, $sql);
    while ($row = $result->fetch_assoc()) {
        $final[] = $row;
    }
    mysqli_close($conn);
} else {
    error_log(__FILE__ . ':' . $e->getMessage());
    echo DB_ERROR;
}

// oop style
try {
    $conn   = new mysqli($config['host'],$config['user'],$config['pwd'],$config['db']);
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $final[] = $row;
        }
    } else {
        error_log(__FILE__ . ':Query Failed');
        echo DB_ERROR;
    }
} catch (Exception $e) {
    error_log(__FILE__ . ':' . $e->getMessage());
    echo DB_ERROR;
}

echo '<pre>';
var_dump($final);
echo '</pre>';
```


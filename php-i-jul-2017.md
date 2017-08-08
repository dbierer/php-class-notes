# PHP-I NOTES -- JULY 2017

## VM instructions need this added:
* Importing Projects into Zend Studio
  * To launch the Zend Studio IDE, select the Files icon (top left) on the launcher toolbar
  * Search from the Home folder for ZendStudio
  * Click on the diamond icon ZendStudio
  * Projects can then created using: File | Import | General | Existing Projects Into Workspace
  * Projects are located in /home/vagrant/Zend/workspaces/DefaultWorkspace
  * Click ¨Finish¨ to import
  
## VM projects each need .buildpath:
```
<?xml version="1.0" encoding="UTF-8"?>
<buildpath>
    <buildpathentry kind="src" path=""/>
    <buildpathentry kind="con" path="org.eclipse.php.core.LANGUAGE"/>
</buildpath>
```

```
<?php
// auto-promotes data type from "int" to "float"
$a = PHP_INT_MAX;
var_dump($a);
$a++;
var_dump($a);
$a--;
$a = (int) $a;
var_dump($a);
```


```
<?php
// example of using % for table striping
echo '<table>';
for ($x =0; $x < 10; $x++) {
    if ($x % 2 == 0) {
        $color = 'gray';
    } else {
        $color = 'black';
    }
    echo '<tr style="color:' . $color . ';">';
    echo '<td>Whatever<td>';
    echo '</tr>';
}
echo '</table>';
```

```
<?php
// example of catching an error
$variableOne = 7 % 3;
echo $variableOne;

$variableTwo = 0 % 3;
echo $variableTwo;

$variableThree = 1 % 3;
echo $variableThree;

try {
    $variableFour= 3 % 0;
    echo $variableFour;
// could also just catch "Error" which is generic
} catch (DivisionByZeroError $e) {
    echo $e->getMessage();
}
```

## For Fri 14 Jul 2017
// (http://collabedit.com/x5qdg)[http://collabedit.com/x5qdg]

```
<?php
// example of how to split a string
$phrase = 'Programming in PHP is fun!';
$test[] = explode(' ', $phrase);
$test[] = str_word_count($phrase, 1);
$test[] = preg_split('/\b| /', $phrase, NULL, PREG_SPLIT_NO_EMPTY);

echo '<pre>';
var_dump($test);
echo '</pre>';
```

```
<?php
// array_key_exists vs. isset
$days = [
    'mon' => 'Monday',
    'tue' => 'Tuesday',
    'wed' => 'Wednesday'
];


if (!array_key_exists('fri', $days)) {
    echo 'You have no weekend!!!';
} else {
    echo 'Hooray!';
}

// alternate approach:

if (!isset($days['fri'])) {
    echo 'You have no weekend!!!';
} else {
    echo 'Hooray!';
}
```

```
<?php
// ternary example
// ternary example setting default from URL params
// i.e. http://sandbox/test.php?status=12345&provider=facebook

define('DEFAULT_PROVIDER', 'google');
$status = (isset($_GET['status'])) ? (int) $_GET['status'] : 0;
$provider = (isset($_GET['provider']))
            ? strip_tags($_GET['provider']) 
            : DEFAULT_PROVIDER;

// example of null coalesce
$token = $_COOKIE['token'] ?? $_POST['token'] ?? $_GET['token'] ?? DEFAULT_TOKEN;

echo $status . ':' . $provider . ':'. $token;
```

### brock
* M3Ex5: Exercise
  *  Declare an array that contains the following sentence with one word in each array element: Programming in PHP is fun! Then, output the third element.

```
// BEGIN -------------------------------------------------------------------------------------------------
<?php
//M3 Ex 5
$sentence = ['Programming ', 'in ', 'PHP ', 'is ', 'fun!'];
print_r($sentence[2]);

/*M3 Ex 8
Key for long = 7 because it is next hightst number */
$numbers = [1,2,3,4];
$cards = [
    'red' => $numbers,
    'blue' => $numbers,
    'green' => $numbers,
    'yellow' => $numbers,
];

//Print Yellow 3
echo 'Yellow ' . $cards['yellow'][2];
// END ---------------------------------------------------------------------------------------------------
```

### danny
* M3Ex6: Exercise
  * What is the code to output the Tuesday in October?

```
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Friday'];
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
            'December'  => $days // The last comma can included or removed
          ];

// BEGIN -------------------------------------------------------------------------------------------------
var_dump($months['October'][1]);


// END ---------------------------------------------------------------------------------------------------
```

### zach
* M3Ex7: Orders Array
  * What is the output of this script?

```
$orders = [
    [
        'id' => 1,
        'orderStatus' => 'complete',
        'amount' => 560,
        'description' => 'Printer',
        'customerName' => 'Susie Builder',
        'formattedDate' => 'Dec 14, 1963'],
    [
        'id' => 2,
        'orderStatus' => 'invoiced',
        'amount' => 9800,
        'description' => 'Networking',
        'customerName' => 'Bob Builder',
        'formattedDate' => 'Jun 14, 1961']
];

echo $orders[1]['customerName'];

// BEGIN -------------------------------------------------------------------------------------------------
// output: "Bob Builder"
// END ---------------------------------------------------------------------------------------------------
```

### brock
* M3Ex8: Exercise
  * What is the key for 'long'?
  * What is the key for 'North America'?

```
$geo = ['country' => 'USA',
    6 => 47.005,
    'long',
    5 => 'eagle'];
$geo[] = 'North America';
    

// BEGIN -------------------------------------------------------------------------------------------------
// keys: 7, 0
// END ---------------------------------------------------------------------------------------------------
```
    
### for everyone
* M3Ex9 Exercise
  * Create a multi-dimensional array to hold the cards and numbers indicated below. Be as code efficient as you can.
  * Use colors as the primary array key
  * Output one color and card number

(red, blue, green, yellow)
(1, 2, 3, 4)

```
// BEGIN ------------------------------------
$colors = ['red', 'blue' , 'green', 'yellow'];
$cards = [ '1'   => $colors,
           '2'   => $colors,
           '3'   => $colors,
           '4'   => $colors ];
           
//var_dump($colors);
//echo "<br>";
//var_dump($cards);-------------------------------------------------------------
var_dump($cards[2][3]);

// END ---------------------------------------------------------------------------------------------------
```

## For Mon 17 July 2017
(http://collabedit.com/95mvv)[http://collabedit.com/95mvv]

### danny
* M4Ex2: Exercise
  * What is the output from each if/else construct?


```
$valueA = "50";
$valueB = 50;

// expected: equal
if ( $valueA == $valueB ) {
    echo "Equal <br>";
} else {
    echo "Not equal <br>";
}

// expected: Not identical 
if ( $valueA === $valueB ) {
    echo "Identical <br>";
} else {
    echo "Not identical <br>";
}
```


### zach
* M4Ex3: Exercise
  * What is the output from each if/else construct?

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

// Output: OrangesBlack 
```

### brock
* M4Ex4: Exercise
  * What is necessary to make this if statement into an if-else statement?

```
if ( $dayOfWeek === "Friday" ) {
    echo "See you on Monday <br>";
} else {
    echo "Enjoy the rest of your week <br>";
}

```

### danny
* M4Ex5: Exercise
  * Assume that people work in an office from Monday through Friday, and are off work on Saturday and Sunday.
  * Modify the code below to handle the response if the day is either Saturday or Sunday?

```
define('SEE_MONDAY', 'See you on Monday');
$dayOfWeek = "Monday";

if ( $dayOfWeek === "Friday" ) {
    echo SEE_MONDAY;
} elseif ($dayOfWeek === "Saturday") {
    echo SEE_MONDAY;
} else {
    echo "See you tomorrow";
}

// switch logic around
if ( $dayOfWeek === "Friday" || $dayOfWeek === "Saturday" ) {
    echo "See you on Monday";
} else {
    echo "See you tomorrow";
}

// another solution:
$workdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
$dayOfWeek = "Saturday";
if (!in_array($dayOfWeek ,  $workdays)) {
    echo "See you on Monday" ;
    //}
} else {
    echo "See you tomorrow";
}
```

### zach
* M4Ex6: Conditionals
  * Write a switch construct that evaluates multiple cases against a true boolean, and acts upon one of them.

```
// NOTE: this works ... but the results might not be as expected
//       In this modified example, result is "1" which might not be desired
$val = true;
switch ($val) {
    case 1 :
        echo '1';
        break;
    case true:
        echo 'true';
        break;
    case false:
        echo 'false';
        break;
    case 0:
        echo '0';
        break;
}
```

```
<?php
$val = true;
switch (true) {
    case $val === 1:
        echo '1';
        break;
    case $val === true:
        echo 'true';
        break;
    case $val === 0:
        echo '0';
        break;
    case $val === false:
        echo 'false';
        break;
}
```

## For Wed 19 Jul 2017
(http://collabedit.com/y7pfm)[http://collabedit.com/y7pfm]

```
<?php
// example foreach() using ArrayIterator
$array = [1, 2, 3, 4];
$iterator = new ArrayIterator($array);
foreach ( $iterator as $key => $value ) {
    //store the new value back into the array
    $iterator->offSetSet($key, $value * 1.1);
}

echo '<pre>';
var_dump($iterator);
echo '</pre>';
```

```
<?php
// while() loop based on time
// example of while() based on time

$start  = time();
$end    = $start + 2;
$current = $start;
$alpha   = 'abcdefghijklmnopqrstuvwxyz';
$rand    = '';
while ($current < $end) {
    $current = time();
    $rand .= $alpha[rand(0,25)];
}

echo strlen($rand);
echo '<br>';
echo $rand;
```


## homework

### brock
* M4Ex7: Exercise
  * Build a card deck with the four colors representing suits, and four cards 1-4.
  * Iterate the card deck using a foreach loop, using keys and values.
  * Conditionally test for a suit and card of choice and build an output string.
  * Echo the output.
  * Here are the deck components:
```
colors: red, blue, green, and yellow
numbers: 1, 2, 3, 4
```

```
// BEGIN ---------------------------------------------------------------------------------------------
<?php
// example of while() based on time
ob_start();
define('DEFAULT_COLOR', 'red');
define('DEFAULT_CARD', 1);
$numbers = [1,2,3,4];
$cards = [
    'red' => $numbers,
    'blue' => $numbers,
    'green' => $numbers,
    'yellow' => $numbers,
];

$output = '';
$temp = $_GET['color'] ?? DEFAULT_COLOR;
if (in_array($temp, array_keys($cards))) {
    $search['color'] = $temp;
} else {
    $search['color'] = DEFAULT_COLOR;
}
$temp = $_GET['card'] ?? DEFAULT_CARD;
if (in_array($temp, $numbers)) {
    $search['card'] = $temp;
} else {
    $search['card'] = DEFAULT_CARD;
}
foreach ($cards as $key => $inner) {
    $output .= '<h2>'. $key . '</h2><ul>';
    foreach ($inner as $subKey => $value) {
        if ($key == $search['color'] && $value == $search['card']) {
            $output .= '<li><b style="color:' . $search['color'] . ';">' . $value . '</b></li>';
        } else {
            $output .= '<li>' . $value . '</li>';
            
        }
    }
    $output .= '</ul>';
}
?>
<!DOCTYPE html>
<html>
<body>
<?= $output; ?>
</body>
</html>

// END -----------------------------------------------------------------------------------------------
```

### danny
* M4Ex8: for Loop
  * What does this code do?

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

// ans: produces prime numbers between 1 and 100
```

### zach
* M4Ex9: Exercise
  * How is this code different from that used in the for statement?

```
$i = 1;

while ($i <= 5) {
    echo $i . "Hello World!\n";
    $i++;
}

// ans: This code will execute as long as the condition is met, while the for loop will execute a set number of times.
```

### brock
* M4Ex10: Exercise
  * Write a do...while loop construct that decrements a count value of 6 for customer James Dean.

```
// BEGIN ---------------------------------------------------------------------------------------------
<?php
echo 'Hello James Dean!';
echo '<br>';
$count = 6;
do {
    echo $count;
} while (--$count >= 0);


// END -----------------------------------------------------------------------------------------------
```

### danny
* M4Ex11: Exercise
  * What is the output?

```
<?php
$i = 6;

while ( $i > 0 ) {
    if ( $i === 4 ) break;
    echo "You only have $i chance(s) to get this right!<br>";
    $i--;
}

// actual output:
/*
You only have 6 chance(s) to get this right!
You only have 5 chance(s) to get this right!
*/
```

### zach
* M4Ex12: Looping
  * Write code to count from 1 to 10 using each type of loop:

```
for ($i = 1; $i <= 10; $i++) {
    echo $i;
}

$x = 1;
while ($x <= 10) {
    echo $x;
    $x++;
}

$y = 1;
do {
    echo $y;
    $y++;
} while ($y <= 10);
```

## brock
* M5Ex1: Function Calling
  * Create a script that defines a function named getOrderTotal ($num1, $num2), which takes two arguments and returns the sum.
  * Call the function and output the result.

```
// BEGIN ---------------------------------------------------------------------------------------------
function getOrderTotal($num1, $num2)
{
    $total = $num1 + $num2;
    return $total;   
}
// END -----------------------------------------------------------------------------------------------
```

## For Fri 21 Jul 2017
(http://collabedit.com/scent)[http://collabedit.com/scent]


```
<?php
// example of "splat" operator

function sumOfSomething($a, $b = 0, ...$params)
{
    echo '<pre>' . var_export($params, TRUE) . '</pre>';
}

sumofSomething(1);

sumofSomething(1,2,3,4,5,6);

sumofSomething(1,2,3,4,5,6,7,8,9);
```


### brock
* M5Ex2: Recursive Function Exercise
  * The Fibonacci sequence is a series of numbers in which each number is the sum of the previous two numbers, starting with 0.
  * 0, 1, 1, 2, 3, 5, 8, 13, 21, 34
  * Write a function that returns the nth number in a Fibbonacci sequence.

```
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

### zach
* M5Ex3: Exercise
  * Notice the variable $varA has the same name inside and outside of the function.

```
$varA = 1;
function myTestFunction()
{
    $varA = 2;
    return $varA;
}

// call the function
echo myTestFunction();
// echoes the value of $varA inside the function scope

echo $varA;
// What is the return value of the call line?  2
// What is the echoed value on the last line?  1
```

### danny
* M5Ex4: Exercise
  * Build two functions, one to get an array element of configuration, and one that takes an array and builds an HTML select/option list.
  * getConfig('some config'), returns an array of allowed statuses
  * htmlSelectHtml($config), returns a string contains an HTML <select> element with the status options.

```
<?php
ob_start();
define('CONFIG_FILE', 'config.php');
// Starting Code
function getConfig($configFile, $key)
{
    $config = include __DIR__ . '/../config/' . $configFile;
    return $config[$key]; // fill in the rest of this statement
}

function htmlSelectHtml( $config )
{
    $html = '<select name="days">';
    // loop through key / value pairs to create <option> tags
    foreach ($config as $key => $value) {
        $html .= '<option value="' . $key . '">' . $value . '</option>';
    }
    $html .= '</select>';
    return $html;
}

$days = getConfig(CONFIG_FILE, 'days');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php
echo '<form method="post">';
echo htmlSelectHtml($days);
echo '<input type="submit" />';
echo '</form>';
phpinfo(INFO_VARIABLES);
?>
</body>
</html>
```

## For Mon 24 Jul 2017
(http://collabedit.com/4b6qn)[http://collabedit.com/4b6qn]

```
<?php
// hit count example but using file_xxx_contents() instead of f* commands
function getCount( $counter )
{
    if (!file_exists($counter)) touch($counter);
    //get the current count
    $num = (int) file_get_contents($counter);
    //write the new number
    file_put_contents($counter, ++$num);
    return $num;
}
echo '<pre>';
echo 'Hit count: ' . getCount('counter.txt') . PHP_EOL;
echo 'Hit count: ' . getCount('counter.txt') . PHP_EOL;
echo 'Hit count: ' . getCount('counter.txt') . PHP_EOL;
echo '</pre>';
```

### brock
* M6Ex1: Exercise
  * Write an example of:
  * Open a file with error handling
  * Write something to the file
  * Close the file
  
```
//begin
<?php
if(!$file = fopen('data.txt', 'w')) {
    exit('Error or file does not exist!');
} else {
    fwrite($file, "Hello world!");
    fclose($file);
}

//end
```

### danny
* M6Ex2: Exercise
  * Using file_get_contents(), get the contents of a file
  * Display the result

```
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!$file = fopen('data.txt', 'w')) {
    exit('Error or file does not exist!');
} else {
    fwrite($file, "Hello world!");
    fclose($file);
}
// one alternative
echo file_get_contents('data.txt');
readfile('data.txt');
```

### zach
* M6Ex3: Exercise
  * Using file_put_contents(), create some string content.
  * file_put_contents('file.txt', 'String content');
  * Over write the contents of a file.
  * Test and echo for success.
  
```
if (file_put_contents('file.txt', 'New content')) {
    echo 'Success!';
}
```

### brock
* M6Ex4: Exercise
  * Write an array of text strings to a file.
  * Open the file using fopen().
  * read and output the third character from each line.
  
```
//begin
<?php
$data = ['Hello, ', 'this ', 'is ', 'an ', 'array ', 'in ', 'a ', 'text ', 'file!'];
if(!$file = fopen('data.txt', 'w')) {
    exit('Error or file does not exist!');
} else {
    foreach($data as $k) {
        fwrite($file, $k);
    }
    fclose($file);
}
// using single string approach
$contents = file_get_contents('data.txt');
$pos = 0;
while ($pos < strlen($contents)) {
    if (($pos +1) % 3 == 0) {
        echo substr($contents, $pos, 1);
    }
    $pos++;
}

//end
```

### danny
* M6Ex5: Exercise
  * Read the directories and files in the class project root and output the following:
  * File Name
  * File Size
  * Number of lines in the file

```
// examples of how to get file info from a path
<?php
$path = __DIR__;
$list = glob($path . '/*');
echo '<pre>';

foreach ($list as $file) {
    if (is_dir($file)) continue;
    printf('%20s | %8d | %8d ' . PHP_EOL, basename($file), filesize($file), count(file($file)));
}

echo '</pre>';
```

## for Thu 27 Jul 2017
(http://collabedit.com/ke9sh)[http://collabedit.com/ke9sh]

```
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
<form method="post">
<input type="text" name="test" />
<input type="checkbox" name="check[]" value="1"/>1
<input type="checkbox" name="check[]" value="2" />2
<input type="checkbox" name="check[]" value="3"/>3
<input type="checkbox" name="check[]" value="4"/>4
<input type="submit" />
</form>
</body>
</html>
<?php phpinfo(INFO_VARIABLES); ?>
```

```
<?php
// validating an email address
$message = 'EMAIL does not validate';
if (isset($_POST['submit'])) {
    if (isset($_POST['email']))
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = 'EMAIL validates OK';
        }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
<form method="post">
<input type="text" name="email" /> <?= $message ?><br>
<input type="checkbox" name="check[]" value="1"/>1
<input type="checkbox" name="check[]" value="2" />2
<input type="checkbox" name="check[]" value="3"/>3
<input type="checkbox" name="check[]" value="4"/>4
<input type="submit" name="submit" value="login" />
</form>
</body>
</html>
<?php phpinfo(INFO_VARIABLES); ?>
```

```
<?php
// filters + validates
$allowed = ['com','net','biz'];
$email = '';
$valid = FALSE;
$message = 'EMAIL does not validate';
if (isset($_POST['submit'])) {
    if (isset($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            foreach ($allowed as $ext) {
                if (substr($_POST['email'], -3) == $ext) {
                    $valid = TRUE;
                    break;
                }
            }
            if ($valid) $message = 'EMAIL validates OK';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
<form method="post">
<input type="text" name="email" value="<?= $email; ?>"/><?= $message; ?><br>
<input type="checkbox" name="check[]" value="1"/>1
<input type="checkbox" name="check[]" value="2" />2
<input type="checkbox" name="check[]" value="3"/>3
<input type="checkbox" name="check[]" value="4"/>4
<input type="submit" name="submit" value="login" />
</form>
</body>
</html>
<?php phpinfo(INFO_VARIABLES); ?>
```


### brock
* M7Ex1: Exercise
  * Build an standard HTML form with embeded PHP
  * Account for
    * form tag attributes
    * input tags for both username and password
    * dynamic attributes for each input tags
    * a submit button

```
//variable assignments as necessary
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


```
// form.php
<?php 
ob_start();
$form = include __DIR__ . '/../config/form_config.php';
?>
<form <?php foreach ($form['form'] as $key => $value) { echo ' ' . $key . '=' . $value; } ?> >
<?php foreach ($form['elements'] as $key => $elementSub) { ?> 
    <br><?php echo ucfirst($key) ?> :
    <input <?php foreach ($elementSub as $key => $value) { echo ' ' . $key . '=' . $value; } ?> />
<?php } ?>
</form>
```

### danny
* M7Ex2: Exercise
  * Only using PHP, build a simple login form.
  * Output the HTML to the browser

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

### zach
* M7Ex3: Exercise
  * Create a script that takes input from a login form (username, password, and email address).
  * Filter and validate all inputs
  * Display a message for both invalid and valid input.


## for Fri 28 Jul 2017
(http://collabedit.com/a82kw)[http://collabedit.com/a82kw]

(https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_solution.php)[https://github.com/dbierer/classic_php_examples/blob/master/web/cookie_solution.php]
(https://github.com/dbierer/classic_php_examples/blob/master/web/session_solution.php)[https://github.com/dbierer/classic_php_examples/blob/master/web/session_solution.php]

```
// join customers and orders
SELECT * FROM `customers` AS c JOIN `orders` AS o ON o.customer = c.id 
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

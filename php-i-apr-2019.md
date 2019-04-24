# PHP-I Class Notes: Apr 2019

file:///D:/Repos/PHP-Fundamentals-I/Course_Materials/index.html#/6/39

## Homework
* For Fri 26 April
  Collabedit: http://collabedit.com/gp56g
  * Sean: Lab: Secure Input Handling
  * Shirley: Lab: Escaping Exercise
  * Srinivas: Lab: SQL
  * Tim: Lab: Putting It Together
* For Wed 24 April
  Collabedit: http://collabedit.com/w95fs
  * Viktor: Lab: Embedded PHP
  * Marcella: Lab: PHP Form String

* For Mon 22 April
  Collabedit: http://collabedit.com/e4972
  * Srinivas: Lab: Two Functions
  * Tim: Lab: F-Type Functions
  * Viktor: Lab: file_get_contents()
  * Marcella: Lab: file_put_contents()
  * Sean: Lab: Write Array Lab
  * Srinivas: Lab: Read Directories
* For Fri 19 April
  Collabedit: http://collabedit.com/7krfu
  * Shirley: Lab: Defining and Calling a Function
  * Srinivas: Lab: Recursive Function Exercise
* For Wed 17 April
  Collabedit: http://collabedit.com/5es2d
  * Sean: Lab: Switch Construct
  * Srinivas: Lab: Foreach Loop
  * Tim: Lab: For Loop
  * Viktor: Lab: While Loop
  * Marcella: Lab: Do...While Loop
* For Mon 15 April
  * Please put your solutions here: http://collabedit.com/ve9n9
  * Course Module 3: Foundation
	  * Marcella: Lab: The Mixed Array 1
	  * Sean: Lab: The Mixed Array 2
	  * Shirley: Lab: The Multi Array
	  * Tim: Lab: The Multi Configuration Array
	  * Viktor: Lab: First Program
	  * Marcella: Lab: Additional Crew Members
  * Course Module 4: Control Structures
	* Sean: Lab: Conditional If
    * Shirley: Lab: Conditional If-Else Equality
    * Tim: Lab: Conditional If-Else Exclusive OR
	* Viktor: Lab: Conditional If-ElseIf

## NOTE TO SELF:
* Q: Please research this syntax:
```
$${0*${0}=$_price * $_qty}
```
* Q: Can you find a practical example of xor?
* A:
* Q: Can you find a practical example of do / while?
* A:

## Resources
* Repository of PHP code examples developed to supplement the PHP classes
  * https://github.com/dbierer/classic_php_examples
* DB Rankings: https://db-engines.com/en/ranking

## Class Discussion
* Example of simple query using config.php from the orderapp:
```
<?php
$config = include __DIR__ . '/../config/config.php';
$db     = $config['db'];
$conn   = mysqli_connect($db['dsn'],$db['username'],$db['password'],$db['database']);

$query  = mysqli_query($conn, 'SELECT * FROM orders');
while ($row = mysqli_fetch_assoc($query)) {
    var_dump($row);
}
```
* Reading the error log in the VM:
```
sudo tail /var/log/apache2/error.log
```
* Simple login form example w/ phpinfo()
```
<?php
$html = '<form action="/test.php" method="post">';
$html .= 'Username: <input type="text" name="username" />';
$html .= '<br>Password: <input type="password" name="password" />';
$html .= '<br><input type="submit" />';
$html .= '</form>';

if ($_POST) {
    phpinfo(INFO_VARIABLES);
}

echo $html;

```

* Recursive directory scan (without using the RecursiveDirectoryIterator SPL class)
  * https://github.com/dbierer/classic_php_examples/blob/master/file/recursive_directory_scan.php

* `file_get_contents()`
```
<?php
$contents = file_get_contents('http://google.com/');
$contents = str_ireplace('Google', 'Boogle', $contents);
echo $contents;
```
* Array examples
```
<?php
$a = [1,2,3];
$b = [4,5,6];
var_dump(array_merge($a, $b));

$c = ['A' => 'a', 'B' => 'b', 'C' => 'c'];
$d = ['X' => 'x', 'Y' => 'y' , 'Z' => 'z', 'A' => NULL];
var_dump(array_merge($c, $d));
```

* Doing arithmetic within ""
  * https://stackoverflow.com/questions/18181491/can-we-do-some-arithmetic-operation-within-double-quotes
* Magic Constants: https://www.php.net/manual/en/language.constants.predefined.php
* Using Ternary operator for pagination:
```
<?php
$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 0;
$next = $page + 1;
$next = ($next > 10) ? 10 : $next;
$prev = $page - 1;
$prev = ($prev < 0) ? 0 : $prev;

echo "Page: $page | Next: $next | Previous: $prev";

```
* Redirect
```
<?php
$test = $_GET['test'] ?? FALSE;

if (!$test) {
    // this performs a FULL redirect
    header('Location: http://zend.com');
    exit;
}

echo htmlspecialchars($test);
```
* for loop can also count down!
```
<?php
$max = 10;
for ( $i = 1; $i <= $max; $i++) {
    echo "Count to $i" . '<br>' . PHP_EOL;
}

for ( $i = $max; $i > 0; $i--) {
    echo "Count to $i" . '<br>' . PHP_EOL;
}
```

## Course Mods
* Increase the font size for code examples in CSS: in index.html:
```
.reveal pre {
    font-size: 0.88em;
}
```

* Alternate way of pre-assigning a multi-array
```
<?php
// Build the crew
$astronaut = [
	['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'],
	['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'],
	['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'],
	['firstName' => 'Marcella', 'lastName' => 'Parker', 'specialty' => 'App Support'],
	['firstName' => 'Bob', 'lastName' => 'Vila', 'specialty' => 'Carpenter'],
];

// Build the mission
$mission = ['STS395' => $astronaut];

//Output a double-quoted string with embedded array values
echo "{$mission['STS395'][3]['firstName']} {$mission['STS395'][3]['lastName']} is the best astronaut!";
```
* Alternatives to ternary
```
<?php
// override the display errors setting
// on a live Internet-facing server, set it this way:
// ini_set('display_errors', 0);
ini_set('display_errors', 1);

// takes URL parameter called "name"

// example using ternary operator
$name = (isset($_GET['name'])) ? $_GET['name'] : 'guest' . __LINE__;

// example using compressed ternary
$name = $_GET['name'] ?: 'guest' . __LINE__;

// example using null coalesce operator
$name = $_GET['name'] ?? 'guest' . __LINE__;

// need to escape the output
// should consider filtering/validating/sanitizing the input as well!
echo 'Name: ' . htmlspecialchars($name);
```
* break multiple levels
```
<?php
for ($x = 0; $x < 10; $x++) {
	for ($y = 0; $y < 10; $y++) {
		for ($z = 0; $z < 10; $z++) {
			echo $x . ':' . $y . ':' . $z . ' ';
			if ($z == 5) break 1;
		}
	}
}
```

## HOMEWORK
* Mon 15 Apr 2019
```
//Tim - Lab: The Multi configuration array
<?php
$config = [
    'router' => [
        'routes' => [
            'market' => [
                 'type' => 'literal',
                 'options' => [
                     'route' => '/market',
                     'defaults' => [
                         'controller' => 'IndexController',
                         'action' => 'index',
                     ],
                 ],
            ],
        ],
    ],
];
echo $config ['router']['routes']['market']['options']['defaults']['action'];

//  Tim - Lab: Conditional If-Else Exclusive OR

//What is the output from each if/else construct?

<?php
$valueA = 10;
$valueB = 20;
if ( ( $valueA >= 50 ) xor ( $valueB === '20') ) {
    echo "Apples";
} else {
    echo "Oranges";
}
if ( ( $valueA >= '5' ) xor ( $valueB === 20 ) ) {
    echo "White";
} else {
    echo "Black";
}

//Answer:
//Statement1: Apples
//Statement2: Black
//I was wrong, because value B is an int, because of the quotes in the 2nd expression and the triple = it needs a string

// Marcella - Lab: The Mixed Array 1
// I'm not sure why the example was writtien with the concatenated single quotes, or why one is moved to the line below?
// The key value required to obtain the last name value is 0.

<?php

// An astronaut array assignment
$astronaut = ['firstName' => 'Mark', 'Watney', 5 => 'Botanist'];

// Access the last name value
echo $astronaut [0] . '
';

//Marcella - Lab: Additional Crew Members

<?php

// Build the crew
$astronaut1 = ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist'];
$astronaut2 = ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander'];
$astronaut3 = ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist'];

// Add members 4 and 5
$astronaut4 = ['firstName' => 'Marcella', 'lastName' => 'Parker', 'specialty' => 'App Support'];
$astronaut5 = ['firstName' => 'Bob', 'lastName' => 'Vila', 'specialty' => 'Carpenter'];

// Build the mission
$mission = ['STS395' => [$astronaut1, $astronaut2, $astronaut3, $astronaut4, $astronaut5]];

//Output a double-quoted string with embedded array values
echo "{$mission['STS395'][3]['firstName']} {$mission['STS395'][3]['lastName']} is the best astronaut!";


//BEGIN Sean HOMEWORK
//Lab: The Mixed Array 2
<?php
// An astronaut array assignment
$astronaut = ['firstName' => 'Mark', 6 => 'Watney', 5 => 'Botanist', 'STS395'];
// Access the last element value, which is 7
echo $astronaut[7];

//Answer for Lab 1: 7

//For Lab: Conditional IF, shown below, all of the IF statements run.  If you did not want all of the
//statements to run when the IF statement resolved to TRUE, you would need to put in ELSE or ELSEIF
//statements.  However, what surprised me is that the code ran without the {} delimiters.  For some reason
//when I ran this PHP code, expecting it to fail because no {}, it ran just fine.  I did not know that
//PHP was like Python and respected an indent.
<?php
$foo = 10;
$bar = 5;
if ( $foo > $bar )
    echo "Foo is greater than bar";
    $foo = $bar;
    echo "The value for Foo has changed";
//END Sean HOMEWORK

//Begin Viktor Homework

//Viktor - Lab: First Program
<?php
echo "Hello World". '  ';
$i = "Hello World";
echo $i;
//Viktor - Lab: First Program HTML
// HTML option

<!DOCTYPE html>
<html lang = "en">
<head>
<title> First PHP Program </title>
</head>
<body>

<?php
    echo "<b> Hello World </b>". ' ' . ',' . ' ';

   $i = "Hello World";
    echo $i;
?>

</body>
</html>

//Viktor - Lab: Conditional If - ElseIf

<?php

$a = 10;
$b = 10;

if ($a > $b) {
    echo "a is bigger than b";
} elseif ($a == $b) {
    echo "a is equal to b";
} else {
    echo "a is smaller than b";
}

?>

//End Viktor homework
```
* From Wed 17 April
```
// Question - If I start running endless code, how do I escape it?


//BEGIN Sean Homework
//Lab: Switch Construct
//An application needs to determine the country of origin for an astronaut applicant. Write a switch
//construct that evaluates multiple country use cases against a true boolean, and sets a variable
//based on the condition evaluated.
<?php

// Build the crew
$astronaut_candidates = [
    ['firstName' => 'Mark', 'lastName' => 'Watney', 'specialty' => 'Botanist', 'country' => 'Canada'],
    ['firstName' => 'Melissa', 'lastName' => 'Lewis', 'specialty' => 'Commander', 'country' => 'Brazil'],
    ['firstName' => 'Beth', 'lastName' => 'Johanssen', 'specialty' => 'Computer Specialist', 'country' => 'China'],
    ['firstName' => 'Marcella', 'lastName' => 'Parker', 'specialty' => 'App Support', 'country' => 'France'],
    ['firstName' => 'Bob', 'lastName' => 'Vila', 'specialty' => 'Carpenter', 'country' => 'Japan'],
];

$asia_list = [];
$europe_list = [];
$americas_list = [];
$other_list = [];

// Sort candidates by geographical location
foreach($astronaut_candidates as $astronaut){
    switch ($astronaut['country']) {
        case 'Japan':
        case 'China':
            // strangely, this syntax achieves the same result, but slightly faster!
            $asia_list[] = $astronaut['lastName'];
            //array_push($asia_list, $astronaut['lastName']);
            break;
        case 'France':
            $europe_list[] = $astronaut['lastName'];
            //array_push($europe_list, $astronaut['lastName']);
            break;
        case 'Brazil':
        case 'Canada':
            $americas_list[] = $astronaut['lastName'];
            //array_push($americas_list, $astronaut['lastName']);
            break;
        default :
            $other_list[] = $astronaut['lastName'];
    }
}

echo "The candidates from Asia are: \n";
foreach($asia_list as $candidate){
    echo "\t$candidate\n";
}

echo "The candidates from Europe are: \n";
foreach($europe_list as $candidate){
    echo "\t$candidate\n";
}
echo "The candidates from the Americas are: \n";
foreach($americas_list as $candidate){
    echo "\t$candidate\n";
}
//END Sean HOMEWORK

// Tim Homework
//Lab: For Loop
//What does this code do?
$max = 10000;
for ($x = 5; $x < $max; $x++) {
    // This if evaluation checks to see if number is odd or even
    $test = TRUE;
    for ($i = 3; $i < $x; $i++) {
        if (($x % $i) === 0) {
            $test = FALSE;
            break;
        }
    }
    if ($test) echo $x . ', ';
}
//   - Answer:  it finds prime numbers, till 100 starting at 5.
//   - It works by skipping all numbers with a modulus of 0

//END Tim homework

// Viktor Homework
// I am not sure how to do it
// I created some whileloop sample:
<?php
$sharePrice = 5;
while ($sharePrice <= 10)
  {
  echo "The share price is " . "$". $sharePrice . ". Don't sell yet. <br>";
  $sharePrice = $sharePrice + 1;
  }
echo "The share price is " . "$". $sharePrice . ". SOLD OUT!";

//After I tried to follow for the task
//=============================
<?php
<?php
$tax     = 0.05;
$invoice = [
    ['name' => 'ice', 'content'=> 'milk', 'color' => 'white', 'price' => 1.11],
    ['name' => 'water', 'content'=> 'water', 'color' => 'clear', 'price' => 2.22],
    ['name' => 'rom', 'content'=> 'alcohol', 'color' => 'yellow', 'price' => 3.33],
];

$i   = 0;
$max = count($invoice);
while ($i < $max) {
    $taxAmount = $invoice[$i]['price'] * $tax;
    echo 'Name:  ' . $invoice[$i]['name'] . "<br>\n";
    echo 'Price: ' . $invoice[$i]['price'] . "<br>\n";
    echo 'Tax:   ' . $taxAmount . "<br>\n";
    $invoice[$i]['price'] += $taxAmount;
    $i++;
}

var_dump($invoice);

//==============================
//  hope I understand how each of them is working, but how to combine it, I don't know.
//END Viktor homework

//Srinivas
//Example: Nested For Each Loop
<?php
/*
*   Purpose of Program: Build the crew, Start the mission, Onboard the crew only for 'STS395' mission
*/

// Build the crew

//Onboarding of First Batch of Crew
$missions = [
    'STS395' => [
        [
            'firstName' => 'Mark',
            'lastName'  => 'Watney',
            'specialty' => 'Botanist'
        ],
        [
            'firstName' => 'Melissa',
            'lastName'  => 'Lewis',
            'specialty' => 'Commander'
        ],
        [
            'firstName' => 'Beth',
            'lastName'  => 'Johanssen',
            'specialty' => 'Computer Specialist'
       ],
    ]
];


//Onboard astronauts for each mission
foreach($missions as $mission => $astronauts){

    //Onboard astronauts only for 'STS395' mission
    if($mission === 'STS395'){
        foreach($astronauts as $astronaut){
            echo " {$astronaut['specialty']} {$astronaut['lastName']} on board" . "<br>";
        }
    }

}

echo "\n<br>\n";

//Example 1

//Build a checklist with six items
$todolists = [
    'list1' => 'Do the task1',
    'list2' => 'Do the task2',
    'list3' => 'Do the task3',
    'list4' => 'Do the task4',
    'list5' => 'Do the task5'
];

foreach($todolists as $listname => $task){
    echo "$listname => $task <br>\n";
}

//End of Home Work
//Srinivas


//Marcella Homework
//Create an associative array with past purchase dates and amounts.
//Iterate the list using a do...while loop displaying the past purchases.
//I created something - but it seems odd to use a do...while loop instead of a for each.

<?php

//Create item records
$items = [
    '123ABC' => [
        'description' => 'AlphabetSoup',
        'price'       => 2.5,
        'taxYN'       => 'N'
    ],
    '456DEF' => [
        'description' => 'Spoon',
        'price'       => 9.5,
        'taxYN'       => 'Y'
    ],
    '789GHI' => [
        'description' => 'Bowl',
        'price'       => 20,
        'taxYN'       => 'Y'
    ]
];

//Build purchase history
$orders = [
    1 => [
        'date' => date('Ymd'),
        'customer' => 'Marcella',
        'account' => 12345,
        'items' => [
            ['itemId' => '123ABC', 'qty' => 2],
            ['itemId' => '789GHI', 'qty' => 3],
        ]
    ],
    2 => [
        'date' => date('Ymd'),
        'customer' => 'Kelli',
        'account' => 67890,
        'items' => [
            ['itemId' => '456DEF', 'qty' => 3],
            ['itemId' => '789GHI', 'qty' => 1],
        ]
    ],
    3 => [
        'date' => date('Ymd'),
        'customer' => 'David',
        'account' => 24680,
        'items' => [
            ['itemId' => '123ABC', 'qty' => 2],
            ['itemId' => '456DEF', 'qty' => 1],
            ['itemId' => '789GHI', 'qty' => 1],
        ]
    ]
];

$_order = 1;
do {
    $_item = $orders[$_order]['items'][0]['itemId'];
    $_price = $items[$_item]['price'];
    $_qty = $orders[$_order]['items'][0]['qty'];
    echo 'Order # ',$_order,' was placed by ',$orders[$_order]['customer'],' on ',
    $orders[$_order]['date'],'.'.PHP_EOL;
    echo "Order # {$_order} contains item # {$_item} with quantity: {$_qty} and a price of $
    {$_price}, for a line total of $${0*${0}=$_price * $_qty}.".PHP_EOL;
    $_order++;
}
while ($_order <= 3);

//End Marcella Homework
```
* For Fri 19 Apr
```
<?php
declare(strict_types=1);
// Shirley's Homework 04/17/2019 Sorry I am not in class today //
// 1. Define a function named getOrderTotal(...), which takes two arguments and returns the sum.//
// 2. Call the function and output the result.  //

$ordertotal = 0.00;     // assign 0.00 to identify this as float
$item1price = 14.77;
$item2price = 2.81;

function getOrderTotal(float $item1price, float $item2price) : float
{
    // Made $ordertotal Global just for kicks ang giggles
    //global $ordertotal;
    $ordertotal = $item1price + $item2price;
    return $ordertotal;
}

function getOrderTotal2(float $item1price, float $item2price) : float
{
    return $item1price + $item2price;
}

$ordertotal = getOrderTotal($item1price, $item2price);
// Because $ordertotal is set to global I can now use it outside of the function
echo ("Your Order total now is $ $ordertotal .");
echo "\n<br>\n";

//If I did not make it global, I could echo the value as follows
echo getOrderTotal2($item1price, $item2price);

/*
 // Doug,,, can you please show us what the format would be to pass in the variables when the program is being called??? //<?php
 //Also, I tried putting the calculation right in the return statement and it works great. Is that a NO NO??
 // Example function getOrderTotal($item1price, $item2price)
 {
     // Made $ordertotal Global just for kicks ang giggles
     global $ordertotal;
     return ($ordertotal = $item1price + $item2price);
 }
*/


<?php
//Srinivas
//Start


// Lab: The Fibonacci sequence is a series of numbers in which each number is the sum of the previous
// two numbers, starting with 0.
// Recursive way
function FibSeries($number){

    // if and else if to generate first two numbers
    if ($number == 0 or $number == 1) {
        return $number;
    // Recursive Call to get the upcoming numbers
    } else {
        return (FibSeries($number-1) +
                FibSeries($number-2)
                ); //Struggling at this line then got idea about it after some research. Please help understand.
    }
}

// Till nth number in a Fibbonacci sequence.
$sequence  = [];
$iteration = 10;
for ($count = 0; $count < $iteration; $count++){
    $sequence[] = FibSeries($count) . PHP_EOL;
}

echo 'The Fibbonacci number for ' . $iteration . ' iterations is ' . array_pop($sequence);

/*
https://io9.gizmodo.com/15-uncanny-examples-of-the-golden-ratio-in-nature-5985588 - Good read - Fibbonacci in Nature
*/

//End
```
* For Mon 22 April
```
# For Mon 22 Apr 2019

//BEGIN Sean LAB
<?php

// 1. Write an array of text strings to a file.
// 2. Open the file using fopen().
// 3. read and output the third character from each line.

// create the strings and arrange them in an array
$lorem1 = "Lorem ipsum dolor sit amet, vim an dicit sensibus laboramus. Ad mel lorem dolor audiam. Mutat omnium prodesset ea ius, legimus appetere eam ex.";
$lorem2 = "Ius vivendo temporibus an, vim ad sumo veri. Ut duo impetus tincidunt comprehensam, has in inermis perpetua voluptatum, te vix tempor ";
$lorem3 = "percipitur. Ut everti postulant theophrastus ius. Graece delicatissimi eu vel, eam eu postea tractatos.";

$lorem_ipsum = [$lorem1, $lorem2, $lorem3];

// Write the strings to a file then close it
$lorem_file = fopen("lorem_ipsum.txt", "w+");

foreach($lorem_ipsum as $item){
    fwrite($lorem_file, $item . PHP_EOL);
}

fclose($lorem_file);

// Open the file we just created and read each line then output the 3rd character
$lorem_file = fopen("lorem_ipsum.txt", "r");

$line_count = 1;

while(!feof($lorem_file)) {
    $new_array = str_split ( fgets($lorem_file) );
    if (count($new_array) > 2){
        echo("The third character on line $line_count is: " . $new_array[2] . PHP_EOL);
    }
    $line_count++;
}
//END Sean LAB

<?php
//BEGIN Viktor Lab: file_get_contents()
//1. Using file_get_contents(), get the contents of a file
//2. Display the result

//text file "test.txt" with following text"%%%This is a test file with test text."
// I placed at the same directory.
echo file_get_contents("test.txt",false,null,3);

$url = "http://vpl.ca";
$content = file_get_contents ($url);
echo $content;

$homepage = file_get_contents('http://www.vpl.ca');
echo $homepage;
//END Viktor LAB

<?php
// TIM Lab

//Lab: F-Type Functions
//Write an example of:
//1. Opening a file with error handling
//2. Write something to the file
//3. Close the file

$j=count(file('numbers.csv'));
$file = fopen('numbers.csv', 'a+');

while (($line = fgetcsv($file)) !== FALSE) {
    print_r($line);
}

function addLines($lines)
{
    //$i=$j+$lines;
    $i=$j+3;
    while ($j<$i) {
        $input=["$j", "$j th", "$j$j"];
        fputcsv($file,$input);
        $j++;
    }
    // Assuming this is inside the function: will cause an infinite loop
    // return addLines(3);
}
// Assuming this is outside the function: do not use the keyword "return"
// return addLines(3);

fclose($file);

//The commented out lines are my attempt to make the addition of lines variable in a function (in this case i set the amount of lines to 3
//by hand, where the idea was to have the function handle the amount of lines. Is it possible to do it like this, and could you show how?
// My CSV file was;
/*
Number,nth,double
1,1st,11
2,2nd,22
3,3rd,33
4,4th,44
5,5th,55
6,6th,66
7,7th,77
8,8th,88

*/
<?php
//Srinivas
//Start

//Assignment 1:
/*

Build two functions, one to get an array element of configuration, and one that takes an array and
builds an HTML select/option list.

 - getConfig('some config'), returns an array of allowed statuses
 - htmlSelectHtml($config), returns a string contains an HTML <select> element with the status
options.

*/

//Config File Content in the 'config/config.properties'
/*
['New', 'WIP', 'Hold', 'Closed']
*/
?>
<!doctype html>
<html>
<head>
    <title>
        Lab: Two Functions
    </title>
</head>
<?php
    function loadConfig( $configFile ){
        //Why this statement prints the output. I wanted it to store in variable
        //But this line prints the array. Maybe we can try this during the session.
        //$config = include ( __DIR__ . '/config/' . $configFile );

    if (!file_exists($configFile)) {
        exit('Unable to locate config file');
    }

        return include $configFile;
    }

    function loadConfigFromText( $configFile ){
        return file($configFile);
    }

    function printSelectOptions( $config ){
        foreach ($config as $val) {
            echo "<option>$val</option><br>";
        }
    }

?>

<body>
    <h1>Load the Configuration from File.</h1>
    Select the Status
    <?php
        $configArray = loadConfig(__DIR__ . '/../config/config.properties.php');
        //$configArray = loadConfigFromText(__DIR__ . '/../config/config.properties');
    ?>
    <select>
        <?= printSelectOptions($configArray) ?>
    </select>
</body>
</html>

<?php
//*************************************//

//Assignment 2
/*
Read the directories and files in the class project root and output the following:
- File Name
- File Size
- Number of lines in the file
*/
?>
<!doctype html>
<html>
<head>
    <title>
        Lab: Read Directories
    </title>
</head>
<?php

    function PrintDirectories(){
        $fileList = glob('*'); //https://www.php.net/manual/en/function.glob.php
        foreach($fileList as $filename){
            //Check if it is file
            if(is_file($filename)){
                $no_of_lines = count(file($filename));
                //FileName: <name> (<Size>) - <No. of Lines>
                echo 'FileName: ' . $filename . ' (' . filesize ($filename) . ' bytes) - ' . $no_of_lines . ' lines <br>';
            }
        }
    }
?>
<body>
    <h1>Showing the Current Directories</h1>
        <?= PrintDirectories() ?>
</body>
</html>

<?php
//End
//Srinivas
?>


<?php

<?php
//Marcella Homework
//Use File_put_contents.  Create some string content.  Over-write the contents of a file.
//Test and echo for success.

$file = 'target.txt';

// This line will create or append the file.
file_put_contents( $file, 'First line of file (create)' . PHP_EOL, FILE_APPEND);

$read = file_get_contents( $file );
echo $read . PHP_EOL;

//This line will append the file.
file_put_contents( $file, 'Second line of file.' . PHP_EOL, FILE_APPEND);

$read = file_get_contents( $file );
echo $read . PHP_EOL;

//Without the file_append flag, this line will now over-write the existing file (all lines).
file_put_contents( $file, 'Over-write existing file.');

$read = file_get_contents( $file );
echo $read . PHP_EOL;

//End Marcella Homework
```

## UPDATES
VM: php.ini::display_errors needs to be set on
* file:///D:/Repos/PHP-Fundamentals-I/Course_Materials/index.html#/4/39: while() loops are best used in situations where the items being handled are of an unknown quantity.  Examples: results from a database query, or analyzing lines from a file; while() loops are also useful for situations where some external control is needed; example: something based upon elapsed time
* file:///D:/Repos/PHP-Fundamentals-I/Course_Materials/index.html#/4/47: out of place???  also: mose
* file:///D:/Repos/PHP-Fundamentals-I/Course_Materials/index.html#/5/32: $table doesn't belong in this statement!

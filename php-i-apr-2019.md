# PHP-I Class Notes: Apr 2019

## Homework
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


## Class Discussion
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

## UPDATES
VM: php.ini::display_errors needs to be set on
* file:///D:/Repos/PHP-Fundamentals-I/Course_Materials/index.html#/4/39: while() loops are best used in situations where the items being handled are of an unknown quantity.  Examples: results from a database query, or analyzing lines from a file; while() loops are also useful for situations where some external control is needed; example: something based upon elapsed time
* file:///D:/Repos/PHP-Fundamentals-I/Course_Materials/index.html#/4/47: out of place???  also: mose

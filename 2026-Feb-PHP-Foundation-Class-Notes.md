# Class Notes -- PHP Foundation -- Feb 2026
http://localhost:8881/#/5

# TODO
* Find a good example using `match` with multiple statements as a return value

# Notes
* Use `number_format()` to produce a specific number of decimal places
  * It also does rounding
  * Return value is a string
  * Accepts args for the "thousands" separator and the decimal separator
* Working example of `continue` in a `while ()` loop:
  * https://github.com/dbierer/filecms-core/blob/main/src/Common/Data/CsvBase.php
* Using `list()` can easily go overboard -- a simpler approach might be a better choice:
```
<?php 
$array = [1 => 2, 2 => 4, 'eight' => 8];

// Instead of this:
// list(1 => $oneInt, 2 => $twoInt, 'eight' => $threeInt) = $array;

// Use this instead:
$oneInt = $array[1];
$twoInt = $array[2];
$threeInt = $array['eight'];

echo $oneInt . PHP_EOL . $twoInt . PHP_EOL . $threeInt;
```
 
# Homework
Fri 6 Feb 2026
* Lab: Array Key Value Access
* Lab: Array Last Value Access
* Lab: The Multi-Dimensional Array
* Lab: The Multi-Configuration Array
* Lab: First Program 
  * Put your code in `/home/vagrant/Zend/sandbox/public/PROGRAM_NAME.php`
  * Access from the VM browser using `http://sandbox/PROGRAM_NAME.php`
* Lab: Additional Crew Members
* Lab: Conditional If
* Lab: Conditional If-Else Equality
* Lab: Conditional If-Else Exclusive OR
* Lab: Conditional If-ElseIf
* Lab: Switch Construct
* Lab: Match Construct
* Lab: Foreach Loop
* Lab: For Loop
* Lab: While Loop
* Lab: Do...While Loop

# Change Requests
http://localhost:8881/#/3/6 -- link problem
http://localhost:8881/#/4/52 -- why use "&" ???

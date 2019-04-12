# PHP-I Class Notes: Apr 2019

file:///D:/Repos/PHP-Fundamentals-I/Course_Materials/index.html#/4/19

## Homework
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

## Class Discussion
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

## Course Mods
* Increase the font size for code examples in CSS: in index.html:
```
.reveal pre {
    font-size: 0.88em;
}
```


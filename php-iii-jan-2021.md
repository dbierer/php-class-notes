# PHP-III Jan 2021

## Homework
* For Wed 6 Jan 2021
  * Setup Apache JMeter
  * Setup Jenkins CI
    * Need to install Jenkins 1st!

## Class Notes
* DateTime
  * https://www.php.net/manual/en/intldateformatter.format.php
* DatePeriod Example
  * https://github.com/dbierer/classic_php_examples/blob/master/date_time/date_time_date_period.php
* Relative `DateInterval` formats
  * http://php.net/manual/en/datetime.formats.relative.php
* Generator/Anonymous Function Example
```
<?php
$function = function () { return 'Whatever'; };
echo $function();
var_dump($function);

function test(int $max)
{
	$num = range(0, 99);
	$count = 0;
	for ($x = 0; $x < $max; $x++) {
		yield $num[$x];
		$count += $num[$x];
	}
	return $count;
}

// NOTE: $x is *NOT* the value from line 14!
$x = test(10);
foreach ($x as $letter) echo $letter;
// This gives you the value from line 14
// NOTE: can only getReturn() *after* the iteration has completed
echo "\nReturn Value:" . $x->getReturn();
var_dump($x);
```



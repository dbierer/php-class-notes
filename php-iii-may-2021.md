# PHP III -- May 2021 -- Notes

## TODO
* Research other options to improve performance of VM on Mac
* Which classes in PHP 8 no longer directly implement Iterator?

## VM
Here are some things to do with the VM after installation
* DO NOT update!  Had a problem with a black screen following the update.
  * Need to research this further
* Need to install `git`:
```
sudo apt install -y git
```

## Homework
For Weds 26 May 2021
  * Setup Apache JMeter
  * Setup Jenkins CI
    * The CheckStyle plug-in reached end-of-life. All functionality has been integrated into the Warnings Next Generation Plugin.
    * Same applies to `warnings` and `pmd` : integrated into `Warnings NG`
    * Here are some other suggestions for initial setup:
      * replace `checkstyle` with `Warnings Next Generation`
      * replace `build-environment` with `Build Environment`
      * replace `phing` with `Phing`
      * replace `violations` with `Violations`
      * replace `htmlpublisher` with `Build-Publisher` (???)
      * replace `version number` with `Version Number`

## Resources
Previous class notes:
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-mar-2021.md
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-jan-2021.md

## Class Notes
`DateTime`
  * https://www.php.net/manual/en/intldateformatter.format.php
  * Example calculating date differences
```
<?php
$fmt  = 'l, d M Y';
$date1 = new DateTime('third thursday of next month');
$date2 = new DateTime();
$date2->setDate(rand(2020,2023), rand(1,12), rand(1,28));
echo $date1->format($fmt) . "\n";
echo $date2->format($fmt) . "\n";

$diff = $date1->diff($date2);
echo "There are {$diff->days} days difference between the two dates\n";
$x = ($diff->invert ===0) ? 'future' : 'past';
echo "The second is in the $x\n";
````
  * Example where the original date cannot be altered
```
<?php
$fmt  = 'l, d M Y';
$list = [0, 30, 60, 90];
$imm  = new DateTimeImmutable('now');
$int  = 'P%dS';
$arr  = [];
foreach ($list as $num) {
	$interval = new DateInterval('P' . $num . 'D');
	$dt = DateTime::createFromImmutable($imm);
	$dt->add($interval);
	$arr[$num] = clone $dt;
}
foreach ($arr as $obj)
	echo $obj->format($fmt) . "\n";
```

DatePeriod` Example
  * https://github.com/dbierer/classic_php_examples/blob/master/date_time/date_time_date_period.php
Relative `DateTime` formats
  * http://php.net/manual/en/datetime.formats.relative.php
Generators
* Example getting return value from a generator
  * https://github.com/dbierer/php7cookbook/blob/master/source/Application/Iterator/LargeFile.php
  * https://github.com/dbierer/php7cookbook/blob/master/source/chapter02/chap_02_iterating_through_a_massive_file.php
  * Use `getReturn()` to get final value from `Generator` instance
    * Can only run this method after iteration is complete
Anonymous Classes
* Some differences in handling in PHP 8:
```
<?php
$anon = new class (2, 2) extends ArrayIterator {
	public function __construct(
		public int $a = 0,
		public int $b = 0)
	{}
	public function add()
	{
		return $this->a + $this->b;
	}
};

echo $anon->add();
echo "\n";
echo $anon::class;
```
* IteratorAggregate
  * Easy way to make a class iterable
  * A *lot* less work then implementing `Iterator`!
  * Example:
```
<?php
$arr = range('A','Z');

class Test implements IteratorAggregate
{
	public function __construct(public array $test = []) {}
	public function getIterator() : Traversable
	{
		return new ArrayIterator($this->test);
	}
}

$test = new Test($arr);
foreach ($test as $letter)
	echo $letter;

echo "\n";
```
* `Serializable` Interface
  * In a yet-to-be-announced future version of PHP, this will go away
  * To switch over to the new mechanism:
    * "Unimplement" `Serializable`
    * Convert `serialize()` to `__serialize()`
    * Convert `unserialize()` to `__unserialize()`
  * New mechanism is available as of PHP 7.4
  * *Must Read* : https://wiki.php.net/rfc/phase_out_serializable
    * Already on the table for PHP 8.1
```
<?php
$arr = range('A','Z');

class Test implements IteratorAggregate, Serializable
{
	public function __construct(public array $test = []) {}
	public function getIterator() : Traversable
	{
		return new ArrayIterator($this->test);
	}
	public function serialize(string $data)
	{
		return 'Whatever';
	}
	public function unserialize()
	{
		echo 'Whatever';
	}
}

$test = new Test($arr);
$str  = serialize($test);
echo $str;
echo "\n";

$obj = unserialize($str);
var_dump($obj);
```
* `Stringable` Interface
  * Auto-assigned in PHP 8 if class defines `__toString()`
Custom Compile PHP
  * See: https://lfphpcloud.net/articles/adventures_in_custom_compiling_php_8

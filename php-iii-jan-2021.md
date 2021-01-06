# PHP-III Jan 2021

## TODO
* Create example of binding `$this` to another class in an anon function
* Does PHP 8 automatically to strict_types=1?

## Homework
* For Wed 6 Jan 2021
  * Setup Apache JMeter
  * Setup Jenkins CI
    * Need to install Jenkins 1st!
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
* Previous class notes:
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-jan-2019.md
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-may-2019.md
* Previous class repos:
  * https://github.com/dbierer/php-iii-may-2019

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
* `ArrayObject` example demonstrating use of internal `IteratorAggregate` interface as well as `ArrayAccess`
```
<?php
$source = ['A' => 111, 'B' => 222, 'C' => 333];
$obj = new ArrayObject($source);

// this is possible due to ArrayAccess interface implementation
echo $obj['A'];
echo $obj->offsetGet('B');
echo "\n";

// this is possible because of IteratorAggregate
foreach ($obj as $key => $val) {
	echo $key . ':' . $val . "\n";
}
echo "\n";

$iter = $obj->getIterator();
foreach ($iter as $key => $val) {
	echo $key . ':' . $val . "\n";
}
echo "\n";
```
* Serialization has changed as of PHP 7.4
  * See: https://wiki.php.net/rfc/custom_object_serialization
  * Example: https://github.com/phpcl/phpcl_jumpstart_php_7_4/blob/master/new_custom_serialize.php
* Type Hinting
```
<?php
// If this is not declared, scalar data-typing acts as a type cast
declare(strict_types=1);
class Test
{
	public $name = 'Fred';
	public function setName(string $name)
	{
		$this->name = $name;
	}
	public function getName() : string
	{
		return $this->name;
	}
}

$test = new Test;
$test->setName('Wilma');
echo $test->getName();


$test->setName(123);
echo $test->getName();
var_dump($test);
```
* Typed Properties
  * RFC: https://wiki.php.net/rfc/typed_properties_v2
  * Example:
    * Old: https://github.com/phpcl/phpcl_jumpstart_php_7_4/blob/master/new_typed_props_old.php
    * New: https://github.com/phpcl/phpcl_jumpstart_php_7_4/blob/master/new_typed_props_new.php
* Nullable Types
  * In PHP 8 you can use a new syntax if you want to accept multiple data types as an argument
  * Referred to as `union` types
  * See: https://wiki.php.net/rfc/union_types_v2
```
// accepts either a string or float as an argument
public function setParam(string|float $param) {	
	$this->param = $param;
}
```
* New Additions:
  * New as of PHP 7.4: https://www.php.net/manual/en/migration74.new-features.php
  * New as of PHP 8.0: https://www.php.net/manual/en/migration80.new-features.php
* PubSub Example: https://github.com/dbierer/php7cookbook/blob/master/source/chapter11/chap_11_pub_sub_simple_example.php
* DoublyLinkedList:
  * https://github.com/dbierer/php7cookbook/blob/master/source/chapter10/chap_10_linked_double.php
  * https://github.com/dbierer/php7cookbook/blob/master/source/chapter10/chap_10_linked_list_include.php
* Stacked Iterators:
  * https://github.com/dbierer/php7cookbook/blob/master/source/chapter03/chap_03_developing_functions_stacked_iterators.php
  * In: https://github.com/dbierer/SimpleHtml/blob/main/src/Common/View/Html.php
    * See `getCardIterator()` method, and
    * `injectCards()` this line: `$iter = new LimitIterator($temp, 0, (int) $qualifier);`
    * Limits iterations returned from the card iterator
* Variable based stream wrapper:
  * https://github.com/dbierer/classic_php_examples/blob/master/file/streams_custom_wrapper.php
* Streams Docs: https://www.php.net/manual/en/book.stream.php
  * For devices, see: https://www.php.net/manual/en/function.stream-socket-client.php

# PHP Certification Test Prep Notes October 2017

NOTE TO SELF: see if you can find ans key
ANOTHER NOTE TO SELF: see if you can find solid docs on what exactly is a "standard" extension
YET ANOTHER TO SELF: docs on when Throwable / Error can be caught and when not
YET ANOTHER YET ANOTHER NOTE: find docs on when static methods no longer can be used in object context in PHP 7.x?
YOU KNOW WHAT: make code archive available Friday

## ERRATA
Quiz #5: correct ans is 6
http://localhost:8080/#/2/38: [] also ".=" as well as "**="
http://localhost:8080/#/2/51: [60] 2nd case s/be "Value2"
http://localhost:8080/#/2/59: [66] on page 66 PHP_INI_USER should have a X in .user.ini as per http://php.net/manual/en/configuration.changes.modes.php
http://localhost:8080/#/3/6: Question s/be "... SimpleXMLElement object ..."
http://localhost:8080/#/3/10: Ans 4 s/be "... SimpleXMLElement object ..."
http://localhost:8080/#/3/21: API class CANNOT by "SoapServer"!!!
http://localhost:8080/#/4/41: too many spaces before 7.1.0!!!
http://localhost:8080/#/4/43: get rid of "&"
http://localhost:8080/#/5/3: no "<pre>" tag!!!
http://localhost:8080/#/5/22: add SORT_NATURAL
http://localhost:8080/#/5/30: 2nd bullet needs to be re-worded for better clarity
http://localhost:8080/#/6/??: handls
http://localhost:8080/#/6/8: s/be "readfile()"
http://localhost:8080/#/8/25: interfaces can also define (public) constants
http://localhost:8080/#/8/34: not only non-existent but also non-visible will trigger these
http://localhost:8080/#/8/36: "clones" s/be "cloned"
http://localhost:8080/#/8/39: add one more $a; return $alpha[++$this->pos];
http://localhost:8080/#/8/45: need to add strict_types + no need for ?? 0
http://localhost:8080/#/9/15: ROLLBACK TRANSACTION???
http://localhost:8080/#/9/24: correct ans is 4: NULL

Mock #2: re: {one, 24, 26} as an answer: need to change echo statement to {} instead of() for answer to be correct
General Note: code block screenshots are hard to read!

### DateTime
https://www.convertunits.com/dates/daysfromnow/90

### Q & A

* from Francois to All Participants: and splat doesn't have to be the only params, you could use myfunc($a, $b, ...$c)
* from Francois to All Participants: can you do ...$c = array()?
* from Francois to All Participants: you can update the splat operator Q&A in your note:you cannot give a default value (...$c = array()), the value is set by default to empty array by PHP. This would work:function abc($a, $b, ...$c) { var_dump($c); }abc(1,2); // prints an empty array
* from Francois to All Participants: Just about the note you took for the the null coalescing operator [...] It returns its first operand if it exists and is not NULL; otherwise it returns its second operand. [...] So $a ?? NULL would be acceptable
* http://php.net/manual/en/language.oop5.late-static-bindings.php
* http://php.net/manual/en/language.oop5.traits.php
* from Mirela to All Participants: what happens if you start transaction and than again start transaction and the commit ?

### OOP DISCUSSION

As of PHP 7 you can now reference any public method using S.R.O ::
<?php
class MyClass
{
    public static $dateFormat = 'l, d M Y';
    public static function formatDate(DateTime $date)
    {
        return $date->format(self::$dateFormat);
    }
    public function formatDate2(DateTime $date)
    {
        return $date->format(self::$dateFormat);
    }
}
// assume date is Thursday, 25 May 2017
$now = new DateTime();
echo MyClass::formatDate($now); // Thursday, 25 May 2017
echo PHP_EOL;
MyClass::$dateFormat = 'Y-m-d H:i:s';
echo MyClass::formatDate($now); // 2017-05-25 06:44:33
echo PHP_EOL;

echo MyClass::formatDate2($now); // Thursday, 25 May 2017
echo PHP_EOL;

### RE: ArrayObject
* See: http://php.net/manual/en/class.serializable.php

### DATABASE
* http://php.net/manual/en/ini.list.php
# PHP Certification Test Prep Notes October 2017


## ERRATA (updated PDF with corrections provided)
* http://localhost:8080/#/2/15: Quiz #5: correct ans is 3 + 6
* http://localhost:8080/#/2/38: [] also ".=" as well as "**="
* http://localhost:8080/#/2/51: [60] 2nd case s/be "Value2"
* http://localhost:8080/#/2/59: [66] on page 66 PHP_INI_USER should have a X in .user.ini as per * http://php.net/manual/en/configuration.changes.modes.php
* http://localhost:8080/#/3/6: Question s/be "... SimpleXMLElement object ..."
* http://localhost:8080/#/3/10: Ans 4 s/be "... SimpleXMLElement object ..."
* http://localhost:8080/#/3/21: API class CANNOT by "SoapServer"!!!
* http://localhost:8080/#/4/41: too many spaces before 7.1.0!!!
* http://localhost:8080/#/4/43: get rid of "&"
* http://localhost:8080/#/5/3: no "<pre>" tag!!!
* http://localhost:8080/#/5/22: add SORT_NATURAL
* http://localhost:8080/#/5/30: 2nd bullet needs to be re-worded for better clarity
* http://localhost:8080/#/6/??: handls
* http://localhost:8080/#/6/8: s/be "readfile()"
* http://localhost:8080/#/8/25: interfaces can also define (public) constants
* http://localhost:8080/#/8/34: not only non-existent but also non-visible will trigger these
* http://localhost:8080/#/8/36: "clones" s/be "cloned"
* http://localhost:8080/#/8/39: add one more $a; return $alpha[++$this->pos];
* http://localhost:8080/#/8/45: need to add strict_types + no need for ?? 0
* http://localhost:8080/#/9/15: ROLLBACK TRANSACTION???
* http://localhost:8080/#/9/24: correct ans is 4: NULL
* http://localhost:8080/#/11/11: missing $_FILES!!!
* http://localhost:8080/#/11/12: question numbering is off!!!
* http://localhost:8080/#/11/26: no closing paren on last table item
* http://localhost:8080/#/11/30: no closing paren on 1st item
* http://localhost:8080/#/11/36: numbering is out of sequence

* Mock #2: re: {one, 24, 26} as an answer: need to change echo statement to {} instead of() for answer to be correct
* General Note: code block screenshots are hard to read!

### DateTime
https://www.convertunits.com/dates/daysfromnow/90

### Q & A

* Q: from Francois to All Participants: and splat doesn't have to be the only params, you could use myfunc($a, $b, ...$c)
* A: OK thanks!
* Q: from Francois to All Participants: can you do ...$c = array()?
* A: from Francois to All Participants: you can update the splat operator Q&A in your note:you cannot give a default value (...$c = array()), the value is set by default to empty array by PHP. This would work:function abc($a, $b, ...$c) { var_dump($c); }abc(1,2); // prints an empty array
* Q: from Francois to All Participants: Just about the note you took for the the null coalescing operator [...] It returns its first operand if it exists and is not NULL; otherwise it returns its second operand. [...] So $a ?? NULL would be acceptable
* A: OK thanks!
* Q: from Mirela to All Participants: what happens if you start transaction and than again start transaction and the commit ?
* A: You can use `SAVE TRANSACTION` to establish a "transaction savepoint" ... but support for this feature is not universal which is why it will not be on the test
* Q: from Francois Dupras to All Participants: eval('system(...)') should be mentioned near system and such command
* A: Agreed! Added to the slide on "Code Injection"
* Q: NOTE TO SELF: see if you can find solid docs on what exactly is a "standard" extension
* A: OK ... here is a list of extensions which is categorized: http://php.net/manual/en/extensions.membership.php
    * Anything on the list under *Core* is built directly into the language.
    * *Bundled* extensions are extensions which are commonly included with most installations.
    * *External* extensions are also included with most PHP installations, but depend on external libraries.
    * *pecl* extensions are installed from `pecl.php.net` and most require external libraries
    * Of the last 3: only the ones we covered in class will be on the test.
* Q: ANOTHER TO SELF: docs on when Throwable / Error can be caught and when not
* A: Best discussion on this I've seen so far is here: https://stackoverflow.com/questions/40361353/what-happens-with-set-error-handler-on-php7-now-that-all-errors-are-exceptions
  * This is the key point:
```
Fatal errors still exist for certain conditions, such as running out of memory, and still behave as before by immediately halting script execution.
An uncaught exception will also continue to be a fatal error in PHP 7. This means if an exception thrown from an error that was fatal in PHP 5.x goes uncaught,
it will still be a fatal error in PHP 7.
```

### OOP DISCUSSION
* http://php.net/manual/en/language.oop5.late-static-bindings.php
* http://php.net/manual/en/language.oop5.traits.php
* As of PHP 7 you can now reference any public method using S.R.O ::
```
<?php
class MyClass
{
    public static $dateFormat = 'l, d M Y';
    public static function formatDate(DateTime $date)
    {
        return $date->format(self::$dateFormat)
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
```

### RE: ArrayObject
* See: http://php.net/manual/en/class.serializable.php

### DATABASE
* http://php.net/manual/en/ini.list.php

### PHP AS CGI BINARY
* http://php.net/manual/en/security.cgi-bin.attacks.php

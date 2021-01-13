# PHP-III Jan 2021

## Homework
* For Wed 13 Jan 2021
  * Lab: New Functions
    * Installing a Custom Extension
  * Optional Lab: install the MongoDB extension or install apcu
  * Lab: Custom Compile PHP
    * See: https://lfphpcloud.net/articles/adventures_in_custom_compiling_php_8
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

## TODO
* Create an example of a heap where you create a branch (e.g. another list associated with "Space Suite Check" from slide example)
* Create example of binding `$this` to another class in an anon function
* Q: Example of using FFI?
* A: See: https://github.com/phpcl/phpcl_jumpstart_php_7_4
* A: Look for PHP examples starting with `ffi*`
* Q: What are the PHP 8 `JIT` flags?
* A: For overview see: https://wiki.php.net/rfc/jit
* A: For `php.ini` defaults see: https://wiki.php.net/rfc/jit#phpini_defaults
* Q: What is `opcache.interned_strings_buffer`?
* A: The amount of memory used to store interned strings in MB
* A: See: https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.interned-strings-buffer
* Q: Check out `runBitCoinFilter` ... bzip2 doesn't appear to be working
* A: Run `stream_get_filters()` to see which are available for your PHP installation
  * Run `php -i` or `phpinfo()` and look for filter support per extension
  * Example for `zlib`:
```
zlib

ZLib Support => enabled
Stream Wrapper => compress.zlib://
Stream Filter => zlib.inflate, zlib.deflate
Compiled Version => 1.2.11
Linked Version => 1.2.11
```
* Q: Examples of using `stream_socket_client`?
* A: See: https://github.com/reactphp/socket
* A: See: https://github.com/reactphp/socket/blob/master/src/TcpConnector.php::line 76
* Q: Explanation of streams buckets?
* A: See: https://stackoverflow.com/questions/27103269/what-is-a-bucket-brigade#31132646
* Q: Is there an article on using `RecursiveDirectoryIterator`?
* A: https://lfphpcloud.net/articles/spl-recursive-directory-iterator
* Q: Find or create an example of storing and retrieving objects using `SplObjectStorage`
* A: This article is 9 years old, but very informative: https://stackoverflow.com/questions/8520241/associative-array-versus-splobjectstorage
* Q: Does PHP 8 automatically default to strict_types=1?
* A: No: same behavior as PHP 7.4
* A: Note: if `declare(strict_types=1);` is not enabled, the type hint acts as a type-cast.
  * If the type cast is unsuccessful or ambiguous a `TypeError` is thrown

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
* Example of `iterable` data type
```
<?php
// If this is not declared, scalar data-typing acts as a type cast
//declare(strict_types=1);
class Test
{
        public $iter = NULL;
        public function setIter(iterable $iter)
        {
                $this->iter = $iter;
        }
        public function getIterAsString()
        {
                $output = '';
                foreach ($this->iter as $key => $val)
                        $output .= $key . ':' . $val . "\n";
                return $output;
        }
}
$arr = ['A' => 111, 'B' => 222, 'C' => 333];
$test = new Test();
$test->setIter($arr);
echo $test->getIterAsString();

$obj = new ArrayObject($arr);
$test->setIter($obj);
echo $test->getIterAsString();
```
* `callable` data type
```
<?php
// If this is not declared, scalar data-typing acts as a type cast
//declare(strict_types=1);
class Test
{
        public $callback = NULL;
        public function setCallback(callable $callback)
        {
                $this->callback = $callback;
        }
        public function getCallback()
        {
                return $this->callback;
        }
}

$func = function ($a, $b) { return $a + $b; };
$anon = new class() {
        public function add($a, $b) {
                return $a + $b;
        }
};
$test = new Test();
// no error
$test->setCallback($func);
// classes that define __invoke are considered callable
// if not, you can  use array syntax as shown:
$test->setCallback([$anon, 'add']);
// no error on defined functions
$test->setCallback('strtolower');
echo $test->getCallback()('ABCDEF');
```
* Create `Closure` from `callable`: https://wiki.php.net/rfc/closurefromcallable
* Example of Null Coalesce Operator
```
$id = $_POST['id'] ?? $_GET['id'] ?? $_SESSION['id'] ?? 0;
```
* New Additions:
  * New as of PHP 7.4: https://www.php.net/manual/en/migration74.new-features.php
    * See: https://github.com/phpcl/phpcl_jumpstart_php_7_4/
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
* Example of `RecursiveDirectoryIterator`
```
<?php
$path = '/home/vagrant/Zend/workspaces/DefaultWorkspace/php3';
$directory = new RecursiveDirectoryIterator($path);
$iterator = new RecursiveIteratorIterator($directory);

foreach ($iterator as $name => $obj) {
        echo $name . "\n";
        var_dump($obj);
}
```
* Variable based stream wrapper:
  * https://github.com/dbierer/classic_php_examples/blob/master/file/streams_custom_wrapper.php
* Streams Docs: https://www.php.net/manual/en/book.stream.php
  * For devices, see: https://www.php.net/manual/en/function.stream-socket-client.php
* Custom compile PHP `configure` options example:
    * See: https://lfphpcloud.net/articles/adventures_in_custom_compiling_php_8
    * Also see installation directions here: https://github.com/php/php-src
    * Missing libraries:
```
sudo apt install -y pkg-config build-essential autoconf bison re2c libxml2-dev libsqlite3-dev
```
    * After cloning from github.com:
```
cd /path/to/cloned/php
tar xvfz php-src-file
cd php-src-xxx
./buildconf
```
    * Example `configure` options
```
./configure  \
    --sysconfdir=/etc \
    --localstatedir=/var \
    --datadir=/usr/share/php \
    --mandir=/usr/share/man \
    --enable-fpm \
    --with-fpm-user=apache \
    --with-fpm-group=apache \
    --with-config-file-path=/etc \
    --with-zlib \
    --enable-bcmath \
    --with-bz2 \
    --enable-calendar \
    --enable-dba=shared \
    --with-gdbm \
    --with-gmp \
    --enable-ftp \
    --with-gettext=/usr \
    --enable-mbstring \
    --enable-pcntl \
    --with-pspell \
    --with-readline \
    --with-snmp \
    --with-mysql-sock=/run/mysqld/mysqld.sock \
    --with-curl \
    --with-openssl \
    --with-openssl-dir=/usr \
    --with-mhash \
    --enable-intl \
    --with-libdir=/lib64 \
    --enable-sockets \
    --with-libxml \
    --enable-soap \
    --enable-gd \
    --with-jpeg \
    --with-freetype \
    --enable-exif \
    --with-xsl \
    --with-pgsql \
    --with-pdo-mysql=/usr \
    --with-pdo-pgsql \
    --with-mysqli \
    --with-pdo-dblib \
    --with-ldap \
    --with-ldap-sasl \
    --enable-shmop \
    --enable-sysvsem \
    --enable-sysvshm \
    --enable-sysvmsg \
    --with-tidy \
    --with-expat \
    --with-enchant \
    --with-imap=/usr/local/imap-2007f \
    --with-imap-ssl=/usr/include/openssl \
    --with-kerberos=/usr/include/krb5 \
    --with-sodium=/usr \
    --with-zip \
    --enable-opcache \
    --with-pear \
    --with-ffi
 ```
* Using PHP directly as a shell script
```
#!/usr/bin/php
<?php
echo 'Hello World!';
```
* Example of a lightweight PHP-based HTML framework
  * https://github.com/dbierer/SimpleHtmlhttps://github.com/dbierer/SimpleHtml
* Using PHP where the document is in another directory:
```
php -S IP-or-DNS:port -t DOC_ROOT_DIR
// example
php -S localhost:9999 -t public
```
* Prototype `StreamWrapper` class
  * Doesn't exist: can't extend it
  * Contains definitions of required methods
  * Only define the ones you need
  * At a minimum: `stream_open()`
  * See: https://www.php.net/StreamWrapper

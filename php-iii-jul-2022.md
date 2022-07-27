# PHP III -- Jul 2022 -- Notes

## TODO
* Q: VM source code update?
* A: `git clone https://github.com/dbierer/php-iii-jul-2022.git`
* A: Alternately download zip:
  * https://github.com/dbierer/php-iii-jul-2022/archive/refs/heads/main.zip

* Q: Jenkins up and running?
TBD

* Q: Async examples: ReactPHP, Swoole and PHP 8.1 fibers?
* A: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/tree/main/ch12

* Get example of new PHP 8 serialization
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_sleep_wakeup.php
  * Article on why `__unserialize()` was introduced: https://wiki.php.net/rfc/custom_object_serialization
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_serialize_unserialize.php
* Q: Do union types also apply to class properties?
* A: Yes, it does
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_union_typed_property.php

* Q: Example of nullsafe operator?
* A: See: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch02/php8_nullsafe_short.php
* A: See: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch02/php8_nullsafe_xml.php

* Q: Example of `SplFixedArray`?
* A: See: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch10/php7_spl_fixed_arr_size.php

* Q: Practical example of `SplObjectStorage`?
* A: See: https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch10/php8_spl_obj_storage.php

* QW: Example of FilterIterator
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php

* Q: Find examples of ArrayIterator::STD_PROP_LIST and ArrayIterator::ARRAY_AS_PROPS?
* A: Couldn't find any examples, but ran across this article:
  * https://stackoverflow.com/questions/14910599/what-does-the-flags-parameter-of-arrayiterator-and-arrayobject-do

## Homework
For Wed 27 Jul 2022
* Lab: OpCache and JIT
* Lab: Existing Extension
  * The `pecl` command probably doesn't work
  * Follow the instructions here: https://openswoole.com/docs/get-started/installation#installing-via-open-swoole-ubuntu-ppa
* Lab: FFI

For Wed 20 Jul 2022
* Update the VM as per class notes (see below)
* Set up Apache JMeter
* Set up Jenkins (follow the lab in the PDF)

## VM
Here are some things to do with the VM after installation
* Update everything
  * Root password = "vagrant"
  * Could take some time!
  * When prompted, choose "Package Maintainer's Version"
  * Do not de-configure the phpMyAdmin database
```
sudo apt update
sudo apt upgrade
```
* Update phpMyAdmin
```
sudo apt remove phpmyadmin
cd /tmp
wget https://files.phpmyadmin.net/phpMyAdmin/5.2.0/phpMyAdmin-5.2.0-all-languages.zip
cd /var/www/html
sudo unzip /tmp/phpMyAdmin-5.2.0-all-languages.zip
sudo mv phpMyAdmin-5.2.0-all-languages/ phpmyadmin
```
* Need to install `git`:
```
sudo apt install -y git
```
Increase the disk size (needed for the Docker labs!)
* See: https://recoverit.wondershare.com/computer-problems/increase-virtualbox-disk-size.html

Refresh the `Zend/workspaces/DefaultWorkspace/php3` folder
* Change to the default workspace directory
```
cd
cd Zend/workspaces/DefaultWorkspace
```
* Repo with updated code examples
```
git clone https://github.com/dbierer/php-iii-jul-2022.git
```

## Lab Notes
### Setup Jenkins CI
* The CheckStyle plug-in reached end-of-life. All functionality has been integrated into the Warnings Next Generation Plugin.
* Same applies to `warnings` and `pmd` : integrated into `Warnings NG`
* Here are some other suggestions for initial setup:
  * replace `checkstyle` with `Warnings Next Generation`
  * replace `build-environment` with `Build Environment`
  * replace `phing` with `Phing`
  * replace `violations` with `Violations`
  * replace `htmlpublisher` with `Build-Publisher` (???)
  * replace `version number` with `Version Number`

### Custom PHP labs
Lab: Install the apcu extension using `pecl`
* To test: use this script: https://github.com/dbierer/php-iii-mar-2021/blob/main/apcu_test.php
* Need to add `apcu.enable=1` and `apc.shm_size=32M` to `/etc/php/8.0/apache2/php.ini` and run from a browser to have the demo work
* Restart the web server after modifying the `php.ini` file: `sudo service apache2 restart`
Lab: New Functions (compile a new extension)
* Install dependencies:
```
sudo apt install php8.0-dev
```
Lab: OpCache and JIT
* Change the last line of code to output not using scientific notation!
```
printf("%8.12f\n", microtime(TRUE) - $start);
```
* Don't forget to set this parameter in the CLI `php.ini` file!
```
opcache.enable_cli=1
```
* JIT demo video: https://studio.youtube.com/video/eJHEpZZtc0c/edit
  * Source code referenced in the video:
  * https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices.git

### Docker Build Lab
See: https://github.com/dbierer/php-iii-jul-2022/blob/main/docker

### Docker Compose Lab
See: https://github.com/dbierer/php-iii-jul-2022/tree/main/docker-compose

### REST API Labs
Lab: REST (using Laminas API Tools)
* You can also run the lab directly from the VM (not the Docker container) as follows:
```
cd ~/Zend/workspaces/DefaultWorkspace
rm -rf apigility
wget https://getcomposer.org/download/1.10.22/composer.phar
php composer.phar create-project --ignore-platform-reqs laminas-api-tools/api-tools-skeleton apigility
cd apigility
mv ../composer.phar .
php composer.phar --ignore-platform-reqs require laminas/laminas-i18n
sudo chgrp -R www-data *
sudo chmod -R 775 *
```
  * From the VM browser: `http://apigility/`
  * Choose `phpcourse` as the database
  * Use `orders` as the table, and change the fields according to this DB structure:
```
CREATE TABLE `orders` (
  `id` int NOT NULL,
  `date` varchar(32) NOT NULL,
  `status` varchar(16) NOT NULL,
  `amount` int NOT NULL,
  `description` text NOT NULL,
  `customer` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```
  * When you insert an order, you can use integer 1 to 5 for customer ID (`customer` field)
  * Ignore the message (if you see it) "Error creating DB connect service"
  * In the lab, substitute `http://apigility` in place of any references to `http://10.20.20.20/laminas-api-tools`


### Middleware Labs
Lab: Add Middleware (Stratigility lab)
* Source code: `wget https://opensource.unlikelysource.com/stratigility_src.zip`
  * Remove `~/Zend/workspaces/DefaultWorkspace/stratigility` directory structure
  * Unzip the source code into a directory on the VM from `~/Zend/workspaces/DefaultWorkspace/`
  * Change to the newly unzipped `stratigility` directory
  * Run `php composer.phar install --ignore-platform-reqs`
  * Reset permissions:
```
sudo chgrp -R www-data *
sudo chmod -R 775 *
```
  * Do the lab

## Resources
Previous class notes:
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-mar-2021.md
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-jan-2021.md
  * https://github.com/dbierer/php-iii-mar-2021

Source code for Stratigility demo updated for Laminas:
  * Source code: `https://opensource.unlikelysource.com/stratigility_src.zip`
  * Sample data dump: `https://opensource.unlikelysource.com/phpcourse.sql`

## Class Notes
Data type hints
  * PHP 7.4 introduced property level data types
```
<?php
declare(strict_types=1);
class Test
{
        public function __construct(
                public int $a = 0,
                public int $b = 0) {}
        public function add()
        {
                return $this->a + $this->b;
        }
}

$test = new Test(2, 2);
echo $test->add();
echo "\n";

$test->a = 2.222;
$test->b = 1.111;
echo $test->add();
echo "\n";
```

DateTime
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
Example using a UNIX timestamp
```
<?php
$date = new DateTime('@' . time());
echo $date->format('l, Y-m-d');
echo "\n";
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
* Usage example
```
<?php
class Test
{
        public function __construct(public array $arr) {}
        public function output()
        {
                return new class($this->arr) {
                        public function __construct(public array $arr) {}
                        public function asHtml()
                        {
                                $out = '<table>' . PHP_EOL;
                                $out .= '<tr><td>' . implode('</td><td>', $this->arr) .  '</td></tr>' . PHP_EOL;
                                $out .= '</table>' . PHP_EOL;
                                return $out;
                        }
                        public function asJson()
                        {
                                return json_encode($this->arr, JSON_PRETTY_PRINT);
                        }
                };
        }
}

$test = new Test([1,2,3,4,5]);
echo $test->output()->asJson();
echo $test->output()->asHtml();
```
* Some differences in handling in PHP 8:
```
<?php
$anon = new class (2, 2) extends ArrayIterator {
        // PHP 8 "constructor argument promotion" syntax
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
// also PHP 8: `::class` is an operator that produces a full namespaced-class name
echo $anon::class;
```
IteratorAggregate
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
Example of `ArrayObject`
```
<?php
$arr = ['A' => 111, 'B' => 222, 'C' => 333];
$obj = new ArrayObject($arr);

echo $obj['B'] . PHP_EOL;
echo $obj->offsetGet('B') . PHP_EOL;

foreach ($obj as $key => $val) echo "$key : $val\n";
```
Classic `__sleep()` and `__wakeup()` example
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_sleep_wakeup.php
* Article on why `__unserialize()` was introduced: https://wiki.php.net/rfc/custom_object_serialization
New `__serialize()` and `__unserialize()`
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_serialize_unserialize.php

* PHP 8 classes that have migrated away from `Iterator` or `Traversable` into `IteratorAggregate`
  * `PDOStatement`
  * `mysqli_result`
  * See: https://www.php.net/manual/en/migration80.other-changes.php
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
* Example of anonymous functions used for form validation/filtering
  * https://github.com/dbierer/classic_php_examples/blob/master/web/form_with_filtering_and_validation.php
Using interfaces as type-hints and abstract classes the implement interfaces
* https://github.com/laminas/laminas-db/blob/2.16.x/src/Adapter/Driver/ConnectionInterface.php
* https://github.com/laminas/laminas-db/blob/2.16.x/src/Adapter/Driver/AbstractConnection.php
* https://github.com/laminas/laminas-db/blob/2.16.x/src/Adapter/Driver/Oci8/Connection.php
`callable` examples:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/callable_examples.php

* `Stringable` Interface
  * Auto-assigned in PHP 8 if class defines `__toString()`
Custom Compile PHP
  * See: https://lfphpcloud.net/articles/adventures_in_custom_compiling_php_8

Strategy Pattern using an array of callbacks
```
<?php
$strategies = [
        'text/html' => function (iterable $arr) {
                $out = '<ul>';
                foreach ($arr as $item) $out .= '<li>' . $item . '</li>';
                $out .= '</ul>';
                return $out;
        },
        'application/json' => function (iterable $arr) {
                return json_encode($arr, JSON_PRETTY_PRINT);
        },
];

$data = ['A' => 111, 'B' => 222, 'C' => 333];
$format = $_SERVER['HTTP_ACCEPT'] ?? 'text/html';
if (!isset($strategies[$format]))
        $format = 'text/html';
echo $strategies[$format]($data);
```
Factory Pattern produces callbacks
```
<?php
class CallbackFactory
{
        public function getCallback(string $x)
        {
                if (method_exists($this, $x)) {
                        return Closure::fromCallable([$this, $x]);
                } else {
                        return NULL;
                }
        }
        public function add($a, $b)
        {
                return $a + $b;
        }
        public function sub($a, $b)
        {
                return $a - $b;
        }
}
$factory = new CallbackFactory();
$add = $factory->getCallback('add');
echo $add(2,2);
```

## SPL
Retrieves an entire directory tree:
```
<?php
$path = '/home/vagrant/Zend/workspaces/DefaultWorkspace/php3/src';
$recurse = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path));
foreach ($recurse as $key => $value) {
        // NOTE: $value is an SplFileInfo instance
        echo $key . '[' . $value->getSize() . "]\n";
}
```
Anonymous class with `FilterIterator` example:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php

## PHP CLI
One-off PHP command inside a shell script:
```
#!/bin/bash
php -r "echo base64_encode(random_bytes($1));"
```
Running PHP code inside a shell script:
```
#!/usr/bin/env php
<?php
echo __FILE__ . "\n";
var_dump($_SERVER);
```
Getting CLI args:
  * `$_SERVER['argv']` or
  * `$argv[]`

## Docker
More examples:
* https://github.com/zendtech/Laminas-Level-1-Attendee/blob/master/docker-compose.yml
* https://github.com/zendtech/Laminas-Level-1-Attendee/blob/master/docker/Dockerfile
Docker Swarm
* Lets you create a cluster of servers running docker
* Shares containers between servers
* You can also use Kubernetes for the same thing
  * Kubernetes is much more complicated to configure and get up and running
* Dockerfile
  * `ENTRYPOINT` is the point-of-entry when you run an image
  * `CMD` is the command provided to the entrypoint
  * Example:
```
ENTRYPOINT /bin/bash
CMD ps -ax
```


## Web APIs
Oauth2 client:
  * https://packagist.org/packages/league/oauth2-client
  * You can then pick from around 60 different "providers" (e.g. authentication sources)

## Software Design
The original seminal work in this area:
  * https://en.wikipedia.org/wiki/Design_Patterns
  * https://www.amazon.com/Patterns-Enterprise-Application-Architecture-Martin/dp/0321127420

## Just-In-Time Compiler
Good foundational article: https://www.zend.com/blog/exploring-new-php-jit-compiler
* Article that describes JIT in PHP 8: https://wiki.php.net/rfc/jit
* You can enable PCRE to use JIT for pattern compilation using this `php.ini` setting:
```
; Enables or disables JIT compilation of patterns. This requires the PCRE
; library to be compiled with JIT support.
pcre.jit=1
```

## Q & A
* Q: Do you have any documentation for HAL+JSON?
* A: https://docs.mezzio.dev/mezzio-hal/v2/

* Q: What is `opcache.interned_strings_buffer`?
* A: The amount of memory used to store interned strings in MB
* A: See: https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.interned-strings-buffer

* Q: What is an "interned" string?
* A: Any strings interned in the startup phase. Common to all the threads, won't be free'd until process exit. If we want an ability to add permanent strings even after startup, it would be still possible on costs of locking in the thread safe builds.
* A: See: https://github.com/php/php-src/blob/master/Zend/zend_string.c

* Q: What are the PHP 8 `JIT` flags?
* A: For overview see: https://wiki.php.net/rfc/jit
* A: For `php.ini` defaults see: https://wiki.php.net/rfc/jit#phpini_defaults

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
* Transmitting binary data using base64
```
<?php
$dir = '/home/vagrant/Downloads/';
$src = 'napoleon.jpg';
$dest = 'test.jpg';
$str = file_get_contents($dir . $src);
$encode = base64_encode($str);
// let's assume this has been transmitted somewhere
file_put_contents($dir . $dest, base64_decode($encode));
```

## Change Request
* Move course module 5 (Targeted Server Environments) to the end

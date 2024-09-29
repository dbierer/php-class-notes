# PHP Architect -- Sep 2024

http://localhost:8883/#/4/21

## TODO
* Q: Are there any good places that give examples or challenges regarding design patterns?

* Example of Doctrine annotations
* Has Laravel switched to using Attributes?
* Find out why unable to install Swoole in the VM

* Q: Is `Carbon` (from Laravel) an exmple of the Decorator pattern?
```
Carbon::now()->format('Y-m-d H:i:s'
```
  * https://carbon.nesbot.com/laravel/

## Homework
For Friday 27 Sep
* Lab: FFI
* Lab: New Extension [Optional]
* Lab: ZendPHP for AWS [optional]

For the week of 23 Sep
* Lab: Custom PHP
* Lab: Built-in Web Server
* Lab: OpCache and JIT
* Lab: Existing Extension

## Class Notes
Design Approaches
* BDD
  * Example: https://docs.behat.org/en/latest/
* AI Driven Design
  * Example: https://v0.dev/chat
  * Example: ChatGPT
* Dependency Injection
  * https://martinfowler.com/articles/injection.html
* Hydrator Example
  * Use this: https://docs.laminas.dev/laminas-hydrator/v4/quick-start/
  
Object Relational Mapping
* https://www.doctrine-project.org/
Example of Active Record (database design)
* https://github.com/dbierer/classic_php_examples/blob/master/db/db_active_record_example.php
Relative DateTime Formats
* https://www.php.net/manual/en/datetime.formats.php#datetime.formats.relative
Example of a working "Event" system
* https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html
Installing PHP from source on Windows
* See: https://wiki.php.net/internals/windows/stepbystepbuild
Attributes
* https://www.php.net/Attributes
Phing
* Docs: https://www.phing.info/guide/hlhtml/
* `build.xml` example: https://github.com/phingofficial/phing/blob/main/docs/example/build.xml

## General Lab Notes
* Lab Code:
  * Source code is located here: `https://opensource.unlikelysource.com/zend-training/php-iii/course_projects.zip`
* Lab: OpCache and JIT
    * CLI utility to reset JIT:
    * https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch10/php8_jit_reset.php
    * Move `/home/vagrant/Zend/JIT/mandelbrot.php` to `/home/vagrant/Zend/sandbox/mandelbrot.php`
    * Don't forget to renable JIT in `/etc/php/PHP_VER/apache2/conf.d/10-opcache.ini`
    * Adjust `php.ini` settings for OpCache and JIT
      * Do a few test runs without OpCache or JIT
      * Do a few test runs with OpCache
      * Do a few test runs without OpCache and JIT in `function` mode
      * Do a few test runs without OpCache and JIT in `tracing` mode
    * Example timinig results:
```
w/out opcache: ~2.7
with  opcache: ~2.5
with JIT function: ~0.75
with JIT tracing: ~0.41
```
Lab: Custom PHP
* See next subheading below
Lab: Existing Extension
* Instructions to install Swoole:
  * Notes from Matthew Weier O'Phinney, Zend Product Manager / Principal Engineer
	* There's no way to pass additional flags when doing a compiled extension installation.
	* The steps you need to take:
	  * Make sure the dev package for the given PHP version is installed.
      * Make sure any dev libraries you need to compile the given extension are installed.
      * Grab the package for the extension from PECL or wherever they are providing it; DO NOT use the pecl tool itself, though.
      * Unarchive the package.
      * In the package root, run `/path/to/phpize-for-your-php-version`
      * From there, you can run `./configure --with-php-config=/path/to/php-config-for-your-php-version --enable-openssl`, along with any other flags
      * If that succeeds, run make​, followed by make install​.
	* The path to `phpize` and `php-config` will vary based on your OS and PHP version, but are usually found in `/usr/bin/`​.
  * The reason I suggest this path instead of using `PECL` is for a couple of reasons:
	* It assumes there is only one PHP on the system. If there is, it's not a problem, but if you have more than one, the wrong `phpize` and/or `php-config` might be used.
    * You cannot provide arguments to configure​ with `PECL`, either.
* Example installation:
```
# NOTE: version was 5.1.4
# Change the the current version
export VERSION=5.1.4
sudo apt install libbrotli-dev php8.3-dev
cd /tmp
curl -L http://pecl.php.net/get/swoole -o swoole.tar.gz
tar -xvf swoole.tar.gz
cd swoole-$VERSION
phpize
sudo ./configure \
	--with-php-config=/usr/bin/php-config \
	--enable-sockets \
	--enable-openssl \
	--enable-brotli \
	--enable-swoole
sudo make
sudo make test
sudo make install
sudo find / -name swoole.so -ls
# Write down the location which we'll call LOCATION
cp $LOCATION/swoole.so /usr/lib/php/8.3-zend
sudo echo "extension=swoole.so" > /etc/php/8.3-zend/mods-available
sudo zendphpctl ext enable swoole
```

Lab: Custom Extension Installation
* You can use `zendphpctl` for this purpose
```
sudo zendphpctl ext install swoole
```

Lab: New Extension
  * Lab needs additional work
  * If you follow the instructions here exactly, "test1()" works, but "test2()" does not
    * https://www.zend.com/resources/php-extensions/building-and-installing-php-extension

Lab: Adding Middleware
  * Take the code from the slides
  * Add a middleware request handler that implements an update (HTTP "PATCH")

Lab: Docker
  * Need to add the `-f` flag to the `ln` command in the `Dockerfile`
```
    ln -s -f /usr/bin/php$PHP_VER /usr/bin/php
```

Lab: Docker Compose Labs
  * Have a look at the article on Orchestration: https://www.zend.com/blog/what-is-cloud-orchestration
* Swoole Lab

  * Run these three program under `src` and compare the time:
    * `normal.php`
    * `swoole.php`
    * `react.php`

API Tools Lab
* If you install it in another directory other than the one in the lab, you can do this:
```
cd path/to/api/tools
php -S 0.0.0.0:8080 -t public public/index.php
```

## Custom PHP Lab Notes

* Clone from github
* Switch to branch target version of PHP (e.g. 7.4.11)
```
git checkout php-PHP_VER
```
* Follow the instructions
* Be sure to install the pre-requisites!
* Suggested `./configure` options (place this all on one line):
```
./configure  \
    --enable-cli \
    --enable-filter \
    --with-openssl \
    --with-zlib \
    --with-curl \
    --enable-pdo \
    --with-libxml \
    --with-iconv \
    --enable-cgi \
    --enable-session \
    --with-pdo-mysql \
    --enable-phar \
    --with-pdo-sqlite \
    --with-pcre-jit \
    --with-zip \
    --enable-ctype \
    --enable-gd \
    --enable-bcmath \
    --enable-sockets \
    --with-bz2 \
    --enable-exif \
    --enable-intl \
    --with-gettext \
    --enable-opcache \
    --enable-fileinfo \
    --with-readline \
    --with-sodium
```

### Dependency errors:
```
vagrant@php-training:/tmp/php-src$ ./buildconf
buildconf: Checking installation
buildconf: autoconf not found.
           You need autoconf version 2.68 or newer installed
           to build PHP from Git.
vagrant@php-training:/tmp/php-src$
```
Installed `autoconf`; now `buildconf` works OK:
```
vagrant@php-training:/tmp/php-src$ sudo apt install autoconf
... some output not shown ...
vagrant@php-training:/tmp/php-src$ ./buildconf
buildconf: Checking installation
buildconf: autoconf version 2.71 (ok)
buildconf: Cleaning cache and configure files
buildconf: Rebuilding configure
buildconf: Rebuilding main/php_config.h.in
buildconf: Run ./configure to proceed with customizing the PHP build.
```
Ran `configure` with the options shown above
```
vagrant@php-training:/tmp/php-src$ ./buildconf
buildconf: Checking installation
buildconf: autoconf version 2.71 (ok)
buildconf: Cleaning cache and configure files
buildconf: Rebuilding configure
... some output not shown ...
checking for pkg-config... no
checking for cc... no
checking for gcc... no
configure: error: in `/tmp/php-src':
configure: error: no acceptable C compiler found in $PATH
See `config.log' for more details
```
* Since this was a fresh Ubuntu 22 install, had to install `gcc`
```
vagrant@php-training:/tmp/php-src$ sudo apt install -y gcc
```
Installed the recommended dependencies:
```
sudo apt install -y pkg-config build-essential autoconf bison re2c \
                    libxml2-dev libsqlite3-dev
```
Installed other potential dependencies based upon the `configure` options:
```
sudo apt install -y libbz2-dev  libpng-dev zlib1g-dev libsodium-dev \
                    libreadline-dev libcurl4-openssl-dev libbz2-dev
```
Again, since this is a fresh version of Ubuntu, other errors arose:
```
No package 'openssl' found
Consider adjusting the PKG_CONFIG_PATH environment variable if you
installed software in a non-standard prefix.

Alternatively, you may set the environment variables OPENSSL_CFLAGS
and OPENSSL_LIBS to avoid the need to call pkg-config.
See the pkg-config man page for more details.
```
But OpenSSL is already installed!
```
vagrant@php-training:/tmp/php-src$ sudo apt install -y openssl
Reading package lists... Done
Building dependency tree... Done
Reading state information... Done
openssl is already the newest version (3.0.2-0ubuntu1.15).
openssl set to manually installed.
0 upgraded, 0 newly installed, 0 to remove and 0 not upgraded.
```
Same problem with the ZIP extension
```
configure: error: Package requirements (libzip >= 0.11 libzip != 1.3.1 libzip != 1.7.0) were not met:

No package 'libzip' found
No package 'libzip' found
No package 'libzip' found

Consider adjusting the PKG_CONFIG_PATH environment variable if you
installed software in a non-standard prefix.

Alternatively, you may set the environment variables LIBZIP_CFLAGS
and LIBZIP_LIBS to avoid the need to call pkg-config.
See the pkg-config man page for more details.
```
* The `configure` error is because PHP uses `pkg-config` to locate dependent packages
  * If a package was installed without `pkg-config` you either need to configure the package for `pkg-config` or set the environment vars indicated in the error message
  * Solution: removed the `--with-openssl` and `--with-zip` options
  * Reran `configure` and it worked OK
  * Will have to install these two extensions separately using `pecl` or the equivalent
Success! `make` worked :-)
```
...
Generating phar.php
Generating phar.phar
PEAR package PHP_Archive not installed: generated phar will require PHP's phar extension be enabled.
directorytreeiterator.inc
phar.inc
invertedregexiterator.inc
clicommand.inc
directorygraphiterator.inc
pharcommand.inc

Build complete.
Don't forget to run 'make test'.

```

### Other Errors
```
checking for BZip2 in default path... not found
configure: error: Please reinstall the BZip2 distribution
```
* https://unix.stackexchange.com/questions/658758/php-build-error-please-reinstall-bzip2-distribution
* `sudo apt install -y libbz2-dev`
```
configure: error: Package requirements (libcurl >= 7.29.0) were not met:
No package 'libcurl' found
```
* `sudo apt install -y libcurl4-openssl-dev`
```
configure: error: Please reinstall readline - I cannot find readline.h
```
* https://stackoverflow.com/questions/35879203/linux-php-7-configure-error-please-reinstall-readline-i-cannot-find-readline
* `sudo apt install -y libreadline-dev`
```
configure: error: Package requirements (libsodium >= 1.0.8) were not met:
No package 'libsodium' found
```
* `sudo apt install -y libsodium-dev`
```
configure: error: Package requirements (zlib) were not met:
No package 'zlib' found
```
* NOTE: this error actually comes from installing the `GD` extension
* See: https://www.php.net/manual/en/image.installation.php
  * As of PHP 7.4.0, `--with-png-dir` and `--with-zlib-dir` have been removed. `libpng` and `zlib` are required.
* See: https://askubuntu.com/questions/508934/how-to-install-libpng-and-zlib
* `sudo apt install -y libpng-dev zlib1g-dev`
```
configure: error: Package requirements (libzip >= 0.11 libzip != 1.3.1 libzip != 1.7.0) were not met:
No package 'libzip' found
```
* https://stackoverflow.com/questions/45775877/configure-error-please-reinstall-the-libzip-distribution
* `sudo apt install -y libzip-dev`

Final Solution:
```
sudo apt install -y libbz2-dev  libpng-dev zlib1g-dev libsodium-dev \
                    libreadline-dev libcurl4-openssl-dev libbz2-dev
```

To switch versions use `update-alternatives --config php` (see below for more info)

## Jenkins Lab:
Instructions for Jenkins using the official Docker image
* General usage: https://github.com/jenkinsci/docker/blob/master/README.md
  * Use this image: `jenkins/jenkins:alpine3.18-jdk21`
  * To run the image:
```
mkdir jenkins_home
docker run -p 8080:8080 -p 50000:50000 --restart=on-failure -v jenkins_home:`pwd`/jenkins_home jenkins/jenkins:alpine3.18-jdk21
```
  * Look for a message about the admin password
    * S/be located here: `/var/jenkins_home/secrets/initialAdminPassword`
  * To access, from a browser: `http://localhost:8080`
  * Installed the "suggested" plugins + those on the list for the lab

## Smoke Testing Lab
Make sure Java is installed:
```
java --version
```
* If it's not installed it tells you how to install it!

Download Apache JMeter
  * Download binary from: https://jmeter.apache.org/download_jmeter.cgi
  * Extract to `/home/vagrant/jmeter`
  * From a terminal window run the shell script:
```
/home/vagrant/jmeter/bin/jmeter.sh
```

## Advanced PHP
Supplementary date-related functions:
* https://www.php.net/manual/en/ref.calendar.php

Full `DateTime::format()` codes:
* https://www.php.net/manual/en/datetime.format.php
Getting differences between dates, use `diff()`
```
<?php
$today = new DateTime('now');
$past  = new DateTime('1970-01-01');
$future = new DateTime('2024-12-01');
$diff[] = $today->diff($past);		// $diff->invert === 1
$diff[] = $today->diff($future);	// $diff->invert === 0
var_dump($diff);

// actual output for today (2023-11-28)
/*
 * array(2) {
  [0]=>
  object(DateInterval)#4 (10) {
    ["y"]=>
    int(53)
    ["m"]=>
    int(10)
    ["d"]=>
    int(27)
    ["h"]=>
    int(2)
    ["i"]=>
    int(15)
    ["s"]=>
    int(15)
    ["f"]=>
    float(0.395718)
    ["invert"]=>
    int(1)
    ["days"]=>
    int(19689)
    ["from_string"]=>
    bool(false)
  }
  [1]=>
  object(DateInterval)#5 (10) {
    ["y"]=>
    int(1)
    ["m"]=>
    int(0)
    ["d"]=>
    int(2)
    ["h"]=>
    int(21)
    ["i"]=>
    int(44)
    ["s"]=>
    int(44)
    ["f"]=>
    float(0.604282)
    ["invert"]=>
    int(0)
    ["days"]=>
    int(368)
    ["from_string"]=>
    bool(false)
  }
}
*/
```
Adding a date, create a `DateInterval` instance
```
<?php
$date = new DateTime('now');
$date->add(new DateInterval('P92D'));
echo $date->format('l, j M Y');
// example output: Wednesday, 3 Mar 2023
```
Relative time formats
```
<?php
$date = new DateTime('third thursday of next month');
echo $date->format('l, j M Y');
echo PHP_EOL;

$date = new DateTime('last day of last month');
echo $date->format('l, j M Y');
echo PHP_EOL;

```
## Generator
Example that demonstrates memory savings using a Generator
```
<?php
$arr = range(1,100000);
function test(array $arr)
{
	$result = [];
	foreach ($arr as $item)
		$result[] = $item * 1.08;
	return $result;
}

foreach (test($arr) as $item) echo $item . ' ';
echo 'Peak Memory: ' . memory_get_peak_usage(); // Peak Memory: 4,596,064

function test2(array $arr)
{
	foreach ($arr as $item)
		yield $item * 1.08;
}

foreach (test2($arr) as $item) echo $item . ' ';
echo 'Peak Memory: ' . memory_get_peak_usage(); // Peak Memory: 2,494,824

```
Does *not* implement the `Countable` interface:
```
function test2(array $arr)
{
	foreach ($arr as $item)
		yield $item * 1.08;
}
$result = test2($arr);
echo count($result);
// PHP Fatal error:  Uncaught TypeError: count(): Argument #1 ($value) must be of type Countable|array, Generator given in /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public/test.php:20
```

Extracting a return value from a Generator
* The iteration must be complete
* Use `getReturn()` to extract the return value
```
<?php
$arr = range(1,100000);

function test2(array $arr)
{
	$sum = 0;
	foreach ($arr as $item) {
		$new = $item * 1.08;
		yield $new;
		$sum += $new;
	}
	return $sum;
}

$gen = test2($arr);
foreach ($gen as $item) echo $item . ' ';
echo PHP_EOL;
echo $gen->getReturn();
```
Make an object "iterable" by implementing `IteratorAggregate`:
```
<?php
class Test implements IteratorAggregate
{
	public function __construct(public string $first, public string $last, public string $role) {}
	public function getIterator()
	{
		return new ArrayIterator(get_object_vars($this));
	}
}

$test = new Test('Fred', 'Flintstone', 'Caveman');

foreach ($test as $item) echo $item . PHP_EOL;

var_dump(iterator_to_array($test));
```
This shows using `IteratorAggregate` to pass through a data type hint of `iterable`
```
<?php
class Test implements IteratorAggregate
{
	public $name = 'Fred';
	public $addr = '123 Main Street';
	public $status = 'OK';
	public function getIterator()
	{
		return new ArrayIterator($this);
	}
}

$test = new Test();

function whatever(iterable $whatever)
{
	foreach ($whatever as $key => $value) {
		echo $key . ':' . $value . PHP_EOL;
	}
}

whatever($test);
```

## Anonymous Class
Example shown on the slides with a slight modification
```
<?php
// change as needed
define('REGEX', '!.*?spl.*?\.php!i');

// starting path for search
$path  = realpath(__DIR__);

// set up directory iteration
$dirIterator = new RecursiveDirectoryIterator($path);
$recIterator = new RecursiveIteratorIterator($dirIterator);

// define filter using an anonymous class
$filtIterator = new class ($recIterator) extends FilterIterator {
    public function accept()
    {
		// $this->key() : returns the filename (full path)
		// $this->current(): returns an SplFileInfo instance
        return preg_match(REGEX, $this->current()->getBasename());
    }
};

// display results
foreach ($filtIterator as $name => $obj) echo $name . "\n";
```

Example where the return value is an anon class with different methods to render its data
```
<?php
class Test
{
    public function getObject(array $arr)
    {
		return new class ($arr) {
			public $arr = [];
			public function __construct(array $arr)
			{
				$this->arr = $arr;
			}
			public function asHtml()
			{
				$html = '<ul>' . PHP_EOL;
				foreach ($this->arr as $item) $html .= '<li>' . $item . '</li>' . PHP_EOL;
				$html .= '</ul>' . PHP_EOL;
				return $html;
			}
			public function asJson()
			{
				return json_encode($this->arr, JSON_PRETTY_PRINT);
			}
		};
	}
}

$arr = ['AAA','BBB','CCC','DDD'];
$obj = (new Test())->getObject($arr);
echo $obj->asHtml();
echo $obj->asJson();
var_dump($obj->arr);
var_dump($obj);
```
Example from the slide "Event Listener" using `__invoke()` to make it callable:
```
// An anonymous event class listener example
$listener = new class {
    public function __invoke(Event $e)
    {
        echo "The big event \" { $e->getName ()} \" is happening!" ;
    }
};
```
Potential problem: how does the user (i.e. another developer) know that this functionality is available
* Solution: have the anonymous class implement an interface:
```
<?php
interface HtmlJson
{
	public function asHtml();
	public function asJson();
}
class Test
{
    public function getObject(array $arr)
    {
		return new class ($arr) implements HtmlJson {
			public $arr = [];
			public function __construct(array $arr)
			{
				$this->arr = $arr;
			}
			public function asHtml()
			{
				$html = '<ul>' . PHP_EOL;
				foreach ($this->arr as $item) $html .= '<li>' . $item . '</li>' . PHP_EOL;
				$html .= '</ul>' . PHP_EOL;
				return $html;
			}
			public function asJson()
			{
				return json_encode($this->arr, JSON_PRETTY_PRINT);
			}
		};
	}
}

$arr = ['AAA','BBB','CCC','DDD'];
$obj = (new Test())->getObject($arr);
echo $obj->asHtml();
echo $obj->asJson();
var_dump($obj->arr);
var_dump($obj);
```

## Interfaces
### Traversable
`Traversable` connects the old approach (`Iterator`) with a newer approach (`IteratorAggregate`)
```
<?php
class Test implements IteratorAggregate
{
        protected $name = 'Doug';
        protected $country = 'Thailand';
        protected $language = 'EN';
        public function getIterator()
        {
                return new ArrayIterator(get_object_vars($this));
        }
}

$test = new Test();
foreach($test as $key => $value) echo $key . ':' . $value . PHP_EOL;
```
Yet another example:
```
<?php
class User implements IteratorAggregate
{
	public $first = 'Fred';
	public $last  = 'Flintstone';
	public $role  = 'Caveman';
	public $date  = NULL;
	public function __construct()
	{
		$this->date = new DateTime();
	}
	public function getIterator()
	{
		$list = get_object_vars($this);
		$list['date'] = $this->date->format('l, j M Y');
        return new ArrayIterator($list);
    }
}

$user = new User();

function looper(Traversable $trav)
{
	foreach ($trav as $key => $val) echo "$key\t$val\n";
}

looper($user);
```
In this example, note that if we uncomment line 8, the legacy code still works
* The reason is because `ArrayObject` implements `ArrayAccess`
* We can also use an anonymous class to extend `ArrayObject` and add new functionality
```
<?php
$arr = [
	'first' => 'Fred',
	'last'  => 'Flintstone',
	'amount' => 99.99,
];

// if you uncomment the next line, $arr becomes an object, but the remaining code works OK
$arr = new class($arr) extends ArrayObject
{
	public function getJson()
	{
		return json_encode($this->getArrayCopy(), JSON_PRETTY_PRINT);
	}
};

// some other code

$purch = (float) ($_GET['purch'] ?? 1.11);
$arr['amount'] += $purch;
$arr['tax']     = $arr['amount'] * 0.07;

// some other code

// final output:
echo '<table>';
foreach ($arr as $key => $val)
	echo '<tr><th>' . $key . '</th><td>' . $val . '</td></tr>' . PHP_EOL;
echo '</table>';
echo PHP_EOL;
echo $arr->getJson();
```
Using an interface as a data type
```
<?php
interface AddInterface
{
	public function add(int $a, int $b) : int;
}

class Test implements AddInterface
{
	public function add(int $a, int $b) : int
	{
		return $a + $b;
	}
}

class Baby extends Test
{
	public function sub(int $a, int $b) : int
	{
		return $a - $b;
	}
}

class Something implements AddInterface
{
	public function add(int $a, int $b) : int
	{
		return $a + $b;
	}
}

function whatever(AddInterface $obj, int $x, int $y)
{
	echo "The sum of $x and $y is: ";
	echo $obj->add($x, $y);
	echo PHP_EOL;
}

// all three instances work because they are associated with AddInterface at some level
$test = new Test();
whatever($test, 2, 2);

$baby = new Baby();
whatever($baby, 2, 2);

$some = new Something();
whatever($some, 2, 2);
```

### Stringable (new in PHP 8)
Anytime you implement `__toString()`
```
<?php
class Test
{
        protected $name = 'Doug';
        protected $country = 'Thailand';
        protected $language = 'EN';
        public function __toString()
        {
                return var_export(get_object_vars($this), TRUE);
        }
}

$test = new Test();
echo $test;
echo PHP_EOL;
$reflect = new ReflectionObject($test);
echo $reflect;
echo PHP_EOL;

// output
/*
 * Object of class [ <user> class Test implements Stringable ] {
  @@ C:\Users\azure\Desktop\test.php 2-11

  - Constants [0] {
  }
  ...
*/
```
### ArrayAccess Interface
It's treated just like an array
```
<?php
$user = [
        'user' => 'joe',
        'email'  => 'joe@company.com',
        'address' => '123 Main Street',
        'city' => 'Utrecht',
        'country' => 'NL',
];

$user = new ArrayObject($user);
$user['status'] = 'OK';

echo 'Name  :' . $user['user'] . PHP_EOL;
echo 'Email :' . $user['email'] . PHP_EOL;
echo 'City  :' . $user['city'] . PHP_EOL;
echo 'Status:' . $user['status'] . PHP_EOL;
```
### Iterators
`ArrayIterator` example
```
<?php
$data = [
        'F' => 666,
        'A' => 111,
        'E' => 555,
        'C' => 333,
        'B' => 222,
        'D' => 444,
];

// here's the traditional way to use a while() with an array:
asort($data);
$pos   = 0;
$count = count($data);
while ($pos++ < $count) {
        echo key($data) . ':' . current($data) . PHP_EOL;
        next($data);
}

// same thing but using ArrayIterator:
$it = new ArrayIterator($data);
$it->asort();
while ($it->valid()) {
        echo $it->key() . ':' . $it->current() . PHP_EOL;
        $it->next();
}
```
## SPL
Example of linked list:
```
<?php
$base = [
	'A' => 111,
	'B' => 222,
	'C' => 333,
	'D' => 444,
	'E' => 555,
	'F' => 666,
];

$link = ['F','E','D','C','B','A'];

foreach ($link as $key)
	echo $base[$key] . PHP_EOL;
```
Example of doubly linked list (using just arrays)
```
<?php
$base = [
	'A' => 111,
	'B' => 222,
	'C' => 333,
	'D' => 444,
	'E' => 555,
	'F' => 666,
];

$reverse = ['F','E','D','C','B','A'];
$forward = ['A','B','C','D','E','F'];

function showBase(array $link, array $base)
{
	foreach ($link as $key)
		echo $base[$key] . PHP_EOL;
}

echo showBase($forward, $base);
echo showBase($reverse, $base);
```
Example of a linked list
```
<?php
$arr  = ['A' => 111, 'B' => 222, 'C' => 333, 'D' => 444, 'E' => 555, 'F' => 666];
$rev = range('F','A');
$fwd = range('A','F');
foreach ($fwd as $key) echo $arr[$key] . PHP_EOL;;
foreach ($rev as $key) echo $arr[$key] . PHP_EOL;;
```
Example of doubly linked list (using `SplDoublyLinkedList`)
```
<?php
$obj = new SplDoublyLinkedList();
$obj[] = 111;
$obj[] = 222;
$obj[] = 333;
$obj[] = 444;
$obj[] = 555;
$obj[] = 666;

function showBaseObj(object $obj)
{
	foreach ($obj as $value)
		echo "$value\n";
}

echo showBaseObj($obj);
$obj->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO );
echo showBaseObj($obj);

```
Another example building the `SplDoublyLinkList` manually
```
<?php

$val  = 100;
$dbl  = new SplDoublyLinkedList();

for ($x = 0; $x < 6; $x++) {
	$dbl->add($x, $val);
	$val += 100;
}

foreach ($dbl as $key => $val) {
	echo $key . ':' . $val;
	echo PHP_EOL;
}

$dbl->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
foreach ($dbl as $key => $val) {
	echo $key . ':' . $val;
	echo PHP_EOL;
}

```

Recurse through an entire directory structure
```
<?php
$path = __DIR__ . '/../../orderapp';
$dir  = new RecursiveDirectoryIterator($path);
$rec  = new RecursiveIteratorIterator($dir);

foreach ($rec as $key => $val) {
	// $key == full path + filename
	echo $key . PHP_EOL;
	// $val == SplFileInfo instance
	var_dump($val);
}

```
`SplSubject`,`SplObserver`, and `SplObjectStorage` used to implement Subject/Observer pattern:
* See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_subject_observer_storage_object.php
`SplFixedArray` example:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_fixed_arr_compared_with_array_and_array_object.php
Example of an autoloader that uses an array mapping technique to locate files that represent classes
* See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_autoload_example_using_map_algorithm.php
Example using recursive iterators to scan a directory structure:
```
<?php
$dirIt = new RecursiveDirectoryIterator(__DIR__ . '/../../php3/src/ModSPL');
$recur = new RecursiveIteratorIterator($dirIt);

foreach($recur as $name => $obj){
	if ($obj->isFile()) {
		echo $obj->getBasename() . PHP_EOL;
	} elseif ($obj->isDir()) {
		echo $obj->getPath() . PHP_EOL;
	}
}
```

## CLI
One of the best implementations for CLI is `Symfony/Console`
* See: https://symfony.com/doc/current/components/console.html
Example using both CLI args and interactive:
```
<?php
$usage = "Usage: php test.php -s | -i \n";
$param = $_SERVER['argv'][1] ?? '-i';
if ($param === '-s') var_dump($argv);
$cmd = readline('What do you want to do? ');
echo $cmd . PHP_EOL;
```
* Also: notice that Composer has an extensive CLI capability
```
$ php composer.phar require
Search for a package: phpunit
Found 15 packages matching phpunit

   [0] phpunit/phpunit
   [1] phpunit/php-timer
   [2] phpunit/php-text-template
   [3] phpunit/php-file-iterator
   [4] phpunit/php-code-coverage
   [5] phpunit/phpunit-mock-objects Abandoned. No replacement was suggested.
   [6] symfony/phpunit-bridge
   [7] jean85/pretty-package-versions
   [8] phpunit/php-invoker
   [9] phpunit/php-token-stream Abandoned. No replacement was suggested.
  [10] johnkary/phpunit-speedtrap
  [11] phpstan/phpstan-phpunit
  [12] brianium/paratest
  [13] yoast/phpunit-polyfills
  [14] spatie/phpunit-snapshot-assertions
```

* If you're using OOP, consider using `Symfony\Console`
## Stream Wrapper Example
`runStreamDb.php`:
```
<?php
/**
 * StreamDb Runner
 */

require __DIR__ . '/../../../vendor/autoload.php';
use src\ModAdvancedTechniques\IO\StreamDb;

stream_wrapper_register('myDb', StreamDb::class);

// Stream write to a row
$user = 'vagrant';
$pwd  = 'vagrant';
$host = '127.0.0.1';
$uri  = 'myDb://' . $user . ':' . $pwd . '@' . $host . '/php3/1';
$resource = fopen($uri, 'w');
if($bytesAdded = fwrite($resource, 'TEST: ' . date('Y-m-d H:i:s'))) echo $bytesAdded . ' bytes Written';
fclose($resource);

// Stream read from a table row.
$resource = fopen($uri, 'r');
var_dump(fread($resource, 4096));
```

`StreamDb.php`:

```
<?php
/**
 * Custom Stream Wrapper and Runner
 */
namespace src\ModAdvancedTechniques\IO;
class StreamDb {
    const TABLE = 'data';
    const SQL_SELECT = 'SELECT * FROM `%s` WHERE id=%d';
    const SQL_UPDATE = 'UPDATE `%s` SET data=:data WHERE id=:id';
    const SQL_INSERT = 'INSERT INTO `%s` (id, data) VALUES (:id, :data)';

    protected $stmt, $position, $data, $url, $id, $mode;

    public function stream_open($url, $mode)
    {
        $result = FALSE;
        $this->position = 0;
        $url = parse_url($url);
        $path = explode('/', $url['path']);
        $this->id = (int) $path[2];
        if (empty($this->id)) $this->id = 1;
        $this->mod = $mode ?? 'r';
        try{
            $pdo = new \PDO("mysql:host={$url['host']};dbname={$path[1]}",
                $url['user'], $url['pass'], [\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION]);
        } catch(\PDOException $e){return $result;}

                switch ($mode) {
                        case 'w' :
                                $pdo->exec('DELETE FROM ' . static::TABLE . ' WHERE id=' . $this->id);
                                $this->stmt = $pdo->prepare(sprintf(static::SQL_INSERT, static::TABLE));
                                break;
                        case 'a' :
                                $this->stmt = $pdo->prepare(sprintf(static::SQL_UPDATE, static::TABLE, $this->id));
                        case 'r' :
                        default :
                                $this->stmt = $pdo->prepare(sprintf(static::SQL_SELECT, static::TABLE, $this->id));
                }
        return TRUE;
    }

    public function stream_write($data)
    {
        $strlen = strlen($data);
        $this->position += $strlen;
        $binding = ['id' => $this->id, 'data' => $data];
        //echo __METHOD__ . ':' . var_export($binding, TRUE) . ':' . var_export($this->stmt, TRUE); exit;
        return $this->stmt->execute($binding) ? $strlen : null;
    }

    public function stream_read()
    {
        $this->stmt->execute();
        if($this->stmt->rowCount() == 0) return false;
        return implode(',', $this->stmt->fetch());
    }

    public function stream_tell()
    {
        return $this->id;
    }

    function stream_eof()
    {
        return (bool) $this->stmt->rowCount();
    }
}
```
SQL to create table in the `php3` database in the VM:
```
CREATE TABLE `data` (
  `id` int unsigned NOT NULL,
  `data` varchar(255) NOT NULL,
  `mod_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
```
## Caching ad JIT
To manipulate browser caching, you can use the `Cache-Control` header
* See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control
Normally OpCache ignores comments (including Annotations)
* Doctrine uses these heavily
* If you're running PHP 8 or above, Doctrine will use Attributes
* See: https://www.doctrine-project.org/projects/doctrine-orm/en/2.17/reference/attributes-reference.html
* See: https://www.php.net/manual/en/language.attributes.overview.php

You can also use a `php.ini` setting of `on` to enable JIT:
* `opcache.jit=on` this is an alias for `tracing`
* Also, don't forget to enable opcache itself
* In addition: set a memory size for JIT (otherwise it won't work)
```
; example:
opcache.jit_buffer_size=32M
```
## Extensions
How do you tell if an extension is part of the "core"?
* See: https://github.com/php/php-src/tree/master/ext
How can you manipulate `php.ini` in a Docker container?
* In the `Dockerfile` first install PHP
* You can then do something like this:
```
# Make sure OpCache is enabled (should be done already!):
export PHP_INI=/etc/php.ini
sed -i 's/;zend_extension=opcache/zend_extension=opcache/g' $PHP_INI
sed -i 's/;opcache.enable=0/opcache.enable=1/g' $PHP_INI
sed -i 's/;opcache.enable_cli=0/opcache.enable_cli=1/g' $PHP_INI
sed -i 's/;opcache.memory_consumption=128/opcache.memory_consumption=128/g' $PHP_INI
```

## ZendPHP on AWS
Steps taken to launch an instance:
* Login to AWS
* Went to AWS marketplace
  * https://us-east-1.console.aws.amazon.com/marketplace/home?region=us-east-1#/landing
* Searched for "ZendPHP"
  * https://us-east-1.console.aws.amazon.com/marketplace/home#/search!mpSearch/search?text=ZendPHP
* Selected "ZendPHP with Apache on Ubuntu 20.04 (BYOL)"
  * Clicked on "Subscribe" or "Continue to Subscribe"
  * Make a note of the "EC2 Instance Types"
  * Make sure everything is $0 per hour
  * Click on "Accept Terms"
  * From next menu clicked on "Continue to Configuration"
* Choose configuration (including region, which could affect what services are in the "Free Tier")
  * Chose "US East (N. Virginia)"
  * Clicked on "Continue to Launch"
* Choose Action
  * Chose "Launch through EC2"
* From "Launch an Instance" menu
  * Chose "t2.micro" (free tier eligible)
  * Chose "Create New Key Pair"
    * RSA
    * PEM
  * Created the directory `~/.aws`
  * Copied downloaded `*.pem` file to `~/.aws`
* Clicked "Launch Instance"
* Click "View All Instances"
* From the next screen, chose the running instance
  * Wrote down Public IPv4 address `a.b.c.d`
    * Example: `52.90.232.221`
  * Wrote down the Public IPv4 DNS
    * Example: `ec2-52-90-232-221.compute-1.amazonaws.com`
* Tested from browser:
```
http://a.b.c.d/
```
* Read instructions on connecting to the instance
  * https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/AccessingInstances.html?icmpid=docs_ec2_console
    * Username: ubuntu
    * Set permissions on the local keypair stored in `~/.aws`
```
chmod 400 key-pair-name.pem
```
* Shelled into instance:
  * See: https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/connect-linux-inst-ssh.html
```
ssh -i .aws/php_iii_dec_2023.pem ubuntu@a.b.c.d

```
* Confirm your PHP version
  * Write down the version
  * e.g. "8.1"
```
sudo zendphpctl php-list-installed
```

* Set up sample app in `/var/www/html`
```
cd /var/www
sudo wget https://opensource.unlikelysource.com/post_code_test_app.zip
sudo apt install unzip
sudo unzip post_code_test_app.zip
sudo rm html/index.html
```
* Configure nginx for PHP-FPM
  * You'll need to remove one of the `fastcgi_pass` directives
    * If you prefer to use the socket, be sure to check for the correct filename
    * Run `ls -l /var/run/php` to confirm the name
```
sudo vi /etc/nginx/sites-available/default
```
* Restart PHP-FPM and nginx
```
sudo /etc/init.d/php8.1-zend-fpm restart
sudo /etc/init.d/nginx restart
```

* Tested from browser:
```
http://a.b.c.d/city=levittown&state=NY
```

## Docker
Orchestration:
* https://www.zend.com/webinars/orchestrating-your-php-applications
* https://www.zend.com/blog/what-is-cloud-orchestration
* https://www.zend.com/blog/what-is-cloud-orchestration
Example Dockerfile:
* https://github.com/dbierer/Learn-MongoDB-4.x/blob/master/docker/Dockerfile
Example `docker-compose.yml`
* A 3 container orchestrated system that represents a 3 node MongoDB replica set
* https://github.com/dbierer/Learn-MongoDB-4.x/blob/master/chapters/13/docker-compose.yml
Terraform templates
* https://developer.hashicorp.com/terraform/language/functions/templatefile
* https://developer.hashicorp.com/terraform/intro

## REST Services
Example using `parse_url()`
```
<?php
$url = 'ftp://user:pwd@www.zend.com/en/services/training?id=1&view=index&component=user';
var_dump(parse_url($url));
// actual output:
/*
 * array(6) {
  ["scheme"]=>
  string(3) "ftp"
  ["host"]=>
  string(12) "www.zend.com"
  ["user"]=>
  string(4) "user"
  ["pass"]=>
  string(3) "pwd"
  ["path"]=>
  string(21) "/en/services/training"
  ["query"]=>
  string(30) "id=1&view=index&component=user"
}
*/

```

## Middleware
* Low level example: https://github.com/dbierer/strat_post
* Example using Mezzio:
  * https://github.com/zendtech/ZendPHP-Attendee/blob/master/Basic_Installation_Alpine/mezzio/config/pipeline.php
## Async
* Good article on async programming: https://www.zend.com/blog/using-swoole-and-mezzio

## CI/CD
Configuration Management tools
* Ansible
* Puppet

## Resources
* Great source of real world data
  * https://geonames.org
* https://github.com/dbierer/php-iii-demos.git
* https://github.com/dbierer/php-iii-dec-2021.git
* https://github.com/dbierer/php-iii-jul-2022.git
* Something to keep your eye on:
  * Machine Learning project: https://www.tensorflow.org/
* Free world city and postcode data
  * geonames.org

## Q & A
* Q: RE: Docker Compose: what's the difference/advantage of "ipam" vs. "overlay" for building networks?
* A: `IPAM` is an old acronym that stands for "IP Address Management". It's not a protocol. You use `ipam` as a sub-key under your network service mainly to define static IP address information.
  * See: https://docs.docker.com/compose/compose-file/#ipam
  * Also check out the "ipv4_address, ipv6_address" sub-heading under https://docs.docker.com/compose/compose-file/compose-file-v3/#networks
* A: `overlay` is a Docker network driver that allows communication between containers.
  * See: https://docs.docker.com/network/overlay/
* A: Also see this article about fixed IP addresses in Docker containers:
  * https://stackoverflow.com/questions/39493490/provide-static-ip-to-docker-containers-via-docker-compose

* Q: Link ZendPHP Terraform templates?
* A: See: https://www.zend.com/blog/what-is-cloud-orchestration
* A: See: https://www.zend.com/downloads/zendphp-terraform-templates

* Q: What's the syntax to switch between PHP versions in Ubuntu/Debian?
* A: The utility for Debian/Ubuntu is `update-alternatives`
* A: Example using Ubuntu 20.04:
```
$ sudo update-alternatives --config php
There are 2 choices for the alternative php (providing /usr/bin/php).

  Selection    Path                  Priority   Status
------------------------------------------------------------
  0            /usr/bin/php8.1-zend   81        auto mode
  1            /usr/bin/php7.4-zend   74        manual mode
* 2            /usr/bin/php8.1-zend   81        manual mode

Press <enter> to keep the current choice[*], or type selection number:
```
* A: If you're using ZendPHP, you can use `zendphpctl` to switch versions
  * See: https://help.zend.com/zendphp/current/content/installation/zendphpctl.htm

* Q: Example of where Interfaces are used as type hints instead of classes?
* A: Have a look at the Laminas framework:
  * Most interfaces have the word "Interface" in their name
  * See: https://github.com/laminas/laminas-mvc/blob/master/src/Application.php
* A: In the Laravel framework, interfaces are generally under the `Illuminate\Contracts` namespace
  * Most interfaces *do not* have "Interface" in their name
  * See: https://github.com/laravel/framework/tree/9.x/src/Illuminate/Contracts/Auth

* Q: Example of `SplObjectStorage` used as a service container
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/spl_obj_storage_as_service_manager.php
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/App/Service/Manager.php

* Q: Why is `STDOUT` still producing output even with `ob_start()`?
* A: Still researching. Unable to duplicate the problem on my main computer.

* Q: Suggested `configure` options for Custom PHP Lab
* A: See below

* Q: Other examples of SPL classic data structures:
* A: `SplDoublyLinkedList`
  * https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch05/php8_spl_spldoublylinkedlist.php
* A: `SplHeap`
  * https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch05/php8_spl_splheap.php
* A: `SplFixedArray`
  * https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch10/php7_spl_fixed_arr_size.php

* Q: Find more examples of iterators
* A: Uses `ArrayIterator` and `LimitIterator` for pagination
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/App/View/Paginate.php
* A: Uses `InfiniteIterator` to build large array to demonstrate PHP 8 "stable sort"
  * https://github.com/dbierer/classic_php_examples/blob/master/basics/sort_stable.php

* Q: Example of login and authentication
* A: https://github.com/dbierer/filecms-website
  * Login logic: https://github.com/dbierer/filecms-website/blob/main/templates/super/login.phtml
  * Ongoing authentication: https://github.com/dbierer/filecms-website/blob/main/src/processing.php
* A: https://github.com/dbierer/filecms-core
  * Ongoing authentication verification:
  * https://github.com/dbierer/filecms-core/blob/main/src/Common/Security/Profile.php

* Q: Other examples of authentication?
* A: Good starting point:
  * See: https://packagist.org/?query=basic%20auth

* Q: Get the syntax for switching between PHP versions
* A: `update-alternatives`
* A: see: https://askubuntu.com/questions/1373755/how-to-change-php-version-in-ubuntu-20-04-console

* Q: Is there a major difference between `Swoole` and `OpenSwoole`?
* A: OpenSwoole was forked from Swoole but nobody is willing to discuss the split.
* A: see: https://github.com/swoole/swoole-src/issues/4450

* Q: How do you set up `pecl` in the VM?
* A: ???

* Q: What is an "interned" string?
* A: Any strings interned in the startup phase. Common to all the threads, won't be free'd until process exit.
     If we want an ability to add permanent strings even after startup, it would be still possible on costs of locking in the thread safe builds.
* A: See: https://github.com/php/php-src/blob/master/Zend/zend_string.c

* Q: What is `opcache.interned_strings_buffer`?
* A: The amount of memory used to store interned strings in MB
* A: See: https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.interned-strings-buffer

* Q: Do you have a good reference on binary trees and how they can be used to model real-life data?
* A: See: https://stackoverflow.com/questions/2130416/what-are-the-applications-of-binary-trees
* A: See: http://cslibrary.stanford.edu/110/BinaryTrees.html
* A: See: https://www.geeksforgeeks.org/applications-advantages-and-disadvantages-of-binary-search-tree/

* Q: Library that allows you to bridge CPP code into a PHP extension
* A: https://www.php-cpp.com/

* Q: Do you have examples using `SplHeap`?
* A: See: https://doeken.org/blog/heaps-explained-in-php

* Q: What is the difference between `SplMinHeap` and `SplMaxHeap`?
* A: See: https://stackoverflow.com/questions/47254521/whats-the-difference-between-splheap-splminheap-splmaxheap-and-splpriorityque
* A: See: https://www.php.net/manual/en/splminheap.compare.php
* A: See: https://www.php.net/manual/en/splmaxheap.compare.php
* A: If you wish to override `compare()` use `SplHeap`

* Q: Do you have an example of form filtering using callbacks?
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/web/form_with_filtering_and_validation.php

* Q: Is PHP multi-threaded?
* A: Short answer: yes, but only for CLI usage
  * See: https://www.php.net/manual/en/intro.pthreads.php
  * See: https://www.php.net/manual/en/intro.parallel.php
  * Good explanation of how they work: https://stackoverflow.com/questions/5201852/what-is-a-thread-really
  * What's the difference between how Java and PHP handle threads
    * Just type the above sentence into Google ... there are hundreds of different answers!

* Q: RE: STDIN: do you have a good example of its use?
* A: Best bet is to read through the reference docs and look at the user comments (lots of examples)
  * https://www.php.net/manual/en/features.commandline.io-streams.php

* Q: What some other approaches to `ENTRYPOINT` other than a simple naive loop?
* A: Examples of Dockerfiles: https://github.com/dockersamples?q=&type=all&language=&sort=stargazers
* A: Pertinent Docker reference:
  * See: https://docs.docker.com/engine/reference/builder/#cmd
  * See: https://docs.docker.com/engine/reference/builder/#entrypoint


* Q: What's the difference between `docker start` and `docker run`?
* A: The `docker run` command runs a command in a new container, pulling the image if needed and starting the container.
* A: You can restart a stopped container with all its previous changes intact using `docker start`.
  * Use `docker ps -a` to view a list of all containers, including those that are stopped.
  * See: https://docs.docker.com/engine/reference/commandline/run/

* Q: What's the current alternative to `yum` on RedHat-based systems?
* A: `dnf` is more recently used

* Q: Pointers on PHP session management
* A: Read this about session timeouts:
  * https://stackoverflow.com/questions/3476538/php-sessions-timing-out-too-quickly
* A: Place session files in a directory under your control:
  * https://www.php.net/session_save_path
* A: Create your own session handler
  * https://www.php.net/manual/en/function.session-set-save-handler.php
  * Be sure to read the user comments!

* Q: References to Doctrine data query cache
* A: https://www.doctrine-project.org/projects/doctrine-orm/en/2.16/reference/caching.html
* A: https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/second-level-cache.html
* A: https://www.doctrine-project.org/projects/doctrine-dbal/en/3.7/reference/caching.html

* Q: Link to Apache jMeter
* A: https://jmeter.apache.org/
  * Installation: just download the binary

* Q: Link to relative time formats?
* A: All formats: https://www.php.net/manual/en/datetime.formats.php
* A: Relative time formats: https://www.php.net/manual/en/datetime.formats.php#datetime.formats.relative

* Q: Upload VM source code via Zoom
* A: Will upload during class
  * Also, clone this repo: https://github.com/dbierer/php-iii-demos.git

* Q: when using @ + `time()` with `DateTime()` does it default to UTC?
* A: yes, it appears to be the case:
```
<?php
$fmt = 'Y-m-d H:i:s';
// change to your own timezone:
echo (new DateTime('now', new DateTimezone('asia/bangkok')))->format($fmt);
echo PHP_EOL;
// both 'now' and @time() appear to default to UTC:
echo (new DateTime('now'))->format($fmt);
echo PHP_EOL;
echo (new DateTime('@' . time()))->format($fmt);
echo PHP_EOL;
```
* Q: Example using `stream_context_create()` and `file_get_contents()`?
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/web/rest_api_call_us_weather_svc.php
  * Also: https://github.com/dbierer/classic_php_examples/blob/master/security/auth_example.php

* Q: What is the RedHat equivalent of Debian `update-alternatives`?
* A: In the RedHat world it's just `alternatives`.
  * See: https://www.redhat.com/sysadmin/alternatives-command

* Q: Do you have an Apcu example of the full-page cache example shown i the slides?
* A: Here it is:
```
<?php
// First check for cache
if (apcu_exists('filecache')) {
    echo apcu_fetch('filecache');
    exit;
}
// No cache so we need to produce the page
$view = new stdClass();
$view->label = 'Current Transaction Listing';
$handle = fopen('bitcoin.csv', 'r');
while($row = fgetcsv($handle)) $view->data[] = $row;
fclose($handle);
// Render the view
ob_start();
require 'layout.phtml';	// includes logic that renders $view
// Save to cache (assumes write privileges)
$output = ob_get_clean();
apcu_store('filecache', $output, 3600);
// the page
echo $output;
```

* Q: Where is the table schema for Stream Wrapper example?
* A: Look here: `/home/vagrant/Zend/workspaces/DefaultWorkspace/php3/src/ModAdvancedTechniques/IO/SQL/data.sql`
```
CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

* Q: Do you have an `SplHeap` example that has the priority as a key instead of what's shown in the slides?
* A: Here's the rewritten version:
```
<?php
$list =[
	1 => 'Comm check',
	4 => 'Fuel load check',
	3 => 'Batteries at max check',
	9 => 'Space suit check',
	6 => 'Landing struts retracted check',
];
 $sequencer = new class() extends SplHeap {
	    // Set the sequence
    public function compare($arr1, $arr2)
    {
        // Do the comparison using the spaceship operator
        return key($arr2) <=> key($arr1);
    }
};
foreach($list as $priority => $item) {
    $sequencer->insert([$priority => $item]);
}
$sequencer->top();
 while($sequencer->valid()) {
	printf("%02d : %s\n", key($sequencer->current()), current($sequencer->current()));
    $sequencer->next();
}
```
* For the PHP III demos, get the `index.php` working correctly!
* Q: what's the difference between JIT 'off' and 'disable'?
* A: JIT `off` means that JIT is off by default but can be enabled at runtime using `ini_set()`
* A: JIT `disable` means that JIT is off by default and cannot be enabled unless this setting is changed

* Q: Is ZendPHP available for the Mac?
* A: Not at present

* Q: How does Swoole Coroutine "go()" functions work?
* A: Just one time; if you need it to repeat, you need to implement a loop yourself
* A: Doc ref: TBD

* Q: Do you have examples of the software design patterns in PHP?
* A: See: https://refactoring.guru/design-patterns
  * Has examples in multiple programming languages, including PHP
  * Visitor pattern: https://refactoring.guru/design-patterns/visitor
* A: Also see: https://hackernoon.com/real-world-examples-of-using-design-patterns-in-modern-php

* Q: Is there a better example of Active Object?
* A: Still researching

* Q: Where is the Visitor pattern being used? Why is it important?
* A: Response from MWOP: "The places it's commonly used are for trees and tree traversal,
	where the trees and leaves often have different types associated.
	The visitor pattern essentially allows these systems to adapt to those types,
	without requiring changes to the type system itself. When I did my site search,
	I created a visitor-style interface that allowed resources of different types to return a standard result type."
* A: Here's an example usage: https://doeken.org/blog/visitor-pattern
* A: Here's another example: https://refactoring.guru/design-patterns/visitor/php/example
* A: MWOP also mentioned that this pattern is frequently used in search
	(e.g. the ElasticSearch PHP SDK, and libraries accessing Lucene or Solr, but these are yet to be confirmed.)


* Q: Source repo for Software Design Patterns discussion
* A: Uploaded via Zoom last week

* Q: What is the complexity of `SplHeap`? Is it faster to insert and then sort later?
* A: See: https://stackoverflow.com/questions/24282531/time-complexity-for-standard-php-library-spl-functions
* A: See: https://docs.google.com/document/d/1lXVlde-qTx5ZzkZHKJQUqpiEyq--A8sdGakBZn6jIGM/edit#heading=h.g30ipfog36rz
* A: See: https://stackoverflow.com/questions/43260889/what-is-o1-space-complexity
* A: See: https://stackoverflow.com/questions/44485470/understanding-o1-vs-on-time-complexity-intuitively
* A: See: https://arkadiuszkondas.com/binary-heap-implementation-in-php/
* A: Example test code:
```
<?php
// array
define('MAX', 100_000);
$start = microtime(true);
$array = [];
for ($i = 0; $i <= MAX; $i++){
	$array[random_int(1, MAX)] = 'Test' . $i;
}
sort($array);
echo "Array:\n";
echo 'Time   : ' . microtime(true) - $start . PHP_EOL;
echo 'Memory : ' . memory_get_peak_usage() / 1024 / 1024;
echo PHP_EOL;

// SplMinHeap
$start = microtime(true);
$heap = new \SplMinHeap();
for ($i = 0; $i <= MAX; $i++) {
	$heap->insert([random_int(1, MAX) => 'Test' . $i]);
}
while ($heap->valid()){
	// just iterate
	$heap->next();
}
echo "SplMinHeap:\n";
echo 'Time   : ' . microtime(true) - $start . PHP_EOL;
echo 'Memory : ' . memory_get_peak_usage() / 1024 / 1024;
echo PHP_EOL;
```

* Q: Do you have a working STDIN example?
* A: Note that `STDIN` example in the course slides works for CLI, but not web-based.
* A: See: https://stackoverflow.com/questions/21184962/use-of-undefined-constant-stdin-assumed-stdin-in-c-wamp-www-study-sayhello

* Q: When using FFI, does PHP send C pointers to the C library? How does that work?
* A: The answer is "yes" and "no". See: https://phpconference.com/blog/php-ffi-and-what-it-can-do-for-you/
* A: Excellent discussion on using FFI: https://stackoverflow.com/questions/78195117/php-ffi-convert-php-array-to-c-pointers-array
* A: Doc reference: https://www.php.net/manual/en/book.ffi.php

* Q: Why dod the Swoole installation fail with the message missing `libbrotlienc`
* A: `libbrotlienc` is a general purposes lossless compression library.
* A: Issue was solved by installing this library prior to extension installation:
```
sudo apt install libbrotli-dev
```

* Q: Do you have a list of `configure` options
* A: See: https://www.php.net/manual/en/configure.about.php

* Q: Is there a general reference for Doctrine attributes?
* A: See: https://www.doctrine-project.org/projects/doctrine-orm/en/2.14/reference/attributes-reference.html



## ERRATA
* Provide a better example of Active Object
* For the compile from source lab
  * need to mention that you have to either clone or download the ZIP of php-src
  * also need to give instructions to set the PHP version back to the default
* For the PHP Extensions lab
  * The VM uses ZendPHP so please show how to use `zendphpctl` to install exts
* http://localhost:8883/#/2/63
  * s/be up to 8.3
* http://localhost:8883/#/2/72
  * Installing PHP via `zendphpctl`:
```
sudo zendphpctl php install X.Y
```
* http://localhost:8883/#/3/35
  * Hydrator example should go here: https://docs.laminas.dev/laminas-hydrator/v4/quick-start/
  * Use the exisiting link as example of Strategy Pattern
* http://localhost:8883/#/4/6
  * s/be `echo $date->format('l, M d Y H:i:s');`

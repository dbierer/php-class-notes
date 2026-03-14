# PHP Architect
Class Notes March 2026


## Homework
Unknown Date
* Lab: 	Laminas API Tools [optional]

Fri 13 Mar 2026
* Lab: all Docker Image Labs
  * Note: new dir: `/home/vagrant/Zend/docker_labs/Docker`
* Lab: Commit the Image [optional]
* Lab: Docker Compose Labs
  * Do all labs for this
  * Note: new dir: `/home/vagrant/Zend/docker_labs/Docker-Compose`

Wed 11 Mar 2026
* Lab: Type Hinting

Fri 6 Mar 2026
* Lab: FFI
* Lab: New Extension

Wed 4 Mar 2026
* Lab: VM Setup
* Lab: Built-in Web Server
* Lab: OpCache and JIT
* Lab: Custom PHP
* Lab: Existing Extension


## TO DO
* Q: Link to the OOP File Handling free course?


* Q: Roadmap for the PHP language?
* A: See: https://wiki.php.net/rfc

* Q: What is asymmetric visibility?
* A: See: https://wiki.php.net/rfc/static-aviz

* Q: What is available for international date/time?
* A: See: https://www.php.net/manual/en/class.intldateformatter.php

* Q: Do you have an example of using `declare(strict_types=1)`?
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/basics/type_hinting_strict.php

* Q: Do you have a link to the Domain Driven Design PDF?
* A: See: https://dn710106.ca.archive.org/0/items/ebooks_202003/Eric%20Evans/Domain-driven%20Design%20%281503%29/Domain-Driven%20Design_%20Tackling%20Complexity%20in%20the%20Heart%20of%20Software.pdf
* A: See also: https://martinfowler.com/bliki/DomainDrivenDesign.html

* Q: Why does this not work?
```
<?php
class Main
{
    protected function __construct() {}
    protected static $instance = NULL;
    public static function getInstance() : static
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}

class ChildOfMain extends Main {}

class GrandChildofMain extends ChildOfMain {}

$arr = [
    Main::getInstance(),
    ChildOfMain::getInstance(),
    GrandChildofMain::getInstance()
];


var_dump($arr);

```

* Q: Example of using `static` to indicate return type of a class at different hierarchical levels
```
<?php
class Main
{
    protected function __construct() {}
    public static function getInstance() : static
    {
        return new static();
    }
}

class ChildOfMain extends Main {}

class GrandChildofMain extends ChildOfMain {}

$arr = [
    Main::getInstance(),
    ChildOfMain::getInstance(),
    GrandChildofMain::getInstance()
];


var_dump($arr);

// actual output:
/*
array(3) {
  [0]=>
  object(Main)#1 (0) {
  }
  [1]=>
  object(ChildOfMain)#2 (0) {
  }
  [2]=>
  object(GrandChildofMain)#3 (0) {
  }
}
*/

```



* Q: Github repo with classic design patterns.
* A: See: https://github.com/DesignPatternsPHP/DesignPatternsPHP/tree/main

* Q: Websites to boost code development
* A: See: https://cursor.com/
* A: See: https://refactoring.guru/


## VM Setup
After running `vagrant up`, run the software-updater to get the latest Ubuntu 24.04 updates
* This will resolve the screen flicker issue

## Class Notes
### PECL
PECL is the tradtional way of installing external extensions from pecl.php.net.
This is being replaced by "pie"
* See: https://github.com/php/pie

### SPL
`SplSubject`,`SplObserver`, and `SplObjectStorage` used to implement Subject/Observer pattern:
* See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_subject_observer_storage_object.php
`SplFixedArray` example:
* https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_fixed_arr_compared_with_array_and_array_object.php

### Generators
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

// test()
// Peak Memory: 8782912
// Time Used  : 2.1432847976685

// test2()
// Peak Memory: 4589232
// Time Used  : 2.2050850391388

```
* Results might be something like this:
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

### Other Notes
To open a terminal window: `CTL + ALT + T`

* Objects are "naturally" iterable:
```
<?php
class Test
{
	public function __construct(
		public string $a,
		public string $b,
		public string $c) {}
}
$test = new Test(111,222,333);
foreach ($test as $key => $val) {
	echo $key . ':' . $val . PHP_EOL;
}
```
* You can also use an obscure array syntax for objects that don't define `__invoke()`
```
<?php
class Test
{
	public function show(iterable $arr)
	{
		$txt = '';
		foreach ($arr as $key => $val) {
			$txt .= $key . ':' . $val . PHP_EOL;
		}
		return $txt;
	}
}

function whatever(callable $obj, iterable $arr) 
{
	echo $obj($arr);
}
	
$arr = ['A' => 111, 'B' => 222, 'C' => 333];
$test = new Test();
whatever([$test ,'show'], $arr);
// output:
/*
A:111
B:222
C:333
*/
```
* Property hooks can be used with PHP 8 constructor property promotion:
  * See: https://www.php.net/manual/en/language.oop5.property-hooks.php
```
class User 
{
    public function __construct(
		public string $name {
			get => ucwords($this->name);
			// Notice the "magic" variable $value:
			set => strtolower($value);
		}
	) 
	{}
}    
```


# Lab Notes
## OPcache and JIT
* For the most radical result copy `mandelbrot.php` to `/home/vagrant/Zend/sandbox/public`
* Run with this URL: `http://sandbox/mandelbrot.php`
* Be sure to restart PHP-FPM when you change the `/etc/php/8.4-zend/fpm/php.ini` file settings
```
sudo /etc/init.d/php8.4-zend-fpm restart
```

## Existing Extension Lab
* You can find `phpize` here: `/usr/bin/phpize`
* Replacement for PECL: 
  * See: https://github.com/php/pie
* You can install the Swoole as follows:
```
sudo pie install swoole/swoole \
	--with-phpize-path=/usr/bin/phpize \
	--with-php-config=/usr/bin/php-config \
	--with-php-path=/usr/bin/php
```
OR: Use this command:
```
sudo zendphpctl ext install swoole
```
OR: install from source:

From Matthew Weir O'Phinney:
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
* Example manual installation:
```
cd /tmp
export PHP_VER=8.4
export SWOOLE_VER=6.1.6
sudo apt install libbrotli-dev
wget https://pecl.php.net/get/swoole-$SWOOLE_VER.tgz
tar -xzvf ./swoole-$SWOOLE_VER.tgz
cd swoole-$SWOOLE_VER
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
# Write down the location which we'll call $LOCATION
# Installing shared extensions:     /usr/lib/php/20230831/
# Installing header files:          /usr/include/php/20230831/
export LOCATION=/usr/lib/php/20230831/
sudo cp $LOCATION/swoole.so /usr/lib/php/$PHP_VER-zend
```
* Create an ini file under `mods-available`
```
sudo nano /etc/php/$PHP_VER-zend/mods-available/swoole.ini
```
* Add the following and save (CTL+X)
```
;priority=30
extension=swoole.so
```
* Enable the extension using `zendphpctl`
```
sudo zendphpctl ext enable swoole
```

## Custom PHP Lab
* Take a snapshot of the VM before 
* Add suggested dependencies 
* Add suggestion "configure" options
* Clone from github
* Switch to branch target version of PHP (e.g. 7.4.11)
```
git checkout php-PHP_VER
```
* Follow the instructions
* Be sure to install the pre-requisites!
* When running `buildconf` you might have to use the `--force` option:
```
./buildconf --force
```
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
sudo apt install -y libbz2-dev \
	libpng-dev \
	zlib1g-dev \
	libsodium-dev \
    libreadline-dev \
    libcurl4-openssl-dev \
    libbz2-dev \
    libzip-dev
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

### API Tools
see: api-tools.getlaminas.org

### Async Lab:
Change `Zend/async/src/App/Lorem.php` as follows:
```
<?php
namespace App\Lorem;
class Ipsum
{
    const API_URL = 'https://fakerapi.it/api/v2/texts?_quantity=1&_characters=500';
    public function __invoke(array &$msg = []) : string
    {
        return file_get_contents(self::API_URL);
    }
}
```
In `Zend/async/src/lib.php` change the "Ipsum" service as follows:
```
function ipsum()
{
    $output = "Lorem Ipsum:\n";
    return (new Ipsum())();
}
```
Change `Zend/php-examples/src/ModAsync/src/App/Lorem.php` as follows:
```
<?php
namespace App\Lorem;
class Ipsum
{
    const API_URL = 'https://fakerapi.it/api/v2/texts?_quantity=1&_characters=500';
    public static function getHtml(array &$msg = []) : string
    {
		$html = '<p>Invalid Response</p>' . PHP_EOL;
        $response = file_get_contents(self::API_URL);
        $arr = json_decode(trim($response), TRUE);
        if (isset($arr['status']) && $arr['status'] === 'OK') {
			$data = $arr['data'][0] ?? [];
			$html = '<table>' . PHP_EOL;
			foreach ($data as $key => $value) {
				$html .= '<tr><th>' . $key . '</th><td>' . $value . '</td></tr>' . PHP_EOL;
			}
			$html .= '</table>' . PHP_EOL;
		}
		return $html;
    }
}
```
## Custom Extension Lab


## Q & A
* Q: Why create a Lazy Object for an already existing object? 
* A: The only time this is done is when an existing object might need to be "rebuilt" with new property values.
  * One of the new `ReflectionClass::resetAsLazy*()` is used, which effectively "deconstructs" the object and re-establishes is as either a lazy ghost or lazy proxy.
* A: See: https://wiki.php.net/rfc/lazy-objects
* A: See: https://www.php.net/manual/en/language.oop5.lazy-objects.php

* Q: What's the primary use case for Closure::fromCallable() or $obj->method(...) ?
* A: There are three uses for converting callables into closures:
  * Better API control for classes
  * Easier error detection and static analysis
  * Performance
* A: See: https://wiki.php.net/rfc/closurefromcallable

* Q: Do you have an example that demonstrates `getReturn()`?
* A: See class notes below on "Generators"

* Q: Do you have an example showing memory efficiency vis a vis Generators?
* A: See class notes below on "Generators"

* Q: When running JIT or OpCache CLI: where does it cache???
* A: JIT might help CLI ops because of its efficient compiler, however OpCache won't help for CLI ops. 
  * The option is mainly available for CLI ops for the purposes of debugging and testing
  * See: https://stackoverflow.com/questions/25044817/zend-opcache-opcache-enable-cli-1-or-0-what-does-it-do

* Q: I noticed that the symlinks for PHP extensions have a load priority. Does the extension load order makes a difference?
* A: Here's a good explanation of why the load order might be important:
* A: See: https://wiki.php.net/rfc/extensions_load_order

* Q: Is there a PHP-FPM course?
* A: See: https://training.zend.com/learn/courses/526/php-focus-boost-website-performance-with-php-fpm-nginx-and-apache
* A: It's $475 and lasts 1 day (3 hours) -- but not yet on the schedule

* Q: Do you have a  link to "cache-control" header for browser caching?
* A: https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Cache-Control

* Q: What is the option to set the target location for a custom PHP installation?
* A: When running `configure` add the `--prefix=/path/to/target` option

* Q: Can we use `zendphpctl` for the Swoole ext and have the future labs work?
* A: Yes ... but extra options (including OpenSSL support) are not enabled by default
* A: Follow the instructions below for custom extension installation

* Q: What does `phpize` do?
* A: Prepares a build environment where PECL cannot be used
* A: See: https://www.php.net/manual/en/install.pecl.phpize.php

* Q: Do you have examples using `SplHeap`?
* A: See: https://doeken.org/blog/heaps-explained-in-php

* Q: What is the difference between `SplMinHeap` and `SplMaxHeap`?
* A: See: https://stackoverflow.com/questions/47254521/whats-the-difference-between-splheap-splminheap-splmaxheap-and-splpriorityque
* A: See: https://www.php.net/manual/en/splminheap.compare.php
* A: See: https://www.php.net/manual/en/splmaxheap.compare.php
* A: If you wish to override `compare()` use `SplHeap`

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
    public function compare($arr1, $arr2) : int
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

* Q: Is there any compelling reason to use `SplObjectStorage` rather a simple array?
* A: Excellent discussion here: https://stackoverflow.com/questions/8520241/associative-array-versus-splobjectstorage
* A: Also see benchmark: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_splobjectstorage_vs_array.php

* Q: Example of `SplObjectStorage` used as a service container
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/spl_obj_storage_as_service_manager.php
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/App/Service/Manager.php

* Q: Can you please show me a good example of FilterIterator?
* A: See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_spl_filteriterator_anon_class.php


## Change Request

http://localhost:8883/#/3/30:
https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/architecture.html

http://localhost:8883/#/3/38
https://www.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/getting-started.html#entity-repositories

http://localhost:8883/#/4/69
-- left out a mention of getReturn()

http://localhost:8883/#/4/73
Auto creation of $token is deprecated

http://localhost:8883/#/4/85
Duplicate?

http://localhost:8883/#/5/35
attach() is deprecated

http://localhost:8883/#/6/14
new dir: `/home/vagrant/Zend/docker_labs/Docker`

http://localhost:8883/#/6/31
"php3" is now "php-examples"

http://localhost:8883/#/6/36
new dir: `/home/vagrant/Zend/docker_labs/Docker-Compose`

http://localhost:8883/#/7/2
port is wrong

http://localhost:8883/#/7/7
already mentioned request_parse_body()

http://localhost:8883/#/8/22
doesn't work

# PHP III -- Jul 2022 -- Notes

## TODO
* Get example of new PHP 8 serialization
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_sleep_wakeup.php
  * Article on why `__unserialize()` was introduced: https://wiki.php.net/rfc/custom_object_serialization
  * https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_magic_serialize_unserialize.php

## Homework
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

## Lab Notes
Setup Jenkins CI
* The CheckStyle plug-in reached end-of-life. All functionality has been integrated into the Warnings Next Generation Plugin.
* Same applies to `warnings` and `pmd` : integrated into `Warnings NG`
* Here are some other suggestions for initial setup:
  * replace `checkstyle` with `Warnings Next Generation`
  * replace `build-environment` with `Build Environment`
  * replace `phing` with `Phing`
  * replace `violations` with `Violations`
  * replace `htmlpublisher` with `Build-Publisher` (???)
  * replace `version number` with `Version Number`

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

Lab: Docker (all)
* Image Build Lab:
  * Might have to do the lab outside the VM (insufficient disk space!)
  * Sample database is here: `https://opensource.unlikelysource.com/phpcourse.sql`
  * After step `4` you need to build the image!
```
docker build .
```
  * Example `Dockerfile` for the lab:
```
# Sample Dockerfile
FROM asclinux/linuxforphp-8.2-ultimate:7.4-nts
RUN \
    echo "Installing Laminas API Tools ..." && \
	cd /srv && \
	wget https://getcomposer.org/download/1.10.22/composer.phar && \
	php composer.phar create-project laminas-api-tools/api-tools-skeleton /srv/laminas-api-tools && \
	mv -f /srv/www /srv/www.OLD && \
	ln -s /srv/laminas-api-tools/public /srv/www && \
	chown -R apache /srv/laminas-api-tools && \
	chmod -R 775 /srv/laminas-api-tools
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    cd /tmp && \
    /etc/init.d/mysql start && \
    sleep 5 && \
    mysql -uroot -v -e "CREATE DATABASE phpcourse;" && \
    mysql -uroot -v -e "CREATE USER 'vagrant'@'localhost' IDENTIFIED BY 'vagrant';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'vagrant'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;" && \
    echo "Restoring sample database ..." && \
    wget https://opensource.unlikelysource.com/phpcourse.sql && \
    mysql -uroot -e "SOURCE /tmp/phpcourse.sql;" phpcourse
RUN \
    echo "Installing phpMyAdmin ..." && \
    cd /tmp && \
    wget https://opensource.unlikelysource.com/phpmyadmin_install.sh && \
    chmod +x *.sh && \
    /tmp/phpmyadmin_install.sh
CMD lfphp --mysql --phpfpm --apache
```
  * Lab: Docker Compose (esp. the Laminas API Tools lab)
    * Example `docker-compose.yml` file:
```
version: "3"
services:
  laminas-api-tools:
    container_name: laminas-api-tools
    hostname: laminas
    image: laminas-api-tools
    volumes:
     - ".:/home"
    ports:
     - "8888:80"
    build: .
    restart: always
    command: lfphp --mysql --phpfpm --apache
    networks:
      ten_net:
        ipv4_address: 10.10.10.10
networks:
  ten_net:
    ipam:
      driver: default
      config:
        - subnet: "10.10.10.0/24"
```
 Lab: Install the apcu extension using `pecl`
* To test: use this script: https://github.com/dbierer/php-iii-mar-2021/blob/main/apcu_test.php
* Need to add `apcu.enable=1` and `apc.shm_size=32M` to `/etc/php/8.0/apache2/php.ini` and run from a browser to have the demo work
* Restart the web server after modifying the `php.ini` file: `sudo service apache2 restart`
Lab: New Functions (compile a new extension)
* Install dependencies:
```
sudo apt install php8.0-dev
```
* Install PHP-CPP (https://php-cpp.com)
```
cd ~/Zend/workspaces/DefaultWorkspace/php3/src/ModAdvancedTechniques/Extensions
git clone https://github.com/CopernicaMarketingSoftware/PHP-CPP.git
cd PHP-CPP
make
sudo make install
# NOTE: had a problem compiling PHP-CPP under PHP 8
# Works OK in the Docker image created in class
```
* Here is the revised `main.cpp` file:
```
#include <phpcpp.h>
#include <iostream>

// function declaration with parameters
void telemetryParams (Php::Parameters &params)
{
    int distance=params[0];
    int speed=params[1];
    std::cout<<"Distance: "<<distance<<std::endl;
    std::cout<<"Speed: "<<speed<<std::endl;
}

// function declaration without parameters
Php::Value telemetryRandom()
{
    if (rand() % 2 == 0) {
        return "no remainder";
    } else {
        return "remainder";
    }
}

// Tell the compiler that the get_module is a pure C function
extern "C" {
    /**
     *  Function that is called by PHP right after the PHP process
     *  has started, and that returns an address of an internal PHP
     *  structure with all the details and features of your extension
     *
     *  This creates an extension object that is memory-resident during runtime.
     */
    PHPCPP_EXPORT void *get_module() {
        static Php::Extension extension("telemetry", "0.0.1");
        extension.add<telemetryParams>("telemetryParams", {
            Php::ByVal("a", Php::Type::Numeric),
            Php::ByVal("b", Php::Type::Numeric)
        });
        extension.add<telemetryRandom>("telemetryRandom");
        return extension;
    }
}
```
* Here is the revised `Makefile`:
```
#	This is the name of your extension. Based on this extension name, the
#	name of the library file (name.so) and the name of the config file (name.ini)
#	are automatically generated
NAME				=	telemetry

#
#	Php.ini directories
#
#	In the past, PHP used a single php.ini configuration file. Today, most
#	PHP installations use a conf.d directory that holds a set of config files,
#	one for each extension. Use this variable to specify this directory.
#
INI_DIR				=	/etc/php/8.0/cli/conf.d

#
#	The extension dirs
#
#	This is normally a directory like /usr/lib/php5/20121221 (based on the
#	PHP version that you use. We make use of the command line 'php-config'
#	instruction to find out what the extension directory is, you can override
#	this with a different fixed directory
#
EXTENSION_DIR		=	$(shell php-config --extension-dir)


#
#	The name of the extension and the name of the .ini file
#
#	These two variables are based on the name of the extension. We simply add
#	a certain extension to them (.so or .ini)
#
EXTENSION 			=	${NAME}.so
INI 				=	${NAME}.ini


#
#	Compiler
#
#	By default, the GNU C++ compiler is used. If you want to use a different
#	compiler, you can change that here. You can change this for both the
#	compiler (the program that turns the c++ files into object files) and for
#	the linker (the program that links all object files into the single .so
#	library file. By default, g++ (the GNU C++ compiler) is used for both.
#
COMPILER			=	g++
LINKER				=	g++


#
#	Compiler and linker flags
#
#	This variable holds the flags that are passed to the compiler. By default,
# 	we include the -O2 flag. This flag tells the compiler to optimize the code,
#	but it makes debugging more difficult. So if you're debugging your application,
#	you probably want to remove this -O2 flag. At the same time, you can then
#	add the -g flag to instruct the compiler to include debug information in
#	the library (but this will make the final libphpcpp.so file much bigger, so
#	you want to leave that flag out on production servers).
#
#	If your extension depends on other libraries (and it does at least depend on
#	one: the PHP-CPP library), you should update the LINKER_DEPENDENCIES variable
#	with a list of all flags that should be passed to the linker.
#
COMPILER_FLAGS		=	-Wall -c -O2 -std=c++11 -fpic -o
LINKER_FLAGS		=	-shared
LINKER_DEPENDENCIES	=	-lphpcpp


#
#	Command to remove files, copy files and create directories.
#
#	I've never encountered a *nix environment in which these commands do not work.
#	So you can probably leave this as it is
#
RM					=	rm -f
CP					=	cp -f
MKDIR				=	mkdir -p


#
#	All source files are simply all *.cpp files found in the current directory
#
#	A builtin Makefile macro is used to scan the current directory and find
#	all source files. The object files are all compiled versions of the source
#	file, with the .cpp extension being replaced by .o.
#
SOURCES				=	$(wildcard *.cpp)
OBJECTS				=	$(SOURCES:%.cpp=%.o)


#
#	From here the build instructions start
#   VERY IMPORTANT: must be proper TABS (not spaces!) in front of each child ${ARG}
#
all:    ${OBJECTS} ${EXTENSION}

${EXTENSION}:   ${OBJECTS}
        ${LINKER} ${LINKER_FLAGS} -o $@ ${OBJECTS} ${LINKER_DEPENDENCIES}

${OBJECTS}:
        ${COMPILER} ${COMPILER_FLAGS} $@ ${@:%.o=%.cpp}

install:
        ${CP} ${EXTENSION} ${EXTENSION_DIR}
        ${CP} ${INI} ${INI_DIR}

clean:
        ${RM} ${EXTENSION} ${OBJECTS}
```
* Make sure you add `extension=/path/to/telemetry.so` in your `php.ini` file!
* Here is the test program:
```
<?php
echo telemetryParams(500, 600);
//for ($i=0; $i<7; $i++) echo(telemetryRandom()."\n");
```

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
Article that describes JIT in PHP 8: https://wiki.php.net/rfc/jit

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

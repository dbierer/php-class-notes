# PHP Architect
Class Notes May 2025
https://github.com/dbierer/php-class-notes/blob/master/php-arch-2025-05.md
http://localhost:8883/#/4/70


## TO DO
* Look up the example showing memory efficiency vis a vis Generators
* Also find the example that demonstrates `getReturn()`

## Q & A
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

* Q: When running JIT or OpCache CLI: where does it cache???
* A: Still researching

* Q: I noticed that the symlinks for PHP extensions have a load priority. Does the extension load order makes a difference?
* A: Still researching


## Class Notes
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


## Homework
Labs for Fri 16 May 2025
* Lab: Existing Extension
  * NOTE: current VM PHP version is 8.4
* Lab: FFI
* Lab: Custom Extension (optional)
* Lab: ZendPHP on the Cloud (optional)

Labs for Wed 14 May 2025
* Setup the VM using materials provided in class
* Lab: Custom PHP Lab
* Lab: Built-in Web Server
* Lab: OpCache and JIT

# Lab Notes
### Custom Extension Lab
You can find `phpize` here: `/usr/bin/phpize`

### Existing Extension Lab
Use this command:
```
sudo zendphpctl ext install swoole
```

As the VM is running ZendPHP we'll need to install this from source!
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
* Example installation:
```
# NOTE: version was 5.1.4
# Change the the current version
export VERSION=5.1.4
sudo apt install libbrotli-dev php8.4-dev
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
sudo cp $LOCATION/swoole.so /usr/lib/php/8.4-zend
```
* Create an ini file under `mods-available`
```
sudo nano /etc/php/8.4-zend/mods-available/swoole.ini
```
* Add the following and save (CTL+X)
```
;priority=20
extension=swoole.so
```
* Enable the extension using `zendphpctl`
```
sudo zendphpctl ext enable swoole
```

### Custom PHP Lab
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



## Change Request
* http://localhost:8883/#/2/11
  * No ";"
* http://localhost:8883/#/2/20
http://localhost:8883/#/2/25
  * use target=_blank
* Custom PHP Lab
  * Don't bother with `configure` options: just use the defaults
    * BUT ... make  you tell the attendees where the files will go
    * Add an instruction to make a snapshot
  * Missing a step:
```
cd /tmp
git clone https://github.com/php/php-src
```
* There is no "I/O" section in the 1st module!
* RE: the Existing Extension Lab:
  * Either move the PHP version to a community source
  * Or ... rewrite to accommodate ZendPHP
* http://localhost:8883/#/4/47
  * There is no previous lab for this!
* http://localhost:8883/#/4/50
  * You can use property hooks in constructor arg promotion

  

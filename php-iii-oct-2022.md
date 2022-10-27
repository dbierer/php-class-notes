# PHP III - Oct 2022

Last Slide: http://localhost:8883/#/4/76

## TODO
* Q: RE: Docker Compose: what's the difference/advantage of "ipam" vs. "overlay" for building networks?
* A:

* Q: Link ZendPHP Terraform templates?
* A:

* Q: What's the syntax to switch between PHP versions?
* A: The utility for Debian/Ubuntu is `update-alternatives`
* A: Syntax: still looking!

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

## Homework
For Thu 27 Oct 2022
* Lab: Laminas API Tools
* Lab: Adding Middleware

For Tue 25 Oct 2022
* Lab: Docker Image Build
* Lab: Commit the Image
* Lab: Docker-Compose
        * Lab: Configuration Review and Pre-Built Service Execution
        * Lab: Create Files to Support the nginx Service
        * Lab: Create Files to Support the PHP-FPM Service
        * Lab: Create the docker-compose.yml File
        * Lab: Set up the sample app


For Thu 20 Oct 2022
* Lab: OpCache and JIT
* Lab: Existing Extension
* Lab: FFI
* Lab: New Extension
* Lab: Custom PHP
  * Clone from github
  * Switch to branch php-8.2.0RC4
```
git checkout php-8.2.0RC4
```
  * Follow the instructions
  * Be sure to install the pre-requisites!
  * Suggested `./configure` options (place this all on one line):
```
./configure  \
    --enable-cli \
    --enable-filter \
    --with-openssl=shared \
    --with-zlib \
    --with-curl=shared \
    --enable-pdo \
    --with-libxml \
    --with-iconv \
    --enable-cgi \
    --enable-session \
    --with-pdo-mysql=shared
    --enable-phar=shared \
    --with-pdo-sqlite=shared \
    --with-pcre-jit \
    --with-zip \
    --enable-ctype \
    --enable-gd \
    --enable-bcmath \
    --enable-sockets=shared \
        --with-bz2=shared \
    --enable-exif=shared \
    --enable-intl=shared \
    --with-gettext=shared \
    --enable-opcache \
    --enable-fileinfo=shared \
    --with-readline \
    --with-sodium=shared
```
Dependency errors:
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
For Tue 18 Oct 2022
* Lab: Built-in Web Server

For Thu 12 Oct 2022
* VM Setup (update/upgrade + phpMyAdmin)
  * phpMyAdmin: use the directions below
* JMeter Setup
* Jenkins Setup

## VM Update
* After the VM first comes up, if you're not prompted to update, reboot the VM
* After reboot: Select yes to "Update System Software" if you're prompted
* Open a terminal window
* Upgrade everything:
```
sudo apt -y upgrade
```
  * If asked to retain the database configuration select "OK"
NOTE: this could take some time!
### Install phpMyAdmin

Download the latest version from https://www.phpmyadmin.net
Make note of the version number (e.g. 5.2.0)
* From a terminal window:
```
cd /tmp
set VER=5.2.0
mv Downloads/phpMyAdmin-$VER-all-languages.zip .
unzip Downloads/phpMyAdmin-$VER-all-languages.zip
sudo cp -r phpMyAdmin-$VER-all-languages/* /usr/share/phpmyadmin
sudo cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php
```
Create the "blowfish secret"
```
sudo -i
export SECRET=`php -r "echo md5(date('Y-m-d-H-i-s') . rand(1000,9999));"`
echo "\$cfg['blowfish_secret']='$SECRET';" >> /usr/share/phpmyadmin/config.inc.php
exit
```
Set permissions
```
sudo chown -R www-data /usr/share/phpmyadmin
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
### Stringable (new in PHP 8)
Anytime you implement `__toString()`
``
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
`SplSubject` and `SplObserver` used to form a pipeline:
* See: https://github.com/dbierer/classic_php_examples/blob/master/oop/oop_subject_observer_storage_object.php

## CLI
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
`StreamDb.php`
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
## JIT
You can also use a `php.ini` setting of `on` to enable JIT:
* `opcache.jit=on` this is an alias for `tracing`
* Also, don't forget to enable opcache itself
* In addition: set a memory size for JIT (otherwise it won't work)
```
; example:
opcache.jit_buffer_size=32M
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

## Middleware
* Low level example: https://github.com/dbierer/strat_post


## Resources
* https://github.com/dbierer/php-iii-demos.git
* https://github.com/dbierer/php-iii-jul-2022.git
* https://github.com/dbierer/php-iii-mar-2021.git
* https://github.com/dbierer/php-class-notes/blob/master/php-iii-may-2021.md

## ERRATA
* http://localhost:8883/#/4/7
  * mising ";" + should add a space between vars on output
* http://localhost:8883/#/4/37
  * s/be "LuaJIT" not "LuiJIT"
* http://localhost:8883/#/4/61
  * You will have permissions issues, so do the following:
```
sudo -i
echo "extension=NAME_OF_EXT.so" >> /path/to/php.ini
exit
```
* http://localhost:8883/#/4/56
  * Either the "C" code needs to change to accommodate full char strings
  * Or the lab needs to be rewritten using single characters instead of string
* http://localhost:8883/#/6/47
  * "howeverm"???
* http://localhost:8883/#/7/7
  * "Middlware"???

# PHP III - Jun 2023

Last: http://localhost:8883/#/2/32

## TODO
* Get the latest slides.pdf to the attendees for this class

## VM Update
Follow these instructions:
  * https://opensource.unlikelysource.com/expanded_vm_instructions.pdf
  * Upgrade/update commands from the PDF:
```
sudo dpkg --configure -a
sudo apt -y update && sudo apt -f -y install && sudo apt -y full-upgrade
```
  * Apache reconfig from the PDF:
```
sudo apt-add-repository ppa:ondrej/apache2
sudo apt install libapache2-mod-php8.2
sudo a2dismod php8.0
sudo a2enmod php8.2
sudo systemctl restart apache2
```

### Install phpMyAdmin
Download the latest version from https://www.phpmyadmin.net
Make note of the version number (e.g. 5.2.1)
* From a terminal window:
```
cd /tmp
set VER=5.2.1
wget https://files.phpmyadmin.net/phpMyAdmin/$VER/phpMyAdmin-$VER-all-languages.zip .
unzip phpMyAdmin-$VER-all-languages.zip
sudo cp -r phpMyAdmin-$VER-all-languages/* /usr/share/phpmyadmin
sudo cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php
```

## General Lab Notes
* Lab Code:
  * Clone this repo: https://github.com/dbierer/php-iii-demos.git
  * Source code is located here: `/home/vagrant/Zend/workspaces/DefaultWorkspace`
* Lab: Adding Middleware
  * Take the code from the slides
  * Add a middleware request handler that implements an update (HTTP "PATCH")
* Lab: New Extension
  * Lab needs additional work
  * If you follow the instructions here exactly, "test1()" works, but "test2()" does not
    * https://www.zend.com/resources/php-extensions/building-and-installing-php-extension
* Lab: Docker Compose Labs
  * Have a look at the article on Orchestration: https://www.zend.com/blog/what-is-cloud-orchestration
* CLI utility to reset JIT:
    * https://github.com/dbierer/PHP-8-Programming-Tips-Tricks-and-Best-Practices/blob/main/ch10/php8_jit_reset.php

## Custom PHP Lab Notes

* Clone from github
* Switch to branch php-8.3.0
```
git checkout php-8.3.0
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

## Advanced PHP
Full `DateTime::format()` codes:
* https://www.php.net/manual/en/datetime.format.php
Getting differences between dates, use `diff()`
```
<?php
$date1 = new DateTime('2022-11-11');
$date2 = new DateTime('2022-11-29');
$diff  = $date1->diff($date2);
var_dump($diff);
echo $diff->days . ':' . $diff->invert;
echo PHP_EOL;


$diff  = $date2->diff($date1);
var_dump($diff);
echo $diff->days . ':' . $diff->invert;
echo PHP_EOL;
// $invert property tell you if it's in the past or future
// see: https://www.php.net/manual/en/class.dateinterval.php

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

## Anonymous Class
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
```
<?php
$arr = [
	'first' => 'Fred',
	'last'  => 'Flintstone',
	'amount' => 99.99,
];
// if you uncomment the next line, $arr becomes an object, but the remaining code works OK
// $arr = new ArrayObject($arr);

// some other code

$purch = $_GET['purch'] ?? 1.11;
$arr['amount'] += $purch;

// some other code

// final output:
echo '<table>';
foreach ($arr as $key => $val)
	echo '<tr><th>' . $key . '</th><td>' . $val . '</td></tr>' . PHP_EOL;
echo '</table>';
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
## JIT
You can also use a `php.ini` setting of `on` to enable JIT:
* `opcache.jit=on` this is an alias for `tracing`
* Also, don't forget to enable opcache itself
* In addition: set a memory size for JIT (otherwise it won't work)
```
; example:
opcache.jit_buffer_size=32M
```

## ZendPHP on AWS
Steps taken to launch an instance:
* Login to AWS
* Went to AWS marketplace
  * https://us-east-1.console.aws.amazon.com/marketplace/home?region=us-east-1#/landing
* Searched for "ZendPHP"
  * https://us-east-1.console.aws.amazon.com/marketplace/home#/search!mpSearch/search?text=ZendPHP
* Selected "ZendPHP with Apache on Ubuntu 20.04 (BYOL)"
  * Clicked on "Subscribe"
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
  * Copied downloaded `*.pem` file to `~/.aws`
* Clicked "Launch Instance"
* From the next screen, chose "View Instance Details"
  * Wrote down IP address `a.b.c.d`
* Read instructions on connecting to the instance
  * https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/AccessingInstances.html?icmpid=docs_ec2_console
* Shelled into instance:
```
ssh -i .aws/php_iii_dec_2022.pem ubuntu@a.b.c.d
```
* Set up sample app in `/var/www/html`
```
cd /var/www
sudo wget https://opensource.unlikelysource.com/post_code_test_app.zip
sudo apt install unzip
sudo unzip post_code_test_app.zip
sudo rm html/index.html
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

## Middleware
* Low level example: https://github.com/dbierer/strat_post

## Async
* Good article on async programming: https://www.zend.com/blog/using-swoole-and-mezzio

## CI/CD
Configuration Management tools
* Ansible
* Puppet

## Resources
* https://github.com/dbierer/php-iii-demos.git
* https://github.com/dbierer/php-iii-dec-2021.git
* https://github.com/dbierer/php-iii-jul-2022.git

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


## ERRATA

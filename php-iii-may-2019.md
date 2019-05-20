# PHP III May 2019

## TODO:
* Finish documenting Jenkins labs
* Finish documenting Docker labs

* Q: When you update Jenkins, does it also update all plugins?
* Q: RE: VM postman: there is no GeoCode pre-defined query: maybe because no longer free?

## Homework
* For Tue 21 May 2019
  * All: Lab: Building a REST Service API
    * If running via Apache set rights to `/home/vagrant/Zend/workspaces/DefaultWorkspace/apigility` to `www-data`
```
sudo chown -R vagrant:www-data .../apigility
sudo chmod -R 775 .../apigility
```
  * All: Lab: REST Service Model Code Setup == copies pre-written classes to save you a lot of work!
  * All: Lab: REST Service Testing
* For Sun 19 May 2019
  * from course module 5
    * NOTE: make sure the Phing Lab works before running the Jenkins Lab
    * All: Jenkins Freestyle Prerequisites Lab
    * All: Jenkins CI Freestyle Project Lab
    * All: Apache JMeter Lab
    * All: all the Docker Labs
      * Existing Image Lab
      * New Image Creation Lab
      * Full-build MySQL Container Lab
      * Pre-built WordPress Services Lab
      * Partial build OrderApp Services Lab
* For Thu 16 May 2019
  * from course Module 4
    * All: Compile and install the Telemetry custom extension
    * All: Installing Customized PHP From Source Lab
      * https://github.com/nruslan/php/blob/master/install-php-from-source.md
      * Add `-j<# cores>` to `make` to greatly improve performance
      * If you configure the `config.nice` file, it's a shell script to run `configure`
  * from course Module 5
    * All: Prerequisites + Phing Lab
    * See Lab Notes section below

* For Tue 14 May 2019
  * All: Built-in Web Server Lab + Experiment with PHP CLI
* For Thu 9 May 2019
  Collabedit: http://collabedit.com/qx3mg
* For Tue 7 May 2019
  * Setting up Apache Jmeter
  * Setting up the Jenkins CI

## Q & A
* Q: What's faster, REST or SOAP?
* A: http://www.ateam-oracle.com/performance-study-rest-vs-soap-for-mobile-applications

* Q: What is `docker-compose up -d` ???
* A: `-d` is an option for `docker-compose up`
  * It means: Detached mode: Run containers in the background, print new container names.
  * To find help on specific `docker-compose` sub-commands, type the following:
```
docker-compose <sub-command> --help
```

* Q: What's the difference between a docker image and docker container?
* A: A _container_ is a runtime instance of an _image_.  Analogy: a docker image is like a PHP class definition.  A docker container is like a PHP object instance.
* A: See: https://stackoverflow.com/questions/23735149/what-is-the-difference-between-a-docker-image-and-a-container

* Q: Where are docker images and containers stored?
* A: see: https://stackoverflow.com/questions/19234831/where-are-docker-images-stored-on-the-host-machine
* A: On the course VM:
```
/var/lib/docker/containers
/var/lib/docker/overlay2
```

* Q: How do you run multiple docker containers at the same time?
* A: Yes: you can do this by configuring Docker containers as  "services"
* A: See: https://stackoverflow.com/questions/49980008/can-we-have-two-or-more-container-running-on-docker-at-the-same-time
* A: Also read this: https://docs.docker.com/engine/swarm/how-swarm-mode-works/services/
* A: Tutorial: https://docs.docker.com/get-started/part3/

* Q: In the Jenkins CI lab, how is the new build number / NEW_VERSION created?
* A: This is created by Jenkins using the `Version Number` plugin

## Lab Notes
* Phing Lab
  * Phing Prerequisites Lab: Part 1
  * How to confirm the group membership of the user `deploy`:
```
groups deploy
```
* Phing Execution Lab
  * Make sure you're the `deploy` user before running this part of the lab:
```
su deploy
```
  * Change to this directory:
```
cd /home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/build
```
  * If you get this error:
```
BUILD FAILED
/home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/build/build.xml:136:30: Failed to copy /home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/build/target/live/config/config.php to /home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/config/config.php: Cannot delete /home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/config/config.php
```
  * Change ownership and permissions for the orderapp directory structure as follows:
```
sudo chown -R www-data:www-data /home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp
sudo chmod -R 775 /home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp
```
  * If you get this error:
```
BUILD FAILED
/home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/build/build.xml:176:32: '/home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/test' is not a valid directory
```
  * Remove references to the `punit` dependency task. Modify `/home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/build/build.xml` as follows:
```
    <target name="main"
            description="Executes shell commands on remote server"
            depends="config, public, logStart">
```
  * Database restore: SQL database file is here:
```
/home/vagrant/Zend/workspaces/DefaultWorkspace/orderapp/data/sql/phpcourse.sql
```
* Jenkins CI Lab
  * The `CheckStyle` plug-in reached end-of-life. All functionality has been integrated into the `Warnings Next Generation` Plugin.
  * Here are some other suggestions for initial setup:
    * replace `checkstyle` with `Warnings Next Generation`
    * replace `build-environment` with `Build Environment`
    * replace `phing` with `Phing`
    * replace `violations` with `Violations`
    * replace `htmlpublisher` with `Build-Publisher` (???)


## Class Discussion
* Agile software tools: web based
  * Jira: https://www.atlassian.com/software/jira
  * nTask: https://www.ntaskmanager.com/
* DateTime Intervals:
  * Relative intervals: see: https://www.php.net/manual/en/datetime.formats.relative.php
  * More Examples: https://github.com/dbierer/classic_php_examples/tree/master/date_time
  * https://github.com/dbierer/classic_php_examples/blob/master/date_time/date_time_date_period.php
    * Note to self: check and update if needed!
* PubSub Example: https://github.com/dbierer/php7cookbook/blob/master/source/chapter11/chap_11_pub_sub_simple_example.php
* Find another example of DoublyLinkedList
  * See: https://github.com/dbierer/php7cookbook/blob/master/source/chapter10/chap_10_linked_double.php
  * See: https://github.com/dbierer/php7cookbook/blob/master/source/chapter10/chap_10_linked_list_include.php
* Find example of stacked iterators
  * See: https://github.com/dbierer/php7cookbook/blob/master/source/chapter03/chap_03_developing_functions_stacked_iterators.php
* Variable based stream wrapper
  * See: https://github.com/dbierer/classic_php_examples/blob/master/file/streams_custom_wrapper.php
* Streams Docs: https://www.php.net/manual/en/book.stream.php
  * For devices, see: https://www.php.net/manual/en/function.stream-socket-client.php

## Corrections:
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/2/9: PHP Fatal error:  Uncaught PDOException: SQLSTATE[HY000] [1049] Unknown database 'php3' in /home/vagrant/Zend/workspaces/DefaultWorkspace/php3/src/ModPhpAdvanced/Generators/GenDb/runTransactionModel.php:11
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/2/10: also: when you are processing an unknown number of results, maybe safer
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/2/39: extra ","
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/4/31: recommend removing any APC refs
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/4/35: should mention installing via pecl
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/5/30: s/be `orderapp.com` ???
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/5/31: (same)
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/5/19: change `¬` to `/home/vagrant`
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/5/23: s/be `phpcourse.sql`
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/1/12: replace `checkstyle` with `Warnings Next Generation`; replace `build-environment` with `Build Environment`; `phing` with `Phing`; `htmlpublisher` with `Build-Publisher` (???); `violations` with `Violations`
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/7/4: there is no GeoCode pre-defined query: maybe because no longer free?

## Class Examples
* ArrayObject
```
<?php
class Test extends ArrayObject
{
}

$array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
$obj   = new Test($array);
echo $obj->offsetGet('a');
echo PHP_EOL;
echo $obj['a'];
echo PHP_EOL;
var_dump($obj);
echo PHP_EOL;
echo serialize($obj);
```
* Example of anon function w/ __invoke()
```
<?php
class Test
{
	function __invoke($n1, $n2) {
		return function() use($n1, $n2) {
			echo $n1 + $n2 ;
		};
	}
}

function simpleAddCalc($n1, $n2) {
    return function() use($n1, $n2) {
        echo $n1 + $n2 ;
    };
}

$calc = simpleAddCalc(5, 10);
// Here we bind the call to the internal anonymous function
$calc();
// Can also do this:
simpleAddCalc(5, 10)();

// shows that this is a Closure instance
var_dump($calc);

// need to add additional () to force construct to self-invoke
(new Test())(5, 10)();
```
* Type Hinting
```
<?php
declare(strict_types = 1);
namespace src\ModPhpAdvanced\StrictTyping;
class UserStrictTyping {
    protected $firstname ;
    protected $lastname ;
    public function __construct(string $firstname, string $lastname) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function getFirstname () : string {
        return $this->firstname;
    }

    public function getLastname () : string {
        return $this->lastname;
    }
    public function getFullName() : string {
		return $this->firstname . ' ' . $this->lastname;
	}
    public function calc(float $a, float $b) : int {
		var_dump($a, $b);
		return $a + $b;
	}

}

try {
	$user = new UserStrictTyping('1234','Flintstone');
	echo $user->getFullName();
	echo PHP_EOL;
	// generates fatal error
	$result = $user->calc((int) 2, (int) 2);
	var_dump($result);
} catch (Throwable $e) {
	echo get_class($e) . ':' . $e->getMessage();
}
```
* Callable examples
```
<?php
function needCallable(callable $call, $a, $b)
{
	return $call($a, $b);
}

class DoesInvoke
{
	public function __invoke($a, $b)
	{
		return $a + $b;
	}
}

class DoesNotInvoke
{
	public function calcNot($a, $b)
	{
		return $a + $b;
	}
}

// these are all callable directly:
$does = new DoesInvoke();
$anon = function ($a, $b) { return $a + $b; };
function calc($a, $b)
{
	return $a + $b;
}

// this is NOT directly callable:
$not  = new DoesNotInvoke();

// all of these work directly
echo needCallable($does, 2, 2);
echo needCallable($anon, 2, 2);
echo needCallable('calc', 2, 2);

// this generates error:
// echo needCallable($not, 2, 2);

// need to do this:
// internally, PHP invokes "$not->calcNot(2,2)"
echo needCallable([$not, 'calcNot'], 2, 2);
```
* Null Coalesce
```
<?php
$name = $_GET['name'] ?? $_POST['name'] ?? $_COOKIE['name'] ?? $_SESSION['name'] ?? 'guest';
$name = strip_tags($name);
echo htmlspecialchars($name);
setcookie('name', $name);
```
* Aggregating Catch Blocks
```
<?php
// new approach:
try {
	$pdo = new PDO(1,2,3,4);
} catch (PDOException | Exception | Error $e) {
	echo get_class($e) . ':' . $e->getMessage();
}
echo PHP_EOL;

// traditional:
try {
	$pdo = new PDO(1,2,3,4);
} catch (PDOException $e) {
	echo get_class($e) . ':' . $e->getMessage();
} catch (Exception $e) {
	echo get_class($e) . ':' . $e->getMessage();
} catch (Error $e) {
	echo get_class($e) . ':' . $e->getMessage();
}
```
* Linked list example:
```
<?php
$data = [
	'M' => ['date' => '2019-01-01', 'amount' => 3.33],
	'D' => ['date' => '2018-02-02', 'amount' => 1.11],
	'X' => ['date' => '2017-03-03', 'amount' => 2.22],
];

$test1 = $data;

// sorts only by the 1st element
asort($test1);
//var_dump($test1);

$linked = array_column($data, 'amount');
$amount = array_combine(array_keys($data), $linked);
//var_dump($amount);
asort($amount);

// linked list $amount ascending order
foreach($amount as $key => $value) {
	echo implode(',', $data[$key]) . PHP_EOL;
}

// linked list $revse present amount in descending order
$reverse = array_reverse($amount);
foreach($reverse as $key => $value) {
	echo implode(',', $data[$key]) . PHP_EOL;
}

```
* Example of RecursiveDirectoryIterator
```
<?php
$recurse = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../Documents'));

foreach ($recurse as $key => $value) {
	echo $key . ':' . var_export($value, TRUE) . PHP_EOL;
}
```

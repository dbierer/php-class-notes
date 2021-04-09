# PHP Test Prep -- Apr 2021

## TODO
* How do you prevent an interface from being extended?

## Class Notes
* Detailed list of topic areas:
  * https://www.zend.com/training/php-certification-exam
* Bitwise tutorial:
  * https://www.w3resource.com/php/operators/bitwise-operators.php
* `php.ini` settings:
  * https://www.php.net/manual/en/ini.list.php
  * https://www.php.net/manual/en/configuration.changes.modes.php
* Extensions
  * https://www.php.net/manual/en/intro.opcache.php
* Garbage Collection
  * https://www.php.net/gc_collect_cycles
  * https://www.php.net/manual/en/features.gc.performance-considerations.php
* XML
  * https://www.w3schools.com/xml/xpath_intro.asp
  * Great study of Soap + XML vs. REST + JSON
    * https://www.ateam-oracle.com/performance-study-rest-vs-soap-for-mobile-applications
* DateTime
  * Examples of `DateInterval` format codes: https://www.php.net/manual/en/dateinterval.createfromdatestring.php
  * Formats: https://www.php.net/manual/en/datetime.formats.php
  * Yes, there is a date function that calculates Easter Day :-)
    * https://www.php.net/manual/en/function.easter-date.php
* Alternate character encoding
  * Can be set per script using `declare()`
  * `zend.multibyte=1` php.ini directive required
  * MB String extension required
  * Unable to find any reference to `--enable-zend-multibyte` option in PHP 7.1 `configure --help`
  * See: https://www.php.net/manual/en/control-structures.declare.php
* Security
  * Test is based on this: https://www.php.net/manual/en/security.php
  * https://www.php.net/manual/en/ref.session.php
### OOP
* Make sure you're up to speed on magic methods
  * https://www.php.net/manual/en/language.oop5.magic.php
* Be sure to study the `Serializable` interface!
  * https://www.php.net/manual/en/class.serializable.php
* Late Static Binding
  * https://www.php.net/manual/en/language.oop5.late-static-bindings.php
* Traits
  * https://www.php.net/traits
* Super important: make sure you study up on `ArrayObject`
## Repo Setup:
### Setup Docker / Docker Compose
* Install `docker`
  * CentOS: https://docs.docker.com/install/linux/docker-ce/centos/#install-docker-ce
  * Debian: https://docs.docker.com/install/linux/docker-ce/debian/
  * Fedora: https://docs.docker.com/install/linux/docker-ce/fedora/
  * Ubuntu: https://docs.docker.com/install/linux/docker-ce/ubuntu/
  * Windows: https://docs.docker.com/docker-for-windows/install/
  * Mac: https://docs.docker.com/docker-for-mac/install/
* Install `docker-compose`
    * https://docs.docker.com/compose/install/

### Build the Image
* Unzip the zip file provided by your instructor into a directory `/path/to/repo`
* From a terminal windows (or command prompt):
```
cd /path/to/ repo
docker-compose build
```
* To run the image:
```
docker-compose up -d
```

### Use the Image
* To access the image from a browser:
```
http://10.30.30.30/php_cert
// or
http://localhost:8888/php_cert
```
* To open a shell into the container:
  * From Linux:
```
docker exec -it php_cert /bin/bash
```
  * From Windows or Mac
    * Locate the running container in _Docker Desktop_
    * Click on the CLI `>_` icon to open a shell
  * To access the database:
    * From the CLI: `mysql -u root zend`
## Past Notes:
* https://github.com/dbierer/php-class-notes/blob/master/php-cert-aug-2020.md
* https://github.com/dbierer/php-class-notes/blob/master/php-cert-jun-2020.md

## ERRATA
* 2/56/84: correct answer s/be B and C.  PSR-4 is only applicable if the question addresses directory structure and namespace. Also, the test does not address the PSR standards.
* 2/58/85: question contradicts the answer.
  * Better question: what is the output of the following?
    * "HelloWORLD" and a Notice
    * "HELLOWorld" and a Warning
    * "HelloWorld"
    * None of the above
```
<?php
// see: 02-58-85.php in this repo
namespace X {
    define('HELLO', 'Hello');
    const WORLD = 'World';
}
namespace Y {
    echo HELLO . WORLD;
}
```
* 4/41/175: correct answer: `255 255.000000`
* 4/57: old question left over from PHP 5.5 exam: ignore
  * Should be rewritten as follows: "C. The _zend.multibyte_ php.ini setting must be enabled"
* 5/17: array_search(): Returns element *key* value, or boolean false. A third boolean parameter includes type checking.
* Mock Exam #2: "Given that $fp is a stream resource, enter the function that outputs a file's contents"
  * Correct Answer: `fpassthru`
* 12/8/???: "Aggregate Catch Blocks"
  * Example doesn't help.  How about this:
```

try {
    $pdo = new PDO($params);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException | ArgumentCountException $e) {
    error_log('Database error: ' . date('Y-m-d H:i:s'));
} finally {
    echo 'Database connection ';
    echo ($pdo) ? 'succeeded' : 'failed';
}
```

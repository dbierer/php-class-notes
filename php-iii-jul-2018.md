# PHP-III CLASS NOTES -- Jul 2018

NOTE TO SELF: after importing *.json file into postman, how do you run those requests?
NOTE TO SELF: upload to the repo example using Stragility v2

## HOMEWORK

### FOR FRI 27 Jul 2018
* Middleware Lab
  * DO NOT create a new zend-expressive-skeleton app!!!
  * Use the existing code under the `/expressive` folder

### FOR WED 25 Jul 2018
* Apigility Lab

### FOR MON 23 Jul 2018
* OPTIONAL Extension Lab:
  * Install MongoDB on the VM
  * Install the PHP driver
* Apache JMeter Lab
  * It's *not* locked to the launcher
  * Click on extreme top left search icon
  * Start typing `jmeter`
  * Click on the feather
* All the Docker Labs in Chapter 6
  * To add an entry to the local hosts file
  * Find the IP address for the docker image by typing `ifconfig`
  * Add that to the `/etc/hosts` file on the VM:
```
sudo gedit /etc/hosts
```
  * Add ip address and host name of your choice
  * To confirm: `ping -c3 host.name`
  * Do all the Docker labs

### FOR FRI 20 Jul 2018
* Extension Custom Development Lab
* Custom PHP Lab
* CD Phing Build Tool Lab
* Continuous Delivery Lab


### FOR WEDS 18 Jul 2018
* Built-in Web Server Lab

### FOR MON 16 Jul 2018
* Define an app that uses software events (or PubSub)
    * Define an EventManager class as a singleton
        * Define `attach()` which takes and event and a callable as arguments
            * The callable needs to accept an array of parameters
        * Define `trigger()` which runs the callable and passes an array of parameters
    * Define two other classes which get an instance of the EventManager
        * Have each of the other classes trigger one or more of the events
    * Create a calling program
        * Provides configuration to the EventManager and creates an instance
        * Creates instances of the other 2 classes and passes in the EventManager
        * Runs methods from the other 2 classes
* Use Iterators to do the following:
    * Do a recursive directory scan of the /php3/* directory structure
    * Use FilterIterator to include only *.php files
    * Use LimitIterator to paginate 20 items per page
    * Use InfiniteIterator to loop back to the beginning when you hit the last page


## Example of DatePeriod
* You can use [Relative Formats](http://php.net/manual/en/datetime.formats.relative.php)
  with `DateInterval::createFromDateString ( string $time )`

## Q & A
* RE: http://localhost:9999/#/2/31: if offset === NULL, what array key is it???
  * A: stays at the same pointer
  * Please confirm!
* RE: http://localhost:9999/#/2/37: example doesn't work in /php3 folder
* RE: Generator class: pull up an example showing a Generator instance
  * A: See: `generator.php` in this repo
* RE: Null Coalesce: https://github.com/dbierer/php7_examples/blob/master/php_7_0/null_coalesce_operator.php
* http://localhost:9999/#/2/13: could also just say
```
public function getDimensions() {
        yield from $this->widths;
        yield from $this->lengths;
    }
```
* RE: stdin: please find example of mini-server
* RE: stream filters: please find example of encryption filter
* RE: http://localhost:9999/#/9/15:s/be "*"
* RE: http://localhost:9999/#/9/22: Title doesn't match the class shown in code
* RE: http://localhost:9999/#/9/64: "dommain" s/be "domain"

## NOTES

### Stream
* Q: What are "buckets" in PHP Streams?
* A: See: https://stackoverflow.com/questions/27103269/what-is-a-bucket-brigade#31132646
* Q: What is PSFS_FEED_ME (etc.)
* A: See: http://php.net/manual/en/stream.constants.php

### PHP 7
* PHP 7 Examples: https://github.com/dbierer/php7_examples

### Data Structures
* Heap: https://en.wikipedia.org/wiki/Heap_%28data_structure%29
  * NOTE: a _priority queue_ is an implementation of a heap
* Note other examples which are now in the repo

### PHP CLI
* Capture command line parameters using either `$argv[]` or `$_SERVER['argv'][]`

### Cache
* [PSR-16](https://www.php-fig.org/psr/psr-16/) is a simplified version of cache based on PSR-6
* Have a look at http://php.net/manual/en/book.apc.php

### Custom PHP
* The download URL varies depending on the code name for the release.  The example shown in the slides is "krakjoe" which is 7.1.  The upcoming version 7.3 has a codename "cmb".
* Just click on the link shown on the main page of http://php.net/
* Here is another example of a PHP custom installation `configure` command string: https://github.com/dbierer/php7_examples#manual-php-7-installation
* You can also use `php -i` (from the command line) or `phpinfo()` (from a browser) to get the `configure` string used for an existing installation

### RE: Thread Safe (TS) vs. Non-Thread Save (NTS) on Windows
* https://stackoverflow.com/questions/7204758/php-thread-safe-and-non-thread-safe-for-windows

### Docker
* No longer have to install `boot2docker` when installing on Windows or Mac
* Look here: https://docs.docker.com/machine/install-machine/
* Try `LinuxForPhp`: https://linuxforphp.net/tutorial

### Apigility
* Start Up: `http://apigility/` from the browser in the VM
* http://localhost:9999/#/7/32: post actual graphic of .htaccess (hard to see)
* http://localhost:9999/#/7/50: missing one thing to copy: the `php3/src/ModWebApi/PropulsionSystems` directory over into
  the `apigility/module/FlyingElephantService/Rest`
  * Look at the next slide to see what the final dir structure should look like
* http://localhost:9999/#/7/50: missing one file: `php3/src/ModWebApi/Flying Elephant Apigility.postman_collection.json`
  * Posted 2 versions of the files in the repo

### MiddleWare
* Authentication: use MiddleWare!!!
    * See: https://framework.zend.com/blog/2017-04-26-authentication-middleware.html
    * Or use something already created:
        * https://github.com/tuupola/slim-jwt-auth
        * https://packagist.org/packages/zendframework/zend-expressive-authentication
* MiddleWare class example: https://github.com/dbierer/zf3-examples/blob/master/guestbook/admin/src/Manage/src/Service/Guestbook.php
* Zend\Expressive MiddleWare project: https://github.com/dbierer/zf3-examples/tree/master/guestbook/admin
* Pre-built PSR-7 compliant classes: https://github.com/zendframework/zend-diactoros
* Upload chap_09_middleware_request_using_with.php to class repo
* PSRs can be installed using Composer:
  * i.e. https://packagist.org/packages/psr/http-message
  * or https://github.com/php-fig/http-message
* Actual implementations of PSR-7 compliant classes that are ready-to-use
  * https://packagist.org/packages/guzzlehttp/psr7
  * https://packagist.org/packages/zendframework/zend-diactoros
* RE: Stragility ... there are actually 3 versions:
  * https://docs.zendframework.com/zend-stratigility/v1/install/
    * Uses these Composer packages:
      * `psr/http-message`
      * `http-interop/http-middleware`
  * https://docs.zendframework.com/zend-stratigility/v2/install/
    * Uses these Composer packages:
      * `psr/http-message`
      * `http-interop/http-middleware`
  * https://docs.zendframework.com/zend-stratigility/v3/install/
    * Uses these Composer packages:
      * `psr/http-message`
      * `psr/http-server-middleware`

### Architecture
* Strategy Pattern: https://en.wikipedia.org/wiki/Strategy_pattern
  * Also called the "Policy" pattern (think Microsoft and "Group" policy)

* Examples of Strategies:
  * https://github.com/zendframework/zend-view/tree/master/src/Strategy
  * https://github.com/zendframework/zend-mvc/blob/master/src/View/Http/RouteNotFoundStrategy.php
  * Example: see `expressive-demo` in the repo:
```
cd /path/to/this/repo/expressive-demo
php -S localhost:9999 -t public
```
  * From your browser: `http://localhost:9999/`
  * Click on the `Strategy Test` link
    * Output should be HTML
  * Open up `postman` or use the FireFox REST Client
    * Add this header: `Accept: application/json`
    * Issue a GET request
    * Output should be JSON

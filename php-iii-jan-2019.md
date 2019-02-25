# PHP III - Jan 2019

Last Update: 15 Feb 2019

## RE: Errors with Expressive Lab using PropulsionSystems module from Apigility:
* The service manager *does* contain a "config" service ... but it's case sensitive, with lower-case "c"
* The class `Zend\Hydrator\ObjectProperty` has been renamed to `Zend\Hydrator\ObjectPropertyHydrator`
* Copied the `propulsion.php` data generator from `apigility.complete/data` to `expressive.2019/data`
* Entered into `/expressive.2019/config/routes.php` this line:
```
$app->get('/api/propulsion-systems[/:id]', FlyingElephantService\Handler\FlyingElephantHandler::class, 'api.propulsion_systems');
```

* Otherwise, the errors shown in class were mainly due to compressing the directory structure of `PropulsionSystems` to get rid of `/V1/Rest`
* Code works OK now:
    * Go to the `expressive.2019` folder
    * Run `composer install`
    * Run `php -S localhost:8888 -t public`
    * From your browser (or REST client) try these tests:
```
http://localhost:8888/api/propulsion-systems
http://localhost:8888/api/propulsion-systems/01d1c119-bf97-4a05-b5d6-d94d950d049f
```

## RE: Errors with phing and Jenkins
* Gertjan reported errors when using Jenkins to run phing to deploy
* Response from Daryl:
    * Doug, it looks like I had inadvertantly lost the orderapp/build, and orderapp/build-JCI directories way back in January 2018.
    I was able to recover them from the January 9th commit and have attached them here as zip files.
    These contained the Phing build scripts, without which, the deployment will not work. Have the students put these in the orderapp directory,
    then double check the Jenkins "OrderAppDeploy" freestyle project, and execute the build again. Let me know if there are any issues. -- Daryl
    * Look in this repo for the `/php3/src/ModTargetedServerEnvironments/Deployment` folder
    * Copy this directory structure and overwrite the `Phing/build` and `Jenkins/build-JCI` folders

## How to run the Stratigility demo
* Change to the `Zend/workspaces/DefaultWorkspace/stratigility` folder
* Run the PHP dev server as follows:
```
php -S localhost:8888 -t public
```
* Go to your browser and open this URL: `http://localhost:8888`
* Alternatively set the permissions on the `log` folder so the `www-data` user has rights to the log file

## Homework
* For Fri 25 Jan 2019
    * Lab: Stratigility Demo: see notes just above
    * Lab: Zend Expressive
        * https://docs.zendframework.com/zend-expressive/
        * Use the existing app under /expressive
        * If you feel brave: remove and overwrite with a new project
        * FlyingElephant API Middleware Lab:
            * convert the API software to middleware
            * OR use an existing middleware package (i.e. Slim JWT Authentication)
            * OR copy the demo module included in full install and make changes
        * Middleware Testing Lab
* For Wed 23 Jan 2019
    * Lab: Building a REST Service API
    * Lab: REST Service Code Review and Stub Development
    * Lab: REST Service Testing
* For Mon 21 Jan 2019
    * Lab: Phing
        * Prerequisites Lab
        * Phing Execution Lab
        * Phing Deployment Lab
    * Lab: Jenkins
        * Jenkins Freestyle Prerequisites Lab
        * Jenkins CI Freestyle Project Lab
    * Lab: Apache Jmeter
        * Load Testing (also called "Smoke Testing")
    * Lab: Docker
        * Common Docker Build Commands
        * Existing DockerHub Image Run Lab
        * New Image Creation Lab
        * Full-build MySQL Container Lab
    * Lab: Docker Compose
        * Pre-built WordPress Services Lab
        * Partial build OrderApp Services Lab
* For Fri 18 Jan 2019
    * Lab: Extension Custom Development
    * Lab: Installing Customized PHP From Source Lab
        * List of `./configure` option flags: http://php.net/manual/en/configure.about.php
        * Another example: https://github.com/dbierer/php7_examples#manual-php-7-installation

* For Wed 16 Jan 2019
    * Built-in Web Server Lab
    * Script to run the built-in web server:
```
php -S localhost:8080
```
* For Wed 9 Jan 2019
    * Lab: Setting up Apache Jmeter
    * Lab: Setting up the Jenkins CI
        * The CheckStyle plug-in reached end-of-life. All functionality has been integrated into the Warnings Next Generation Plugin.
        * Same applies to `warnings` and `pmd` : integrated into warnings NG

## Q & A
* Q: Does Apigility use ZF2 or ZF3?
* A: ZF2

* Q: Is there a ZF module to generate swaggerhub-style API docs?
* A: Via composer:
    * `zfcampus/zf-apigility-documentation-swagger`
    * `zircote/swagger-php`

* Q: FAQ on Docker?
* A: See: https://stackoverflow.com/questions/tagged/docker-image?sort=votes&pageSize=50

* Q: What is meant by "interned_strings_buffer" ? (OpCache)
* A: See: https://stackoverflow.com/questions/27300219/zend-opcache-performance-settings-vs-default-settings

* Q: Where does APC store its cache data?
* A: In memory.  See: https://stackoverflow.com/questions/14678676/where-does-apc-store-the-data

* Q: Will APC interfere with OpCache?
* A: Yes.  It's either one or the other.  As of PHP 5.5, OpCache is included in the core, and is preferred.  Development on APC stopped in 2013 (see next question).

* Q: Is APC included with PHP?
* A: Not any longer.  The last stable version of APC is 3.1.13 and is dated 3 Sep 2013!
     See: http://pecl.php.net/package/APC

* Q: Is there a good example of delegating generator?
* A: https://github.com/dbierer/php7_examples/blob/master/php_7_0/generator_delegation_words.php

* Q: Is there an example of doubly linked list?
* A: See: https://github.com/dbierer/php7cookbook/blob/master/source/chapter10/chap_10_linked_double.php

* Q: How do you run PHP in a Windows BAT file?
* A: First of all, make sure the PHP executable is in your PATH
    * See: https://stackoverflow.com/questions/12870880/run-php-file-in-windows-cmd
    * Then all you need to do is to enter the following inside your `*.bat` file:
```
php c:\path\to\script.php
```

## Class Notes
* DateTime formats
    * `j` == day of month _without_ leading zeros
    * `n` == month number _without_ leading zeros
* DateTime use cases
    * You could also use the `diff()` method to compare two DateTime instances
* Future roadmap for the PHP language: https://wiki.php.net/rfc
* PHP CLI
    * `-r` == runtime lets you run single commands
    * `-l` == PHP 'lint' == syntax checking
    * `-v` == PHP version
* Streams
    * http://php.net/manual/en/book.stream.php
    * http://php.net/manual/en/wrappers.php
    * Example of PSR-7 StreamInterface class which uses PHP strings to read/write
        * https://github.com/dbierer/php7cookbook/blob/master/source/Application/MiddleWare/TextStream.php
    * Buckets: https://stackoverflow.com/questions/27103269/what-is-a-bucket-brigade#31132646
* OpCache
    * Performance suggestions: https://stackoverflow.com/questions/23382615/apc-apcu-opcache-performance-poor

## Resources
* Examples from past PHP III classes:
    * https://github.com/dbierer/php-iii-jul-2018

## ERRATA
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/3/12: EventManager needs to be rewritten
    * see files in the directory structure `/php3/src/` and `/php3/src/ModSPL/StandardDatastructures/SplPriorityQueue`in the repo for rewrites
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/3/42: use the autoloader to avoid the 3rd `require` statement
```
// runLoader.php in the SPL Functions area in the VM
$config = require 'config.php';
require 'PSR4Loader.php';
// Init the autoloader
$loader = new \src\ModSPL\Functions\PSR4Loader;
$loader->init($config);

use src\ModSPL\Functions\Controllers\FrontController;

$controller = new FrontController();
$view = $controller->init($config);

$view->render();
```
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/5/43: dir structure changed
    * Look in this repo for the `/php3/src/ModTargetedServerEnvironments/Deployment` folder
    * Copy this directory structure and overwrite the `Phing/build` and `Jenkins/build-JCI` folders
    * Suggestion: just use one user for both labs
    * Troubleshooting tips: i.e. when do you have restart Jenkins, or refresh the browser
* phing lab:
    * This error should be fixed by copying the files into `Phing/build` as mentioned just above
    * from Gertjan to Host (privately): error happend at slide 213: phing -f build.xml
```
sudo phing -f build.xml
Buildfile: /home/deploy/ModTargetedServerEnvironments/Deployment/Phing/build/build.xml
 [property] Loading /home/deploy/ModTargetedServerEnvironments/Deployment/Phing/build/build.properties
 [property] Loading /home/deploy/ModTargetedServerEnvironments/Deployment/Phing/build/build.live.properties
     [echo] Deploying to: orderapp/releases

OrderApp > config:

     [echo] Executing environment configuration tasks
     [echo] Executing config copy tasks ...
     [copy] Copying 1 file to /home/deploy/ModTargetedServerEnvironments/Deployment/Phing/config
     [echo] Copy Public Assets Task Successful

OrderApp > public:

     [echo] Executing target public files copy
     [copy] Copying 3 files to /home/deploy/ModTargetedServerEnvironments/Deployment/Phing/public
     [echo] Copy Public Assets Task Successful

OrderApp > logStart:

     [echo] Creating deployment log entry

OrderApp > main:

     [echo] Directory exists, updating...
     [echo] Attempting filesync command on remote server orderapp from /home/deploy/ModTargetedServerEnvironments/Deployment/Phing/build/.. to /var/www/orderapp/releases/build-0.0.1
deploy@orderapp's password:
 [filesync] /usr/bin/rsync -r --no-perms --verbose -e "ssh -i id_rsa.pub" --delete-after --ignore-errors --force --itemize-changes --exclude-from="/home/deploy/ModTargetedServerEnvironments/Deployment/Phing/build/../build/exclude.file" "/home/deploy/ModTargetedServerEnvironments/Deployment/Phing/build/.." "deploy@orderapp:/var/www/orderapp/releases/build-0.0.1" 2>&1
 [filesync] Task exited with code: 23
 [filesync] Task exited with message: (23) Partial transfer due to error

BUILD FAILED
/home/deploy/ModTargetedServerEnvironments/Deployment/Phing/build/build.xml:101:42: 23: Partial transfer due to error

Total time: 3.3594 seconds
```

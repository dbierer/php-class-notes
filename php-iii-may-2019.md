# PHP III May 2019

## TODO:

* Q: RE: VM postman: there is no GeoCode pre-defined query: maybe because no longer free?
* Arrange to get VM source to Olawale
* Foundation of modern software design patterns:
  * https://www.amazon.com/Design-Patterns-Elements-Reusable-Object-Oriented/dp/0201633612
  * https://www.amazon.com/Patterns-Enterprise-Application-Architecture-Martin/dp/0321127420/ref=sr_1_1?crid=33WORKA14VTG4&keywords=martin+fowler+patterns+of+enterprise+architecture&qid=1558668034&s=books&sprefix=martin+fowler+pattern%2Cstripbooks-intl-ship%2C392&sr=1-1
## Homework
* Repo for Class: https://github.com/dbierer/php-iii-may-2019
* For Thu 23 May 2019
  * All: Stratigility Exercise
  * All: Zend-Expressive Labs
    * FlyingElephant API Middleware Lab
    * vendor/bin/expressive in expressive.complete is not working
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

## Lab Notes
NOTE: whenever you see `/path/to/source` in these notes, in the VM it's `/home/vagrant/Zend/workspaces/DefaultWorkspace`
* Expressive Lab Preface
  * Please apply the suggested lab changes in this set of notes after you complete the lab
  * When you're done, test first by just running `http://expressive/` from the browser
    * The `Whoops` error handler middleware generates a nicely formatted HTML page
    * Easier to read error messages from the browser
  * When you're bug free, switch over to Postman to generate REST requests
  * Theoretically you should be able to run any of the imported Apigility requests just by changing the host name from `apigility` to `expressive`

* Expressive Lab Notes
  * To create the new module, from the `/path/to/source/expressive` directory, use this command:
```
vendor/bin/expressive module:create FlyingElephantService
```
  * If you get this error message: `Unable to match FlyingElephantServiceMiddlewareAuthCheckMiddleware to an autoloadable PSR-4 namespace`
    * Be sure to use `\\` from the command line as a single `\` is an escape character
    * Refresh the Composer autoloader
  * To register middleware, in `/path/to/source/expressive/config/pipeline.php` add this `use` statement at the top of the file:
```
use FlyingElephantService\Middleware\ {AuthCheckMiddleware, UuidCheckMiddleware};
```
  * Modify `FlyingElephantService\V1\Rest\PropulsionSystems\PropulsionSystemsResourceFactory`: change references to `Propulsion\Mapper` to `FlyingElephantService\V1\Model\ArrayMapper`
  * Modify `FlyingElephantService\V1\Model\ArrayMapperFactory`: change references from `$container->get('Config')` to `$container->get('config')`
  * Add the following to `/path/to/source/expressive/config/autoload/dependencies.global.php`:
```
return [
	'propulsion' => [
		'db' => 'flying-elephant-db',
		'table' => 'propellant',
		'array_mapper_path' => 'data/propulsion.php'
	],
	'dependencies' => [
        'services' => [
			'zf-mvc-auth' => [
				'authorization' => [
					'FlyingElephantService\\V1\\Rest\\PropulsionSystems\\PropulsionSystemsResource' => [
						'collection' => [
							'GET' => true,
							'POST' => true,
							'PUT' => false,
							'PATCH' => false,
							'DELETE' => false,
						],
						'entity' => [
							'GET' => true,
							'POST' => true,
							'PUT' => true,
							'PATCH' => true,
							'DELETE' => true,
						],
					],
				],
			],
        ],
	]
];
```
  * If you get this error message: `Class 'ZF\Configuration\ConfigResource' not found` add this to the `/path/to/source/expressive/composer.json` file `require` directive, and update:
```
        "zfcampus/zf-configuration" : "*"
```
  * If you get this error message: `Class 'Ramsey\Uuid\Uuid' not found` add this to the `/path/to/source/expressive/composer.json` file `require` directive, and update:
```
        "ramsey/uuid" : "*"
```
  * Make sure the web server user has read/write privileges to the `/path/to/source/expressive/data` directory

* Stratigility Lab
  * Set permissions on the `/path/to/source/stratigility/log` folder so the `www-data` user can write to the log file
  * Copy the `.htaccess` file from `/path/to/source/expressive.complete/public` to `/path/to/source/stratigility/public`
  * You can now run the Stratigility demo from the browser using the `http://stratigility/`
  * Here is the modified `/path/to/source/stratigility/middleware/library` file:
```
<?php
// stratigility middleware "library"

// class needed
use Zend\Diactoros\Response;

// init constants
define('LOG_FILE', __DIR__ . '/../logs/access.log');
define('MENU', '<a href="/">Home Page</a><br><a href="/page/1">Page 1</a><br><a href="/page/2">Page 2</a><br><a href="/json">JSON</a><br><a href="/view">View Log</a>');

// order in which middleware pages should be attached to the pipe
$order = ['log','accept','page','json','view','home'];
$response = new Response();

$middleware = [
    // middleware: writes to a log file; does not return a response
    'log' => [
        'path' => FALSE,
        'func' => function ($req, $handler) use ($response) {
            $text = sprintf('%20s : %10s : %16s : %s' . PHP_EOL,
                            date('Y-m-d H:i:s'),
                            $req->getUri()->getPath(),
                            ($req->getHeaders()['accept'][0] ?? 'N/A'),
                            ($req->getServerParams()['REMOTE_ADDR']) ?? 'Command Line');
            file_put_contents(LOG_FILE, $text, FILE_APPEND);
            return $handler->handle($req);
        }
    ],
    // middleware: sets "Content-Type" to JSON if "Accept" header is "application/json"
    'accept' => [
        'path' => FALSE,
        'func' => function ($req, $handler) use ($response) {
			$accept = $req->getHeaders()['accept'][0];
			if (strpos($accept, 'application/json') !== FALSE) {
				header('Content-Type: application/json');
			}
            return $handler->handle($req);
        }
    ],
    // middleware: outputs JSON; returns a response
    'json' => [
        'path' => '/json',
        'func' => function ($req, $handler) use ($response) {
			$data = ['A' => 'This is line 1', 'B' => 'This is line 2', 'C' => 'This is line 3'];
            $response->getBody()->write(json_encode($data));
            return $response;
        }
    ],
    // middleware: page 1 and 2; returns a response
    'page' => [
        'path' => '/page',
        'func' => function ($req, $handler) use ($response) {
            $path = $req->getUri()->getPath();
            $page = preg_replace('/[^0-9]/', '', $path);
            $response->getBody()->write('<h1>Page ' . $page . '</h1>' . MENU);
            return $response;
        }
    ],
    // middleware: view log page; returns a response
    'view' => [
        'path' => '/view',
        'func' => function ($req, $handler) use ($response) {
            $contents = file_get_contents(LOG_FILE);
            $response->getBody()->write('<h1>View Access Log</h1><pre>' . $contents . '</pre>' . MENU);
            return $response;
        }
    ],
    // middleware: home page; returns a response
    'home' => [
        'path' => '/',
        'func' => function ($req, $handler) use ($response) {
            if (! in_array($req->getUri()->getPath(), ['/', ''], true)) {
                return $handler->handle($req);
            }
            $response->getBody()->write('<h1>Home Page</h1>' . MENU);
            return $response;
        }
    ]
];
```

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
cd /path/to/source/orderapp/build
```
  * If you get this error:
```
BUILD FAILED
/path/to/source/orderapp/build/build.xml:136:30: Failed to copy /path/to/source/orderapp/build/target/live/config/config.php to /path/to/source/orderapp/config/config.php: Cannot delete /path/to/source/orderapp/config/config.php
```
  * Change ownership and permissions for the orderapp directory structure as follows:
```
sudo chown -R www-data:www-data /path/to/source/orderapp
sudo chmod -R 775 /path/to/source/orderapp
```
  * If you get this error:
```
BUILD FAILED
/path/to/source/orderapp/build/build.xml:176:32: '/path/to/source/orderapp/test' is not a valid directory
```
  * Remove references to the `punit` dependency task. Modify `/path/to/source/orderapp/build/build.xml` as follows:
```
    <target name="main"
            description="Executes shell commands on remote server"
            depends="config, public, logStart">
```
  * Database restore: SQL database file is here:
```
/path/to/source/orderapp/data/sql/phpcourse.sql
```
* Jenkins CI Lab
  * The `CheckStyle` plug-in reached end-of-life. All functionality has been integrated into the `Warnings Next Generation` Plugin.
  * Here are some other suggestions for initial setup:
    * replace `checkstyle` with `Warnings Next Generation`
    * replace `build-environment` with `Build Environment`
    * replace `phing` with `Phing`
    * replace `violations` with `Violations`
    * replace `htmlpublisher` with `Build-Publisher` (???)
    * replace `version number` with `Version Number`
  * Jenkins Freestyle Prerequisites Lab
    * 1st 3 commands in one: `sudo usermod -G sudo,root,www-data jenkins`
  * Jenkins Freestyle Lab
    * Unfortunately we don't have a repo in common for student use
    * Something to consider for this lab:
      * Initialize a bare repo
      * Clone it
      * Use this as the target in Jenkins

* Apigility REST API Lab
  * When adding authentication adapter, make sure you enter `api` for the "realm"
  * After creating this file: `/path/to/source/apigility/public/.htaccess` make sure you reset ownership and permissions:
```
chown vagrant:www-data /path/to/source/apigility/data/.htpasswd
chmod 750 /path/to/source/apigility/data/.htpasswd
```

  * `/path/to/source/apigility/public/.htaccess` file contents:
```
AuthType Basic
AuthName "Restricted Files"
AuthUserFile /path/to/source/apigility/data/.htpasswd
Require valid-user
RewriteEngine On
# The following rule allows authentication to work with fast-cgi
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
# The following rule tells Apache that if the requested filename
# exists, simply serve it.
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
# The following rewrites all other queries to index.php. The
# condition ensures that if you are using Apache aliases to do
# mass virtual hosting, the base path will be prepended to
# allow proper resolution of the index.php file; it will work
# in non-aliased environments as well, providing a safe, one-size
# fits all solution.
RewriteCond %{REQUEST_URI}::$1 ^(/.+)(.+)::\2$
RewriteRule ^(.*) - [E=BASE:%1]
RewriteRule ^(.*)$ %{ENV:BASE}index.php [NC,L]
```
  * When reviewing out methods in the `PropulsionSystemsResource` class:
    * reset the ownership + permissions so that user `vagrant` has all rights, and group `www-data` has read and execute rights to entire source code structure
    * this file will be overwritten in the next step
  * When copying files from `/path/to/source/php3/src/ModWebApi/PropulsionsSystems` be sure to overwrite the original files created by the GUI process
* Docker Labs
  * New Image Creation Lab
    * To build and run `/path/to/source/php3/src/ModDocker/NewImageBuild` do this:
```
docker build -t first-lab /path/to/source/php3/src/ModDocker/NewImageBuild
```
    * To confirm images: `docker image ls`
    * To run the image create above:
```
docker run -d -p 8888:80 first-lab
````
    * From the VM browser, open the URL `http://localhost:8888`
    * You will see the initial Apache2 Ubuntu splash page
  * Full-build MySQL Container Lab
    * Build command:
```
docker build -t mysql-lab /path/to/source/php3/src/ModDocker/MySqlBuild
```
    * Run the image: `docker run mysql-lab`
    * Open a new terminal window
    * Find the container id: `docker container ls`
    * Run a shell on the container: `docker exec -it <container_id> bash`
    * Run MySQL from the command line: `#mysql`
  * Pre-built WordPress Services Lab
    * To get a list of containers: `docker container ls`
    * To access WordPress, from the VM browser: `http://localhost:8000/`

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
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/7/33: replace screen shot with text of .htaccess file(above)
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/7/47: reset the ownership + permissions so that user `vagrant` has all rights, and group `www-data` has read and execute rights to entire source code structure
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/7/47: rewrite paragraph and make it clear this is review only: this file will be overwritten in the next step by a pre-built version
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/7/51: when copying files from `/path/to/source/php3/src/ModWebApi/PropulsionsSystems` make is clear the student needs to overwrite the original files created by the GUI process
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/6/21: change the following commands: `docker build -t first-lab /path/to/source/php3/src/ModDocker/NewImageBuild`, `docker run -d -p 8888:80 first-lab`, and then change last instruction to use port 8888
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/5/29: 1st 3 commands in one: `sudo usermod -G sudo,root,www-data jenkins`
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/11: need to copy the `.htaccess` file from `expressive.complete/public` to `stratigility/public` in `Course_Applications`
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/23: need to clarify instructions: instruct the students to install the expressive skeleton app and make sure the project name is "expressive"
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/23: redo the screenshot to the current one for Zend Expressive
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/25: `expressive.complete` project doesn't work
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/25: add a note that `vendor/bin/expressive module:create FlyingElephantService` will do most of this for you
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/34: rewrite this using full namespace classnames
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/45: after this slide, mention that you need to copy this config to `/path/to/source/expressive/config/autoload/dependencies.global.php`.  Has to be at the same level as the `dependencies` key, not *under* it.
```
return [
	'propulsion' => [
		'db' => 'flying-elephant-db',
		'table' => 'propellant',
		'array_mapper_path' => 'data/propulsion.php'
	],
	'dependencies' => [
		// etc.
	]
];
```
* file:///D:/Repos/PHP-Fundamentals-III/Course_Materials/index.html#/8/47: add this to the `/path/to/source/expressive/composer.json` file
```
"zfcampus/zf-configuration" : "*",
"ramsey/uuid" : "*"
```

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
## Q & A
* Q: When you update Jenkins, does it also update all plugins?
* A: No.  Here is a good article on the entire Jenkins update process:
  * https://www.thegeekstuff.com/2016/06/upgrade-jenkins-and-plugins/comment-page-1/
  * See also: https://stackoverflow.com/questions/7709993/how-can-i-update-jenkins-plugins-from-the-terminal
  * To see all plugins which need an upgrade from a bash script:
```
java -jar /root/jenkins-cli.jar -s http://127.0.0.1:8080/ list-plugins | grep -e ')$' | awk '{ print $1 }'
```
  * Automatic upgrade bash script (from the stackoverflow article mentioned above):
```
UPDATE_LIST=$( java -jar /root/jenkins-cli.jar -s http://127.0.0.1:8080/ list-plugins | grep -e ')$' | awk '{ print $1 }' );
if [ ! -z "${UPDATE_LIST}" ]; then
    echo Updating Jenkins Plugins: ${UPDATE_LIST};
    java -jar /root/jenkins-cli.jar -s http://127.0.0.1:8080/ install-plugin ${UPDATE_LIST};
    java -jar /root/jenkins-cli.jar -s http://127.0.0.1:8080/ safe-restart;
fi
```


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


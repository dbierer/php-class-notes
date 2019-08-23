# ZF Masters Class Notes

file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/2/30

## REPO
* https://github.com/dbierer/zf-master-aug-2019

## HOMEWORK (CURRENT)
* For Mon 26 Aug
  * Lab: Psr7Bridge
  * Lab: MiddleWare Listener
* For Wed 21 Aug
  * Lab: Hydrator Filters and Strategies
  * Lab: Custom Route
    * Create a custom route which does a database lookup on title; if found, takes you to the page displaying that item
    * Example: this URL `http://onlinemarket.work/market/view/title/3.5%20Inch%20Diskettes` should end up here `http://onlinemarket.work/market/view/item/15`
    * Hint: use `urldecode()` to strip out any URL encoding
    * Good outline: https://olegkrivtsov.github.io/using-zend-framework-3-book/html/en/Routing/Writing_Own_Route_Type.html

## TODO
* Finish the Aggregate Hydrator in onlinemarket.work re: `PrivateMessages` module
* Is there a way to get `TableGateway\Feature\EventFeature` to work with `ZendDeveloperTools`?
* Get Guestbook demo app in VM working properly
* Post solution to Custom Route Lab
* Post latest Guestbook to the Repo
* Add "Stratigility" demo to `sandbox`

* Check to see why a newly registered user cannot logout
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/51: find original image and make sure it appears in full
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/83: find the stand-alone examples mentioned here

* Find an example of form created using annotation form builder where elements are added later
* Port solution to Lazy Services lab from *.work to *.complete in class repo
* ???Need port `sandbox` into class repo: /sandbox/public/events_aggregate_hydrator.php.
* Double check to see if the up-to-date code for `onlinemarket.complete` posted in repo works OK in VM

## HOMEWORK (PAST)
* For Mon 19 Aug
  * Lab: Oauth2
  * Lab: LDAP
    * Main website: http://www.openldap.org/
    * Install OpenLDAP server on Ubuntu: https://www.linux.com/blog/2019/3/how-install-openldap-ubuntu-server-1804
    * Restore database from LDIF file (29 Nov 2016!):
```
## DEFINE DIT ROOT/BASE/SUFFIX ####
## uses RFC 2377 format
## replace company and com as necessary below
## or for experimentation leave as is

## dcObject is an AUXILLIARY objectclass and MUST
## have a STRUCTURAL objectclass (organization in this case)
# this is an ENTRY sequence and is preceded by a BLANK line

## FIRST Level hierarchy - zf2widder
## uses mixed upper and lower case for objectclass
# this is an ENTRY sequence and is preceded by a BLANK line

dn: ou=zf2widder,dc=company,dc=com
ou: zf2widder
description: Sample Company
objectclass: organizationalunit

## SECOND Level hierarchy
## ADD a single entry under FIRST (people) level
# this is an ENTRY sequence and is preceded by a BLANK line
# the ou: Human Resources is the department name

dn: cn=adminTwo,ou=zf2widder,dc=company,dc=com
objectclass: inetOrgPerson
cn: adminTwo
sn: adminTwo
uid: adminTwo
userpassword: password
departmentNumber: 2
preferredLanguage: English
homephone: +1 555-111-2222
mail: adminTwo@zend.com
description: super user
ou: Software Development

dn: cn=clark,ou=zf2widder,dc=company,dc=com
objectclass: inetOrgPerson
cn: clark
sn: everetts
uid: ceveretts
userpassword: password
departmentNumber: 1
preferredLanguage: English
homephone: +1 555-111-2222
mail: clark.e@zend.com
description: swell guy
ou: Software Development

dn: cn=doug,ou=zf2widder,dc=company,dc=com
objectclass: inetOrgPerson
cn: doug
sn: bierer
uid: dbierer
userpassword: password
departmentNumber: 1
preferredLanguage: English
homephone: +1 555-111-2222
mail: doug@unlikelysource.com
description: slow tourist
ou: Software Development

dn: cn=Robert Smith,ou=zf2widder,dc=company,dc=com
objectclass: inetOrgPerson
cn: bob
sn: smith
uid: rjsmith
userpassword: password
carlicense: HISCAR 123
homephone: 555-111-2222
mail: rsmith@company.com
description: swell guy
ou: Human Resources

## FIRST Level hierarchy - onlinemarket
## uses mixed upper and lower case for objectclass
# this is an ENTRY sequence and is preceded by a BLANK line

dn: ou=onlinemarket, dc=company,dc=com
ou: onlinemarket
description: Sample Company
objectclass: organizationalunit

## SECOND Level hierarchy
## ADD a single entry under FIRST (people) level
# this is an ENTRY sequence and is preceded by a BLANK line
# the ou: Human Resources is the department name

dn: cn=adminOne, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: adminOne
sn: adminOne
uid: adminOne
userpassword: password
employeeType: admin
preferredLanguage: English
homephone: +1 555-111-2222
mail: adminOne@zend.com
description: super user
ou: Admin

dn: cn=guest, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: guest
sn: user
uid: guest
userpassword: password
employeeType: guest
preferredLanguage: English
homephone: +1 555-111-2222
mail: guest@zend.com
description: guest user
ou: Guest

dn: cn=Xavier Change, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: xchange
sn: change
uid: xchange
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +1 555-111-2222
mail: xchange@company.com
description: Category Manager for Barter
ou: Barter

dn: cn=Marilyn Monroe, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: marilyn
sn: monroe
uid: mmonroe
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +1 555-111-2222
mail: mmonroe@company.com
description: Category Manager for Beauty
ou: Beauty

dn: cn=Jean Blue, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: jean
sn: blue
uid: jblue
userpassword: password
employeeType: manager
preferredLanguage: Italian
homephone: +39 555-111-2222
mail: jblue@company.com
description: Category Manager for Clothing
ou: Clothing

dn: cn=Alessandro Turing, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: alessandro
sn: turing
uid: aturing
userpassword: password
employeeType: manager
preferredLanguage: Spanish
homephone: +34 555-111-2222
mail: jturing@company.com
description: Category Manager for Computer
ou: Computer

dn: cn=Groucho Marx, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: groucho
sn: marx
uid: gmarx
userpassword: password
employeeType: manager
preferredLanguage: Fast
homephone: +1 555-111-2222
mail: gmarx@company.com
description: Category Manager for Entertainment
ou: Entertainment

dn: cn=Grah Tweet, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: grah
sn: tweet
uid: gtweet
userpassword: password
employeeType: manager
preferredLanguage: French
homephone: +33 555-111-2222
mail: gtweet@company.com
description: Category Manager for Free
ou: Free

dn: cn=Herb Ivore, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: herb
sn: ivore
uid: hivore
userpassword: password
employeeType: manager
preferredLanguage: Green
homephone: +64 555-111-2222
mail: hivore@company.com
description: Category Manager for Garden
ou: Garden

dn: cn=Douglas MacArthur, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: mac
sn: macarthur
uid: dmacarthur
userpassword: password
employeeType: manager
preferredLanguage: No-Nonsense
homephone: +1 555-111-2222
mail: dmacarthur@company.com
description: Category Manager for General
ou: General

dn: cn=Jerry Lewis, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: jerry
sn: lewis
uid: jlewis
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +1 555-111-2222
mail: jlewis@company.com
description: Category Manager for Health
ou: Health

dn: cn=Martha Stewart, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: martha
sn: stewart
uid: mstewart
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +44 555-111-2222
mail: mstewart@company.com
description: Category Manager for Household
ou: Household

dn: cn=Alex Bell, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: alex
sn: bell
uid: abell
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +1 555-111-2222
mail: abell@company.com
description: Category Manager for Phones
ou: Phones

dn: cn=Elizabeth Windsor, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: TheQueen
sn: windsor
uid: thequeen
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +44 555-111-2222
mail: ewindsor2@company.com
description: Category Manager for Property
ou: Property

dn: cn=David Beckham, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: david
sn: beckham
uid: dbeckham
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +44 555-111-2222
mail: dbeckham@company.com
description: Category Manager for Sporting
ou: Sporting

dn: cn=Mike Holmes, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: mike
sn: holmes
uid: mholmes
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +1 555-111-2222
mail: mholmes@company.com
description: Category Manager for Tools
ou: Tools

dn: cn=Transporter, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: transporter
sn: transporter
uid: transporter
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +44 555-111-2222
mail: transporter@company.com
description: Category Manager for Transportation
ou: Transport
ation

dn: cn=Al Capone, ou=onlinemarket,dc=company,dc=com
objectclass: inetOrgPerson
cn: al
sn: capone
uid: acapone
userpassword: password
employeeType: manager
preferredLanguage: English
homephone: +1 555-111-2222
mail: acapone@company.com
description: Category Manager for Wanted
ou: Wanted
```

* For Fri 16 Aug
  * Lab: BlockCipher
* For Wed 14 Aug
  * LAB: Database Events
    * When implementing the Event Feature ... got this error:
```
Argument 1 passed to ZendDeveloperTools\Listener\EventLoggingListenerAggregate::onCollectEvent() must be an instance of Zend\EventManager\Event, instance of Zend\Db\TableGateway\Feature\EventFeature\TableGatewayEvent given, called in /home/vagrant/zf-master-aug-2019/onlinemarket.work/vendor/zendframework/zend-eventmanager/src/EventManager.php on line 322
```
	* Had to completely uninstall ZendDeveloperTools using Composer
  * LAB: run the code on the slides `Scrypt Example` and `PBKDF2 Example`
    * Add `zendframework/zend-crypt` to `composer.json`
    * Run `composer update`
    * Create separate script files in `public` for onlinemarket.work
    * Don't forget to include `vendor/autoload.php`
```
use Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Math\Rand;
$pass = 'password';
$salt = Rand::getBytes(32, true);
$key  = Pbkdf2::calc('sha256', $pass, $salt, 10000, 32);
printf ("Original password: %s\n", $pass);
printf ("Derived key (hex): %s\n", bin2hex($key));
```
```
use Zend\Crypt\Key\Derivation\Scrypt;
use Zend\Math\Rand;
$pass = 'password';
$salt = Rand::getBytes(32, true);
$key  = Scrypt::calc($pass, $salt, 2048, 2, 1, 32);
printf ("Original password: %s\n", $pass);
printf ("Derived key (hex): %s\n", bin2hex($key));
```

* For Mon 12 Aug
  * Restore `onlinemarket.work` and `onlinemarket.complete` current versions to class repo
  * Restore the database from `onlinemarket.work/data/sql/course.sql`
  * Lab: Delegating Hydrators
  * Lab: Lazy Listeners
    * NOTE: do the work in `Modify Events\Listener\Aggregate::attach()`
  * Lab: Aggregate Hydrator
* For Fri 9 Aug
  * Doctrine Lab
    * Port `Guestbook\Event\Doctrine` over to onlinemarket.work as a new module `MyDoctrine`
    * Get it working
    * Add a new route
    * Use the `xxx_d` tables for this
  * Lab: Lazy Services
    * Make sure that any delegators are assigned as an array, even if only one:
```
// in module.config.php file
'service_manager' => [
	'delegators' => [
		Logging::class => [LazyServiceFactory::class],
	],
]
```
	* If you get this error: `Fatal error: Uncaught Error: Class 'ProxyManager\Configuration' not found`, make sure you installed the `ProxyManager` component: see: https://docs.zendframework.com/zend-servicemanager/lazy-services/#setup

* For Wed 7 Aug
  * Install the Doctrine ORM Module for ZF
  * Provide configuration in `/config/autoload`
  * Don't worry about module config yet
  * Create the `proxy` directory + change owner and permissions
	* `chown vagrant:www-dat /data/proxy`
	* `chmod 775 /data/proxy`
  * Test by running `/vendor/bin/doctrine-module`
    * If you see the help screen and no errors, you're good
  * *IMPORTANT*: make sure you add these two entries into `/config/modules.config.php`
```
'DoctrineModule',
'DoctrineORMModule',
```

## RE: Oauth2 Discussion
* Note that when you are building a namespaced classname, using "\\" is optional.  Have a look at this example:
```
<?php
namespace Test\One\Two {

	class Test
	{
		public function test()
		{
			echo __CLASS__;
		}
	}
}

namespace Whatever {
	$class1 = 'Test\One\Two\Test';
	$obj1 = new $class1();
	echo $obj1->test();
	echo PHP_EOL;
	$class2 = 'Test\\One\\Two\\Test';
	$obj2 = new $class2();
	echo $obj2->test();
	// returns:
	// "Test\One\Two\Three \n Test\One\Two\Three"
}
```

## RE: SECURITY
* Run this to find out what algorithms, key size and mode combos are available on your server:
```
<?php
$algos = openssl_get_cipher_methods();
var_dump($algos);
```

## RE: ZEND DEVELOPER TOOLS
* Follow the instructions here: https://github.com/zendframework/zend-developer-tools

## VM
* Need to change the name of the database from `zfcourse` to `course`
  * Go to `phpMyAdmin`
  * Create database `course`
  * From the repo created for this class, import from `/path/to/repo/onlinemarket.work/data/sql/course.sql`
* Modify the `php.ini` to display_errors on
* Reset permissions as follows:
```
sudo chown -R vagrant:www-data /home/vagrant/Zend
sudo chmod -R 775 /home/vagrant/Zend
```
* To get the `guestbook-admin` project running:
```
cd /home/vagrant/Zend/workspaces/DefaultWorkspace/guestbook/admin
composer install
php -S localhost:9999 -t public
```
* If you get this error:
```
Configuration is missing a "session_config" key, or the value of that key is not an array
```
  * Replace the onlinemarket.work `PhpSession` module with the one in the class repo

## Vagrant Provisioning
* This error was spotted:
```
 Running provisioner: shell...
    default: Running: C:/Users/ACER/AppData/Local/Temp/vagrant-shell20190728-10120-1xfgm4x.sh
    default: Provisioning course DB ...
    default: Pulling database from: https://s3.amazonaws.com/zend-training/zf3/zfcourse.sql
    default: Bootstrap the course MySql database...
    default: /tmp/vagrant-shell: line 11: zfcourse.sql: No such file or directory
    default: rm:
    default: cannot remove 'zfcourse.sql'
```

## ERRATA
* Change VM provisioning script to create database `course` (not `zfcourse`)
* Update listings dates in `course.sql` 2013 => 2019
* Make sure all links are set (maybe import database from ZF-Level-1)
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/1/06: Recording policy changed
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/1/11: ZF2/3 diffs covered in other course: remove
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/2/3: dup Strategy
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/2/9: Zend\Hydrator\XXX is now Zend\Hydrator\XXXHydrator
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/2/10: hydrate() must have Employee object
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/2/28: make it consistent w/ VM: course / vagrant /vagrant
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/3/11: `Hydratory` s/be `Hydrator`
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/4/20: is now `ObjectPropertyHydrator`
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/4/9: s/be `Modify Events\Listener\Aggregate::attach() to accomplish this task` (remove `Factory` from the namespace)
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/4/31: change self::IDENTIFIER to __CLASS__
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/4/31: need to add const IDENTIFIER = 'whatever'
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/14: s/be PBKDF2!!!
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/4/18: s/be `$object->message = $this->blockCipher->decrypt($data['message']);`
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/51: find original image and make sure it appears in full
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/69: top DC s/be `com`
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/72: `cn=homer,ou=support,ou=users,ou=zend,dc=sanjose,dc=roguewave,dc=com`
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/73: s/be `dc=roguewave,dc=com` + resize image to make it fully visible
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/5/56: rewrite as follows:
```
$requestedName = 'Zend\Db\Adapter\Adapter';
$name = str_replace('\\','-',$requestedName);
$element = explode('-', $name);
echo end($element);
```
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/6/35: s/be ZF 3
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/6/40: needs to be expanded (understatement)
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/8/2: link needs to be updated: all links now rolled into PSR-15
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/8/2: add Zend Expressive!
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/8/46: where is the sample program?
* file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/8/55: dir s/be `manage`
* RE: Doctrine ORM Lab: already installed in VM: need to un-install!
* RE: Doctrine ORM Lab: onlinemarket.complete is missing the Doctrine portion of Events module
* RE: LDAP Lab: the OpenLDAP server is not installed in the VM + the link is missing from the home page
* RE: Middleware: Move course Module 8 (Middleware) in front of Module 6 (Cross Cutting Concerns)

# ZF Masters Class Notes

file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/2/30

## TODO
* Find an example of form created using annotation form builder where elements are added later
* Port solution to Lazy Services lab from *.work to *.complete in class repo
* ???Need port `sandbox` into class repo: /sandbox/public/events_aggregate_hydrator.php.
* Get LazyServices solution working in Logging module

## REPO
* https://github.com/dbierer/zf-master-aug-2019

## HOMEWORK
* For Wed 14 Aug
  * LAB: Database Events
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
* RE: Doctrine ORM Lab: already installed in VM: need to un-install!
* RE: Doctrine ORM Lab: onlinemarket.complete is missing the Doctrine portion of Events module

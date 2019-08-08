# ZF Masters Class Notes

file:///D:/Repos/ZF-Level-3/Course_Materials/index.html#/2/30

## HOMEWORK
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

## TODO
* Need to restore Events\Doctrine\* source code: find in commit log where it got erased
* Find an example of form created using annotation form builder where elements are added later

## VM
* Need to change the name of the database from `zfcourse` to `course`
  * Go to `phpMyAdmin`
  * Create database `course`
  * Import from `/home/vagrant/Zend/workspaces/DefaultWorkspace/course.sql`
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
* RE: Doctrine ORM Lab: already installed in VM: need to un-install!
* RE: Doctrine ORM Lab: onlinemarket.complete is missing the Doctrine portion of Events module

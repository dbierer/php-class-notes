# Zend Server Training -- May 2020

## Homework
* For mercredi 27
  * Lab: Zend Server Manual Installation
    * For class, use: `sudo apt-get install zend-server-apache-fpm`
    * Root password: `vagrant`
  * Lab: Component Enable Verification
  * Lab: Monitor Settings for Directives
  * Lab: Web API Keys Generation
  * Lab: Zend Server Command Line
  * Lab: zs-client

## Installation
* https://docs.roguewave.com/en/zend/current/content/installation_guide.htm

## Class Notes
* Info on PHP-FPM: https://www.php.net/manual/en/install.fpm.php

## Tools
* Change password:
```
sudo php /usr/local/zend/bin/gui_passwd.php <PASSWORD>
```
* Start/stop *all* ZS daemons:
```
sudo /usr/local/zend/bin/zsd.sh start|stop|restart|status
```

## ZS Databases
* Location: `/usr/local/zend/var/db`
* To edit database "XXX":
```
sqlite3 /usr/local/zend/var/db/XXX.db
```
* If you need to change the password "manually" (assumes the new password is "password"):
```
$ su root
# php -r "echo hash('sha256', 'password');"
# sqlite3 /usr/local/zend/var/db/gui.db
sqlite> -- locate the ID of the "admin" user:
sqlite> select * from GUI_USERS;
sqlite> update GUI_USERS set PASSWORD="hash from PHP command above" where ID="ID for admin";
sqlite> .exit
```
WARNING: the above procedure can wipe out your installation if a mistake is made!

## Course Timing:
* Day 1: Module 1 to Module 5 (Virtual Host Management)
* Day 2: Module 5 to Module 6 (Monitoring > Logs)
* Day 3: Module 6 to Module 9 (Debugging)
* Day 4: Module 9 to the End

## Q & A
* Q: What is the relationship between /usr/local/zend/etc/conf.d/*.ini and the GUI components menu?
* A: There is a 1-to-1 correspondance.  All of the settings in these *.ini files are accessible via the Components menu.

* Q: How can I view Apache log files using GUI _Monitoring_ :: _Logs_?
* A: Assign rights to the group `zend` as follows:
```
sudo chgrp -R zend /var/log/apache2
```
* Q: How can I generate a web API key from command line?

## Test Code
Code examples that will cause problems:
* Unbridled array nesting:
```
<?php
// unbridled nesting
function addLayer($array)
{
    $array = array_combine(range('A','Z'),range('A','Z'));
    foreach ($array as $element) {
        addLayer($array[$element]);
    }
}

$wild = [];
addLayer($wild);
var_dump($wild);
```
* Prime number generation:
```
<?php
// prime number generator
$count  =  0;
$number =  2;
$max    = 999999;
while ($count < $max ) {
    $div_count = 0;
    for ( $i = 1; $i <= $number; $i++) {
        if (($number%$i) == 0) {
            $div_count++;
        }
    }
    if ($div_count < 3) {
        echo $number." , ";
        $count += 1;
    }
    $number += 1;
}
```
* Recursing through a directory structure:
```
<?php
// recursion through entire www directory (be sure "www-data" user has rights)
$path = realpath('/path/to/dir/with/lots/of/files');
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path),
										 RecursiveIteratorIterator::SELF_FIRST);
$rows = '<table>';
$count = 0;
foreach($objects as $name => $object){
	$color = ($count++ & 1) ? '#FFFFEE' : '#FFFFDD';
	if ($object->isDir()) {
		$rows .= sprintf('<tr bgcolor="%s"><td colspan=2>%s</td></tr>' . PHP_EOL, $color, $name);
	} else {
		$rows .= sprintf('<tr bgcolor="%s"><td width="10px;">&nbsp;</td><td>%s</td><td>%s</td></tr>' . PHP_EOL,
						  $color, $object->getPath(), $object->getBasename());
	}
}
$rows .= '</table>';
echo $rows;
```


# Zend Server Training -- May 2020

## TODO
* Research relationship between /usr/local/zend/etc/conf.d/*.ini and the GUI components menu
* Change access rights for log files
* Generate a web API key from command line?

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
* PHP-FPM: https://www.php.net/manual/en/install.fpm.php

## Tools
* Change password:
```
sudo php /usr/local/zend/bin/gui_passwd.php <PASSWORD>
```
* Start/stop *all* ZS daemons:
```
sudo /usr/local/zend/bin/zsd.sh start|stop|restart|status
```

## Course Timing:
* Day 1: Module 1 to Module 5 (Virtual Host Management)
* Day 2: Module 5 to Module 6 (Monitoring > Logs)
* Day 3: Module 6 to Module 9 (Debugging)
* Day 4: Module 9 to the End

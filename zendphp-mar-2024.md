# ZendPHP/ZendHQ Class Notes -- Mar 2024

## Add Extensions:
* xml
* simplexml
* dom
* xmlwriter


## Issues Installing ZendPHP on Windows w/ IIS
* Contact Josh Ziss for details

## zendphpctl
* Move the discussion on installing using `zendphpctl` in front of the other approaches
* Mention there's another approach
* There might be rare scenario where downloading the `zendphpctl` script could be an issue
* Just released for ARM64 + Alpine (confirmed!)
* http://localhost:9999/#/3/31
  * integrationv
* Add info on `zendphpctl completions`
* http://localhost:9999/#/3/33
  * remove the "-" from `zendphpctl php-install 8.1` (remove the dash)
* http://localhost:9999/#/3/34
  * remove the dash
* Add demo to the presentation at this point

## PHP-FPM / Apache / nginx
* Move to a separate course module

## IBMi
* Move the materials for IBMi into a separate course module

## PHP-FPM
* http://localhost:9999/#/3/48
  * need to add the apache conf file for a vhost that shows the reverse proxy directive settings

## Basic Installation
* http://localhost:9999/#/3/62
  * Need to add steps to access licensed LTS versions
* http://localhost:9999/#/3/68
  * Add note: for other OS: usually a systemctl-style run control methodology is used
  
## ZendHQ
* http://localhost:9999/#/4/4
  * Det ???
  * infrasturctural
  
* Need to add info on developing plugins
* http://localhost:9999/#/4/9
  * Need to make clear that the ZendHQ extension can be installed anywhere
  * The zendhqd can only installed on Linux and IBMi (currently) 
    * On Windows: can use the WSL (need to confirm)
  * The GUI can run on many different platforms
    
* http://localhost:9999/#/4/10
  * Need to confirm MSI installer as a Windows service???
  
* http://localhost:9999/#/4/12
  * backs up the current ini file
  * inserts the new hash

* http://localhost:9999/#/4/17
  * mention path to `zendhqctl` and should put that in the profile

In general: may want to specify paths:
```
56f121bc9d6b:/home/training/mezzio# ls -l /usr/bin |grep php
lrwxrwxrwx 1 root root      18 Mar 26 10:19 php -> /usr/bin/php82zend
-rwxr-xr-x 1 root root 8394632 Mar 18 06:28 php82zend
56f121bc9d6b:/home/training/mezzio# ls -l /usr/sbin |grep php
lrwxrwxrwx 1 root root      23 Mar 26 10:19 php-fpm -> /usr/sbin/php-fpm82zend
-rwxr-xr-x 1 root root 8395200 Mar 18 06:28 php-fpm82zend
```

* http://localhost:9999/#/4/21
  * just restart the `zendhqd` 
  
    

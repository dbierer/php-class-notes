# ZendPHP/ZendHQ Class Notes -- Mar 2024

## Overall
* Move the class to a 3 day
* Make sure the Vagrantfile for the course install Docker and Docker-Compose
  * Switch to `apt-get` to install Docker and Docker Compose
* Lock in a specific version of Alpine
* Update the Vagrantfile to configure Docker to run with a regular user
* Consider just having attendees install ZendPHP/ZendHQ directly in the VM and don't use Docker/Docker-Compose
* Consider locking into 8.2

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
  
## Basic Installation lab
* Remove `composer.lock`
* http://localhost:9999/#/3/64
  * Add a reference page with names of modules
      
* http://localhost:9999/#/3/57
  * Move this to the end: showing other options
  
http://localhost:9999/#/3/60
  * Mention that you need to be in the `/path/to/repo` directory

  * Mention you need to find out what is your path (e.g. `echo $PATH`)
  
* http://localhost:9999/#/3/62
  * Add reference to what needs to be done to access licensed LTS version

* http://localhost:9999/#/3/62
  * the `wget` and `echo` commands are not needed (confirm this)

* http://localhost:9999/#/3/65
  * Mention that this is optional
  
* http://localhost:9999/#/3/67
  * Should also look at the FPM pool conf

* Regarding `composer.phar install`
  * There might be issues with 8.3 and Mezzio packages
  * Maybe `ifconfig` to confirm IP address

* nginx config file doesn't work! Use this instead:
```
server {
    listen                  80;
    root                    /var/www/mezzio/public;
    index                   index.php;
    server_name             _;
    client_max_body_size    32m;
    error_page              500 502 503 504  /50x.html;
    location = /50x.html {
        root              /var/lib/nginx/html;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        fastcgi_pass      127.0.0.1:9000;
        fastcgi_index     index.php;
        include           fastcgi.conf;
        fastcgi_param     SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param     SCRIPT_NAME      $fastcgi_script_name;
    }
}
```


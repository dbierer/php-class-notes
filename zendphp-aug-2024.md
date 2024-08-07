# ZendPHP/ZendHQ Class Notes -- August 2024

## TODO
* Q: What does the `zendphpctl completions` subcommand do?
* A:

* Q: Get instructions for installing extensions outside of the list of currently supported ones

* Q: Is the Z-Ray browser bar available with ZendHQ?

* Q: With the ZendHQ license, can it be installed on multiple containers?


## Homework
For Thursday 7 Aug 2024
* Lab: ZendPHP Installation Lab
* Lab: PHP-FPM Installation and Configuration Lab
* Lab: ZendHQ Installation Lab

## Class Notes
IMPORTANT: Make sure you obtain a real or demo ZendHQ license before doing the ZendHQ lab!

Here's the corrected nginx configuration for the Mezzio app:
```
server {
    server_name  _;
    root         /var/www/mezzio/public;

    location / {
        try_files $uri index.php @mezzio;
    }

    location @mezzio {
        rewrite /(.*)$ /index.php?/$1 last;
    }

    location ~ \.php {
		fastcgi_pass 127.0.0.1:9000;
		fastcgi_split_path_info ^(.+\.php)(/.*)$;
		include snippets/fastcgi-php.conf;

		fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
		fastcgi_param DOCUMENT_ROOT $realpath_root;

		internal;
    }
}
```

## Lab Notes
ZendPHP Installation
* If you want to install the YAML extension
  * Here's the prereq:
```
sudo apt install libyaml-dev
```
ZendHQ Installtion Lab
* Lab: Set Up the Demo App
  * Add the `--ignore-platform-reqs` flag if using PHP 8.3
```
composer install --ignore-platform-reqs
```
* Lab: Start the Service
  * If you get a message that port 10091 is already in use check to see if `zendhqd` is already running:
```
# ps -ax |grep zendhqd
```
  * If so, try to stop using the run system:
```
# /etc/init.d/zendhqd stop
```
  * If that doesn't work, make a note of the process (which we'll call `ZENDHQD_PID`)
  * Kill the process:
```
# kill ZENDHQD_PID
```
* Lab: Install the ZendHQ PHP Extension
  * Review the extension configuration
  * No changes are needed for this lab
```
# nano /etc/php/8.3-zend/fpm/conf.d/90-zendhq.ini
```
* Lab: Install the ZendHQ GUI
  * To run the GUI from inside the VM you can also use the GUI file browser, locate the extracted binary, and double click
## Q & A
* Q: Is `zendphp-vhost.sh` available outside the cloud?

* Q: For ZRay database queries, does it show you what got returned from the query?

* Q: Is there a problem with ZRay plugins when running PHP 8.3?
  * Only one plugin (`test`) showed up on the list of available plugins
  * `sudo apt install zray-plugins` defaulted to PHP 7.2 and failed
  * `sudo zendphpctl zray plugin install` seemed to work but no plugins are on the list

* Q: When you add plugins, can you assign RBAC permissions?

* Q: Does the ZRay token convert to a cookie?

* Q: Can you set a wildcard on function errors? (E.g. `preg.*?`)

* Q: What is the role of ZendMQ?

* Q: What is the cost (if any) for requesting language additions

* Q: If installing PHP using zendphpctl, does it sync with the OS package management?

* Q: Using the legacy approach, how do you enable LTS licensed access to the repo sources?

* Q: How do you manage the ZendPHP install on Windows after the MSI installer has finished?
  * Maybe using the PowerShell script?

* Q: Why is PHP-FPM tied to the PHP version?

* Q: Is ZendPHP available for the Mac?
* A: Not on the list

* Q: Does zendhqd run on a Windows server?
* A: Only under WSL (Windows Services for Linux)

* Q: How to restart zendhqd cleanly?
* A: In Debian-based Linux distros, you can use the traditional `systemctl` run manager:
```
/etc/init.d/zendhqd start|restart|status
```

## Errata

* http://localhost:8884/#/3/12
http://localhost:8884/#/3/17
  * not `php-set-default` (no initial dash)
* http://localhost:8884/#/5/11
  * For RHEL/Oracle etc: $PHP_VER will have no dot and no dash (e.g. PHP 8.3 would be php83zend)

# ZendPHP/ZendHQ Class Notes -- August 2024

## TODO
* Q: Example using the build script for ZendPHP Docker images

* Q: When creating a job for an application, when the application scales across multiple nodes, is there a way to ensure the job only runs once?

* Q: What's the best way to do Z-Ray monitoring when doing AJAX requests?
* A:

* Q: Is there a mechanism to keep the \*.db files under control?

* Q: Is there any provision for excluding or setting separate rules for specific URLs? It would be nice to avoid pages where we know it will be of slow execution.

* Q: Related: is there any way to limit Z-Ray to a specific URL path instead any request from that domain?

* Q: Why does the token not change?
* A:


* Q: Get instructions for installing extensions outside of the list of currently supported ones
* A: Here are the instructions:
```
 The steps you need to take:

    Make sure the dev package for the given PHP version is installed.
    Make sure any dev libraries you need to compile the given extension are installed.
    Grab the package for the extension from PECL or wherever they are providing it; DO NOT use the pecl tool itself, though.
    Unarchive the package.
    In the package root, run /path/to/phpize-for-your-php-version
    From there, you can run `./configure --with-php-config=/path/to/php-config-for-your-php-version`, along with any other
    If that succeeds, run make​, followed by make install​.

The path to phpize and php-config will vary based on your OS and PHP version, but are usually found in /usr/bin/​.

The reason I suggest this path instead of using PECL is for a few reasons:

    It assumes there is only one PHP on the system. If there is, it's not a problem, but if you have more than one,
    the wrong phpize and/or php-config might be used. You cannot provide arguments to configure​ with PECL, either.

```

* Q: What does the `zendphpctl completions` subcommand do?
* A:

* Q: Is the Z-Ray browser bar available with ZendHQ?
* A:

* Q: With the ZendHQ license, can it be installed on multiple containers?
* A:

* Q: If installing PHP using zendphpctl, does it sync with the OS package management? If so, will ZendPHP get updated along with the other OS packages?
* A:

* Q: Why is PHP-FPM tied to the PHP version? Isn't it just a gateway between the web server and the PHP installation?
* A:

* Q: Can you set a wildcard on function errors? (E.g. `preg.*?`)
* A:


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

## Z-Ray
* If you anchor your initial request to the
## Lab Notes
ZendPHP Installation
* If you want to install the YAML extension
  * Here's the prereq:
```
sudo apt install libyaml-dev
```
ZendHQ Installation Lab
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
* A: Yes. The first time it's a URL param. Subsequent requests to the same site result in a cookie being automatically sent.

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
* User assigned only rights to "mon" is able to alter configuration
* http://localhost:8884/#/6/8
  * Screens show different areas of error
  * Link goes to the same for all of them
* http://localhost:8884/#/6/45
  * Based on the VM not Alpine
* http://localhost:8884/#/9/22
  * capabiities

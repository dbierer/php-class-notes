# ZendPHP/ZendHQ Class Notes -- May 2024

## TODO
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

## Homework
For Thursday 23 May 2024
* Lab: ZendPHP Installation Lab
* Lab: PHP-FPM Installation and Configuration Lab
* Lab: ZendHQ Installation Lab

## Class Notes
Make sure you obtain a real or demo ZendHQ license before doing the labs.

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


## Errata

#### Fixed
PHP-FPM Lab:
x  * The link source for the demo app is not correct. Here's the correct link:
```
# ln -s /home/vagrant/Zend/Basic_Installation/mezzio /var/www/mezzio
```

x* Also need to install the DOM extension

* Check for situations where you need to be root, vs. just regular user

x* This `/etc/nginx/http.d/default` s/be `/etc/nginx/sites-available/default`

x* IBMi is now in a separate section (remove from title slide)

* ZendPHP Supported versions
  * Centos Stream?
  * SuSE Linux?

x* Correct typo: "integrationv"

x* `zendphpctl php-list-installed` s/be `zendphpctl php list-installed`

x* Correct typo: "Det of practices"

x* ZendHQ installation lab: get rid of this "This lab is based upon the Alpine Dockerx image."

x* change this 10.10.60.10 to "localhost" in the labs

ZendHQ Lab

* Make it clear how to run the GUI
* Mention from CLI you will see GTK error messages
x* Switch refs from 10.10.??? to localhost
* Need to restart the zendhqd after Lab: Change the Login Token
* Confirm that zendhqd runs under systctl, if so, change lab instructions
* Make sure the PHP zendhq extension config is mentioned in the labs

* http://localhost:9999/#/6/8
  * Screenshots are all the same

* Rework lab creating a series of simple PHP programs that cause specific problems

* Consider moving PHP version back to 8.2 or 8.1 so that plugins are available

* http://localhost:9999/#/8/10
  * Are all these still active?

* http://localhost:9999/#/10/3
  * Update supported versions

* http://localhost:9999/#/10/7
  * Remove

### Not Yet Fixed

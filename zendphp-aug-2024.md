# ZendPHP/ZendHQ Class Notes -- August 2024

## TODO

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


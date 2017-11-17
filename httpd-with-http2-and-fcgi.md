# Setting up Apache for HTTP2 and using PHP as FastCGI (beta instruction)
## Compiling
Here is how I've built my apache (I've removed php from the modules list since I'm using fcgi)
```
./configure --enable-modules="ssl rewrite deflate security" --with-included-apr --enable-http2 --enable-so --enable-proxy --enable-proxy-fcgi
```

The flag ```--enable-http2``` is, of course, for HTTP/2 and ```--enable-proxy --enable-proxy-fcgi``` will allow you to run PHP in fcgi mode  
> (there are some dependencies like libnghttp2-devel that you might have to install)

and here is how I built my php
```
./configure --enable-bcmath --with-bz2 --with-curl  --enable-filter --with-gd --enable-gd-native-ttf --with-freetype-dir --with-jpeg-dir --with-png-dir --enable-intl --enable-mbstring --with-mcrypt --enable-mysqlnd --with-mysql-sock=/var/lib/mysql/mysql.sock --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd  --with-pdo-sqlite --disable-phpdbg --disable-phpdbg-webhelper --enable-opcache --with-openssl --enable-simplexml --with-sqlite3 --enable-xmlreader --enable-xmlwriter --enable-zip --with-zlib --with-apxs2=/usr/local/apache2/bin/apxs --with-config-file-scan-dir=/etc/php.d --enable-fpm
```
The flag ```--enable-fpm``` is very important if you want to run as fcgi.  
> (there is also dependencies that you might have to install before compile PHP, like: yum install libxml2 libxml2-devel bzip2-devel libcurl-devel gd-devel libicu-devel gcc-c++ libmcrypt-devel)

## Configuring PHP-FPM
Then you have to configure php-fpm. First find your default configuration file: php-fpm.conf.default and copy it to php-fpm.conf (```find / -name php-fpm.conf.default```)  
I only had to change the last line to reflect the folder where the config was:
```
include=/usr/local/etc/php-fpm.d/*.conf
```
Inside the ```/php-fpm.d/``` folder, you need to have your fast cgi configuration. You should have a default ```www.conf.default``` file that you can copy to ```www.conf```  
The only 2 changes I made to this file is to change the user/group that this process will run as, I choose to run my php as apache:apache but you can setup a user with different permission just for php. Then update the folder where your php code is located, I put mine in /var/www, do I change this directive:
```
chdir = /var/www
```
You should also take note of the listening option you want, the default is to use port 9000 on local ip
```
listen = 127.0.0.1:9000
```

If everything goes well, you should be able to start the php-fpm using this command, BUT this will not allow you to stop the process without using the kill command.
```
php-fpm
```

If you want to create a service for PHP-FPM on systemd (CentOS 7), create the following file ```/lib/systemd/system/php-fpm.service``` with the content as follow:
```
[Unit]
Description=The PHP 7.1 FastCGI Process Manager
After=network.target

[Service]
Type=simple
PIDFile=/var/run/php-fpm.pid
ExecStart=/usr/local/sbin/php-fpm --nodaemonize --fpm-config /usr/local/etc/php-fpm.conf
ExecReload=/bin/kill -USR2 $MAINPID

[Install]
WantedBy=multi-user.target
```

Then you can use ```systemctl start php-fpm``` to start your service, you can also use ```systemctl enable php-fpm``` to get php-fpm to start automatically on boot.

## Configuring Apache
To be able to use FastCGI you have to setup a proxy for your Apache to the php-fpm executable, you can do this in a vhost. My vhost configuration for PHP looks like this:
```
<VirtualHost *:80>
    ServerAdmin webmaster@test.local
    DocumentRoot "/var/www"
    ServerName php.test.local
    ServerAlias php.test.local
    ErrorLog "logs/php.test.local-error_log"
    CustomLog "logs/php.test.local-access_log" common
    <Directory "/var/www">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9000/var/www/$1
</VirtualHost>
<VirtualHost *:443>
    ServerAdmin webmaster@test.local
    DocumentRoot "/var/www"
    ServerName php.test.local
    ServerAlias php.test.local
    ErrorLog "logs/php.test.local-error_log"
    CustomLog "logs/php.test.local-access_log" common
    <Directory "/var/www">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9000/var/www/$1

    SSLEngine on
    SSLCertificateFile "/root/ca/testlocal.crt"
    SSLCertificateKeyFile "/root/ca/testlocal.key"
    SSLCertificateChainFile "/root/ca/testlocal_ca.crt"
    <FilesMatch "\.(cgi|shtml|phtml|php)$">
        SSLOptions +StdEnvVars
    </FilesMatch>
</VirtualHost>
```

For the FastCGI, the important line is ```ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9000/var/www/$1``` This tells Apache to forward incoming request from your vhost (php.test.local in my case) to the php-fpm using the ip/port defined in your www.conf earlier.

I have included the SSL certificate information since it is necessary for HTTP/2 in most browsers.

After restarting Apache, you should be able to run php code located on the server in ```/var/www``` using https://php.test.local (provided that you update your hosts file to forward this domain to your server's IP)

## Setting up HTTP/2
It is actually very easy to get HTTP/2 working once it is compiled and you have an HTTPS connection. All you have to do is to activate it in your Apache configuration file.
I set mine as a separate include file called ```http2.conf``` with only this
```
LoadModule http2_module modules/mod_http2.so
Protocols h2 http/1.1
```
The flag ```Protocols h2 http/1.1``` tells the server to try HTTP/2 first (h2) and if it fails fallback to HTTP/1.1. You can activate HTTP/2 without HTTPS by adding ```h2c``` in the list of protocols, but I believe Firefox is the only browser supporting it and I wasn't able to make this work.

After you restart Apache, you can inspect the header received from https://php.test.local and the protocol should be HTTP/2.


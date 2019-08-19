# Apache Fundamentals Notes

Last Update: 9 Apr 2019

## Suggestions
* Rename course to Apache Enterprise
* Reduce slide count: figure what is not needed
* Instead of listing every single directive, refer to docs instead

## TODO
* HTTP Response Code Logging are the slide examples stated correctly?
  * file:///D:/Repos/apache-fundamentals/Course_Materials/index.html#/3/27

## Installing the GUI
```
yum -y groups install "GNOME Desktop"
startx
```

## Lab Notes
* LAB: Install Apache with mod_ssl
  * Install OpenSSL on the OS (use `yum` to do that)
  * Compile from source `mod_ssl` (see tutorial and apache docs)
  * Re-compile apache from source and include mod_ssl:
```
./configure --with-included-apr --enable-ssl
```
* LAB: Install a Self-Signed Certificate
* LAB: Set up a Vhost which uses HTTPS
* LAB: Configuring Logs
* LAB: Access Logging
* LAB: Name Based Virtual Hosts 1
	* Set up the VM for two name based virtual hosts: "foo.local" and "bar.local"
	* Edit /etc/hosts
		* `foo.local`
		* `bar.local`
	* Make directories
```
/home/vagrant/foo
/home/vagrant/bar
```
	* Create index.html for each:
```
/home/vagrant/foo/index.html
/home/vagrant/bar/index.html
```
	* Assign rights to the user "daemon" to the new directories and files
	* In `httpd.conf` locate and uncomment the line which includes `httpd-vhosts.conf`
	* In `/usr/local/apache2/conf/extra/httpd-vhosts.conf`
	define named based virtual hosts for `foo.local` and `bar.local`
	* In each vhost configuration add `<Directory>` directives `AllowOverride all` and `Require all granted`
	which grants permissions for the web server to be able to read from those directories
	* Note the main host goes away. Add a vhost entry at the top of `httpd-vhosts.conf` for the default
```
<VirtualHost *:80>
    DocumentRoot "/usr/local/apache2/htdocs"
    ServerName test.local
    ServerAlias www.test.local
    ErrorLog "logs/test-error_log"
    CustomLog "logs/test-access_log" common
    <Directory "/usr/local/apache2/htdocs">
        Require all Granted
    </Directory>
</VirtualHost>
```
* LAB: Alias
  * Might want to add the 3 directives to stop browser cache
* LAB: ScriptAlias
* LAB: RewriteCond
  * Might not work!
  * Maybe try something from the slide examples for this lab!
* LAB: RewriteBase
* LAB: mod_headers
  * force refresh the browser by hitting `CTL+F5` otherwise the browser caches the page!
  * dont forget to clone the LAB source code (see next line) + copy the /var/www/* structure over to /var/www
  * also: don't forget to set the `DocumentRoot` directive in `httpd.conf` to `/var/www`
* LAB source code: https://github.com/dbierer/apache-training
* Second Lab: Install Apache from Source
  * Documentation: http://httpd.apache.org/docs/2.4/install.html
  * When you first download the main Apache source code file, make sure you download the latest version with `*.bz2` extension
  * After download, run the dependency check, and do a screenshot so you have the list saved
    * `yum install rpm-build`
    * `rpmbuild -tc httd.xxx.xxx.xxx.tar.bz2`
    * Suggestion: just install all the packages listed as dependencies
  * Make sure you install the development packages (mentioned on the slides):
```
yum groupinstall development tools
```
  * If during `make` you get an error about `expat.h` then install all the packages identified as dependencies

* First Lab:
```
LAB: Install, Start and Stop Apache
Modify the network settings on the VM from NAT to Bridged and restart the VM
Use this command: shutdown -r now
Login as "vagrant" and switch user to "root"
Install lynx
Remove any existing version of Apache
Clean up and update yum
Using the VirtualBox Manager (or the equivalent on your system) create a snapshot of the VM which we will call "clean"
Install Apache from a pre-compiled binary using yum
Determine the IP address for your VM using "ifconfig"
Create an entry for "test.local" in /etc/hosts which matches the VM IP address
Configure the basic httpd.conf for "test.local" and the "apache" user
Start and stop Apache successfully with minimal settings
Confirm the installation works

STEPS:
LAB: Set Up Infrastructure
Change to the "root" user using "su" with a password "vagrant"
Update yum sources: yum -y update
Clean up yum: yum clean all
Remove any existing httpd installations: yum remove httpd
Install the Lynx text browser: yum install lynx
Test: lynx http://zend.com/
Determine the IP address for your VM using "ifconfig"
Create an entry for "test.local" in /etc/hosts which matches the VM IP address: echo "vm.ip.addr.ess test.local" >> /etc/hosts
Using the VirtualBox Manager (or the equivalent on your system) create a snapshot of the VM which we will call "clean"

LAB: Install Apache
Install apache: yum install httpd
Locate httpd.conf: find / -name httpd.conf
Configure the basic httpd.conf for "test.local" and the "apache" user
Add a firewall exception for port 80 (see previous slides)
Start and stop Apache successfully with minimal settings
Test the installation from inside the VM using lynx
Test from outside the VM using any browser on your host computer
If you do not have any response when testing from the outside, try the following:
Right click on the network settings icon (bottom right of the VM window)
Switch from "NAT" to "Bridged" mode
If you have more than one adapter on the host, make sure you have chosen one which is in use and connects to your network router
```
* Need to add how to set up Windows to recognize `test.local` which what the VM is now considered to be
  * C:\Windows\System32\drivers\etc\hosts
  * Add entry just like in Linux
* Latest PCRE source is here:  https://ftp.pcre.org/pub/pcre/
* Latest APR and APR-UTIL is here: https://www-us.apache.org/dist/apr/

## Q&A
http://httpd.apache.org/docs/2.4/sections.html

* Q: Can the `Location` and `Directory` directives use regex?
* A: Yes, just add ~ after `Location` and before the URL
  A: See: http://httpd.apache.org/docs/2.4/mod/core.html#location
  A: Even better, use the `LocationMatch` and `DirectoryMatch` directives

* Q: Link to reference on log format codes?
* A: http://httpd.apache.org/docs/2.4/mod/mod_log_config.html#formats

* Q: Documentation on virtual hosts?
* A: http://httpd.apache.org/docs/2.4/vhosts/

* Q: Practical example of rewrite rules?
* A: See: https://github.com/zendframework/zend-expressive-skeleton/blob/master/public/.htaccess

* Q: Is there a good description on RewriteBase?
* A: https://stackoverflow.com/questions/21347768/what-does-rewritebase-do-and-how-to-use-it

* Q: How do you set file system permissions?
* A: Use this command, where x/y/z is the directory to modify
  * This command changes the owner to `vagrant`  and the group to `daemon`
```
chown -R vagrant:daemon /x/y/z
chmod -R 775 /x/y/z
```

* Q: What happens if two headers are added with the same name?
* A: ???

* Q: How do you find where a version of some installed software is located?
* A: Use a command `whereis xxx` where "xxx" is what you're looking for
* Q: Can you give me an example of an Apache module which is not thread safe?
* A: See: https://stackoverflow.com/questions/1623914/what-is-thread-safe-or-non-thread-safe-in-php

* Q: Which MPM is better, Event or Worker?
* A: see https://linuxtechme.wordpress.com/2014/11/04/mpm/

* Q: What is APSX?
* A: apxs - APache eXtenSion tool; a tool for building and installing extension modules
  See: https://httpd.apache.org/docs/trunk/programs/apxs.html

* Q: from Francois to All Participants: what is the support for IPv6 in Apache?
* A: from Todd Reed to All Participants: Apache does support dual stack

* Q: from Francois: how do I enable HTTP2 support?
* A: see: https://httpd.apache.org/docs/2.4/howto/http2.html; and rebuild Apache with
```
--enable-http2          HTTP/2 protocol handling in addition to HTTP
                          protocol handling. Implemented by mod_http2. This
                          module requires a libnghttp2 installation. See
                          --with-nghttp2 on how to manage non-standard
                          locations. This module is usually linked shared and
                          requires loading.
```

* Q: Log format codes docs?
* A: http://httpd.apache.org/docs/2.4/mod/mod_log_config.html

* Q: re: the “SetHandler” directive: what handlers are available?
* A: see:https://httpd.apache.org/docs/current/handler.html

* Q: how do I set PHP as a “handler” for *.php requests?
* A: see:http://php.net/manual/en/install.unix.apache2.php

* Q: How many sub-patterns?
* A: $1 up to $9

* Q: What is an IPv4 mapped IPv6 address?
* A: see: https://tools.ietf.org/html/rfc5156 and https://en.m.wikipedia.org/wiki/IPv6#IPv4-mapped_IPv6_addresses

* Q: What is `mod_vhost_alias`?
* A: Provides the ability to dynamically create large numbers of vhosts automatically.  See: https://httpd.apache.org/docs/2.4/mod/mod_vhost_alias.html

* Q: from Francois to All Participants: how would you "enable" an apache instance with a different conf file so that it start automatically at boot?
  systemctl enable httpd, can you say systemctl enable httpd -f /new-file.conf?

* Q: from Christopher to All Participants: What is the difference between aNull and eNull?
* A: from James to All Participants: eNULL = ciphers offering no encryption, aNULL = cipher suites offering no authentication

* Q: What is the difference between SCGI and CGI?
* A: See: http://python.ca/scgi/protocol.txt
  * The SCGI protocol is a replacement for the Common Gateway Interface
    (CGI) protocol.  It is a standard for applications to interface with
    HTTP servers.  It is similar to FastCGI but is designed to be easier
    to implement.

* Q: What is "stickyness" in regards to `mod_proxy_balancer`?
* A: See: https://httpd.apache.org/docs/2.4/mod/mod_proxy_balancer.html#stickyness
  * When a request is proxied to some back-end, then all following requests from the same user should be proxied to the same back-end. Many load balancers implement this feature via a table that maps client IP addresses to back-ends. This approach is transparent to clients and back-ends, but suffers from some problems: unequal load distribution if clients are themselves hidden behind proxies, stickyness errors when a client uses a dynamic IP address that changes during a session and loss of stickyness, if the mapping table overflows.

* Q: from Christopher to All Participants: Does that module also rewrite CSS and JS?
* A: Need to set mod_proxy_html::ProxyHTMLExtended flag to ¨on¨

* Q: What is suExec?
* A: see: http://httpd.apache.org/docs/2.4/suexec.html
   * provides users of the Apache HTTP Server the ability to run CGI and SSI programs under user IDs different from the user ID of the calling web server

* Q: Why would TransferLog be used over CustomLog (or vice-versa)?
* A: *TransferLog* is used to change the log file name only, not the log format.
     This is useful if you want to define a uniform log format for all log files (for several VHosts, for example) in one place using "LogFormat".
     *CustomLog* is useful to customize the log format as well, for example if you need additional information for one VHost.
  * See: https://httpd.apache.org/docs/2.4/mod/mod_log_config.html#comments_section

* Q: RE: `SetEnvIf` what are "aspects of the request"?
* A: See: https://httpd.apache.org/docs/2.4/mod/mod_setenvif.html#setenvif
| Aspect      | Notes |
|-------------|-------|
| Remote_Host | the hostname (if available) of the client making the request |
| Remote_Addr | the IP address of the client making the request |
| Server_Addr | the IP address of the server on which the request was received (only with versions later than 2.0.43) |
| Request_Method | the name of the method being used (GET, POST, et cetera) |
| Request_Protocol | the name and version of the protocol with which the requst was made (e.g., "HTTP/0.9", "HTTP/1.1", etc.) |
| Request_URI | the resource requested on the HTTP request line -- generally the portion of the URL following the scheme and host portion without the query string. See the RewriteCond directive of mod_rewrite for extra information on how to match your query string |


* Q: Do I need to enable and configure `mod_session` in order to use $_SESSION in PHP?
* A: No: PHP uses its own mechanism which bypasses the one used by `mod_session`

## GENERAL NOTES
* RE: /usr/local/apache2/bin/apachectl ? == help screen
* RE: HTTP2 ... suggest adding this to the section on Modules, or make it a new course section
* RE: Dynamic Shared Objects: http://httpd.apache.org/docs/2.4/dso.html
* RE: RewriteMap: http://httpd.apache.org/docs/2.4/mod/mod_rewrite.html#mapfunc
  * also: http://httpd.apache.org/docs/2.4/rewrite/rewritemap.html#txt
* RE: config section / httpd.conf: need to talk about <Location> and <Directory> directives
* RE: configuration sections: http://httpd.apache.org/docs/2.4/sections.html

* RE: mod_alias: stackoverflow.com regex summary: https://stackoverflow.com/questions/22937618/reference-what-does-this-regex-mean
* RE: mod_redirect: valid HTTP status codes:https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
* RE: mod_rewrite: examples of rewrite conditions: https://httpd.apache.org/docs/2.0/misc/rewriteguide.html
  * NOTE: is based on Apache 2.0 and needs to be updated

* RE: Proxy* directives:
  * ProxyPass : Maps remote servers into the local server URL-space : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypass
  * ProxyPassReverse: Adjusts the URL in HTTP response headers sent from a reverse proxied server : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypassreverse
  * ProxyPreserveHost: Use incoming Host HTTP request header for proxy request : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypreservehost
  * from Francois to All Participants: One thing that wasn't clear in the pdf, to get multiple instance running you need to change either ServerRoot or set different PidFile in each config file.

* RE: mod_rewrite: probably one of the most used features, but see if it can be made more concise, but add great examples
  * Remove sections which are straight out of the docs: add a reference to the docs

* RE: Module 9 Web Arch == focus on High Availability and get rid of config stuff

* RE: Any mention of Apache Tomcat (i.e. mod_jk), move to separate course module, optional, at the end

* RE: monitoring tools: kibana, zenoss, solarwinds, nagios, apachetop, iftop, tcpdump, apache bench

* RE: forward proxy: The client must be specially configured to use the forward proxy to access other sites.
* RE: PHP installation: these instructions are good for Centos: https://www.webhostinghero.com/centos-apache2-mariadb10-php7-setup/
  * Here is a ref to installing PHP and using a PHP-FPM worker:
  * https://blacksaildivision.com/php-install-from-source
  * https://wiki.apache.org/httpd/PHP-FPM

* RE: mod_status
```
<Location "/server-status">
    SetHandler server-status
    Require local
    Require ip 192.168.175.1
</Location>
```

* RE: Security
  * suEXEC: http://httpd.apache.org/docs/2.4/suexec.html
  * CGIWrap: https://github.com/cgiwrap/cgiwrap (last update Nov 2015!)
  * Suhosin: https://suhosin.org/stories/index.html
    * Two parts: a patch to the PHP core + a PHP extension which adds security functionality
  * `LimitExcept` is the inverse of `Limit`
    * See: http://httpd.apache.org/docs/2.4/mod/core.html#limit
    * See: http://httpd.apache.org/docs/2.4/mod/core.html#limitexcept
  * "Slow Loris" attack: Slowloris tries to keep many connections to the target web server open and hold them open as long as possible. It accomplishes this by opening connections to the target web server and sending a partial request. Periodically, it will send subsequent HTTP headers, adding to—but never completing—the request. Affected servers will keep these connections open, filling their maximum concurrent connection pool, eventually denying additional connection attempts from clients
    * See: https://en.wikipedia.org/wiki/Slowloris_(computer_security)
  * EPEL rpm repository == Extra Packages for Enterprise Linux
    * see: https://fedoraproject.org/wiki/EPEL
  * `readline` == The "readline" library will read a line from the terminal and return it
  * mod_security: https://www.modsecurity.org/
  * mod_security_crs: https://modsecurity.org/crs/
    * crs == Core Rule Set
  * ap_expr == Apache Expression Parser
    * see: https://httpd.apache.org/docs/current/expr.html
  * OS level tool `fail2ban` is when you have IP trying to login with SSH + can work with weblogs
  * mod_evasive -- info on that

* RE: mod_log_config
  * Format codes: https://httpd.apache.org/docs/2.4/mod/mod_log_config.html
  * NCSA = National Center for Supercomputing Applications
  * In the example shown:
```
LogFormat "%h %l %u %t \"%r\" %>s %b" common
CustomLog "logs/access_log" common
```
    * "common" is the format nickname

* RE: mod_setenvif
  * For more info on expressions: http://httpd.apache.org/docs/2.4/expr.html

## SSL etc.
* To find the VM version of openssl: `rpm -q openssl`
* To find where openssl is installed: `whereis openssl`
* To get a list of modules which are loaded: `apachectl -M`
* If you get an error `configure: WARNING: OpenSSL version is too old`
  * install the openssl development package: `yum install openssl-devel`
* Tutorial on creating certificates for mod_ssl on Centos 7: https://www.digitalocean.com/community/tutorials/how-to-create-an-ssl-certificate-on-apache-for-centos-7
* Excellent tutorial on installing httpd with ssl: https://www.rodneybeede.com/Building_Apache_2_4_for_Linux_with_mod_ssl.html
  * Oriented towards Ubuntu/Debian Linux so you'll need to adjust for Redhat/Fedora/CentOS
    * i.e. instead of `sudo apt-get install xxx` you would change to root (`su`) and then: `yum install xxx`
* This configure command seems to work:
```
./configure --with-included-apr --with-expat-lib --enable-ssl=shared --enable-mods-shared=all
```
  * TLS: https://en.m.wikipedia.org/wiki/Transport_Layer_Security
  * Good security overview: https://en.m.wikipedia.org/wiki/Transport_Layer_Security#Security
  * HEARTBLEED: Status of different versions:
    * OpenSSL 1.0.1 through 1.0.1f (inclusive) are vulnerable
    * OpenSSL 1.0.1g is NOT vulnerable
    * OpenSSL 1.0.0 branch is NOT vulnerable
    * OpenSSL 0.9.8 branch is NOT vulnerable
    * Bug was introduced to OpenSSL in December 2011 and has been out in the wild since OpenSSL release 1.0.1 on 14th of March 2012. OpenSSL 1.0.1g released on 7th of April 2014 fixes the bug.
  * POODLE:
    * The SSL 3.0 vulnerability stems from the way blocks of data are encrypted under a specific type of encryption algorithm within the SSL protocol. The POODLE attack takes advantage of the protocol version negotiation feature built into SSL/TLS to force the use of SSL 3.0 and then leverages this new vulnerability to decrypt select content within the SSL session. The decryption is done byte by byte and will generate a large number of connections between the client and server.
    * While SSL 3.0 is an old encryption standard and has generally been replaced by TLS, most SSL/TLS implementations remain backwards compatible with SSL 3.0 to interoperate with legacy systems in the interest of a smooth user experience. Even if a client and server both support a version of TLS the SSL/TLS protocol suite allows for protocol version negotiation (being referred to as the “downgrade dance” in other reporting). The POODLE attack leverages the fact that when a secure connection attempt fails, servers will fall back to older protocols such as SSL 3.0. An attacker who can trigger a connection failure can then force the use of SSL 3.0 and attempt the new attack. [1]
    * Two other conditions must be met to successfully execute the POODLE attack: 1) the attacker must be able to control portions of the client side of the SSL connection (varying the length of the input) and 2) the attacker must have visibility of the resulting ciphertext. The most common way to achieve these conditions would be to act as Man-in-the-Middle (MITM), requiring a whole separate form of attack to establish that level of access.
These conditions make successful exploitation somewhat difficult. Environments that are already at above-average risk for MITM attacks (such as public WiFi) remove some of those challenges.
    * Solution
      * There is currently no fix for the vulnerability SSL 3.0 itself, as the issue is fundamental to the protocol; however, disabling SSL 3.0 support in system/application configurations is the most viable solution currently available.
      * Some of the same researchers that discovered the vulnerability also developed a fix for one of the prerequisite conditions; TLS_FALLBACK_SCSV is a protocol extension that prevents MITM attackers from being able to force a protocol downgrade.
    * OpenSSL has added support for TLS_FALLBACK_SCSV to their latest versions and recommend the following upgrades: [5]
      * OpenSSL 1.0.1 users should upgrade to 1.0.1j.
      * OpenSSL 1.0.0 users should upgrade to 1.0.0o.
      * OpenSSL 0.9.8 users should upgrade to 0.9.8zc.
      * Both clients and servers need to support TLS_FALLBACK_SCSV to prevent downgrade attacks.
  * DROWN attack: https://en.m.wikipedia.org/wiki/DROWN_attack
  * Recent TLS https://en.m.wikipedia.org/wiki/DROWN_attack: https://cve.mitre.org/cgi-bin/cvekey.cgi?keyword=Tls
  * DH === Diffie-Hellman
  * HSTS: https://www.owasp.org/index.php/HTTP_Strict_Transport_Security_Cheat_Sheet
  * Elliptic Curve Cryptography: https://en.m.wikipedia.org/wiki/Elliptic-curve_cryptography
    * Before a client and server can begin to exchange information protected by TLS, they must securely exchange or agree upon an encryption key and a cipher to use when encrypting data (see Cipher). Among the methods used for key exchange/agreement are: public and private keys generated with RSA (denoted TLS_RSA in the TLS handshake protocol), Diffie-Hellman (TLS_DH), ephemeral Diffie-Hellman (TLS_DHE), Elliptic Curve Diffie-Hellman (TLS_ECDH), ephemeral Elliptic Curve Diffie-Hellman (TLS_ECDHE), anonymous Diffie-Hellman (TLS_DH_anon),[1] pre-shared key (TLS_PSK)[29] and Secure Remote Password (TLS_SRP).[30]
    * The TLS_DH_anon and TLS_ECDH_anon key agreement methods do not authenticate the server or the user and hence are rarely used because those are vulnerable to Man-in-the-middle attack. Only TLS_DHE and TLS_ECDHE provide forward secrecy.

* RE: Generating Certificates: see this tutorial: https://jamielinux.com/docs/openssl-certificate-authority/index.html
* RE: Firewall settings:
```
firewall-cmd --zone=public --add-port=443/tcp --permanent
firewall-cmd --reload
iptables -L
```
* Notes from slides:
```
If you encounter a situation where "configure" stops due to a missing dependency, and you have already installed the latest version, try to install the "*-devel" version.
Troubleshooting: look in "config.log" for clues.
If you get error from "bin/ld" try "ld --help" and then "ld -l<missing lib> --verbose"
Don't forget to run "make clean" after a failed "make" run
See: http://askubuntu.com/questions/514414/trying-to-compile-from-source-newest-apache-with-newest-openssl
```


### Procedure without using Intermediate Certs
#### Set up directory structure
* There already exists a directory structure: `/etc/pki/CA`
```
cd /etc/pki/CA
mkdir csr
touch index.txt
echo 1000 > serial
```
* Create `openssl.cnf` using example from https://jamielinux.com/docs/openssl-certificate-authority/_downloads/root-config.txt
#### Root Key and Certificate
* Create root key:
```
openssl genrsa -aes256 -out private/ca.key.pem 4096
chmod 400 private/ca.key.pem
```
  * Use `password` for the password
* Create the root certificate:
```
openssl req -config openssl.cnf -key private/ca.key.pem -new -x509 -days 7300 -sha256 -extensions v3_ca -out certs/ca.cert.pem
chmod 444 certs/ca.cert.pem
```
  * Answer the prompts
  * use `password` for the password
* Verify the root certificate: `openssl x509 -noout -text -in certs/ca.cert.pem`

#### Sign server and client certificates
* Create server key:
```
openssl genrsa -aes256 -out private/test.local.key.pem 2048
chmod 400 private/test.local.key.pem
```
  * Use `password` for the password
* Create signing request:
```
openssl req -config openssl.cnf -key private/test.local.key.pem -new -sha256 -out csr/test.local.csr.pem
```
  * Answer the prompts
  * Use `password` for the password
* Create certificate:
```
openssl ca -config openssl.cnf -extensions server_cert -days 375 -notext -md sha256 -in csr/test.local.csr.pem -out certs/test.local.cert.pem
chmod 444 certs/test.local.cert.pem
```
  * Use `password` for the password
* Verify the certificate:
```
openssl x509 -noout -text -in certs/test.local.cert.pem
```
#### Deploy the certificate
* Modify `/usr/local/apache2/conf/httpd.conf` as follows:
  * Remove the comment in front of this line (towards the end): `Include conf/extra/httpd-ssl.conf`
  * Enable these modules:
    * mod_socache_dbm
    * mod_log_config
    *

  * Make sure `mod_ssl` is *not* loaded in this file!
* Modify `/usr/local/apache2/conf/extra/httpd-ssl.conf` as follows:
  * Add this line towards the top: `LoadModule ssl_module modules/mod_ssl.so`
  * Change the VirtualHost block starting tag to this: `&lt;VirtualHost *:443&gt;`
  * Modify the server name as follows: `ServerName test.local:443`
  * Edit the location of the SSL certificate file: `SSLCertificateFile "/etc/pki/CA/certs/test.local.cert.pem"`
  * Edit the location of the SSL key file: `SSLCertificateKeyFile "/etc/pki/CA/private/test.local.key.pem"`
* Make sure the firewall allows HTTPS on port 443:
```
iptables -A INPUT -i lo -j ACCEPT
iptables -A INPUT -p tcp -m tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp -m tcp --dport 443 -j ACCEPT
iptables -L -n
iptables-save | sudo tee /etc/sysconfig/iptables
```
  * See: https://www.digitalocean.com/community/tutorials/how-to-set-up-a-basic-iptables-firewall-on-centos-6
  * See: https://crm.vpscheap.net/knowledgebase.php?action=displayarticle&id=29 (common iptables rules)
* Restart the server and fix any errors which might show up: `apachectl restart`
* Test using Lynx: `lynx https://test.local`
* Test from your browser outside the VM

### Setting up PHP using FastCGI
* See: https://github.com/dbierer/php-class-notes/blob/master/httpd-with-http2-and-fcgi.md
* Install PHP using the `--enable-fpm` configure switch
    * `php-fpm` is now included with any core installation of PHP
* Recompile Apache using these flags (in addition to any other flags you've been using): `--enable-proxy --enable-proxy-fcgi`
* Enable these modules:
    * mod_proxy
    * mod_proxy_fcgi
* Sample vhost config file (many thanks to Francois!):
```
<VirtualHost *:80>
    ServerAdmin webmaster@example.com
    DocumentRoot "/var/www"
    ServerName test.local
    ErrorLog "logs/test.local-error_log"
    CustomLog "logs/test.local-access_log" common
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin webmaster@test.local
    DocumentRoot "/var/www"
    ServerName php.test.local
    ServerAlias php.test.local
    ErrorLog "logs/php.test.local-error_log"
    CustomLog "logs/php.test.local-access_log" common
    <Directory "/var/www">
        Options Indexes FollowSymLinks
        DirectoryIndex index.php
        AllowOverride All
        Require all granted
    </Directory>
    ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://localhost:9000/var/www/$1
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
        DirectoryIndex index.php
        AllowOverride All
        Require all granted
    </Directory>
    ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://localhost:9000/var/www/$1
    SSLEngine on
    SSLCertificateFile "/etc/pki/CA/certs/test.local.cert.pem"
    SSLCertificateKeyFile "/etc/pki/CA/private/test.local.key.pem"
    <FilesMatch "\.(cgi|shtml|phtml|php)$">
        SSLOptions +StdEnvVars
    </FilesMatch>
</VirtualHost>
```

## EXAMPLES
* Created user `apache` using this command: `useradd apache`
* Modified `/usr/local/apache2/conf/httpd.conf` as follows:
  * Set user and group to `apache`
  * Added at end: `Include /usr/local/apache2/conf/extra/test.conf`
* Created the following:
  * `/usr/local/apache2/htdocs/test/index.html`
  * `/usr/local/apache2/htdocs/notest/index.html`
  * `/home/apache2/test/index.html`
* Create file: `/usr/local/apache2/conf/extra/test.conf` as follows:
```
<Location "/test">
  Header merge Cache-Control no-cache
  Header merge Cache-Control no-store
  Header unset ETag
  SetEnvIf TestReqHeader ABC HAVE_TestReqHeader
  Header set TestRespHeader "%D %t XYZ" env=HAVE_TestReqHeader
  Header set TestXXX "Hey ... how is it going Joe?"
</Location>
Alias "/home" "/home/apache/test"
<Directory "/home/apache/test">
  Require all granted
</Directory>
<Location "/unlikely">
  Redirect temp "https://unlikelysource.com/"
</Location>
```
* Example from in-class practical 10-Nov-2017:
  * Added this to `/usr/local/apache2/conf/httpd.conf`:
```
Include /usr/local/apache2/conf/extra/class.conf
```
  * Here is the contents of `class.conf`:
```
# allows use of .htaccess in the class directory
<Directory "/usr/local/apache2/htdocs/class">
  AllowOverride all
</Directory>
# any URL which starts with "/whatever" will be mapped to "/var/www/whatever"
Alias "/whatever" "/var/www/whatever"
# the web server is given access to this directory, which is outside the document root
<Directory "/var/www/whatever">
  Require all granted
</Directory>
# the URL "/something/zend" is captured by this Location section
<Location "/something/zend">
  RewriteEngine On
  # check to see if "/something/zend" is an actual directory on the filesystem
  RewriteCond %{REQUEST_FILENAME} -d
  # if so, just load [L] any content
  RewriteRule .* - [L]
  # otherwise, redirect to the zend website [R] == redirect
  RewriteRule .* http://zend.com/ [R]
</Location>
```

## HTTP2
* from Francois to All Participants: this is basically what I recreated to see for myself http://www.http2demo.io/
* configure command as per Francois:
```
./configure --enable-modules="php ssl rewrite deflate security" --with-included-apr --enable-http2 --enable-so --enable-proxy --enable-proxy-fcgi
```

## CORRECTIONS
Look for discussion on <Directory> and <Location> and move forward into the 2nd course module
Also mention where config can be placed: httpd.conf, a file included by same, or .htaccess
Implement advanced highlighting as per Daryl
Font size for tables needs to be increased!
Module 3: get rid of duplication with Module 2

### DONE
* Course_Materials/index.html#/1/21: need to update this
* Course_Materials/index.html#/1/19: link to apache.org doesn't work
* Course_Materials/index.html#/2/29: make sure the header which records timing is added to this lab solution
* Course_Materials/index.html#/2/52: missing end "
* Course_Materials/index.html#/2/70: improve formatting on table
* Course_Materials/index.html#/2/90: out of place?  SSL not enabled yet!
* Course_Materials/index.html#/3/17: change from /home/apache to /home/vagrant
* Course_Materials/index.html#/3/18: change from /home/apache to /home/vagrant
* Course_Materials/index.html#/3/24: need a link: http://httpd.apache.org/docs/2.4/mod/mod_log_config.html#formats
* Course_Materials/index.html#/3/26: `CustomLog` needs to go on next line
* Course_Materials/index.html#/3/26: s/be no space here: `logs/ english_log` and `logs/ non_english_log`
* Course_Materials/index.html#/3/30: link doesn't work! s/be http://httpd.apache.org/docs/2.4/mod/mod_log_config.html#formats
* Course_Materials/index.html#/3/33: http://httpd.apache.org/docs/2.4/mod/mod_log_config.html#bufferedlogs
* Course_Materials/index.html#/3/36: find example for GlobalLog; http://httpd.apache.org/docs/2.4/mod/mod_log_config.html#globallog
* Course_Materials/index.html#/3/43: http://httpd.apache.org/docs/2.4/logs.html#piped
* Course_Materials/index.html#/4/2: Google's new policy on HTTPS
* Course_Materials/index.html#/4/3: need a link: http://jmeter.apache.org/
* Course_Materials/index.html#/4/24: LoadModule ssl_module modules/mod_ssl.so Listen 443
* Course_Materials/index.html#/4/36: CSR = Certificate Signing Request
* Course_Materials/index.html#/4/47: need to add CentOS firewall command equivalent
* Course_Materials/index.html#/4/35: "ciph"???
* Course_Materials/index.html#/5/7: compresion
* Course_Materials/index.html#/5/11: update hardware specs + "Served"???
* Course_Materials/index.html#/5/58: consider removing the Apache Tomcat stuff
* Course_Materials/index.html#/6/13: what user?
* Course_Materials/index.html#/6/25: 2nd line: "apache" (lowercase a)
* Course_Materials/index.html#/6/28: dup
* Course_Materials/index.html#/6/29: dup
* Course_Materials/index.html#/6/36: change example to allow for HTTP2 as well
* Course_Materials/index.html#/7/17: missing "#" on top line
* Course_Materials/index.html#/7/53: 2nd to last bullet s/be "stale"
* Course_Materials/index.html#/7/56: last bullet s/be "stale"
* Course_Materials/index.html#/7/83: space before .htaccess
* Course_Materials/index.html#/7/88: scenariaio
* Course_Materials/index.html#/7/90: scenariaio

### TODO
* Course_Materials/index.html#/6/46: rewrite instructions for v3
* Course_Materials/index.html#/7/7:  update screenshot mod_status
* Course_Materials/index.html#/7/8:  refs to mod_benchmark???
* Course_Materials/index.html#/7/28: provide a use case for this + an example
* Course_Materials/index.html#/7/86: how do you flush buffers?

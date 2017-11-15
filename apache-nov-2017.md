# Apache Fundamentals Notes November 2017

NEED TO INCLUDE *ALL* SLIDES in PDF
WHERE WE LEFT OFF: http://localhost:8888/#/11/6


## Q&A
* Q: Which MPM is better, Event or Worker?
* A: see https://linuxtechme.wordpress.com/2014/11/04/mpm/

* Q: What is APSX?
* A: apxs - APache eXtenSion tool; a tool for building and installing extension modules
  See: https://httpd.apache.org/docs/trunk/programs/apxs.html

* Q: What is the performance gain/loss using APR?
* A: ???

* Q: What is meant by "Asynchronous" support for MPMs?
* A:

* Q: RPM vs. SRC considerations: make sure discussion is in mod 1

* Q: from Francois to All Participants: what is the support for IPv6 in Apache?
* A: from Todd Reed to All Participants: Apache does support dual stack
     TODO: find the module or configuration needed for this

* Q: Example of LAYOUT

* Q: from Francois to All Participants: with --with-expat=MPM why MPM?

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

* Q: from Christopher to All Participants: How can we see what ./configure flags a distribution used when building their verison of Apache?

* Q: from Francois to All Participants: do why it was installed as apache2 instead of httpd? is that the prefix argument?

* Q: from Christopher to All Participants: I can do httpd -V and get some info, but not all of the flags.

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

* Q: List of SSL hardware acceleration available?

* Q: from Christopher to All Participants: What is the difference between aNull and eNull?
* A: from James to All Participants: eNULL = ciphers offering no encryption, aNULL = cipher suites offering no authentication

* Q: How to you specify # instances?

* Q: What is the difference between SCGI and CGI?
* A: See: http://python.ca/scgi/protocol.txt
  * The SCGI protocol is a replacement for the Common Gateway Interface
    (CGI) protocol.  It is a standard for applications to interface with
    HTTP servers.  It is similar to FastCGI but is designed to be easier
    to implement.

* Q: What is "stickyness" in regards to `mod_proxy_balancer`?
* A: See: https://httpd.apache.org/docs/2.4/mod/mod_proxy_balancer.html#stickyness
  * When a request is proxied to some back-end, then all following requests from the same user should be proxied to the same back-end. Many load balancers implement this feature via a table that maps client IP addresses to back-ends. This approach is transparent to clients and back-ends, but suffers from some problems: unequal load distribution if clients are themselves hidden behind proxies, stickyness errors when a client uses a dynamic IP address that changes during a session and loss of stickyness, if the mapping table overflows.


## ERRATA
* 52: must Linux s/be most Linux
* 52: bad char in code
* 78: Shared (Dynamic) vs Static Libraries: img needs width
* 129: missing 1st example: `Header echo ^TS`shown on next slide
* 185 URL-path is is omitted: remove duplicate "is"
* 196: last screenshot `ScriptAlias` directive needs to be swapped with the screenshot on p. 197
* 216: update to php7
* 225: "Servers that are heaving on serving" s/be "Servers that are heavy on serving"
* 249: img needs width
* 272: img needs width
* 276: img too big
* 293: need ref for more detail
* 316: usemod_cache
* 330: Mod Cluster: out of place???
* 331: Advantages of mod_cluster: out of place???
* 365: mod_cluster and Load Balancing 4: funny chars in <code> block
* http://localhost:8888/#/2/7: s/ not be "MPMs server"
* http://localhost:8888/#/4/28: s/be "-h" not "- h" and "-V" not "- V" etc.
* http://localhost:8888/#/5/5: mod_cache *not* shown above"!
* http://localhost:8888/#/6/9: get rid of space after "/"
* http://localhost:8888/#/6/11: get rid of space after "/"
* http://localhost:8888/#/6/12: move lab to end of course module
* http://localhost:8888/#/4/12: move this slide to before slide on rpmbuild!
* http://localhost:8888/#/6/10: step 5: HTTPS not available yet
* http://localhost:8888/#/7/17: http://httpd.apache.org/docs/2.4/expr.html
* http://localhost:8888/#/7/42: flag s/be "-h" NOT "-H"
* http://localhost:8888/#/7/42: "regular" file or ... ????
* http://localhost:8888/#/7/44: mismatch between text and graphic
* http://localhost:8888/#/7/45: RewriteEngine on == "on" s/be bold
* http://localhost:8888/#/7/48: should make clear that this is a separate subject: i.e. enabling mod_rewrite + move this unit before discussion on config
* http://localhost:8888/#/7/60: from Francois to All Participants: locationmatch saves as <NUMBER> but reads as MATCH_NUMBER, is that normal or an error?
* http://localhost:8888/#/7/71: text and screenshot do not match
* http://localhost:8888/#/8/13: “NameVirtualHost” directive has been deprecated
* http://localhost:8080/index.html#/9/36: Link is broken: use this: https://jamielinux.com/docs/openssl-certificate-authority/appendix/root-configuration-file.html
* http://localhost:8080/index.html#/9/39: move the openSSL directory to httpd-xxx/srclib/openssl ... don't worry about the version
* http://localhost:8080/index.html#/9/39: `--with-ssl=` flag is incorrect; s/be:
```
--with-ssl=/usr/local/src/httpd-2.4.x/srclib/openssl
```
* http://localhost:8888/#/9/5: from Francois to All Participants: why is this slide here (in http vs https)?
  * maybe move to security or config section
* http://localhost:8888/#/9/18: need to update this chart + browser versions
* http://localhost:8888/#/9/22: SSL v3 date not mentioned; v2 mentioned 2x
* http://localhost:8888/#/9/27: Listen s/be on its own line
* http://localhost:8888/#/9/28: from Christopher to All Participants: That SSLHonorCipherOrder on should be on a new line
* http://localhost:8888/#/9/29: missing # on 1st line
* http://localhost:8888/#/9/29: might be better to default to a higher level of security, and then "allow" lower levels in certain non-sensitive areas of the website
* http://localhost:8888/#/9/36: correct link: https://jamielinux.com/docs/openssl-certificate-authority/appendix/root-configuration-file.html
* http://localhost:8888/#/9/42: rewrite this a bit: from Christopher to All Participants: I think you meant configure it to use the certificate and key
* http://localhost:8888/#/9/55: assumes you've created an Apache user
* http://localhost:8888/#/10/4-6: just pull linger_close() discussion out: confuses more then helps
* http://localhost:8888/#/10/7: dup slide from config section (?verify)
* http://localhost:8888/#/10/12: need to add references

RE: forward proxy: The client must be specially configured to use the forward proxy to access other sites.
RE: PHP installation: these instructions are good for Centos: https://www.webhostinghero.com/centos-apache2-mariadb10-php7-setup/
Here is a ref to installing PHP and using a PHP-FPM worker:
https://blacksaildivision.com/php-install-from-source
https://wiki.apache.org/httpd/PHP-FPM

## GENERAL NOTES

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

## SSL etc.
* To find the VM version of openssl: `rpm -q openssl`
* To find where openssl is installed: `whereis openssl`
* To compile Apache with built-in ssl:
```
./configure --with-included-apr --with-ssl=/usr/lib64/openssl
```
* To get a list of modules which are loaded: `apachectl -M`
* If you get an error `configure: WARNING: OpenSSL version is too old`
  * install the openssl development package: `yum install openssl-devel`
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


## FEEDBACK
* from Francois to All Participants: the steps of this entire modules is weird, I had to go back and forth a few times
* from self: http://localhost:8888/#/7/4: more practical examples
* from self: http://localhost:8888/#/7/10: more practical examples
* from self: http://localhost:8888/#/7/17: more practical examples
* from self: http://localhost:8888/#/7/36: more practical examples for this entire section
* from Maroun to All Participants: I would like to see example which covers the whole flow, how you set header and how it affects the request in browser and how the response looks like
* from self: practical use cases encompassing the whole thing
* from self: Headers chapter: convert screenshots of code examples to text blocks which can be copied + get the order straight
* from Francois to All Participants: course feedback -- personally, I think you should talk about mod_alias first and then go with "if you need more, here is what you can do with mod_rewrite" because at this point, I'm not sure what mod_rewrite can do that alias can't (except rewrite condition I guess).
* from self: Headers / Rewrite Lab
  * Create ScriptAlias for server side includes
  * Create html with ssi date
  * Don’t do PHP
* from Francois to All Participants: I know you did not write these examples, but you know we are not supposed to use port 81-83? anything under 1024 (if I remember correctly) are reserved for specific apps
* from Francois to All Participants: have cert and vhost first and multi instance and proxy after to me cert and vhost is something we do all the time so I think it should be first
* from self: combine multi-instance w/ proxy course chapters
* from self: add lab using separate config for each instance
* from Christopher Young to All Participants: I would offer everyone one word of warning...
apachectl configtest doesn't catch all SSL related errors that would stop your server from starting up
You can have properly stuctured configuration but if your cert and key are messed up, it won't point it out

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

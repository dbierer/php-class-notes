# Apache Fundamentals Notes November 2017

NOTE TO SELF: scrub last names

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

## ERRATA
* 52: must Linux s/be most Linux
* 52: bad char in code
* 129: missing 1st example: `Header echo ^TS`shown on next slide
* 185 URL-path is is omitted: remove duplicate "is"
* 196: last screenshot `ScriptAlias` directive needs to be swapped with the screenshot on p. 197
* 216: update to php7
* 225: "Servers that are heaving on serving" s/be "Servers that are heavy on serving"
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

## GENERAL NOTES
* RE: Dynamic Shared Objects: http://httpd.apache.org/docs/2.4/dso.html
* RE: RewriteMap: http://httpd.apache.org/docs/2.4/mod/mod_rewrite.html#mapfunc
  * also: http://httpd.apache.org/docs/2.4/rewrite/rewritemap.html#txt
* RE: config section / httpd.conf: need to talk about <Location> and <Directory> directives
* RE: mod_alias: stackoverflow.com regex summary: https://stackoverflow.com/questions/22937618/reference-what-does-this-regex-mean
* RE: mod_redirect: valid HTTP status codes:https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
* RE: mod_rewrite: examples of rewrite conditions: https://httpd.apache.org/docs/2.0/misc/rewriteguide.html
  * NOTE: is based on Apache 2.0 and needs to be updated
* RE: configuration sections: http://httpd.apache.org/docs/2.4/sections.html
* RE: Proxy* directives:
  * ProxyPass : Maps remote servers into the local server URL-space : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypass
  * ProxyPassReverse: Adjusts the URL in HTTP response headers sent from a reverse proxied server : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypassreverse
  * ProxyPreserveHost: Use incoming Host HTTP request header for proxy request : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypreservehost
* RE: mod_rewrite: probably one of the most used features, but see if it can be made more concise, but add great examples
  * Remove sections which are straight out of the docs: add a reference to the docs
* RE: TLS Security etc.
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

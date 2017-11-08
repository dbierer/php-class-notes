# Apache Fundamentals Notes November 2017

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

* Q: from Francois Dupras to All Participants: what is the support for IPv6 in Apache?
* A: from Todd Reed to All Participants: Apache does support dual stack
     TODO: find the module or configuration needed for this

* Q: Example of LAYOUT

* Q: from Francois Dupras to All Participants: with --with-expat=MPM why MPM?

* Q: Log format codes docs?
* A: http://httpd.apache.org/docs/2.4/mod/mod_log_config.html

* Q: from Christopher Young to All Participants: How can we see what ./configure flags a distribution used when building their verison of Apache?
* Q: from Francois Dupras to All Participants: do why it was installed as apache2 instead of httpd? is that the prefix argument?
* Q: from Christopher Young to All Participants: I can do httpd -V and get some info, but not all of the flags.
* Q: re: the “SetHandler” directive: what handlers are available?
* A: see:https://httpd.apache.org/docs/current/handler.html
* Q: how do I set PHP as a “handler” for *.php requests?
* A: see:http://php.net/manual/en/install.unix.apache2.php

## ERRATA
* 52: must Linux s/be most Linux
* 52: bad char in code
* 129: missing 1st example: `Header echo ^TS`shown on next slide
* 185 URL-path is is omitted: remove duplicate "is"
* 196: last screenshot `ScriptAlias` directive needs to be swapped with the screenshot on p. 197
* 216: update to php7
* http://localhost:8888/#/2/7: s/ not be "MPMs server"
* http://localhost:8888/#/4/28: s/be "-h" not "- h" and "-V" not "- V" etc.
* http://localhost:8888/#/5/5: mod_cache *not* shown above"!
* http://localhost:8888/#/6/9: get rid of space after "/"
* http://localhost:8888/#/6/11: get rid of space after "/"
* http://localhost:8888/#/6/12: move lab to end of course module
* http://localhost:8888/#/4/12: move this slide to before slide on rpmbuild!
* http://localhost:8888/#/6/10: step 5: HTTPS not available yet
* http://localhost:8888/#/7/17: http://httpd.apache.org/docs/2.4/expr.html

## GENERAL NOTES
* RE: Dynamic Shared Objects: http://httpd.apache.org/docs/2.4/dso.html
* RE: RewriteMap: http://httpd.apache.org/docs/2.4/mod/mod_rewrite.html#mapfunc
* RE: config section / httpd.conf: need to talk about <Location> and <Directory> directives
* RE: mod_alias: stackoverflow.com regex summary: https://stackoverflow.com/questions/22937618/reference-what-does-this-regex-mean
* RE: mod_redirect: valid HTTP status codes:https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
* RE: mod_rewrite: examples of rewrite rules/conditions: 
https://httpd.apache.org/docs/2.0/misc/rewriteguide.html
NOTE: is based on Apache 2.0 and needs to be updated
* RE: configuration sections: http://httpd.apache.org/docs/2.4/sections.html
* RE: Proxy* directives:
  * ProxyPass : Maps remote servers into the local server URL-space : 
http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypass
  * ProxyPassReverse: Adjusts the URL in HTTP response headers sent from a reverse proxied server : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypassreverse
  * ProxyPreserveHost: Use incoming Host HTTP request header for proxy request : http://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypreservehost

 
## FEEDBACK
* from Francois Dupras to All Participants:
the steps of this entire modules is weird, I had to go back and forth a few times
* from self: http://localhost:8888/#/7/4: more practical examples
* from self: http://localhost:8888/#/7/10: more practical examples
* from self: http://localhost:8888/#/7/17: more practical examples
* from self: http://localhost:8888/#/7/36: more practical examples for this entire section
* from Maroun Sleiman to All Participants: I would like to see example which covers the whole flow, how you set header and how it affects the request in browser and how the response looks like
* from self: practical use cases encompassing the whole thing
* from self: Headers chapter: convert screenshots of code examples to text + get the order straight

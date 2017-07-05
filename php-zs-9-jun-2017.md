--------------------------------------------------------------------------------------------------------------------
# ZEND SERVER FUNDAMENTALS -- CLASS NOTES -- JUNE 2017
--------------------------------------------------------------------------------------------------------------------
* http://downloads.zend.com/zendserver/9.1.0/ZendServer-9.1.0-RepositoryInstaller-linux.tar.gz

* Web API: http://files.zend.com/help/Zend-Server/content/web_api_reference_guide.htm

--------------------------------------------------------------------------------------------------------------------
## ERRATA
--------------------------------------------------------------------------------------------------------------------
* p. 056: should also add port 443 == https
* p. 057: s/be apache 2.4 not 2.2
* p. 084: the /etc/hosts file does not match up with the list on this page
* p. 088: s/be Applications | Manage Apps | Deploy Application
* p. 089: the last 4 bullet points duplicate the 1st 4
* p. 109: need to add stuff on IBMi
* p. 174: exercise number should be "M6Ex0"
* p. 261: username = "administrator" and password = "password"
* p. 308: there is no final project!!!
* p. 310: no IBMi path
* p. 310: should be "libraries" not "libaries"!!!
* p. 312: for IBMI: /www/zendphp7/htdocs

NOTE: pages reference the PDF file

--------------------------------------------------------------------------------------------------------------------
## LAB NOTES:
--------------------------------------------------------------------------------------------------------------------
* M4Ex3: Zend Server Deployment
  * got message from Zend Studio created package: invalid package file
    * need to use "application" for the "Application Directory"
    * Also: change the vhost template document root back to "${docroot}"
* M5Ex1: Z-Ray Selective Mode
  * ZRayDisable=1 doesn't work
    * Works when Z-Ray Mode == Enabled
    * When Z-Ray Mode == Selective you don't need to do this!
* M5Ex2: Z-Ray Mobile Access
  * api.test demo: get error message: PHP cli not installed
    * use this path: "/usr/local/zend/bin/php sample_client.php"
  * getting 404 error from api.test:8888/api/widget/test
    * need to enter "8888" for the port when first adding the vhost
    * need to add "Listen 8888" as the 1st line of the vhost template
* M7Ex2: Apache Bench Test
  * Make sure you run apache bench BEFORE setting up the page for caching!!!

--------------------------------------------------------------------------------------------------------------------
## Q & A
--------------------------------------------------------------------------------------------------------------------
* Q: How do I do the equivalent of zs-client.sh on the IBMi?
* A: Still researching

* Q: How do I reset permissions for Apache logs?
* A: The username used by the Zend Server GUI is "zend".  You can either add this user to the group owning the log files
   (located under /var/log/apache2/* in Debian / Ubuntu Linux), or you can add "r" permissions to "other"
   sudo o+r /var/log/apache2/*

* Q: Where do I find IBMi libraries and the GUI database?
* A: You can find all libraries under: /usr/local/zendphp7/var/libraries/
   and db under: /usr/local/zendphp7/var/db
   
* Q: How do I deploy a package using Zend Studio?
* A: 1. File | Configure | Add Deployment Support
   2. Fill in the form
   3. Just use "application" for the "Application Folder"
   4. Click "Deploy Application"

* Q: What are some considerations for running ZS 8.5 and ZS 9.1 in parallel?
   Also: any special considerations for IBMi in this case?
* A: [4:11:02 PM] mickey hoter: For IBM i, it is not uncommon for the customer to have a single machine running a 
   single partition (a partition is sort of like a virtual machine).  So, for major release upgrades that require 
   significant application testing, running in parallel is the only way for the customer to have access to the new 
   version for testing while continuing to run the old version in production.  Even when there is a developer partition, 
   it can be important to have the old version to compare results against the new version when testing.  
   BTW we had specific customer requests to do that.

* Q: How to update PHP extensions?
* A: The OS will do the updates.  When you first install ZS, it gives you a list of the PHP extensions in the form
   of packages suitable for your target verson of PHP and your OS.  So, for example, the PHP "intl" extension
   for PHP 7.1 on Ubuntu linux would be "php7.1-intl"

* Q: RE: path to deployment files on IBMi?
* A: /usr/local/zendphp7/var/data/__default__/0/*

* Q: I made a change to a couple of settings in the PHP | Extensions menu but they're not showing up in the php.ini file.
   How do I get the changes to show up?
* A: You need to click on "Save" to write the changes out to the php.ini (or *.ini file for extensions).
   You'll also need to restart the server, in some cases, to make the changes effective.
   
* Q: When running ZS 8.5 + ZS 9.1 in parallel, noticed there were 2 different versions of the extensions
   What's going with that?
* A: It's possible that the ZS 8.5 installation is running PHP 5.x whereas the ZS 9.1 installation is running PHP 7.x.
   This would account for the differences.

* Q: from Lakshmi to All Participants:
   RE:deployment: is there a way to deploy an existing project in amazon cloud?
* A: Deployment of applications (I assume this is what you mean when you say project) is the same regardless of 
   the physical location of Zend Server. Using ZPKs, This can be done either through the web GUI of Zend Server 
   or by using the web API.

* Q: from Matt to All Participants:
   is there a way to programatically export the settings?
* A: yes: using zs-client.sh == configurationExport
   Or: backup /usr/local/zend/var/db/gui.db
   Or: run a script which runs and sqlite command to dump data from /usr/local/zend/var/db/gui.db
   
* Q: from Matt to All Participants:
   is the internal database sqlite on an AS400?
   also, is this also the case for Zend Server running on IBMi, or in this case is the data stored some place else?
* A: That is correct. Once moving to cluster, mysql is required and the data is kept for all the cluster servers centerally. 
   In the case of IBMi for 9.1 this is the first time we introduce cluster, on Zend DBi whic is MariaDB.

* Q: from Matt to All Participants:
   another question, is there a way to have multiple developer accounts in zend server to track who does what 
   if we have multiple devs
* A: ZS can integrate with LDAP system to get more users other than just Admin/Dev. 
   Along with the Audit feature one can tell who did what on the server
   For LDAP goto adminstration ->users-> settings->extended authentication
   
* Q: Can you just use sqlite to add users to /usr/local/zend/var/db/gui.db?
* A: It is not possible to add users, and not recommended to try hacks for doing so...

* Q: How can you add a PHP extension not listed with Zend Server
* A: CAUTION: the extensions included with Zend Server are certified and pre-tested: guaranteed to work together ...
   HOWEVER ... you can copy *.so files to /usr/local/zend/lib/php_extensions and 
   add a *.ini file with ¨extension=xxx.so¨ to /usr/local/zend/etc/conf.d

* Q: Where are the ZF files located?
* A: from James to All Participants:
   Here is what find I found on the VMs:  
   /usr/local/zend/var/libraries/Zend_Framework_2/2.4.11/library/Zend
   /usr/local/zend/var/libraries/Zend_Framework_1/1.12.20/library/Zend
   /usr/local/zend/include/php/Zend
   /usr/local/zend/gui/vendor/ZF2/library/Zend
   /usr/local/zend/share/zs-cli-tools/library/Zend/home/vagrant/Zend

* Q: Is Zend Guard included in ZS 9?
* A: No.  It is a separate product that will not developed further, but it is still supported

* Q: Can you provide examples using the Web API?
* A: The documentation is here: http://files.zend.com/help/Zend-Server/content/web_api_reference_guide.htm
   Web API ZF Module: https://github.com/zend-patterns/ZendServerWebApiModule
   SDK for Web API: https://github.com/zend-patterns/ZendServerSDK
   Sample code (3 years old but should work OK): https://github.com/zend-patterns/SamplesWebAPI


# Zend Server Training -- May 2020

## TODO
* Q: Can you write an example of caching the results of prime generation ?

* Q: Can I create a "plugin" similar to the demo apps (e.g. drupal) to deploy from a github repo?
* Q: Can you locate the `deployment.xml` files for the sample apps included w/ Zend Server (e.g. drupal)?
* Q: Can you locate the deployment hook scripts for the sample apps included w/ Zend Server (e.g. drupal)?
* Q: How can I export rules?  Nothing appears in the XML file.

* Q: Why can I not access the Cache Pulse screen?  It's greyed out.
* A: Make sure the component is enabled (Adminstration > Components) + somebody needs to access the page to generate data for the pulse.

## Homework
* For vendredi 29
  * Lab: Adjust Permissions for Apache Log Monitoring
  * Lab: Add a New Application Log
  * Lab: Slow Request Execution Event
  * Lab: Monitoring PHP Errors
  * Lab: Page Caching Pulse Test
  * Lab: Blacklisting
  * Lab: Change Profile
* For jeudi 28
  * Lab: Virtual Host Setup
  * Lab: Deploy Demo Package
  * Lab: Application Packaging and Deployment
  * Lab: Joining a Cluster
* For mercredi 27
  * Lab: Zend Server Manual Installation
    * For class, use: `sudo apt-get install zend-server-apache-fpm`
    * Root password: `vagrant`
  * Lab: Component Enable Verification
  * Lab: Monitor Settings for Directives
  * Lab: Web API Keys Generation
  * Lab: Zend Server Command Line
  * Lab: zs-client

## Installation
* https://docs.roguewave.com/en/zend/current/content/installation_guide.htm

## Class Notes
* Zend Debugger
  * Toolbar for Firefox: https://addons.mozilla.org/en-US/firefox/addon/zend-debugger-toolbar/?src=search
  * IDE Setup: https://www.jetbrains.com/help/phpstorm/configuring-zend-debugger.html#
* Example using `zs-client.sh`:
```
sudo /usr/local/zend/bin/zs-client.sh getServerInfo --serverId=0 --zskey=test --zssecret=0bbc693cd0506c12b56e1ba307561d3961e05772a86f57b644e28ea0f3180b21 --output-format=json
```
* Basic Docker commands (you can use these in the VM):
  * List of containers that are running: `docker container ls`
  * Shell into a container:
```
docker exec -it <CONTAINER> /bin/bash
```
  * Run a command from *outside* Docker:
```
docker exec <CONTAINER> /bin/bash -c "command"
```
  * To start/stop the 3 Docker containers:
```
cd ~/Docker
docker-compose up -d | down
```

* Info on `deployment.xml` file:
  * https://docs.roguewave.com/en/zend/current/content/understanding_the_application_package_structure.htm
* Info on PHP-FPM: https://www.php.net/manual/en/install.fpm.php
* Example of `composer.json` file with installation (deployment) scripting:
  * https://github.com/mezzio/mezzio-skeleton/blob/master/composer.json

## Tools
* Change password:
```
sudo php /usr/local/zend/bin/gui_passwd.php <PASSWORD>
```
* Start/stop *all* ZS daemons:
```
sudo /usr/local/zend/bin/zsd.sh start|stop|restart|status
```

## ZS Databases
* Location: `/usr/local/zend/var/db`
* To edit database "XXX":
```
sqlite3 /usr/local/zend/var/db/XXX.db
```
* If you need to change the password "manually" (assumes the new password is "password"):
```
$ su root
# php -r "echo hash('sha256', 'password');"
# sqlite3 /usr/local/zend/var/db/gui.db
sqlite> -- locate the ID of the "admin" user:
sqlite> select * from GUI_USERS;
sqlite> update GUI_USERS set PASSWORD="hash from PHP command above" where ID="ID for admin";
sqlite> .exit
```
WARNING: the above procedure can wipe out your installation if a mistake is made!

## Q & A
* Q: What is the relationship between /usr/local/zend/etc/conf.d/*.ini and the GUI components menu?
* A: There is a 1-to-1 correspondance.  All of the settings in these *.ini files are accessible via the Components menu.

* Q: How can I view Apache log files using GUI _Monitoring_ :: _Logs_?
* A: Add the user `zend` to the `adm` group (or equivalent admin group):
```
sudo usermod -G adm zend
```
* Q: How can I generate a web API key from command line?

## Test Code
Code examples that will cause problems:
* Unbridled array nesting:
```
<?php
// unbridled nesting
function addLayer($array)
{
    $array = array_combine(range('A','Z'),range('A','Z'));
    foreach ($array as $element) {
        addLayer($array[$element]);
    }
}

$wild = [];
addLayer($wild);
var_dump($wild);
```
* Prime number generation:
```
<?php
// prime number generator
$count  =  0;
$number =  2;
$max    = 999999;
while ($count < $max ) {
    $div_count = 0;
    for ( $i = 1; $i <= $number; $i++) {
        if (($number%$i) == 0) {
            $div_count++;
        }
    }
    if ($div_count < 3) {
        echo $number." , ";
        $count += 1;
    }
    $number += 1;
}
```
* Recursing through a directory structure:
```
<?php
// recursion through entire www directory (be sure "www-data" user has rights)
$path = realpath('/path/to/dir/with/lots/of/files');
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path),
										 RecursiveIteratorIterator::SELF_FIRST);
$rows = '<table>';
$count = 0;
foreach($objects as $name => $object){
	$color = ($count++ & 1) ? '#FFFFEE' : '#FFFFDD';
	if ($object->isDir()) {
		$rows .= sprintf('<tr bgcolor="%s"><td colspan=2>%s</td></tr>' . PHP_EOL, $color, $name);
	} else {
		$rows .= sprintf('<tr bgcolor="%s"><td width="10px;">&nbsp;</td><td>%s</td><td>%s</td></tr>' . PHP_EOL,
						  $color, $object->getPath(), $object->getBasename());
	}
}
$rows .= '</table>';
echo $rows;
```
* Example `deployment.xml` for a Mezzio (formerly Zend Expressive) application
```
<?xml version="1.0" encoding="utf-8"?>
<package version="2.0" xmlns="http://www.zend.com/server/deployment-descriptor/1.0">
  <type>application</type>
  <name>mezzio</name>
  <summary>Mezzio micro-framework skeleton app</summary>
  <description>Mezzio micro-framework skeleton app</description>
  <version>
    <release>0.2</release>
  </version>
  <eula>LICENSE.md</eula>
  <appdir></appdir>
  <docroot>public</docroot>
  <scriptsdir>scripts</scriptsdir>
  <healthcheck>http://mezzio/</healthcheck>
  <dependencies>
    <required>
		<php>
			<min>7.1</min>
		</php>
		<extension>
			<name>pdo_mysql</name>
		</extension>
		<directive>
			<name>memory_limit</name>
			<min>16M</min>
		</directive>
    </required>
  </dependencies>
  <parameters>
    <parameter id="locale"
    display="Locale Settings.Locale"
    required="true" type="choice">
    <validation>
    <enums>
    	<enum>GMT</enum>
    	<enum>other</enum>
    </enums>
    </validation>
      <description></description>
    </parameter>
    <parameter id="db_host"
    display="Database Connection.Host"
    required="true" type="string">
      <description>
        You can specify server port, ex.: localhost:3307 If
        you are not using default UNIX socket, you can specify it
        here instead of host, ex.:
        /var/run/mysqld/mysqld.sock
      </description>
    </parameter>
    <parameter id="db_name"
    display="Database Connection.Database Name"
    required="true" type="string">
      <defaultvalue>wikiblog</defaultvalue>
      <description>

      </description>
    </parameter>
    <parameter id="db_username"
    display="Database Connection.User Name"
    required="true" type="string">
      <defaultvalue>vagrant</defaultvalue>
      <description>

      </description>
    </parameter>
    <parameter id="db_password"
    display="Database Connection.User Password"
    required="false" type="password">
      <defaultvalue></defaultvalue>
      <description>

      </description>
    </parameter>
    <parameter id="skip_base"
    display="Web access options.Skip Base URL Validation Before the Next Step"
    required="false" type="checkbox">
      <defaultvalue>false</defaultvalue>
      <description>
        Check this box only if it is not possible to
        automatically validate the Base URL.
      </description>
    </parameter>
  </parameters>
</package>
```
## Course Timing:
* Day 1: Module 1 to Module 5 (Virtual Host Management)
* Day 2: Module 5 to Module 6 (Monitoring > Logs)
* Day 3: Module 6 to Module 9 (Debugging)
* Day 4: Module 9 to the End


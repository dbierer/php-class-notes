# ZF Fundamentals June 2019

## Labs
* For Wed 12 Jun 2019
  * Lab: fix the Apache vhost definition for `onlinemarket.work` as shown below
  * Lab: install the Zend Framework skeleton app as described in the lab instructions
    * Recommendation: don't do steps 4 and 5 (so that you'll see the error message associated with missing modules later)
  * Lab: Integrating an Existing Module
    * https://github.com/zendframework/zend-developer-tools
## Class Discussion
* New "home" for Zend Framework in the future:
  * https://www.linuxfoundation.org/blog/2019/04/lf-forms-laminas-project/
  * https://getlaminas.org/
* ZF2 vs. ZF3
  * https://github.com/dbierer/ZF2_ZF3_Side_by_SIde
## TODO
* Troubleshoot VM web server issues
* Need to modify the virtual host definition for `onlinemarket.work` as follows:
  * From the VM open a terminal window
  * Run `gedit` as the root user:
```
sudo gedit /etc/apache2/sites-available/onlinemarket.work/conf
```
  * Add `onlinemarket.work` after the `ServerName` directive
  * When done, the config file should look like this:
```
<VirtualHost *:80>
	ServerName onlinemarket.work
	DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/onlinemarket.work/public
	<Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/onlinemarket.work/public/>
		Options Indexes FollowSymlinks MultiViews
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```
  * Perform a config test to make sure the syntax is correct:
```
sudo apachectl configtest
```
  * Restart the web server as follows:
```
sudo service apache2 start
```

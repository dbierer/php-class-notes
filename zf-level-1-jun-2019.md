# ZF Fundamentals June 2019

## TODO
* Troubleshoot VM web server issues
  * Notify Isha when done: isha.negi19@gmail.com
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

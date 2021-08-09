# PHP-Exp Aug 2021

## Homework

## Class Notes
  
## Resources
Previous class notes:

## VM Setup
Download the source code.  From a terminal window in the VM:
```
cd ~/Zend/workspaces/DefaultWorkspace
wget https://opensource.unlikelysource.com/php-exp-src.zip
unzip php-exp-src.zip
```
Set up the `sandbox` as an Apache virtual host
```
sudo cp /etc/apache2/sites-available/orderapp.conf /etc/apache2/sites-available/sandbox.conf
```
Apache vhost definition:
```
<VirtualHost *:80>
	 ServerName sandbox
	 DocumentRoot /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox
	 <Directory /home/vagrant/Zend/workspaces/DefaultWorkspace/sandbox/>
		 Options Indexes FollowSymlinks MultiViews
		 AllowOverride All
		 Require all granted
	 </Directory>
 </VirtualHost>
```
Enable the virtual host
```
sudo a2ensite sandbox.conf 
sudo service apache2 restart
```
Add an entry to the `/etc/hosts` for `sandbox`
```
sudo gedit /etc/hosts
127.0.0.1 sandbox
```


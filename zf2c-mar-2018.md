# ZF2C NOTES March 2018

## General Notes
* Just for fun: https://pageconfig.com/post/portable-utf8

### Utility
* Hydrators
    * Look at Zend\Stdlib\Hydrator\AbstractHydrator to see how strategies are used
    * Have a look at Zend\Stdlib\Hydrator\ClassMethods::__construct() for examples of adding filters

### Authentication
* S/be Zend\Permissions\Rbac NOT Zend\Permissions\RBAC

## 2nd Quiz
* RE: Zend\Cache\Storage\StorageInterface is correct, but exam said it was wrong,  but then listed as answer

### Forms
* `InputFilterManager` should be `InputFilterPluginManager`

### Filters
* In the slide "Filter Chains (Priority Example)" should be `new` and not "nw"

### Revised VM Notes

* The structure for this project is based on the original ZF2 Skeleton App
* All code examples are in the `public` folder

#### REQUIREMENTS TO RUN EXAMPLES
* PHP 5.6 recommended
  * DO NOT USE PHP 7.2!!!
* ZF 2.2.10
* MySql
  * Data dump is in file `zend.sql`

#### Revised Vagrantfile:
* Unzip the ZF2C zip file you received in the email
* Copy this into `Vagrantfile`
```
# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'
VM_DISPLAY_NAME = 'ZF2C_Cert'

@script = <<SCRIPT
echo "Updating APT repos"
apt-get update
echo "Installing OpenSSL"
apt-get install -y openssl
echo "Installing PHP5"
apt-get install -y php5-cli php5-intl
ln -s /usr/bin/php5 /usr/bin/php
echo "Done"
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "bento/ubuntu-14.04-i386"
  config.vm.network "forwarded_port", guest: 80, host: 8888
  config.vm.hostname = "vagrant.local"
  config.vm.synced_folder '.', '/var/www/zf'
  config.vm.provision 'shell', inline: @script
  config.vm.network "forwarded_port", guest: 80, host: 8888, host_ip: "127.0.0.1"
  config.vm.provider "virtualbox" do |vb|
    vb.gui = true
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--cableconnected1", "on"]
    vb.customize ["modifyvm", :id, "--name", VM_DISPLAY_NAME]
    vb.customize ["modifyvm", :id, "--accelerate3d", "on"]
    vb.name = VM_DISPLAY_NAME
  end
end
```

#### TO RUN EXAMPLES
* Install VirtualBox
* Install Vagrant
* Run `vagrant up`
  * This uses the `Vagrantfile` provided with the original ZF2 skeleton app
  * Installs a VM with PHP 5
* Once you see the message "Done" do this:
  * Login to the VM as user `vagrant` password `vagrant`
  * Copy the source files into the home directory:
```
cp -r /var/www/zf ~/zf
```
  * Reset the VM network adapter mode to "bridged"
  * Restart the VM

#### VM CONFIGURATION
Once the VM has been installed (see above), do the following:
* Login Info
  * Username: vagrant
  * Password: vagrant
* Install MySQL
  * User is `root` and the password is `vagrant`
  * Create a database `zend` with a user `test` and password `password`
  * Restore from  `/data/zend.sql`
```
mysql -u root -p
create datbase zend;
use zend;
source /home/vagrant/zf/data/zend.sql;
show tables;
-- should see a bunch of tables
select * from names;
-- should see a bunch of names
exit;
```
* Install ZF 2.2:
```
cd ~/zf
php composer.phar install
```
* Make a note of the IP address chosen for the VM using: `ifconfig`
* Run the built-in PHP webserver:
```
# Where "x.x.x.x" is the IP address noted above:
php -S x.x.x.x:80 -t /home/vagrant/zf/public
```
* From the browser on your host computer: `http://x.x.x.x/"



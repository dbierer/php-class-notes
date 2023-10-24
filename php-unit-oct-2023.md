# PHP Unit JumpStart Notes

## To Do
Find ref's to tools that help figure the minimum viable number of tests needed for a given project

## VM
When working with Composer, best to download the latest version and use that:
```
cd ~/Zend/workspaces/DefaultWorkspace
rm composer.phar
wget https://getcomposer.org/composer.phar
```
To run sample tests:
  * Configuration is in `phpunit.xml`
  * Autoloading config is in `composer.json`
```
cd ~/Zend/workspaces/DefaultWorkspace
vendor/bin/phpunit
```
In the `Vagrantfile` these 3 settings need to be updated as follows:
```
config.vm.box = "datashuttle/Zend-Ubuntu-20-04LTS-DT"
config.vm.box_version = "1.0.0"
vb.customize ["modifyvm", :id, "--memory", "4096"]
```
When the VM is up and running, go ahead and accept the prompts to update and/or upgrade
* NOTE: the update/upgrade could take some time!

## phpMyAdmin
The version of phpMyAdmin that's packaged with Ubuntu doesn't work on PHP 8.
Replace it as follows:
* From the VM browser go to this URL: `https://www.adminer.org`
  * Select your desired version (e.g. Adminer 4.8.1 for MySQL English Only)
  * Click to download your target version
  * Make a note of the downloaded filename which we'll call DOWNLOAD_FILE
* From a terminal window:
```
sudo cp ~/Downloads/DOWNLOAD_FILE /var/www/html/adminer.php
```
* To access the utility from the VM browser: `http://localhost/adminer.php`

## Errata
* http://localhost:8884/#/3/11
  * Link is not valid
  * https://docs.phpunit.de/en/10.4/assertions.html
* http://localhost:8884/#/3/12
  * Invalid link
  * https://docs.phpunit.de/en/10.4/organizing-tests.html


# PHP III - Oct 2022

## VM Update
* After the VM first comes up, if you're not prompted to update, reboot the VM
* After reboot: Select yes to "Update System Software" if you're prompted
* Open a terminal window
* Upgrade everything:
```
sudo apt -y upgrade
```
  * If asked to retain the database configuration select "OK"
NOTE: this could take some time!
### Install phpMyAdmin

Download the latest version from https://www.phpmyadmin.net
Make note of the version number (e.g. 5.2.0)
* From a terminal window:
```
cd /tmp
set VER=5.2.0
mv Downloads/phpMyAdmin-$VER-all-languages.zip .
unzip Downloads/phpMyAdmin-$VER-all-languages.zip
sudo cp -r phpMyAdmin-$VER-all-languages/* /usr/share/phpmyadmin
sudo cp /usr/share/phpmyadmin/config.sample.inc.php /usr/share/phpmyadmin/config.inc.php
```
Create the "blowfish secret"
```
sudo -i
export SECRET=`php -r "echo md5(date('Y-m-d-H-i-s') . rand(1000,9999));"`
echo "\$cfg['blowfish_secret']='$SECRET';" >> /usr/share/phpmyadmin/config.inc.php
exit
```
Set permissions
```
sudo chown -R www-data /usr/share/phpmyadmin
```

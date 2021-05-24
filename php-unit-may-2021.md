# PHP Unit JumpStart Notes

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

## Class Notes
Find alternate syntax for `prophesize()`

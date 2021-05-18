# PHP III -- May 2021 -- Notes

## VM
Here are some things to do with the VM after installation
* DO NOT update!  Had a problem with a black screen following the update.
  * Need to research this further
* Need to install `git`:
```
sudo apt install -y git
```
## Homework
For Weds 26 May 2021
  * Setup Apache JMeter
  * Setup Jenkins CI
    * The CheckStyle plug-in reached end-of-life. All functionality has been integrated into the Warnings Next Generation Plugin.
    * Same applies to `warnings` and `pmd` : integrated into `Warnings NG`
    * Here are some other suggestions for initial setup:
      * replace `checkstyle` with `Warnings Next Generation`
      * replace `build-environment` with `Build Environment`
      * replace `phing` with `Phing`
      * replace `violations` with `Violations`
      * replace `htmlpublisher` with `Build-Publisher` (???)
      * replace `version number` with `Version Number`

## Resources
Previous class notes:
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-mar-2021.md
  * https://github.com/dbierer/php-class-notes/blob/master/php-iii-jan-2021.md

## Class Notes
`DateTime`
  * https://www.php.net/manual/en/intldateformatter.format.php
`DatePeriod` Example
  * https://github.com/dbierer/classic_php_examples/blob/master/date_time/date_time_date_period.php
Relative `DateTime` formats
  * http://php.net/manual/en/datetime.formats.relative.php
Custom Compile PHP
  * See: https://lfphpcloud.net/articles/adventures_in_custom_compiling_php_8

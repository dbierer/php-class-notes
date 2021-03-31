# PHP Test Prep -- Apr 2020

## TODO
* Check on answers to 2/56
* Question 2/58: question contradicts the answer

## Links
* Detailed list of topic areas:
  * https://www.zend.com/training/php-certification-exam
* Bitwise tutorial:
  * https://www.w3resource.com/php/operators/bitwise-operators.php
* `php.ini` settings:
  * https://www.php.net/manual/en/ini.list.php
  * https://www.php.net/manual/en/configuration.changes.modes.php
* Extensions
  * https://www.php.net/manual/en/intro.opcache.php
* Garbage Collection
  * https://www.php.net/gc_collect_cycles
  * https://www.php.net/manual/en/features.gc.performance-considerations.php
* XML
  * https://www.w3schools.com/xml/xpath_intro.asp
* DateTime
  * Examples of `DateInterval` format codes: https://www.php.net/manual/en/dateinterval.createfromdatestring.php
  * Formats: https://www.php.net/manual/en/datetime.formats.php
## Repo Setup:
### Setup Docker / Docker Compose
* Install `docker`
  * CentOS: https://docs.docker.com/install/linux/docker-ce/centos/#install-docker-ce
  * Debian: https://docs.docker.com/install/linux/docker-ce/debian/
  * Fedora: https://docs.docker.com/install/linux/docker-ce/fedora/
  * Ubuntu: https://docs.docker.com/install/linux/docker-ce/ubuntu/
  * Windows: https://docs.docker.com/docker-for-windows/install/
  * Mac: https://docs.docker.com/docker-for-mac/install/
* Install `docker-compose`
    * https://docs.docker.com/compose/install/

### Build the Image
* Unzip the zip file provided by your instructor into a directory `/path/to/repo`
* From a terminal windows (or command prompt):
```
cd /path/to/ repo
docker-compose build
```
* To run the image:
```
docker-compose up -d
```

### Use the Image
* To access the image from a browser:
```
http://10.30.30.30/php_cert
// or
http://localhost:8888/php_cert
```
* To open a shell into the container:
  * From Linux:
```
docker exec -it php_cert /bin/bash
```
  * From Windows or Mac
    * Locate the running container in _Docker Desktop_
    * Click on the CLI `>_` icon to open a shell

## Past Notes:
* https://github.com/dbierer/php-class-notes/blob/master/php-cert-aug-2020.md
* https://github.com/dbierer/php-class-notes/blob/master/php-cert-jun-2020.md

## ERRATA
* 2/57  correct answer s/be B and C.  PSR-4 is only applicable if the question addresses directory structure and namespace
* 4/42: correct answer: `255 255.000000`
* 5/17: array_search(): Returns element *key* value, or boolean false. A third boolean parameter includes type checking.

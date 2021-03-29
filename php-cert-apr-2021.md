# PHP Test Prep -- Apr 2020

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

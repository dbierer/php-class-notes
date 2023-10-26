# PHP Unit JumpStart Notes

## To Do
Find ref's to tools that help figure the minimum viable number of tests needed for a given project

Test Platforms:
* https://www.tricentis.com/
* https://smartbear.com/product/testcomplete/
* https://www.cypress.io/
* https://www.gspann.com/resources/white-papers/top-10-software-automation-testing-tools-compared/

Test coverage / minimum number of tests:
* Working on it!

Behavioral Driven Design (BDD)
* https://github.com/Behat/Behat


## Class Notes
Better separation between "sandbox" and "completed" test suites:
```
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">
  <testsuites>
	<testsuite name="sandbox">
	  <directory>sandbox/test</directory>
	</testsuite>
	<testsuite name="completed">
	  <directory>completed/test</directory>
	</testsuite>
  </testsuites>
</phpunit>
```
Call one or the other test suite as follows:
```
vendor/bin/phpunit --testsuite completed|sandbox
```
To show deprecations, warnings, notices, add any/all of these flags:
```
  --display-deprecations
  --display-errors
  --display-notices
  --display-warnings
```
IMPORTANT: Data provider methods must now be `public` and `static`
Example testing a `protected` method using an anonymous class
* NOTE: you can name your data sets / providers
```
<?php
namespace SandboxTest\Roman;

use Sandbox\Roman\RomanNumeral;
use PHPUnit\Framework\TestCase;

class RomanNumeralTest extends TestCase
{
	public $fake = NULL;
	public function setup() : void
	{
		$this->fake = new class() extends RomanNumeral {
			public $instance = NULL;
			public function convert(int $num)
			{
				return parent::convert($num);
			}
		};
	}
	public static function singleValueProvider()
	{
		return [
			[[1, 5, 10], ['I','V','X']]
		];
	}
	public static function additiveValueProvider()
	{
		return [
			[[3, 6, 8], ['III','VI','VIII']]
		];
	}
	// I II III IV V VI VII VIII IX X
	/**
	 * @dataProvider singleValueProvider
	 * @dataProvider additiveValueProvider
	 */
	public function testSingleValue($provided, $expected_in)
	{
		$numeral = $this->fake;
		foreach ($provided as $key => $number) {
			$expected = $expected_in[$key];
			$actual = $numeral->convert($number);
			$this->assertEquals($expected, $actual);
		}
	}
}
```

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
## phpunit
You need to install the following:
```
sudo apt install php8.2-curl php8.2-dom php8.2-mbstring
```
If you want to use Prophecy to create mock objects you need to add this to your `composer.json` file:
```
composer require --dev phpspec/prophecy
```
* PHP unit 8 provided Prophecy built-in
* Starting with PHP Unit version 9 you need to add Prophecy manually
* For more info: https://github.com/phpspec/prophecy

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

## Labs
Sample solution for Widget API lab:
* WidgetStorage class:
```
<?php
namespace Sandbox\Widget;

/*
 *
CREATE TABLE `widgettracker` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `widget` varchar(128) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
*/
use PDO;
class WidgetStorage
{
	const TABLE = 'widgettracker';
	public function __construct(public PDO $pdo)
	{ }
	public function storeApiQueryResult(string $data) : bool
	{
		$sql = 'INSERT INTO ' . static::TABLE . ' '
		     . '(widget,price,date) '
		     . 'VALUES (?,?,?);';
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(array_values(json_decode($data, TRUE)));
	}
}
```
* WidgetStorageTest class:
```
<?php
namespace SandboxTest\Widget;

use PDO;
use PDOStatement;
use Sandbox\Widget\WidgetStorage;
use PHPUnit\Framework\TestCase;

class WidgetStorageTest extends TestCase
{
    protected $mockStorage;
    protected $mockPDO;
    public function setUp() : void
    {
		// mock the API
		// Expected result: {"widget":"test","price":"111.11","date":"2016-12-28 11:11:11"}
		// Sample query: http://localhost:8080/api/widget/test
		$this->mockPDO = new class() extends PDO {
			public function __construct() {}
			public function prepare(string $sql, array $options = [])
			{
				return new class () extends PDOStatement {
					public function execute(?array $values = NULL) {
						return TRUE;
					}
				};
			}
		};
		$this->mockStorage = new WidgetStorage($this->mockPDO);
    }
    public static function apiDataGood()
    {
		return [
			['{"widget":"test","price":"111.11","date":"2016-12-28 11:11:11"}'],
		];
	}
    public static function apiDataMissing()
    {
		return [
			[''],
		];
	}
    public static function apiDataBad()
    {
		return [
			['{"widget":"doesnotexist","price":"111.11","date":"2016-12-28 11:11:11"}'],
		];
	}
    /**
     * @dataProvider apiDataGood
     */
    public function testStoreGoodApiQueryResult($data)
    {
		$actual = $this->mockStorage->storeApiQueryResult($data);
		$this->assertTrue($actual);
    }
}
```
* Test run results:
```
vagrant@phpunit-training:~/Zend/workspaces/DefaultWorkspace$ vendor/bin/phpunit sandbox/test/Widget/WidgetStorageTest.php
PHPUnit 10.4.1 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.11
Configuration: /home/vagrant/Zend/workspaces/DefaultWorkspace/phpunit.xml

.                                                                   1 / 1 (100%)

Time: 00:00.149, Memory: 8.00 MB

OK (1 test, 1 assertion)
vagrant@phpunit-training:~/Zend/workspaces/DefaultWorkspace$
```

## Errata
* http://localhost:8884/#/3/11
  * Link is not valid
  * https://docs.phpunit.de/en/10.4/assertions.html
* http://localhost:8884/#/3/12
  * Invalid link
  * https://docs.phpunit.de/en/10.4/organizing-tests.html
* http://localhost:8884/#/7/2
  * Invalid link
  * https://docs.phpunit.de/en/10.4/test-doubles.html



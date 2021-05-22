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

## Prophecy
The following usage is deprecated as of PHP unit 9:
```
    public function testProphecy()
    {
        // using Prophecy
        // NOTE: this syntax was allowed in PHP Unit 9 and below:
        $prophecy = $this->prophesize(PDO::class);
        $prophecy->query()->willReturn($this->arr);
        $mock = $prophecy->reveal();

        $expected = $this->arr;
        $actual   = $mock->query();
        $this->assertEquals($expected, $actual);
    }
```
Here is the correct syntax to use:
```
    public function testProphecy()
    {
        // using Prophecy
        $prophet = new Prophet();
        $prophecy = $prophet->prophesize(PDO::class);
        $prophecy->query()->willReturn($this->arr);
        $mock = $prophecy->reveal();

        $expected = $this->arr;
        $actual   = $mock->query();
        $this->assertEquals($expected, $actual);
    }
```


## Test Doubles
Here's a sample test that shows different way to create test doubles:
```
<?php
// for more info on test doubles see:
// https://phpunit.readthedocs.io/en/9.5/test-doubles.html
namespace SandboxTest;

use PDO;
use Mockery;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class DoublesTest extends TestCase
{
    public $arr = ['id' => 111, 'name' => 'Fred Flintstone'];
    public $mock = [];
    public function testMockBuilder()
    {
        // using Mock Builder
        $mock = $this->getMockBuilder(PDO::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['query'])
                     ->getMock();
        $mock->expects($this->once())
             ->method('query')
             ->willReturn($this->arr);
        $expected = $this->arr;
        $actual   = $mock->query();
        $this->assertEquals($expected, $actual);

    }
    public function testAnonymousClass()
    {
        // PHP 7.x anonymous class
        $mock = new class($this->arr) extends PDO {
            public $arr = [];
            public function __construct(array $arr) {
                $this->arr = $arr;
            }
            public function query() { return $this->arr; }
        };

        $expected = $this->arr;
        $actual   = $mock->query();
        $this->assertEquals($expected, $actual);
    }
    public function testProphecy()
    {
        // using Prophecy
        // NOTE: this syntax was allowed in PHP Unit 9 and below:
        // $prophecy = $this->prophesize(PDO::class);
        // this is the updated syntax:
        $prophet = new Prophet();
        $prophecy = $prophet->prophesize(PDO::class);
        $prophecy->query()->willReturn($this->arr);
        $mock = $prophecy->reveal();

        $expected = $this->arr;
        $actual   = $mock->query();
        $this->assertEquals($expected, $actual);
    }
    public function testMockery()
    {
        // using Mockery
        $mock = Mockery::mock(Foo::class);
        $mock->shouldReceive('query')
                        ->andReturn($this->arr);
        $expected = $this->arr;
        $actual   = $mock->query();
        $this->assertEquals($expected, $actual);
    }
}
```


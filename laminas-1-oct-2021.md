# Laminas Fundamentals Class Notes
Oct 2021

## TDO
Get updated PDF to Jeff when available

## Q & A
* Get docs on Laminas console commands (and examples)
  * https://docs.laminas.dev/laminas-cli/intro/
* Find examples of Laminas code
  * https://github.com/dbierer/laminas-1-feb-2021
* Get the name of the ZF1 equivalent to listeners and events
  * https://framework.zend.com/manual/1.12/en/zend.event-manager.event-manager.html
* ZF1 Resource Plugins
  * https://framework.zend.com/manual/1.12/en/zend.application.available-resources.html
* ZF1 App: https://github.com/dbierer/zf.unlikelysource.net
 * Demo: http://zf.unlikelysource.net/

## Homework
For 29 Oct 2021
* Lab: Events
For 27 Oct 2021
* Lab: Manipulating Views and Layouts
* Lab: Forms, Filters and Validators
For 25 Oct 2021
* Lab: Creating and Accessing a Service
For 22 Oct 2021
* Lab: Using a Built-in Controller Plugin
* Lab: Using a Custom Controller Plugin
* Lab: New Controllers and Factories
  * Step 11: add `child_routes` here:
```
// onlinemarket.work/module/Market/config/module.config.php:
	'router' => [
        'routes' => [
            'market' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/market',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
				// may_terminate => true,
                // child_routes => [ xxx ]
            ],
        ],
    ],
```
For 20 Oct 2021
  * Lab: New Project: Laminas Skeleton
    * Step 5: Laminas Skeleton: Do not create the symbolic (i.e. skip this step)
  * Lab: Create a New Module
  * Lab: Create a New Controller, Layout Template, and Route
    * Step 4: Need to add a `use` statement as follows (before the `return` command):
```
namespace Market;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
```

## Class Notes
Laminas Tools:
* To Install:
```
composer require phpcl/laminas-tools
```
* To Use:
```
vendor/bin/phpcl-laminas-tools
```

Using Controller Plugins and services:
```
<?php
namespace Market\Controller;
use ArrayObject;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Interop\Container\ContainerInterface;
class IndexController extends AbstractActionController
{
	public $container = NULL;
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
    public function indexAction()
    {
		$name = $this->params()->fromQuery('name', 'Default');
		$zend = $this->params()->fromQuery('zend', FALSE);
		if ($zend) return $this->redirect()->toUrl('https://zend.com');
		$time = $this->timeNow();
		$categories = $this->container->get('market-categories');
		$abc = $this->container->get('application-abc');
		$rand[] = $this->container->get('application-random-key');
		$rand[] = $this->container->get('application-random-key');
        return new ViewModel([
			'name' => $name,
			'time' => $time,
			'categories' => $categories,
			'abc' => $abc,
			'random' => $rand]);
    }
}
```
Factory:
```
<?php
namespace Market\Controller\Factory;
use ArrayObject;
use Market\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null)
    {
        return new IndexController($container);
    }
}
```
Custom Plugin:
```
<?php
namespace Market\Controller\Plugin;
use DateTime;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
class TimePlugin extends AbstractPlugin {
    // parameters are at your discretion
    public function __invoke(mixed $params = NULL)
    {
        $time = new DateTime('now');
        return $time->format('l, d M Y');
    }
}
```
Configuration for plugin:
```
// module.config.php:
    'controller_plugins' => [
        'factories' => [
            TimePlugin::class => InvokableFactory::class,
        ],
        'aliases' => [
			'timeNow' => TimePlugin::class,
        ],
    ],
```

Inversion of Control software design pattern:
  * https://www.martinfowler.com/bliki/InversionOfControl.html
Non-Shared Services:
```
// module.config.php:
	'service_manager' => [
		'services' => [
			'application-abc' => range('A','Z'),
			],
		'factories' => [
			'application-random-key' => function ($container, $requested) {
				return base64_encode(random_bytes(16));
			},
		],
		'shared' => [
			'application-random-key' => FALSE,
		],
	],
```
## Services
Example of overriding a service:
* `Test\Module`
```
<?php
declare(strict_types=1);
namespace Test;
class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig() : array
    {
		return [
			'services' => [
				'test-one' => __FILE__,
				'test-two' => [__FILE__],
			],
		];
	}
}
```
* `module/Test/config/module.config.php`
```
...
    'service_manager' => [
		'services' => [
			'test-one' => __FILE__,
			'test-two' => [__FILE__],
		],
	],
...
```
* `config/autoload/global.php`
```
return [
    'service_manager' => [
		'services' => [
			'test-one' => __FILE__,
			'test-two' => [__FILE__],
		],
	],
];
```
* `config/autoload/local.php`
```
return [
    'service_manager' => [
		'services' => [
			'test-one' => __FILE__,
			'test-two' => [__FILE__],
		],
	],
];
```
* Output:
```
Test View
One: /home/onlinemarket.work/config/autoload/local.php
Two:
/home/onlinemarket.work/module/Test/view/test/index/index.phtml:5:
array (size=4)
  0 => string '/home/onlinemarket.work/module/Test/src/Module.php' (length=50)
  1 => string '/home/onlinemarket.work/module/Test/config/module.config.php' (length=60)
  2 => string '/home/onlinemarket.work/config/autoload/global.php' (length=50)
  3 => string '/home/onlinemarket.work/config/autoload/local.php' (length=49)
```
* Examples using view helpers
  * `module/Test/view/test/index/index.phtml`
```
<h1>Test View</h1>
One: <?= $this->one; ?>
<br />Two:
<br />
<?= $this->htmlList($this->two, 1); ?>
<br />
<?= $this->partial('test/index/child1', []) ?>
<br />
<!-- Passing a 2nd argument filters what info is visible to the child view -->
<!-- in this example, no parent data gets passed -->
<?= $this->partial('test/index/child2', []) ?>
<br />
<?= get_class($this); ?>
<br />
<?= $this->escapeHtml($this->bad); ?>
```
Form generation using configuration:
* https://github.com/dbierer/laminas-1-feb-2021

Example using SQL generation
```
    public function indexAction()
    {
		$category = $this->params()->fromRoute('category');
		$sql = new Sql($this->adapter);
		$select = $sql->select()->from('listings')->where(['category' => $category]);
        $queryString = $sql->buildSqlString($select);
        $result = $this->adapter->query($queryString, Adapter::QUERY_MODE_EXECUTE);
        return new ViewModel(['category' => $category, 'list' => $result]);
    }
```
Mapping between `module.config.php` keys and `Module` class `get*Config()` methods:
* https://docs.laminas.dev/laminas-modulemanager/module-manager/#module-manager-listeners
  * about in the middle of the page

## Errata
* "General Troubleshooting"
  * `docker exec -it laminas_1 /bin/bash`
  * OR: `admin shell`
* http://localhost:9999/#/4/16
  * Keys should be in quotes: `'router' => 'routes'`
* http://localhost:9999/#/4/34
  * Contoller plugin s/be doing something more useful!
* http://localhost:9999/#/5/20
  * Command shown needs to have namespace using double \\
* Lab: Creating and Accessing a Service
  * Step 1: the path s/include `Application` not `application`
* http://localhost:9999/#/7/13
  * `WhiteList` is now `AllowList`
  * `BlackList` is now `DenyList`
* Lab: Forms, Filters, Validators, Step 10
  * http://localhost:9999/#/7/53
  * CAPTCHA: `imgUrl => '/onlinemarket.work/captcha'`
  * Also: need to create the `captcha` directory and assign permissions to the `apache` group
  * NOTE: same goes for onlinemarket.complete
* http://localhost:9999/#/9/45
  * The following line is corrected as follows:
```
$rowset = $userTableGateway->selectWith($select);
```
* http://localhost:9999/#/10/14
  * revise this:
```
configuration array returned by /config/module.config.php.
```
  * To this:
```
configuration array returned by /config/modules.config.php.
```

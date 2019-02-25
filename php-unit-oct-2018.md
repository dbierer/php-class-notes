# php-unit-oct-2018

## GENERAL NOTES
* Provide examples using Prophecy (i.e. compared to Mockery, mockBuilder, or anon class)  (done)
* Provide example testing a file upload (oops ... not done ... sorry!)

## ERRATA
* Redo the links for PHP Unit 7 (done)
* Look for "textXXX()"  (done)
* PHP Unit version 6 allows for "_" style namespaces whereas PHP Unit 7 has switched to "\\" style
* Make sure the API simulator is working for PHP 7.2  (done)

## FIRST LAB
```
wget https://getcomposer.org/composer.phar
sudo rm /usr/local/bin/phpunit
sudo ln -s /home/vagrant/Zend/workspaces/DefaultWorkspace/punit/src/vendor/bin/phpunit /usr/local/bin/phpunit
```

## DOCUMENTATION
* https://phpunit.readthedocs.io/en/7.4/index.html

## ZF TESTING USING SERVICE MANAGER
```
<?php
namespace RestApiTest;

use RestApi\Model\AuthenticateModel;

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;
use Zend\Http\Client;
use Zend\Http\Request;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    const BASE_URL = 'http://xxx.local';
    const LOG_FILE = __DIR__ . '/test.log';
    const TEST_FILE = __DIR__ . '/test.png';
    const HTTP_METHODS = [
        Request::METHOD_POST,
        Request::METHOD_GET,
        Request::METHOD_PUT,
        Request::METHOD_DELETE
    ];
    protected $authModelTable;
    protected $token;
    protected $authData;
    protected $serviceManager;
    protected $mvcApplication;
    protected $baseRoute;
    public function setup()
    {
        // create service manager + MVC application instances
        $appConfig = require __DIR__ . '/../../../config/application.config.php';
        if (file_exists(__DIR__ . '/../../../config/development.config.php')) {
            $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../../../config/development.config.php');
        }
        $this->mvcApplication = Application::init($appConfig);
        $this->serviceManager = $this->mvcApplication->getServiceManager();

        // create auth token
        $this->token = bin2hex(random_bytes(32));
        $this->authData = [
            'userKey' => bin2hex(random_bytes(32)),
            'userSecret' => bin2hex(random_bytes(32)),
            'token' => $this->token
        ];
        $this->authModelTable = $this->serviceManager->get(AuthenticateModel::class)->getTableGateway();
        $this->authModelTable->insert($this->authData);
        parent::setup();
    }
    public function teardown()
    {
        // remove test auth data
        $this->authModelTable->delete(['userKey' => $this->authData['userKey']]);
    }
    // send requests
    public function send($uri, $method = Request::METHOD_GET, $data = NULL, $uploadFn = '', $uploadParam = '')
    {
        // set up client
        $client = new Client($uri);
        $client->setMethod($method);
        // Content-Type header
        $headers  = $client->getRequest()->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
        // $client->setFileUpload('some_text.txt', 'upload', $text, 'text/plain');
        if ($uploadFn && file_exists($uploadFn)) $client->setFileUpload($uploadFn, $uploadParam);
        if ($data) $client->setRawBody($data);

        // JWT auth
        $request = $client->getRequest();
        $headers = $request->getHeaders();
        $headers->addHeaderLine('Authorization', $this->token);

        // make request and return response
        return $this->sanitizeBody($client->send());
    }
    protected function sanitizeBody($response)
    {
        $body = $response->getBody();
        if (strlen($body) > 100) {
            if (preg_match('/Statement could not be executed \((.*?)\)/', $body, $matches)) {
                $body = $matches[1] ?? $body;
                $body = str_replace('&#039;', '"', $body);
            } elseif (strpos($body, 'A 404 error occurred')) {
                $body = 'A 404 error occurred. Page not found. The requested URL could not be matched by routing.';
            }
        }
        $body = str_replace(["\n","\t"], '', $body);
        return $response;
    }
}
```


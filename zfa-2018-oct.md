# ZF ADVANCED Oct 2018

## NOTE TO SELF
* finish Email labs + get guestbook working!!!
* add the filter to the logger module
* lookup how JWT was stored (done: see below)

## HOMEWORK
* For Friday 26 Oct 2018
  * Lab: ACL
  * Lab: Navigation
* For Wednesday 24 Oct 2018
  * Lab: Authentication
  * Lab: Password
      * NOTE: there is now a separate `Registration` module: you will need to work with both the `Login` and `Registration` modules.
              Create the `Password` class under `Login\Security` you will then modify the callback check auth adapter to use `verify()`.
              You will then use the same class in the `Registration` module to save the user info with hashed password.
	  * NOTE: You also need to modify `Model\Table\UsersTable::save()` to accommodate password hashing
* For Monday 22 Oct 2018
  * Lab: Cache
  * Lab: Sessions
  * Lab: Logging
  * Lab: Zend Mail
* For Friday 19 Oct 2018
  * Lab: Delegators
* For Wednesday 17 Oct 2018
  * Lab: Form Security
  * Lab: Initializers
  * Lab: Abstract Factories
* For Monday 15 Oct 2018
  * Lab: Forms and Fieldsets
  * Lab: File Uploads
* For Friday 12 Oct 2018
  * Lab: Object Hydration and Database Operations
  * Lab: Table Module Relationships

## ERRATA/NOTES
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/27: properties need to be public
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/32: should be `$user->email` and `$user->password`
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/31: should mention also need `getArrayCopy()` for extract
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/35: why does Reflection hydrator not extract public props?
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/57: should mention put JS stuff just before </body>
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/62: consider "queuing up" the requests, and then performing an optimized single database query at the end
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/3/5:  did not clarify what is "@ANO" == Zend\Form\Annotation
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/3/6:  verify the syntax for multiple validators in one line: missing {} ???
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/3/19: Profile entity should include a property "twitter"
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/4/5:  overrides ARE recommended!
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/4/13: need to clearly identify where this code is run!
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/4/25: you also need to register this factory using "abstract_factories" key
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/4/45: CSRF to PostForm already done in Forms lab!
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/5/56: priority goes before message in Logger::log()
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/5/78: comment should read "CRAM-MD5"
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/5/78: add a slide on creating a multi-part email messsage
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/6/9:  Assuming "BaseDN" is correct, the "DN" should be this:
```
CN=user1,OU=Sales,DC=example,DC=net
```
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/6/35: need to rewrite the lab mentioning that both the `Login` and `Registration` modules will be updated
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/6/40: what is `$acl` ???
file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/7/15:   not described in this course!!!

* RE: Delegators lab: there is an error in the original Registration module view
* RE: Logger Lab: you need to remove the references in `Logging/config/module.config.php` to `'listeners' => xxx`
* RE: Session Lab: you *must* specify these two keys in the `module.config.php` file of the `PhpSession` module for it to work:
```
return [
	'session_config' => [],
	'session_storage' => [
		//*** SESSION LAB: enter the type of storage to use
		//***              this must match whatever you put in your SessionManager factory!
		'type' => 'Zend\Session\Storage\SessionArrayStorage',
	],
];
```
* RE: Authentication Lab: get rid of field for "provider" + make it clear that "Users" comes from "Model\Entity"
  * Clear up any confusion over this!!!
  * In Login\Controller\IndexController remove notes for Translation and LDAP

## CLASS NOTES
### Form Annotations
* Create (or find) an example using Annotations
* Better docs: https://docs.zendframework.com/zend-form/quick-start/#using-annotations

### Object Hydration and Extraction
* You could rewrite the `exchangeArray()` method to make it more generic as follows:
```
class User
{
    public $email = '';
    public $password = '';
    public function exchangeArray($data)
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value)
            if (isset($data[$key])) $this->$key = $value;
    }
}
```

## LAB NOTES:
* Table Module / Entities
  * onlinemarket.work entity classes already complete!
* composer.json doesn't like "//"

## JW Token
Here is an example of using a listener aggregate to capture JWT info.
```
<?php
namespace Application\Listener;

use Application\Model\ModelTrait;
use Application\Traits\ConfigTrait;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class Listener implements ListenerAggregateInterface
{
    use ConfigTrait;
    use ModelTrait;
    /**
     * Attach listeners to MvcEvent::EVENT_DISPATCH
     */
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_ROUTE,  [$this, 'checkAuthorization'], -99);
    }
    /**
     * Required by the interface
     */
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    /**
     * Check Authorized Token
     * @param type $event
     * @return type Description
     */
    public function checkAuthorization(MvcEvent $event)
    {
        $jsonData = [];
        $request = $event->getRequest();
        $response = $event->getResponse();
        $isAuthorizationRequired = $event->getRouteMatch()->getParam('isAuthorizationRequired');
        if ($isAuthorizationRequired) {
            $jwtToken = $this->getJwtToken($request);
            if ('' != $jwtToken) {
                if (!$this->authenticationModel->checkValidToken($jwtToken)) {
                    $response->setStatusCode(400);
                    $jsonData = [
                        $this->config['ApiKeys']['status'] => $this->config['messages']['errorNotOk'],
                        $this->config['ApiKeys']['result'] =>
                            [$this->config['ApiKeys']['error'] => $this->config['messages']['errorUnauthToken']],
                    ];
                    return $this->bailOut($response, $jsonData);
                }
            } else {
                $response->setStatusCode(401);
                $jsonData = [
                    $this->config['ApiKeys']['status'] => $this->config['messages']['errorNotOk'],
                    $this->config['ApiKeys']['result'] =>
                        [$this->config['ApiKeys']['error'] => $this->config['messages']['errorAuthReq']],
                ];
                return $this->bailOut($response, $jsonData);
            }
        }
    }
    /**
     * Returns Response object directly thereby short-circuiting the flow
     * @param Zend\Http\Response $response
     * @param array $data == data to be JSON encoded
     * @return Zend\Http\PhpEnvironment\Response
     */
    protected function bailOut($response, $data)
    {
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($data));
        return $response;
    }
    /**
     * Check Request object have Authorization token or not
     * @param type $request
     * @return string $jwtToken
     */
    protected function getJwtToken($request): string
    {
        $jwtToken = $request->getHeaders("Authorization") ? $request->getHeaders("Authorization")->getFieldValue() : '';
        if ('' != $jwtToken) {
            $jwtToken = trim($jwtToken);
            return $jwtToken;
        }
        if ($request->isGet()) {
            $jwtToken = $request->getQuery('token');
        }
        if ($request->isPost()) {
            $jwtToken = $request->getPost('token');
        }
        return (string) $jwtToken;
    }
}
```

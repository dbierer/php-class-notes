# ZFF-I NOTES

## ERRATA
* http://localhost:9090/#/2/5: s/be ´event´
* http://localhost:9090/#/3/22: s/be onlinemarket.work
* http://localhost:9090/#/3/19: there is no folder "Model"
* http://localhost:9090/#/4/10: s/be <module_name>/src/Module.php (as per convention in  "autoload": { "psr-4": { in composer.json)
http://localhost:9090/#/4/27: s/be ´SOME VALUE´

* First Lab:
  * Need to add onlinemarket.work apache vhost link
  * Do not do steps 7 and 8
  * Need to add a step assigning rights to ¨www-data¨
  * Need to add entry for onlinemarket.work to /etc/hosts
* Module Lab:
  * make sure you update security rights for new module 
    ```
    cd /home/vagrant/Zend/workspaces/DefaultWorkspace/onlinemarket.work
    sudo chown -R module/Market
    ```
  * path for controller s/be: onlinemarket.work\module\Market\src\Controller\IndexController.php
  * s/be Market\config\module.config.php
  
## Q & A
* Q: Do you need git installed to use composer?
* A: If the repository from which Composer draws is based on github.com or bitbucket.org you do not have to install git.  Otherwise, if the packages uses something else (e.g. svn), you need to have that client installed.

* Q: Is there a list of Module::get*Config() methods?
* A: Yes: look here (https://docs.zendframework.com/zend-modulemanager/module-manager/)[https://docs.zendframework.com/zend-modulemanager/module-manager/] about the middle of the page

## Wed 16 Aug 2017

### Example of setting alternate template:
```
<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function testAction()
    {
        $viewModel = new ViewModel(['controller' => __CLASS__]);
        $viewModel->setTemplate('application/index/index');
        return $viewModel;
    }
}
```



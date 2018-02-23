# ZEND FRAMEWORK FUNDAMENTALS I -- Course Notes

Left Off With: http://localhost:9999/#/11

NOTE TO SELF: rephrase http: refs to PDF page #

## GENERAL NOTES
* To view PHP errors:
```
tail /var/log/apache2/error.log
```

## HOMEWORK
* Fri 23 Feb 2018
  * Lab: Database Persistence
* Wed 21 Feb 2018
  * Lab: Events
* Tue 20 Feb 2018
  * Lab: Forms
    * form layout == form view template
    * for PostController: if "$form->isValid()" returns false, DO NOT redirect!!!
      Let it "drop through" and re-display the form.
    * Good to know the database structure:
```
 CREATE TABLE `listings` (
  `listings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` char(16) NOT NULL,
  `title` varchar(128) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expires` timestamp NULL DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `photo_filename` varchar(1024) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(32) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `country` char(2) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `delete_code` char(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`listings_id`),
  KEY `title` (`title`),
  KEY `category` (`category`),
  KEY `delete_code` (`delete_code`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8
```

* Fri 16 Feb 2018
  * Lab: Manipulating Views and Layouts
* Wed 14 Feb 2018
  * Lab: Creating and Accessing a Service
    * Step 3: consider creating a trait w/ property and method for categories
    * Array of categories for your use:
```
'barter',
'beauty',
'clothing',
'computer',
'entertainment',
'free',
'garden',
'general',
'health',
'household',
'phones',
'property',
'sporting',
'tools',
'transportation',
'wanted'
```
* Mon 12 Feb 2018
  * Lab: Using a Built-in Controller Plugin
    * Modify Step 2 as follows:
    * Within the `indexAction()` method, write an `if` statement that tests on a user being logged in based on the value of a `$_GET` param `isLoggedIn`
  * Lab: Using a Custom Controller Plugin
    * Directory s/be "Plugin" (note: uppercase "P")
  * Lab: New Controllers and Factories
    * Only need to define `template_path_stack` once per module!

* Fri 9 Feb 2018
  * Lab: MVC Basics Lab == New Module
* Web 7 Feb 2018
  * Lab: New Project


## Q & A
* Q: How do you create a JOIN across different databases?
* A: Create multiple adapters, but the username and password has to be the same for all affected databases.
     All databases have to be on the same database server.

* Q: Will the `ObjectProperty` hydrator work w/ protected props?
* A: No: it uses the PHP `get_object_vars()` function.  Only public properties of the object being hydrated are visible.

* Q: What is the full namespace name for @ANO?
* A: You can only use `@ANO` as a prefix for your form property annotations if you add this statement in the beginning of your file:
```
use Zend\Form\Annotation AS ANO
```

* Q: How do I use a template system like Twig with ZF?
* A: Add to the `module.config.php` key `view_helpers => strategies` a "Twig" strategy.  This can be provided by one of these two modules:
  * https://github.com/ZF-Commons/ZfcTwig
  * https://github.com/OxCom/zf3-twig

* Q: from Bryant to All Participants: What happens if you set 'may_terminate' => FALSE?  Is 'may_terminate' a required field?
* A: `may_terminate` is a switch which, if set TRUE, allows the parent route only to be considered a match.
  If set to FALSE, the route listener has to match *both* parent *and* child before returning a valid match.
  * See: https://stackoverflow.com/questions/20785532/what-is-may-terminate-in-zend-framework-2

* Q: Is there a good step-by-step list for creating resources (i.e. modules, controllers, etc.) in ZF 3?
* A: Here is the "official" guide:
  * Modues: https://docs.zendframework.com/tutorials/getting-started/modules/
  * Controllers/Routing: https://docs.zendframework.com/tutorials/getting-started/routing-and-controllers/
  * Database: https://docs.zendframework.com/tutorials/getting-started/database-and-models/
  * Forms: https://docs.zendframework.com/tutorials/getting-started/forms-and-actions/

* Q: I have a question regarding the preferred "construction" of factory controller key/value pairs in `module.config.php`.
  * So far, I've seen them written in 3 (slightly) different ways:
```
    Controller\PostController::class => InvokableFactory::class,
    PostController::class => Controller\Factory\PostControllerFactory::class,
    Controller\PostController::class => Controller\Factory\PostController::class,
```
  * Could you explain which one you prefer and why?
* A: `::class` is a PHP construct.  This operator was introduced in PHP 5.5, and is used to produce a "fully qualified" (i.e. namespace + name) class name.
  The documentation reference is here: http://php.net/manual/en/migration55.new-features.php#migration55.new-features.class-name
  See also a great article explaining it here: https://stackoverflow.com/questions/30770148/what-is-class-in-php
  *   Example:
```
use Market\Controller;
echo PostController::class; // produces: 'Market\Controller\PostController
```
  * So, if in the `module.config.php` file you have this:
```
use Market;
```
  * then this command:
```
echo Controller\PostController::class;
```
  * will produce: `Market\Controller\PostController`
  * Likewise, if you have this statement:
```
use Market\Controller;
```
  * then this command:
```
echo PostController::class;
```
  * will produce the same thing: `Market\Controller\PostController`
  * Now ... to address the difference between the factories:
  * `InvokableFactory::class` is included with ZF and simply produces an instance of the class.
  This works OK if the instance you wish to produce has no dependencies.
  For example, a Controller class which does not use any other services, can be built using `InvokableFactory::class`.
  * On the other hand, if there are any external classes needed by the controller (e.g. the controller needs to do a database lookup,
  and thus needs a model class which gives it access to the database), then you'll need to define a custom factory class which creates
  the controller and either provides the dependencies as constructor arguments, or uses a "setXXX()" method to inject the needed object.
  * There is no requirement for a custom factory class to either have the word "Factory" in its classname, nor is there a need to have this
  class reside in a "Factory" namespace.  On the other hand, it is considered a best practice to identify the class as a factory class by
  doing either of these two things.

* Q: Is there a quick way to generate basic factories?
* A: You can use the command line tool `vendor/bin/generate-factory-for-class`.
  * So, to create the `IndexControllerFactory` for example:
```
cd ~/Zend/workspaces/DefaultWorkspace/onlinemarket.work
vendor/bin/generate-factory-for-class "Market\\Controller\\IndexController"
```
  * You can then use `>` to redirect output to the appropriate factory class.


## NOTES ON SLIDES
* http://localhost:9999/#/3/5: 5 elements
* http://localhost:9999/#/3/20: there is no "onlinemarket.work" link on localhost
  * Optional: add this link to `/var/www/html/index.html`
  * Need to just type this into the browser
```
http://onlinemarket.work/
```
* http://localhost:9999/#/4/6: missing `<module>/src/Module.php`
* http://localhost:9999/#/4/10: add explanation about  `module/NAME_OF_MODULE/config/module.config.php` vs. `/config/modules.config.php`
* http://localhost:9999/#/4/18: "layout" s/be "template"
* http://localhost:9999/#/4/29: these examples need a little help
* http://localhost:9999/#/4/30: s/be Zend\View\Helper\AbstractHtmlElement
* http://localhost:9999/#/4/34: RoutMatch
* http://localhost:9999/#/5/17: should add documentation on $options
* http://localhost:9999/#/5/18: p. 118: missing "''" for 'routes'; would go into `module.config.php` file of some unspecified module
* http://localhost:9999/#/5/28: s/be `return new ViewModel(['categories' => $this->categories]);`
* http://localhost:9999/#/5/29: s/be "Plugin"
* http://localhost:9999/#/5/43: only need to do this once! (remove this slide)
* http://localhost:9999/#/6/7: Order is:
  * "application.config.php" should be 1st on this list
  * for each module:
      * "Module.php" get*Config()
      * "module.config.php"
  * config/autoload/*global.php
  * config/autoload/*local.php
* http://localhost:9999/#/6/25: s/be a normal factory!!!
* http://localhost:9999/#/8/5: s/be Zend\Form\Form
* http://localhost:9999/#/8/9: missing "use" alias for @ANO
* http://localhost:9999/#/8/23: form or postForm? need to be consistent
* http://localhost:9999/#/8/32: s/be public???
* http://localhost:9999/#/8/39: assumes InputFilter has been assigned to this form
* http://localhost:9999/#/8/40: "layout" == "view template"
* http://localhost:9999/#/8/52: remove the "else" which does a redirect if "isValid()" === FALSE
* http://localhost:9999/#/9/2: registeration
* http://localhost:9999/#/9/17: re-instate trigger / listener diagram
* http://localhost:9999/#/10/26: s/be "EqualTo"
* http://localhost:9999/#/10/28:
```
$select->from('products')
       ->where(
        (new Where())->greaterThanOrEqualTo('qty_oh', 10)
                     ->lessThan('cost', 100)
        );
```
* http://localhost:9999/#/10/40: need to format the code more clearly!
```
$result = $userTableGateway->update(
    ['id' => 3,'email' => 'someonenew@example.com'],  // this is the update data
    ['email' => 'someNewUser@example.com']            // this generates the WHERE clause
);
```

## AUTOLOADING FOR ZF 2
* see: https://github.com/dbierer/zf2.unlikelysource.org/blob/master/init_autoloader.php#L29
* see: https://github.com/dbierer/zf2.unlikelysource.org/blob/master/module/QandA/Module.php


## LAB NOTES
* Forms Lab:
  * Discrepancy between "expiredDays" and "expireDays"
* Creating the Project:
  * From Bryant: When installing ZF, Composer gives me a list of "Do not inject", "config/modules.config.php", and "config/development.config.php.dist".
    Which answer is the correct one?  I would have thought "both", but that isn't a choice.
  * The best answer, IMHO, is #1.  What happens in that case is that Composer automatically updates the list of modules to be loaded.
    In the case of ZF3, some modules are not automatically initialized if they're outside the "standard" ones included in the skeleton application.
    Because in the lab you were instructed to add other modules to composer.json, which are not part of the defaults for the skeleton app,
    Composer wants to make sure these modules are properly initialized.
  * Ref for the skeleton app: https://framework.zend.com/downloads/skeleton-app
* Lab: Create a New Module
  * In the `Module.php` you'll need to add a method `getConfig()` which returns the value from `Market/config/module.config.php` file
  * In `Market/config/module.config.php` file
    * Make sure the module namespace is at the top:
```
namespace Market;
```
    * Activate the new controller as follows:
```
use Zend\ServiceManager\Factory\InvokableFactory;
return [
    // NOTE there is other config you need to do: i.e. adding a route
    //      look into `Application/config/module.config.php` for clues
    'controllers' => [
       'factories' => [
          Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
];
```
* Lab: Creating and Accessing a Service:
  * The suggestion for `IndexController::indexAction()` should include the following:
```
return new ViewModel(['categories' => $this->categories]);
```
  * Note the array syntax, where the array key `categories` becomes a variable in the view template

## DATABASE STUFF
* Zend\Db\Sql\Examples
  * See: https://gist.github.com/ralphschindler/3949548
  * Simple SELECT ... WHERE example:
```
$list = $this->adapter->query('SELECT * FROM listings', []);
$sql = new \Zend\Db\Sql\Sql($this->adapter);
$select = $sql->select()->where('price < 100')->from('listings')->order('category');
$statement = $sql->prepareStatementForSqlObject($select);
$results = $statement->execute();
```
  * More examples (located in Market\Controller\IndexController::adapterAction())
    * Assumes $this->adapter has been injected via a ServiceManager factory
```
// hard coded SQL example:
$sql     = 'SELECT e.name, r.registration_time, '
         . 'CONCAT(r.first_name, \' \', r.last_name) AS full_name '
         . 'FROM event AS e '
         . 'JOIN registration AS r ON e.id = r.event_id '
         . 'WHERE r.first_name LIKE :name '
         . 'ORDER BY e.id, r.registration_time';
$results = $this->adapter->query($sql, ['name' => 'D%']);
echo '<pre>' . var_dump($results->toArray()) . '</pre>';

// using "createStatement()"
$results = [];
$sql = 'SELECT e.name, r.registration_time, '
     . 'CONCAT(r.first_name, \' \', r.last_name) AS full_name '
     . 'FROM event AS e '
     . 'JOIN registration AS r ON e.id = r.event_id '
     . 'WHERE r.first_name LIKE ? '
     . 'ORDER BY e.id, r.registration_time';
$statement = $this->adapter->createStatement($sql);
$results   = $statement->execute(['D%']);
echo '<pre>' . var_dump(iterator_to_array($results)) . '</pre>';

// using Zend\Db\Sql
$zdbSql = new Sql($this->adapter);
$concat = new Expression("CONCAT(r.first_name,' ',r.last_name)");
$where  = new Where();
$where->greaterThanOrEqualTo('r.registration_time', '2017')
      ->and->nest()->like('r.first_name', 'D%')->or->like('r.first_name', 'S%')->unnest();
$select = $zdbSql->select();
$select->from(['e' => 'event'])
       ->columns(['name'])
       ->join(['r' => 'registration'],
               'e.id = r.event_id',
               ['registration_time', 'fullName' => $concat],
               Select::JOIN_INNER)
       ->where($where)
       ->order('e.id ASC, r.registration_time ASC');
echo $select->getSqlString($this->adapter->getPlatform());
$result = $zdbSql->prepareStatementForSqlObject($select)->execute();
echo '<pre>' . var_dump(iterator_to_array($result)) . '</pre>';
```

## Updated New Module Lab:

### Lab: Create a New Module
In this lab, we're going to create a new module *Market*:
* Create a bare minimum module *Market* following the guidelines discussed.
* Enable the module.
* Configure the module for autoloading. Don't forget to run either <code>composer update</code> or <code>composer dump-autoload</code> after changes are made.

IMPORTANT: do not forget to update the filesystem permissions if needed!
HINT: Reference the <i>onlinemarket.complete</i> or <i>guestbook</i> projects if you get stuck.

### Lab: Create a New Controller
In this lab, we're going to create a new controller *Market\Controller\IndexController*:
* Create a PHP file which defines a controller class *Market\Controller\IndexController*
* Define a public method *indexAction()* which returns an instance of *Zend\View\Model\ViewModel* containing an array of sample data.
* In the Market module's configuration file *Market/config/module.config.php* do the following:
    * Register the controller using <code>InvokableFactory</code>
    * Add a route to the new controller and action

### Lab: Create a View Template
In this lab, we're going to create a view template which matches the *IndexController::indexAction()*
* Create a directory structure */path/to/onlinemarket.work/module/Market/view/market/index*
* Create a template file *index.phtml* in the newly created folder
* Echo the values of the variables passed by the view model
* Modify *index.phtml* and escape the output variables using the *escapeHtml()* view helper, i.e. *$this->escapeHtml()*
* Allow the view manager to locate your new templates by updating the *module.config.php::view_manager::template_path_stack*

You can now test your changes from the browser included in the VM by entering this URL: *http://onlinemarket.work/market*

If everything looks good, great!, you're ready to move forward, otherwise check everything again and test.


## VM NOTES

### guestbook project
* Need to update the database structure:
  * From the browser go to `http://localhost/`
  * Select `phpMyAdmin`
  * Select `guestbook`
  * Select `SQL`
  * Paste in the following:
```
CREATE TABLE `entry` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
* To test:
  * From the browser: `http://guestbook/guestbook`
  * Enter the requested info and post
  * Check to make sure your entry has been posted

## DAY ZERO
* Sample out for `vagrant up`
```
$ vagrant up
Bringing machine 'default' up with 'virtualbox' provider...
==> default: Box 'datashuttle/RWZ-Ubuntu-16.04LTS-DTP' could not be found. Attem                                                                     pting to find and install...
    default: Box Provider: virtualbox
    default: Box Version: 1.0.2
==> default: Loading metadata for box 'datashuttle/RWZ-Ubuntu-16.04LTS-DTP'
    default: URL: https://vagrantcloud.com/datashuttle/RWZ-Ubuntu-16.04LTS-DTP
==> default: Adding box 'datashuttle/RWZ-Ubuntu-16.04LTS-DTP' (v1.0.2) for provi                                                                     der: virtualbox
    default: Downloading: https://vagrantcloud.com/datashuttle/boxes/RWZ-Ubuntu-                                                                     16.04LTS-DTP/versions/1.0.2/providers/virtualbox.box
==> default: Box download is resuming from prior download progress
    default:
==> default: Successfully added box 'datashuttle/RWZ-Ubuntu-16.04LTS-DTP' (v1.0.                                                                     2) for 'virtualbox'!
==> default: Importing base box 'datashuttle/RWZ-Ubuntu-16.04LTS-DTP'...
==> default: Matching MAC address for NAT networking...
==> default: Checking if box 'datashuttle/RWZ-Ubuntu-16.04LTS-DTP' is up to date                                                                     ...
==> default: Setting the name of the VM: ZFF1 - Provisioning
==> default: Clearing any previously set network interfaces...
==> default: Preparing network interfaces based on configuration...
    default: Adapter 1: nat
==> default: Forwarding ports...
    default: 80 (guest) => 8084 (host) (adapter 1)
    default: 22 (guest) => 2222 (host) (adapter 1)
==> default: Running 'pre-boot' VM customizations...
==> default: Booting VM...
==> default: Waiting for machine to boot. This may take a few minutes...
    default: SSH address: 127.0.0.1:2222
    default: SSH username: vagrant
    default: SSH auth method: private key
    default:
    default: Vagrant insecure key detected. Vagrant will automatically replace
    default: this with a newly generated keypair for better security.
    default:
    default: Inserting generated public key within guest...
    default: Removing insecure key from the guest if it's present...
    default: Key inserted! Disconnecting and reconnecting using new SSH key...
==> default: Machine booted and ready!
==> default: Checking for guest additions in VM...
    default: The guest additions on this VM do not match the installed version o                                                                     f
    default: VirtualBox! In most cases this is fine, but in rare cases it can
    default: prevent things such as shared folders from working properly. If you                                                                      see
    default: shared folder errors, please make sure the guest additions within t                                                                     he
    default: virtual machine match the version of VirtualBox you have installed                                                                      on
    default: your host and reload your VM.
    default:
    default: Guest Additions Version: 5.1.30
    default: VirtualBox Version: 5.2
==> default: Setting hostname...
==> default: Mounting shared folders...
    default: /home/vagrant/Shared => D:/VM/ZF-Level-1
==> default: Running provisioner: shell...
    default: Running: C:/Users/george/AppData/Local/Temp/vagrant-shell20180202-2                                                                     760-1mlennp.sh
    default: Provisioning course projects...
    default: [DONE: Provisioning course project(s)]
==> default: Running provisioner: shell...
    default: Running: C:/Users/george/AppData/Local/Temp/vagrant-shell20180202-2                                                                     760-1vxbs0m.sh
    default: Provisioning virtual hosts for the project...
    default: [DONE: Provisioning virtual hosts]
==> default: Running provisioner: shell...
    default: Running: inline script
==> default: Running provisioner: shell...
    default: Running: C:/Users/george/AppData/Local/Temp/vagrant-shell20180202-2                                                                     760-13c1p1k.sh
    default: Bootstrap the course MySql database...
    default: Creating database for guestbook and populating
    default: Creating database for onlinemarket and populating
    default: [DONE: Provisioning course MySQL DB]
==> default: Running provisioner: shell...
    default: Running: C:/Users/george/AppData/Local/Temp/vagrant-shell20180202-2                                                                     760-s5oyuq.sh
    default: Provisioning environment...
    default: [DONE: Provisioning environment]
==> default: Running provisioner: shell...
    default: Running: C:/Users/george/AppData/Local/Temp/vagrant-shell20180202-2                                                                     760-1tlezmr.sh
    default: Provisioning general cleanup detail...
    default: [DONE: Provisioning cleanup]
```


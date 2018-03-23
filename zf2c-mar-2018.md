# ZF2C NOTES March 2018

## General Notes
* Just for fun: https://pageconfig.com/post/portable-utf8

### Utility
* Hydrators
    * Look at Zend\Stdlib\Hydrator\AbstractHydrator to see how strategies are used
    * Have a look at Zend\Stdlib\Hydrator\ClassMethods::__construct() for examples of adding filters

### Authentication
* S/be Zend\Permissions\Rbac NOT Zend\Permissions\RBAC

## 2nd Quiz
* RE: Zend\Cache\Storage\StorageInterface is correct, but exam said it was wrong,  but then listed as answer

### Forms
* `InputFilterManager` should be `InputFilterPluginManager`

### Filters
* In the slide "Filter Chains (Priority Example)" should be `new` and not "nw"


NOTE TO SELF: hydrate then bind!

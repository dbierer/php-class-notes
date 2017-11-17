# ZFF II Notes November 2017

LEFT OFF: http://localhost:9999/#/8/59

## TO DO
* Get the latest onlinemarket.work version to students after class ends
* Complete the Cache Lab::clear cache

## Q & A
* Q: from Charles to All Participants: can you get an unclickable where you are crumb?
* Q: where are the pre-defined validation errors translations?


## BETA NOTES
* Include discussion on recorded sessions
* Mic policy
* Need to include 'service_manager' => 'abstract_factories' => AdapterAbstractFactory in the presentation
* Suggestion: flip code slides to black on white

## VM NOTES
* If you installed VirtualBox and vagrant, but get a message after running ¨vagrant up¨
  to the effect that you are missing a provider and that you need to install VirtualBox,
  check for compatibility issues between your OS, vagrant and VirtualBox
* Events\Controller\SignupController should NOT have ServiceLocatorAwareInterface!
* Doctrine Lab: PLEASE change modules/Doctrine/config/module.config.php::router=>routes=>events to router=>routes=>doctrine
* Guestbook: no ability to upload an avatar during registration!!!

## ERRATA
* http://localhost:9999/#/3/23: delegator assignment needs to be array
* http://localhost:9999/#/3/8: 'MyClass' needs to be at same level as 'service_manager'
* http://localhost:9999/#/4/16: in the relationship diagram, Attendee s/have a link to "registration_id"
* http://localhost:9999/#/4/28: drop "@Annotation" from "@ANO\@Annotation\Name("registration")"
* http://localhost:9999/#/4/32: Need to change module name from "Doctrine" to "MyDoctrine"!!!
* http://localhost:9999/#/4/32: Add instruction to install Doctrine Module for ZF!!!
* http://localhost:9999/#/6/56: Dup OFB
* http://localhost:9999/#/6/58: Paddng -- typo!!!
* http://localhost:9999/#/7/6: dup slide
* http://localhost:9999/#/7/4: needs to be re-written
* http://localhost:9999/#/7/6: needs to be re-written
* http://localhost:9999/#/7/8: extra "," has to be removed
* http://localhost:9999/#/7/23: s/be REST not SOAP
* http://localhost:9999/#/8/9: route s/be "/post" not "/login"
* http://localhost:9999/#/8/25: get rid of debugging code!!!
* http://localhost:9999/#/8/28: 'listeners' key needs to be at top level
* http://localhost:9999/#/8/52: dup slide
* http://localhost:9999/#/9/30: drop ref to translation
* http://localhost:9999/#/9/55: remove ref to translatable routes
* http://localhost:9999/#/9/59: used in any customer view helper s/be used in any custom view helper
## LAB NOTES:
* Doctrine Lab: PLEASE change modules/Doctrine/config/module.config.php::router=>routes=>events to router=>routes=>doctrine
* Auth/Password Lab: missing Application\Model\AbstractModel ==> copy this from the guestbook project

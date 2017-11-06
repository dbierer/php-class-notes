# ZFF II Notes November 2017

## TO DO
* Create repo for onlinemarket.complete

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

## ERRATA
* http://localhost:9999/#/3/23: delegator assignment needs to be array
* http://localhost:9999/#/3/8: 'MyClass' needs to be at same level as 'service_manager'
* http://localhost:9999/#/4/16: in the relationship diagram, Attendee s/have a link to "registration_id"
* http://localhost:9999/#/4/28: drop "@Annotation" from "@ANO\@Annotation\Name("registration")"
* http://localhost:9999/#/4/32: Need to change module name from "Doctrine" to "MyDoctrine"!!!
* http://localhost:9999/#/4/32: Add instruction to install Doctrine Module for ZF!!!

## LAB NOTES:
* Doctrine Lab: PLEASE change modules/Doctrine/config/module.config.php::router=>routes=>events to router=>routes=>doctrine

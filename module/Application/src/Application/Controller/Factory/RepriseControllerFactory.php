<?php
namespace Application\Controller\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,  
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
   Application\Controller\RestapiRepriseController
        ;

class RepriseControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $controller = new \Application\Controller\RepriseController($sm);
//        $controller->setSrvLocator($sm);
//        $controller->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
//        $controller->setRepository($sm->get('doctrine.entitymanager.orm_default')->getRepository('Application\Entity\CcReprise'));

        return $controller;
    }
}
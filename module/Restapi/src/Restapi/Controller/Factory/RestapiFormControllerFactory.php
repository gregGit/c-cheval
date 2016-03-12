<?php
namespace Restapi\Controller\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,  
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
   Restapi\Controller\RestapiFormController
        ;

class RestapiFormControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $controller = new \Restapi\Controller\RestapiFormController();
        $controller->setSrvLocator($sm);
        $controller->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        $controller->setRepository(null);
        return $controller;
    }
}
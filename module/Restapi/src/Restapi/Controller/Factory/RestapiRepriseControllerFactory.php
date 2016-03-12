<?php
namespace Restapi\Controller\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,  
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
   Restapi\Controller\RestapiRepriseController
        ;

class RestapiRepriseControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $controller = new \Restapi\Controller\RestapiRepriseController();
        $controller->setSrvLocator($sm);
        $controller->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        $controller->setRepository($sm->get('doctrine.entitymanager.orm_default')->getRepository('Application\Entity\CcReprise'));

        return $controller;
    }
}
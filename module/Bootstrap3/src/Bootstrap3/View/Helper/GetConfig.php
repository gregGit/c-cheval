<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface; 

class GetConfig extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke()
    {
        $config = $this->getServiceLocator()->getServiceLocator()->get('Config');
        foreach (func_get_args() as $arg) {
            if (!isset($config[$arg])) {
                throw new \RuntimeException("Config option ".implode('.', func_get_args())." not found");
            }
            $config = $config[$arg];
        }
        
        return $config;
    }
    
    /*
    * @return \Zend\ServiceManager\ServiceLocatorInterface
    */
    public function getServiceLocator()
    {
         return $this->serviceLocator;  
    }
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;  
        return $this;  
    }
}
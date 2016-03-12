<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);


        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->addTranslationFile('phpArray', 'vendor/zendframework/zend-i18n-resources/languages/fr/Zend_Validate.php', 'default', 'fr_FR');
        \Zend\Validator\AbstractValidator::setDefaultTranslator(new \Zend\Mvc\I18n\Translator($translator));

        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, array($this, 'onRender'), 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Application\Form\FormBuilder' => function($sm) {
                    return new Form\FormBuilder($sm);
                },

            ),
        );
    }


    public function onRender(MvcEvent $e)
    {
        if (is_a($e->getApplication()->getServiceManager()->get('request'), 'Zend\Console\Request')) {
            return;
        }

        $routeMatch = $e->getRouteMatch();

        if (null !== $routeMatch) {
            $baseUrl = $e->getRouter()->getBaseUrl();
            $renderer = $e->getApplication()->getServiceManager()->get('Zend\View\Renderer\PhpRenderer');
            $action = $routeMatch->getParam('action');
            $controller = $routeMatch->getParam('controller');
            if (strlen($controller) > 0) {
                list($module, $_null, $controller) = explode('\\', $controller);
            }
            $jsFile = $renderer->basePath('js/' . $controller . '/' . strtolower($action) . '.js');
            if (file_exists(realpath(__DIR__ . '/../../public/' . $jsFile))) {
                $renderer->inlineScript()->appendFile($jsFile);
            }
        }
//        
//        $sharedManager = $application->getEventManager()->getSharedManager();
//
//        $router = $sm->get('router');
//        $request = $sm->get('request');
//
//        $matchedRoute = $router->match($request);
//        if (null !== $matchedRoute) {
//            $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) use ($sm) {
//                $sm->get('ControllerPluginManager')->get('Myplugin')
//                        ->doAuthorization($e); //pass to the plugin...    
//            }, 2
//            );
//        }
    }

}

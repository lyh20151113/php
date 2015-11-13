<?php
namespace Base;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
class Module implements AutoloaderProviderInterface,ControllerProviderInterface,ServiceProviderInterface
{
   
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
         
        $eventManager->attach($application->getServiceManager()
            ->get('Base\Listener\DispatchNav'));
        $eventManager->attach($application->getServiceManager()
            ->get('Base\Listener\GlobalAcl'));
      
    }
    
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ]
            ]
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'abstract_factories' => [
                'Base\Service\AbstractFactory\Controller'
            ]
        ];
    }
    

    public function getServiceConfig(){
        return [
            'abstract_factories' => [
                'Base\Service\AbstractFactory\Dao'
            ],
            'invokables' => [
                'Base\Listener\DispatchNav' => 'Base\Listener\DispatchNav',
                'Base\Listener\GlobalAcl' => 'Base\Listener\GlobalAcl',
                'Base\Listener\ErrorResponse' => 'Base\Listener\ErrorResponse'
            ]
        ];
    }
}
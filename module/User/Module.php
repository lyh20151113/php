<?php
namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;

class Module implements AutoloaderProviderInterface,DependencyIndicatorInterface,ConfigProviderInterface,ServiceProviderInterface,BootstrapListenerInterface
{
   
    public function onBootstrap(EventInterface $e){
         $application = $e->getApplication();
         $serviceManager = $application->getServiceManager();
         $eventManager = $application->getEventManager();
        
         $eventManager->attach($serviceManager->get('User\Listener\CheckAuth'));
    }
 
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
    
    public function getModuleDependencies()
    {
        return [
            'Base'
        ];
    }
    public function getServiceConfig()
    {
        return array(
//             'factories' => [
//                 'User\Dao\UserDao' => function($sm){
//                     $objectManager = $sm->get('Doctrine\ORM\EntityManager');
//                     $userDao = new UserDao();
//                     $userDao->setEm($objectManager);
//                     return $userDao;
//                 }
//             ],
            'invokables' => [
                'User\Listener\CheckAuth' => 'User\Listener\CheckAuth',
                'User\Service\Acl' => 'User\Service\Acl'
            ]
        );
    }
  
}
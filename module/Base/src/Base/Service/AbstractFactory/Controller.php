<?php

namespace Base\Service\AbstractFactory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * controller的自动注册工厂
 * @author lyh
 *
 */
class Controller implements AbstractFactoryInterface 
{
   
    protected $controllerServiceNameKey = '\Controller\\';
    
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName){
        return strpos($requestedName, $this->controllerServiceNameKey) !== false && class_exists($requestedName.'Controller');
    }
    
    
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName){
        $controllerClass = $requestedName.'Controller';
        $controller = new $controllerClass;
        return $controller;
    }
}
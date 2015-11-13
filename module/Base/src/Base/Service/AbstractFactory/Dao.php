<?php

namespace Base\Service\AbstractFactory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * 所有Dao的自动注册工厂
 * 要求所有Dao继承BaseDao，并且对于命名空间有限制  如User\Entity\User,userDao的命名空间就应该为User\Dao\UserDao
 * @author lyh
 *
 */
class Dao implements AbstractFactoryInterface 
{
   
    protected $daoServiceNameKey = '\Dao\\';
    
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName){
        
        return strpos($requestedName, $this->daoServiceNameKey) !== false && class_exists($requestedName);
    }
    
    
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName){
 
        
        $dao = new $requestedName;
        $objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $dao->setEm($objectManager);
        $arr = explode("\\",$requestedName);
        $arr[1] = "Entity";
        $daoName = $arr[0]."\\".$arr[1]."\\".$arr[2];
        $className = substr($daoName,0,-3);
       
        $dao->setClassName($className);
        return $dao;
    }
}
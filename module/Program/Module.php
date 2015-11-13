<?php
namespace Program;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Program\Model\Program;
use Program\Model\Playbill;
use Zend\Db\ResultSet\ResultSet;
use Program\Model\ProgramTable;
use Zend\Db\TableGateway\TableGateway;
use Program\Model\PlaybillTable;
use Program\Model\SystemTable;
use Program\Model\System;


class Module implements AutoloaderProviderInterface,DependencyIndicatorInterface,ConfigProviderInterface,
    ServiceProviderInterface
{
   
  
    
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
            'factories' => array(
                'Program\Model\ProgramTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProgramTableGateway');
                    $table = new ProgramTable($tableGateway);
                    return $table;
                },
                'ProgramTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Program());
                    return new TableGateway('program', $dbAdapter, null, $resultSetPrototype);
                },
                'Program\Model\PlaybillTable' =>  function($sm) {
                $tableGateway = $sm->get('PlaybillTableGateway');
                $table = new PlaybillTable($tableGateway);
                return $table;
                },
                'PlaybillTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Playbill());
                    return new TableGateway('playbill', $dbAdapter, null, $resultSetPrototype);
                },
                'Program\Model\SystemTable' =>  function($sm) {
                $tableGateway = $sm->get('SystemTableGateway');
                $table = new SystemTable($tableGateway);
                return $table;
                },
                'SystemTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new System());
                    return new TableGateway('system', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array
    (
        'driver'         => "Pdo",
        'dsn'            => "mysql:dbname=zf2tutorial;host=localhost",
        'username'       => "root", //here I added my valid username 
        'password'       => "root", //here I added my valid password 
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        )
    ),
    'caches' => array(
        'redis' => array( // //can be called directly via SM in the name of 'memcached'
            'adapter' => array(
                'name' => 'redis',
                'options' => array(
                    'server' => array(                  
                            '127.0.0.1',//服务器域名或ip
                            6379       //       
                            
                    ),
                )
            )
        )
    )
    
);

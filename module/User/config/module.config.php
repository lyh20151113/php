<?php

return [
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/User/Entity')
            ),
    
            'orm_default' => array(
                'drivers' => array(
                    'User\Entity' => 'application_entities'
                )
            )
        )
    ),
    'view_manager' =>[
        'template_map' => [
            'user\layout' => __DIR__ . '/../view/layout/layout.phtml',
            'user\pagination' => __DIR__ . '/../view/layout/pagination.phtml',
            'user\login' => __DIR__ . '/../view/user/login.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
    'router' => [
        'routes' => [
            'User' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/DH/user[/:controller][/:action][/:id].html',
                    'defaults' => [
                        '__NAMESPACE__' => 'User\Controller',
                        'controller' => 'User',
                        'action' => 'index'
                    ]
                ]
            ],
         ]
     ],
];
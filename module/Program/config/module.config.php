<?php

return [
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Program/Entity')
            ),
    
            'orm_default' => array(
                'drivers' => array(
                    'Program\Entity' => 'application_entities'
                )
            )
        )
    ),
    'view_manager' =>[
        'template_map' => [
          'program\index\index' => __DIR__ .  '/../view/program/index/index.phtml', 
          'program\index\child\playbill' => __DIR__ .  '/../view/program/index/child/playbill.phtml', 
          'program\index\child\programEdit' => __DIR__ .  '/../view/program/index/child/programEdit.phtml',
          'program\index\child\programAdd' => __DIR__ .  '/../view/program/index/child/programAdd.phtml',
          'program\index\child\programLook' => __DIR__ .  '/../view/program/index/child/programLook.phtml',
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
            'Program' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/DH/program[/:controller][/:action][/:date][/:cId][/:subrun].html',
                    'defaults' => [
                        '__NAMESPACE__' => 'Program\Controller',
                        'controller' => 'Index',
                        'action' => 'Index'
                    ]
                ]
            ],
         ]
     ],
];
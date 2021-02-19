<?php
declare(strict_types=1);
namespace Market;
use Laminas\Router\Http\{Literal,Segment};
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
    'router' => [
        'routes' => [
            'market' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/market',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                // this is a "switch" that allows both parent and child routes to be considered
				'may_terminate' => TRUE,
                // IMPORTANT: 'child_routes' are *after* 'options', at the same level, inside the 'market' array key
				'child_routes' => [
					'json' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/json[/:name]',
							'defaults' => [
								'controller' => Controller\IndexController::class,
								'action'     => 'json',
								'name'		 => 'Unknown',
							],
						],
					],
					'panic' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/panic[/]',
							'defaults' => [
								'controller' => Controller\IndexController::class,
								'action'     => 'panic',
							],
						],
					],
					'post' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/post[/]',
							'defaults' => [
								'controller' => Controller\PostController::class,
								'action'     => 'index',
							],
						],
					],
					'view' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/view[/]',
							'defaults' => [
								'controller' => Controller\ViewController::class,
								'action'     => 'index',
							],
						],
					],
				],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\PostController::class => Controller\PostControllerFactory::class,
            Controller\ViewController::class => Controller\ViewControllerFactory::class,
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            // alternatively: you can just specify a callback like so:
            // however ... it's not recommended to place an anonymous function in a config file
            //Controller\IndexController::class => function ($container) { return new Controller\IndexController(); },
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
		'strategies' => [	
            'ViewJsonStrategy',
        ],
    ],
    'controller_plugins' => [
        'aliases' => [
            'timePlugin' => Controller\Plugin\TimePlugin::class,
        ],
        'factories' => [
            Controller\Plugin\TimePlugin::class => InvokableFactory::class,
        ],

    ],
    'view_helpers' => [
        'aliases' => [
            'leftLinks' => View\Helper\LeftLinksHelper::class,
        ],
        'factories' => [
            View\Helper\LeftLinksHelper::class => InvokableFactory::class,
        ],

    ],
];

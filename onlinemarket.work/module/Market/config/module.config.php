<?php
declare(strict_types=1);
namespace Market;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
    'router' => [
        'routes' => [
            'market' => [
                'type'    => Segment::class,
                'options' => [
                    // add additional params to "route" key if needed
                    'route'    => '/market[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            // alternatively: you can just specify a callback like so:
            // however ... it's not recommended to place an anonymous function in a config file
            //Controller\IndexController::class => function ($container) { return new Controller\IndexController(); },
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'controller_plugins' => [
        'aliases' => [
            'timePlugin' => Controller\Plugin\TimePlugin::class,
        ],
        'factories' => [
            Controller\Plugin\TimePlugin::class => InvokableFactory::class,
        ],

    ],
];

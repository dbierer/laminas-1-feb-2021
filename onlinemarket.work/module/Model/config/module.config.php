<?php
declare(strict_types=1);
namespace Model;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
	'service_manager' => [
		'factories' => [
			Adapter::class => Adapter\AdapterFactory::class,
			Table\ListingsTable::class => Table\ListingsTableFactory::class
		],
	],
];

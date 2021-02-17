<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig() : array
    {
		return [
			'services' => [
    			'application-categories' => [
					__FILE__,
					'barter',
					'beauty',
					'clothing',
					'computer',
					'entertainment',
					'free',
					'garden',
					'general',
					'health',
					'household',
					'phones',
					'property',
					'sporting',
					'tools',
					'transportation',
					'wanted'
				]
			]
		];
	}
}

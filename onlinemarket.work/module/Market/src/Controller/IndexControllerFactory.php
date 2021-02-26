<?php
namespace Market\Controller;
use Model\Table\ListingsTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return $requestedName instance
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new $requestedName($container->get('application-categories'),
                                  $container->get('Model\Adapter'));
        $controller->setListingsTable($container->get(ListingsTable::class));
        return $controller;
    }
}


<?php
declare(strict_types=1);
namespace Market;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\Event;
class Module
{
	// this is a reserve method name
	// is activated immediate following the MvcEvent::EVENT_BOOTSTRAP being triggered
	public function onBootstrap(MvcEvent $event)
	{
		$mvcEm = $event->getApplication()->getEventManager()->getSharedManager();
		$mvcEm->attach('*', 'market-test', [$this, 'marketTest']);
	}
	// customer listener
	public function marketTest(Event $event)
	{
		$name   = $event->getParam('name', 'Default');
		$message = __METHOD__ . ':' . $name;
		error_log($message);
	}
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}

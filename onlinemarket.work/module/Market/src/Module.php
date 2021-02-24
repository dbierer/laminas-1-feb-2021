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
		$shared = $event->getApplication()->getEventManager()->getSharedManager();
		$shared->attach('*', 'market-test', [$this, 'marketTest']);
		$shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
	}
	// custom listener
	public function marketTest(Event $event)
	{
		$name   = $event->getParam('name', 'Default');
		$message = __METHOD__ . ':' . $name;
		error_log($message);
	}
    public function onDispatch(MvcEvent $e) 
    {	
		// the view model here is actually the layout
        $vm = $e->getViewModel();
        $sm = $e->getApplication()->getServiceManager();
        $vm->setVariable('categories', $sm->get('global-categories'));
    }    
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}

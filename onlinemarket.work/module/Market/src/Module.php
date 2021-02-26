<?php
declare(strict_types=1);
namespace Market;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\Event;
class Module
{
	// this is a reserve method name
	public function init(ModuleManager $mm)
	{
		$shared = $mm->getEventManager()->getSharedManager();
		$shared->attach('*', '*', [$this, 'logEverything']);
		//$mm = $mm->getEventManager();
		//$mm->attach('*', [$this, 'logEverything']);
	}
	// is activated immediate following the MvcEvent::EVENT_BOOTSTRAP being triggered
	public function onBootstrap(MvcEvent $event)
	{
		$shared = $event->getApplication()->getEventManager()->getSharedManager();
		$shared->attach('*', 'market-test', [$this, 'marketTest']);
		$shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
	}
	public function getServiceConfig()
	{
		return [
			'services' => [
				'test' => [ __FILE__ ],
			],
		];
	}
	// custom listeners
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
	public function logEverything(Event $event)
	{
		$message = __METHOD__;
		$message .= ':' . $event->getName();
		$message .= ':' . get_class($event->getTarget());
		error_log($message);
	}
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}

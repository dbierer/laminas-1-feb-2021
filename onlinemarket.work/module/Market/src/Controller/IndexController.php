<?php
declare(strict_types=1);
namespace Market\Controller;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\{ViewModel,JsonModel};
class IndexController extends AbstractActionController
{
    use ListingsTableTrait;
    protected $categories;
    protected $adapter;
    protected $test;
    public function __construct(array $categories, Adapter $adapter, array $test)
    {
        $this->categories = $categories;
        $this->adapter = $adapter;
        $this->test = $test;
    }
    public function indexAction()
    {
        $item = $this->table->findLatest();
        return new ViewModel(['item' => $item]);
    }
    public function demoAction()
    {
        $this->doEventStuff();
        // database lookup using the adapter
        $sql = 'SELECT * FROM listings';
        $result = $this->adapter->query($sql, []);
        // build the view
        $name = $this->params()->fromQuery('name', 'Unknown');
        $viewModel = new ViewModel(['name' => $name,
                              'datetime' => $this->timePlugin(),
                              'listing' => $result,
                              'test' => $this->test,
                              'request' => $this->getRequest()]);
        //$viewModel->setTerminal(TRUE);
        return $viewModel;
    }
    protected function doEventStuff()
    {
        //************** ATTACHING A LISTENER ******************************
        // let's get the MVC eventmanager via the MvcEvent Instance
        //$em = $this->getEvent()->getApplication()->getEventManager();
        // this gets a "local" event manager instance from the controller
        $em = $this->getEventManager();
        // define a listener
        $listener = function ($event) {
            $target = $event->getTarget();
            $message = 'MARKET\INDEXCONTROLLER:' . get_class($event) . ':' . get_class($target);
            error_log($message);
        };
        // attach the listener to the finish event using the shared manager
        $em->getSharedManager()->attach('*', MvcEvent::EVENT_FINISH, $listener, 1);
        //************** TRIGGERING AN EVENT*** ******************************
        // trigger a custom event "market-test" defined in Market\\Module::onBootstrap()
        $em->trigger('market-test', $this, ['name' => __METHOD__]);
    }
    public function panicAction()
    {
        $response = $this->getResponse();
        $response->setStatusCode(500);
        $response->setContent('<h1>Do Not Panic ... Everything is Under Control</h1>');
        return $response;
    }
    public function jsonAction()
    {
        $name = $this->params()->fromRoute('name');
        $data = ['A' => 111, 'B' => 222, 'C' => 333];
        return new JsonModel(['name' => $name, 'data' => $data]);
    }
}

<?php
declare(strict_types=1);
namespace Market\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class IndexController extends AbstractActionController
{
	protected $timestamp;
	public function __construct(int $timestamp)
	{
		$this->timestamp = $timestamp;
	}
    public function indexAction()
    {
		$name = $this->params()->fromQuery('name', 'Unknown');
        return new ViewModel(['name' => $name, 
							  'datetime' => $this->timePlugin(), 
							  'timestamp' => $this->timestamp,
							  'request' => $this->getRequest()]);
    }
    public function panicAction()
    {
		$response = $this->getResponse();
		$response->setStatusCode(500);
		$response->setContent('<h1>Do Not Panic ... Everything is Under Control</h1>');
		return $response;
	}
}

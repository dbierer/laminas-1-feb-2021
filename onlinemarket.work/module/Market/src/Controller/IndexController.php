<?php
declare(strict_types=1);
namespace Market\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\{ViewModel,JsonModel};
class IndexController extends AbstractActionController
{
	protected $categories;
	public function __construct(array $categories)
	{
		$this->categories = $categories;
	}
    public function indexAction()
    {
		$name = $this->params()->fromQuery('name', 'Unknown');
        $viewModel = new ViewModel(['name' => $name, 
							  'datetime' => $this->timePlugin(), 
							  'categories' => $this->categories,
							  'request' => $this->getRequest()]);
		//$viewModel->setTerminal(TRUE);
		return $viewModel;
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

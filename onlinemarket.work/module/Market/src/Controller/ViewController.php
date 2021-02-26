<?php
declare(strict_types=1);
namespace Market\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class ViewController extends AbstractActionController
{
    use ListingsTableTrait;
    public function indexAction()
    {
        $category = $this->params()->fromRoute('category', 'free');
        $listing = $this->table->findByCategory($category);
        return new ViewModel(['category' => $category, 'listing' => $listing]);
    }
    public function itemAction()
    {
        $itemId = $this->params()->fromRoute('itemId', 1);
        $item   = $this->table->findById($itemId);
        return new ViewModel(['item' => $item]);
    }
}

<?php
declare(strict_types=1);
namespace Market\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class ViewController extends AbstractActionController
{
    public function indexAction()
    {
        $category = '';
        $listing = [];
        return new ViewModel(['category' => $category, 'listing' => $listing]);
    }
    public function itemAction()
    {
        $itemId = '';
        $item = NULL;
        return new ViewModel(['item' => $item]);
    }
}

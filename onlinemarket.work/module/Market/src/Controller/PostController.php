<?php
declare(strict_types=1);
namespace Market\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
class PostController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
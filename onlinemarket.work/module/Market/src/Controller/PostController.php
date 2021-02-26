<?php
declare(strict_types=1);
namespace Market\Controller;
use Model\Table\ListingsTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;
class PostController extends AbstractActionController
{
    protected $form = '';
    public function __construct(Form $form)
    {
        $this->form = $form;
    }
    public function indexAction()
    {
        $data = [];
        $message = 'Please enter appropriate form data';
        $em = $this->getEvent()->getApplication()->getEventManager();
        if ($this->getRequest()->isPost()) {
            $this->form->setData($this->params()->fromPost());
            if ($this->form->isValid()) {
                $message = 'SUCCESS: form data is valid';
                $data = $form->getData();
                $em->trigger(ListingsTable::EVENT_PRE, $this, ['data' => $data]);
                if ($this->table->save($data)) {
                    $message .= '<br />SUCCESS: item posted to the online market';
                    $em->trigger(ListingsTable::EVENT_POST, $this, ['status' => 'SUCCESS: database updated']);
                } else {
                    $message .= '<br />ERROR: item not posted to the online market';
                    $em->trigger(ListingsTable::EVENT_POST, $this, ['status' => 'ERROR: database not updated']);
                }
            } else {
                $message = 'ERROR: form data failed validation';
            }
        }
        return new ViewModel(['postForm' => $this->form, 'message' => $message, 'data' => $data]);
    }
}

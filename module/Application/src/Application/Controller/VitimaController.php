<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VitimaController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function adicionarAction()
    {
        return new ViewModel();
    }


}


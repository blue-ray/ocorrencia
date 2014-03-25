<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        //$this->flashMessenger()->addSuccessMessage("Mensagem de teste");
        return new ViewModel();
    }
    
    //http://igorrocha.com.br/tutorial-zf2-parte-6-rotas-controllers-actions-helpers-e-jquery/5/
}

<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\MunicipioTable as ModelMunicipio;

class MunicipioController extends AbstractActionController {
    public function indexAction() {

        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model MunicipioTable instanciado
        $modelMunicipio = new ModelMunicipio($adapter); // alias para MunicipioTable
        
        // enviar para view o array com key contatos e value com todos os contatos
        return new ViewModel(array('municipio' => $modelMunicipio->fetchAll()));
    }

}

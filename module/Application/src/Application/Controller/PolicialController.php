<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\PolicialTable as ModelPolicial;
use Application\Model\Policial;

class PolicialController extends AbstractActionController {

    public function indexAction() {
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model PolicialTable instanciado
        $modelPolicial = new ModelPolicial($adapter);
        
        // enviar para view o array com key policial e value com todos os policias
        return new ViewModel(array('policiais' => $modelPolicial->fetchAll()));
    }

    public function adicionarAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;

            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                
                $policial = new Policial();
                $policial->id_policial  = 0;
                $policial->id_graduacao = $postData['id_graduacao'];
                $policial->numeral      = $postData['numeral'];
                $policial->nome         = strtoupper($postData['nome']);
                $policial->nome_guerra  = strtoupper($postData['nome_guerra']);
                $policial->matricula    = $postData['matricula'];
                $policial->data_nasc    = $postData['data_nasc'];
                $policial->sexo         = $postData['sexo'];
                
                // localizar adapter do banco
                $adapter = $this->getServiceLocator()->get('AdapterDb');

                // model PolicialTable instanciado
                $modelPolicial = new ModelPolicial($adapter);
                $modelPolicial->salvarPolicial($policial);
               
                $this->flashMessenger()->addSuccessMessage("Policial cadastrado com sucesso");

                // redirecionar para action index no controller contatos
                return $this->redirect()->toRoute('policiais');
                
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao cadastrar o policial");

                // redirecionar para action novo no controllers contatos
                return $this->redirect()->toRoute('policiais', array('action' => 'index'));
            }
        }
        //return new ViewModel();
    }

    public function detalhesAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);
        
        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Policial não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('policiais');
        }

       
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model PolicialTable instanciado
        $modelPolicial = new ModelPolicial($adapter);
        
        // enviar para view o array com key policial e value com todos os policias
        return new ViewModel(array('policial' => $modelPolicial->find($id)));
    }

    public function editarAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = false;

            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                
                $policial = new Policial();
                $policial->id_policial  = $postData['id'];
                $policial->id_graduacao = $postData['id_graduacao'];
                $policial->numeral      = $postData['numeral'];
                $policial->nome         = strtoupper($postData['nome']);
                $policial->nome_guerra  = strtoupper($postData['nome_guerra']);
                $policial->matricula    = $postData['matricula'];
                $policial->data_nasc    = $postData['data_nasc'];
                $policial->sexo         = $postData['sexo'];
                
                // localizar adapter do banco
                $adapter = $this->getServiceLocator()->get('AdapterDb');

                // model PolicialTable instanciado
                $modelPolicial = new ModelPolicial($adapter);
                $modelPolicial->salvarPolicial($policial);
                
                $this->flashMessenger()->addSuccessMessage("Policial editado com sucesso");

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('policiais', array("action" => "detalhes", "id" => $postData['id'],));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar o Policial");

                // redirecionar para action editar
                return $this->redirect()->toRoute('policiais', array('action' => 'editar', "id" => $postData['id'],));
            }
        }

        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para policiais
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Policial não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('policiais');
        }

        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // model PolicialTable instanciado
        $modelPolicial = new ModelPolicial($adapter);
        
        // enviar para view o array com key policial e value com todos os policias
        return new ViewModel(array('policial' => $modelPolicial->find($id)));

    }

    public function deletarAction() {
        // filtra id passsado pela url
        $id      = (int) $this->params()->fromRoute('id', 0);
        $confirm = (int) $this->params()->fromRoute('confirm', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Policial não encotrada");
        } else {
            
            $adapter = $this->getServiceLocator()->get('AdapterDb');

            // model PolicialTable instanciado
            $modelPolicial = new ModelPolicial($adapter);
            if($confirm){
                if($modelPolicial->deletePolicial($id)){
                    
                    $this->flashMessenger()->addSuccessMessage("Policial de ID $id deletado com sucesso");
                    // redirecionar para action index
                    return $this->redirect()->toRoute('policiais');
                 }
                else{
                    $this->flashMessenger()->addErrorMessage("Erro na Exclusão do Polcial. O mesmo deve está vinculado a outras entidades.");
                    // redirecionar para action detalhes
                    return $this->redirect()->toRoute('policiais', array("action" => "deletar", "id" => $id));
                }
                     
                
                 
            }
            else{
                // enviar para view o array com key policial e value com todos os policias
                return new ViewModel(array('policial' => $modelPolicial->find($id)));
            }
            

            
            
        }

        
    }

}

<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\PolicialTable as ModelPolicial;
use Application\Model\Policial;
use Application\Model\GraduacaoTable as ModelGraduacao;
use Application\Model\Graduacao;

class PolicialController extends AbstractActionController {

    public function indexAction() {
         // Numero da página a ser exibida
        $currentPage = $this->params()->fromQuery('pagina');
        
        // Quantidade de itens por págima
        $countPerPage = "5";
        $policiais = $this->getPolicialTable()->fetchAll($currentPage,$countPerPage);
        $grads = $this->getGraduacaoTable()->fetchAll();
        
       
        // enviar para view o array com key policial e value com todos os policias
        return new ViewModel(array('policiais' => $policiais, 'grads' => $grads));
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
                $policial->setId_policial(0);
                
                $grad = $this->getGraduacaoTable()->find($postData['id_graduacao']);
                
                $policial->setGgraduacao($grad);
                $policial->setNumeral($postData['numeral']);
                $policial->setNome(strtoupper($postData['nome']));
                $policial->setNome_guerra(strtoupper($postData['nome_guerra']));
                $policial->setMatricula($postData['matricula']);
                $policial->setData_nasc($postData['data_nasc']);
                $policial->setSexo($postData['sexo']);
                
                $this->getPolicialTable()->salvarPolicial($policial);
               
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

        // enviar para view o array com key policial e value com todos os policias
        return new ViewModel(array('policial' => $this->getPolicialTable()->find($id)));
    }

    public function editarAction() {
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
                $policial->setId_policial($postData['id']);
                
                $grad = $this->getGraduacaoTable()->find($postData['id_graduacao']);
                
                $policial->setGraduacao($grad);
                $policial->setNumeral($postData['numeral']);
                $policial->setNome(strtoupper($postData['nome']));
                $policial->setNome_guerra(strtoupper($postData['nome_guerra']));
                $policial->setMatricula($postData['matricula']);
                $policial->setData_nasc($postData['data_nasc']);
                $policial->setSexo($postData['sexo']);
                
                
                $this->getPolicialTable()->salvarPolicial($policial);
                
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
            
            if($confirm){
                if($this->getPolicialTable()->deletePolicial($id)){
                    
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
                return new ViewModel(array('policial' => $this->getPolicialTable()->find($id)));
            }
            

            
            
        }

        
    }
    
    //função que retorna uma instancia da classe PoliciaTable 
    private function getPolicialTable(){
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return model PolicialTable
        return new ModelPolicial($adapter); // alias para PolicialTable
    }
    
    //função que retorna uma instancia da classe GraduacaoTable 
    private function getGraduacaoTable(){
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return model PolicialTable
        return new ModelGraduacao($adapter); // alias para GraduacaoTable
    }

}

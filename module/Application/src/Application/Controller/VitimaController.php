<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VitimaController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
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
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela adição
                // 2 - inserir dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Vítima criada com sucesso");

                // redirecionar para action index no controller contatos
                return $this->redirect()->toRoute('vitimas');
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao criar a vítima");

                // redirecionar para action novo no controllers contatos
                return $this->redirect()->toRoute('vitimas', array('action' => 'index'));
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
            $this->flashMessenger()->addMessage("Vítima não encotrada");

            // redirecionar para action index
            return $this->redirect()->toRoute('vitimas');
        }

        // aqui vai a lógica para pegar os dados referente ao contato
        // 1 - solicitar serviço para pegar o model responsável pelo find
        // 2 - solicitar form com dados desse contato encontrado
        // formulário com dados preenchidos
        $form = array(
            'nome' => 'Igor Rocha',
            "telefone_principal" => "(085) 8585-8585",
            "telefone_secundario" => "(085) 8585-8585",
            "data_criacao" => "02/03/2013",
            "data_atualizacao" => "02/03/2013",
        );

        // dados eviados para detalhes.phtml
        return array('id' => $id, 'form' => $form);

        return new ViewModel();
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
                // aqui vai a lógica para editar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela atualização
                // 2 - editar dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Vítima editado com sucesso");

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('vitimas', array("action" => "detalhes", "id" => $postData['id'],));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar a vítima");

                // redirecionar para action editar
                return $this->redirect()->toRoute('vitimas', array('action' => 'editar', "id" => $postData['id'],));
            }
        }

        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('vitimas');
        }

        // aqui vai a lógica para pegar os dados referente ao contato
        // 1 - solicitar serviço para pegar o model responsável pelo find
        // 2 - solicitar form com dados desse contato encontrado
        // formulário com dados preenchidos
        $form = array(
            'nome' => 'Igor Rocha',
            "telefone" => "(085) 8585-8585",
            "data_nascimento" => "(085) 8585-8585",
        );

        // dados eviados para editar.phtml
        return array('id' => $id, 'form' => $form);
        //return new ViewModel();
    }

    public function deletarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Vitima não encotrada");
        } else {
            // aqui vai a lógica para deletar o contato no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta contato
            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Vitima de ID $id deletada com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('vitimas');
    }

}

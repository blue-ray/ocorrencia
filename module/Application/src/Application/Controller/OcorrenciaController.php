<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\OcorrenciaTable as ModelOcorrencia;
use Application\Model\PolicialTable as ModelPolicial;
use Application\Model\ViaturaTable as ModelViatura;
use Application\Model\AreaTable as ModelArea;
use Application\Model\VitimaTable as ModelVitima;
use Application\Model\Ocorrencia;

class OcorrenciaController extends AbstractActionController {

    public function indexAction() {
        // Numero da página a ser exibida
        $currentPage = $this->params()->fromQuery('pagina');

        // Quantidade de itens por págima
        $countPerPage = "5";
        $ocorrencias = $this->getOcorrenciaTable()->fetchAll($currentPage, $countPerPage);



        // enviar para view o array com key policial e value com todos os policias
        return new ViewModel(array('ocorrencias' => $ocorrencias));
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

                $oc = new Ocorrencia();
                $oc->setId_ocorrencia(0);
                $oc->setId_end($postData['id_end']);

                $vtr = $this->getViaturaTable()->find($postData['id_vtr']);
                $area = $this->getAreaTable()->find($postData['id_area']);

                $oc->setVtr($vtr);
                $oc->setArea($area);
                $oc->setId_usuario(1);
                $oc->setData($postData['data']);
                $oc->setHorario($postData['horario']);
                $oc->setNarracao($postData['narracao']);

                $policiais = $postData['id_policial'];

                $ultimo_id = $this->getOcorrenciaTable()->salvarOcorrencia($oc);

                if (count($policiais)) {
                    foreach ($policiais as $idp) {
                        $this->getOcorrenciaTable()->addPolicialOcorrencia($ultimo_id, $idp);
                    }
                }


                $this->flashMessenger()->addSuccessMessage("Ocorrencia cadastrada com sucesso");

                // redirecionar para action index no controller contatos
                return $this->redirect()->toRoute('ocorrencia', array('action' => 'index', 'id' => $ultimo_id));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao cadastrar o policial");

                // redirecionar para action novo no controllers contatos
                return $this->redirect()->toRoute('ocorrencia', array('action' => 'index'));
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
            $this->flashMessenger()->addMessage("Ocorrencia não encontrada");

            // redirecionar para action index
            return $this->redirect()->toRoute('ocorrencia');
        }

        // enviar para view o array com key policial e value com todos os policias
        $oc = $this->getOcorrenciaTable()->find($id);
        $pols = $this->getPolicialTable()->findByOcorrecia($id);

        $total_vitimas = $this->getOcorrenciaTable()->totalVitimasOcorrencia($id);
        $total_crimes = $this->getOcorrenciaTable()->totalCrimesOcorrencia($id);
        $total_acusados = $this->getOcorrenciaTable()->totalAcusadosOcorrencia($id);

        return new ViewModel(
                array(
                    'ocorrencia' => $oc,
                    'pols' => $pols,
                    'tVitimas' => $total_vitimas,
                    'tAcusados' => $total_acusados,
                    'tCrimes' => $total_crimes
                )
        );
    }

    public function editarAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $id = $postData['id'];

            $policiais = $postData['id_policial'];

            $formularioValido = true;

            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {

                $oc = new Ocorrencia();
                $oc->setId_ocorrencia($id);
                $oc->setId_end($postData['id_end']);

                $vtr = $this->getViaturaTable()->find($postData['id_vtr']);
                $area = $this->getAreaTable()->find($postData['id_area']);

                $oc->setVtr($vtr);
                $oc->setArea($area);
                $oc->setId_usuario(1);
                $oc->setData($postData['data']);
                $oc->setHorario($postData['horario']);
                $oc->setNarracao($postData['narracao']);


                $this->getOcorrenciaTable()->salvarOcorrencia($oc);


                $this->getOcorrenciaTable()->delPoliciaisOcorrencia($id);

                if (count($policiais)) {
                    foreach ($policiais as $idp) {
                        $this->getOcorrenciaTable()->addPolicialOcorrencia($id, $idp);
                    }
                }



                $this->flashMessenger()->addSuccessMessage("Ocorrencia editada com sucesso");

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('ocorrencia', array("action" => "detalhes", "id" => $id,));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar a Ocorrencia ID: $id");

                // redirecionar para action editar
                return $this->redirect()->toRoute('ocorrencia', array('action' => 'editar', "id" => $id,));
            }
        }

        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para policiais
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("ocorrencia não encontrada");

            // redirecionar para action index
            return $this->redirect()->toRoute('ocorrencia');
        }

        $oc = $this->getOcorrenciaTable()->find($id);
        $pols = $this->getPolicialTable()->findByOcorrecia($id);

        return new ViewModel(array('ocorrencia' => $oc, 'pols' => $pols));
    }

    public function deletarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);
        $confirm = (int) $this->params()->fromRoute('confirm', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Ocorrência não encontrada");
        } else {

            if ($confirm) {
                if ($this->getOcorrenciaTable()->deleteOcorrencia($id)) {

                    $this->flashMessenger()->addSuccessMessage("Ocorrência de ID $id deletada com sucesso");
                    // redirecionar para action index
                    return $this->redirect()->toRoute('ocorrencia');
                } else {
                    $this->flashMessenger()->addErrorMessage("Erro na Exclusão da Ocorrência. A mesma deve está vinculada a outras entidades.");
                    // redirecionar para action detalhes
                    return $this->redirect()->toRoute('ocorrencia', array("action" => "deletar", "id" => $id));
                }
            } else {
                // enviar para view o array com key policial e value com todos os policias
                $oc = $this->getOcorrenciaTable()->find($id);
                $pols = $this->getPolicialTable()->findByOcorrecia($id);

                return new ViewModel(array('ocorrencia' => $oc, 'pols' => $pols));
            }
        }
    }
    
    public function vitimasAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        // Quantidade de itens por págima
        $countPerPage = "5";
        $vitimas = $this->getVitimaTable()->vitimasOcorrencia($id);



        // enviar para view o array com key policial e value com todos os policias
        return new ViewModel(array('vitimas'=>$vitimas, 'id_ocorrencia'=>$id));
    }

    //função que retorna uma instancia da classe PoliciaTable 
    private function getOcorrenciaTable() {
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return model PolicialTable
        return new ModelOcorrencia($adapter); // alias para PolicialTable
    }

    //função que retorna uma instancia da classe GraduacaoTable 
    private function getPolicialTable() {
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return model PolicialTable
        return new ModelPolicial($adapter); // alias para GraduacaoTable
    }

    private function getViaturaTable() {
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return model PolicialTable
        return new ModelViatura($adapter); // alias para GraduacaoTable
    }

    private function getAreaTable() {
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return model PolicialTable
        return new ModelArea($adapter); // alias para GraduacaoTable
    }
    
    private function getVitimaTable() {
        // localizar adapter do banco
        $adapter = $this->getServiceLocator()->get('AdapterDb');

        // return model PolicialTable
        return new ModelVitima($adapter); // alias para GraduacaoTable
    }

}

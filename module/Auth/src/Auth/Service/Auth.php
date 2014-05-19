<?php

namespace Auth\Service;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Sql\Select;

/**
 * Serviço responsável pela autenticação da aplicação
 */
class Auth extends AbstractActionController {

    /**
     * Adapter usado para a autenticação
     * @var Zend\Db\Adapter\Adapter
     */
    private $dbAdapter;

    /**
     * Construtor da classe
     *
     * @return void
     */
    public function __construct($dbAdapter = null) {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Faz a autenticação dos usuários
     *
     * @param array $params
     * @return array
     */
    public function authenticate($params) {
        if (!isset($params['username']) || !isset($params['password'])) {
            $this->flashMessenger()->addErrorMessage("Parâmetros inválidos");
            return false;        
        }

        //$password = md5($params['password']);
        $auth = new AuthenticationService();
        $authAdapter = new AuthAdapter($this->dbAdapter);
        $authAdapter
                ->setTableName('usuario')
                ->setIdentityColumn('usuario')
                ->setCredentialColumn('senha')
                ->setIdentity($params['username'])
                ->setCredential($params['password']);
        $result = $auth->authenticate($authAdapter);

        if (!$result->isValid()) {
            $this->flashMessenger()->addErrorMessage("Login ou senha inválidos");
            return false;
        }

        //salva o user na sessão
        $session = $this->getServiceLocator()->get('Session');
        $session->offsetSet('usuario', $authAdapter->getResultRowObject());

        return true;
    }

    /**
     * Faz o logout do sistema
     *
     * @return void
     */
    public function logout() {
        $auth = new AuthenticationService();
        $session = $this->getServiceLocator()->get('Session');
        $session->offsetUnset('user');
        $auth->clearIdentity();
        return true;
    }

    /**
     * Faz a autorização do usuário para acessar o recurso
     * @return boolean
     */
    public function authorize() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            return true;
        }
        return false;
    }

}

<?php

namespace Auth\Model;

use Zend\Db\Sql\Sql;


class User {

    
    /**
     * @var int
     */
    public $id_usuario;

    /**
     * @var string
     */
    public $usuario;

    /**
     * @var string
     */
    public $senha;

    /**
     * @var string
     */
    public $id_policial;


    /**
     * Configura os filtros dos campos da entidade
     *
     * @return Zend\InputFilter\InputFilter
     */
     public function exchangeArray($data)
     {
         $this->id     = (isset($data['id_usuario']))     ? $data['id_usuario']     : null;
         $this->username = (isset($data['usuario'])) ? $data['usuario'] : null;
         $this->password  = (isset($data['senha']))  ? $data['senha']  : null;
         $this->email  = (isset($data['id_policial']))  ? $data['id_policial']  : null;
     }


    public function verificarEmail($email, $dbadapter) {
        $sql = new Sql($dbadapter);
        $select = $sql->select()->from('users')->where(array('email' => $email));
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        echo $result->count() . '<br>';
        
        exit();
    }

}

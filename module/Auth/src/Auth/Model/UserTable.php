<?php
namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id_usuario' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não pode encontrar $id");
        }
        return $row;
    }

    public function saveUser(User $album)
    {
        
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function validateEmail($email) {
        //$sql = new Sql($dbadapter);
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        return $row;        
    }
}
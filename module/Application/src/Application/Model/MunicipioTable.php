<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

/**
 * Description of MunicipioTable
 *
 * @author leandro
 */
class MunicipioTable {

    protected $tableGateway;
    protected $adapter;
    protected $resultSetPrototype;
    /**
     * Contrutor com dependencia do Adapter do Banco
     * 
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Municipio());

        $this->tableGateway = new TableGateway('municipio', $adapter, null, $this->resultSetPrototype);
    }

    /**
     * Recuperar todos os elementos da tabela municipio
     * 
     * @return ResultSet
     */
    public function fetchAll() {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela municipio
     * 
     * @param type $id
     * @return \Model\Municipio
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id_muni' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado municipio de id = {$id}");

        return $row;
    }

}

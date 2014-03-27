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
class PolicialTable {

    protected $tableGateway;
    /**
     * Contrutor com dependencia do Adapter do Banco
     * 
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    
    public function __construct(Adapter $adapter) {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Policial());

        $this->tableGateway = new TableGateway('policial', $adapter, null, $resultSetPrototype);
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
        $rowset = $this->tableGateway->select(array('id_policial' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado policial de id = {$id}");

        return $row;
    }

}

<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

/**
 * Description of MunicipioTable
 *
 * @author leandro
 */
class AreaTable {

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
        $this->resultSetPrototype->setArrayObjectPrototype(new Area());

        $this->tableGateway = new TableGateway('area', $this->adapter, null, $this->resultSetPrototype);
    }

    /**
     * Recuperar todos os elementos da tabela policial
     * 
     * @return ResultSet
     */
    public function fetchAll($currentPage = 0, $countPerPage = 0) {
        //return $this->tableGateway->select();
        
        $select = new \Zend\Db\Sql\Select;
        $select->from(array('a' => 'area'));
        $select->columns(array('id_area','descricao'));
        $select->join(array('m'=>'municipio'), "a.id_muni = m.id_muni",array('id_muni','municipio'));
        //echo $select->getSqlString();

        // create a new pagination adapter object
        $paginatorAdapter = new DbSelect(
                // our configured select object
                $select,
                // the adapter to run it against
                $this->tableGateway->getAdapter(),
                // the result set to hydrate
                $this->resultSetPrototype
        );
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setItemCountPerPage($countPerPage);
        $paginator->setCurrentPageNumber($currentPage);
        
        
        return $paginator;
    }

    /**
     * Localizar linha especifico pelo id da tabela municipio
     * 
     * @param type $id
     * @return \Model\Policial
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id_area' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado policial de id = {$id}");

        return $row;
    }
    
    public function salvarArea(Policial $policial)
    {
        $data = array(
            'numeral'       => $policial->getNumeral(),
            'nome'          => $policial->getNome(),
            'nome_guerra'   => $policial->getNome_guerra(),
            'matricula'     => $policial->getMatricula(),
            'id_graduacao'  => $policial->getId_graduacao(),
            'data_nasc'     => $policial->getData_nasc(),
            'sexo'          => $policial->getSexo()
        );

        $id = (int)$policial->getId_policial();
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->find($id)) {
                $this->tableGateway->update($data, array('id_policial' => $id));
            } else {
                throw new \Exception('Policial não encontrado');
            }
        }
        
        
    }
    
    public function deleteArea($id)
    {
        try {
            return $this->tableGateway->delete(array('id_policial' => $id));
        
        }catch (\Exception $e) {
            return false;
        }
        
    }

}

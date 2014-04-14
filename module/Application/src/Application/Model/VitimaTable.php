<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Db\Sql\Sql,
    Zend\Paginator\Paginator;

/**
 * Description of MunicipioTable
 *
 * @author leandro
 */
class VitimaTable {

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
        $this->resultSetPrototype->setArrayObjectPrototype(new Vitima());

        $this->tableGateway = new TableGateway('vitima', $this->adapter, null, $this->resultSetPrototype);
    }

    /**
     * Recuperar todos os elementos da tabela policial
     * 
     * @return ResultSet
     */
    public function fetchAll($currentPage = 0, $countPerPage = 0) {
        $select = new \Zend\Db\Sql\Select;
        $select->from(array('o' => 'ocorrencia'));
        $select->columns(array('*'));
        $select->join(array('e' => 'endereco'), "o.id_end = e.id_endereco", array('*'));
        $select->join(array('a' => 'area'), "o.id_area = a.id_area", array('descricao'));
        $select->join(array('v' => 'vtr'), "o.id_vtr = v.id_vtr", array('prefixo'));

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
    
    public function vitimasOcorrencia($id_ocorrencia) {
        $select = new \Zend\Db\Sql\Select;
        $select->from('vitima');
        $select->columns(array('*'));
        $select->join(array('ov'=>'ocorrencia_vitima'), "vitima.id_vitima = ov.id_vitima", array());
        $select->where(array('id_ocorrencia'=>$id_ocorrencia));
        $select->order(array('nome ASC')); // produces 'name' ASC, 'age' DESC

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


        return $paginator;
    }

    /**
     * Localizar linha especifico pelo id da tabela policial
     * 
     * @param type $id
     * @return \Model\Policial
     * @throws \Exception
     */
    public function find($id) {

        $id = (int) $id;


        $select = new \Zend\Db\Sql\Select;
        $select->from('ocorrencia');
        $select->columns(array('*'));
        $select->join(array('e' => 'endereco'), "ocorrencia.id_end = e.id_endereco", array('*'));
        $select->join(array('a' => 'area'), "ocorrencia.id_area = a.id_area", array('descricao'));
        $select->join(array('v' => 'vtr'), "ocorrencia.id_vtr = v.id_vtr", array('prefixo'));
        $select->where(array('ocorrencia.id_ocorrencia' => $id));
        $select->order(array('data ASC', 'horario ASC')); // produces 'name' ASC, 'age' DESC
        //echo $select->getSqlString();exit;
        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();


        if (!$row)
            throw new \Exception("Não foi encontrado a ocorrencia  de id = {$id}");

        return $row;
    }

    public function salvarOcorrencia(Ocorrencia $oc) {
        $data = array(
            'id_ocorrencia' => $oc->getId_ocorrencia(),
            'id_end' => $oc->getId_end(),
            'id_vtr' => $oc->getVtr()->getId_vtr(),
            'id_area' => $oc->getArea()->getId_area(),
            'id_usuario' => $oc->getId_usuario(),
            'data' => $oc->getData(),
            'horario' => $oc->getHorario(),
            'narracao' => strtoupper($oc->getNarracao()),
        );

        $id = (int) $oc->getId_ocorrencia();
        if ($id == 0) {
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue;
        } else {
            if ($this->find($id)) {
                $this->tableGateway->update($data, array('id_ocorrencia' => $id));
            } else {
                throw new \Exception('Ocorrencia não encontrada');
            }
        }
    }

    public function addPolicialOcorrencia($id_ocorrencia, $id_policial) {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert('ocorrencia_policial');
        $newData = array(
            'id_ocorrencia' => $id_ocorrencia,
            'id_policial' => $id_policial,
        );
        $insert->values($newData);
        $selectString = $sql->getSqlStringForSqlObject($insert);
        $results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        return $results->count();
    }

    public function delPoliciaisOcorrencia($id_ocorrencia) {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete('ocorrencia_policial')->where(array('id_ocorrencia' => $id_ocorrencia));

        $selectString = $sql->getSqlStringForSqlObject($delete);
        $results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        return $results->count();
    }

    public function deleteOcorrencia($id) {
        try {
            return $this->tableGateway->delete(array('id_ocorrencia' => $id));
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function totalVitimasOcorrencia($id_ocorrencia) {
        $sql = new Sql($this->adapter);
        $select = $sql->select('ocorrencia_vitima')->where(array('id_ocorrencia' => $id_ocorrencia));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        return $results->count();
    }
    
    public function totalAcusadosOcorrencia($id_ocorrencia) {
        $sql = new Sql($this->adapter);
        $select = $sql->select('ocorrencia_acusado')->where(array('id_ocorrencia' => $id_ocorrencia));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        return $results->count();
    }
    
    public function totalCrimesOcorrencia($id_ocorrencia) {
        $sql = new Sql($this->adapter);
        $select = $sql->select('ocorrencia_crime')->where(array('id_ocorrencia' => $id_ocorrencia));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        return $results->count();
    }

}

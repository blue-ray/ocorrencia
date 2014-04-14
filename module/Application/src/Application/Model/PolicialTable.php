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
class PolicialTable {

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
        $this->resultSetPrototype->setArrayObjectPrototype(new Policial());

        $this->tableGateway = new TableGateway('policial', $this->adapter, null, $this->resultSetPrototype);
    }

    /**
     * Recuperar todos os elementos da tabela policial
     * 
     * @return ResultSet
     */
    public function fetchAll($currentPage = 0, $countPerPage = 0) {
        $select = new \Zend\Db\Sql\Select;
        $select->from('policial');
        $select->columns(array('*'));
        $select->join('graduacao', "policial.id_graduacao = graduacao.id_grad");
        $select->order(array('nome_guerra ASC')); // produces 'name' ASC, 'age' DESC

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
     * Localizar linha especifico pelo id da tabela policial
     * 
     * @param type $id
     * @return \Model\Policial
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        
        
        $select = new \Zend\Db\Sql\Select;
        $select->from('policial');
        $select->columns(array('*'));
        $select->join('graduacao', "policial.id_graduacao = graduacao.id_grad");
        $select->where(array('id_policial' => $id));
        
        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();


        if (!$row)
            throw new \Exception("Não foi encontrado policial de id = {$id}");

        return $row;
    }
    
    public function findByOcorrecia($id_ocorrencia) {
        $id = (int) $id_ocorrencia;
        
        
        $select = new \Zend\Db\Sql\Select;
        $select->from('policial');
        $select->columns(array('*'));
        $select->join(array('op'=>'ocorrencia_policial'), "policial.id_policial = op.id_policial");
        $select->where(array('op.id_ocorrencia' => $id));
        
        return $this->tableGateway->selectWith($select);
        

    }

    public function salvarPolicial(Policial $policial) {
        $data = array(
            'numeral' => $policial->getNumeral(),
            'nome' => $policial->getNome(),
            'nome_guerra' => $policial->getNome_guerra(),
            'matricula' => $policial->getMatricula(),
            'id_graduacao' => $policial->getGraduacao()->getId_graduacao(),
            'data_nasc' => $policial->getData_nasc(),
            'sexo' => $policial->getSexo()
        );

        $id = (int) $policial->getId_policial();
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

    public function deletePolicial($id) {
        try {
            return $this->tableGateway->delete(array('id_policial' => $id));
        } catch (\Exception $e) {
            return false;
        }
    }

}

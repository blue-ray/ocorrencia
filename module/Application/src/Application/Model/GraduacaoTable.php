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
class GraduacaoTable {

    protected $tableGateway;
    protected $adapter;
    /**
     * Contrutor com dependencia do Adapter do Banco
     * 
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Graduacao());

        $this->tableGateway = new TableGateway('graduacao', $this->adapter, null, $resultSetPrototype);
    }

    /**
     * Recuperar todos os elementos da tabela policial
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
     * @return \Model\Policial
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id_grad' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado policial de id = {$id}");

        return $row;
    }
    
    public function salvarPolicial(Policial $policial)
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
    
    public function deletePolicial($id)
    {
        try {
            return $this->tableGateway->delete(array('id_policial' => $id));
        
        }catch (\Exception $e) {
            return false;
        }
        
    }

}

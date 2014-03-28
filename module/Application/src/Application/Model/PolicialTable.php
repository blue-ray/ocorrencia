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
        $rowset = $this->tableGateway->select(array('id_policial' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado policial de id = {$id}");

        return $row;
    }
    
    public function salvarPolicial(Policial $policial)
    {
        $data = array(
            'numeral'       => $policial->numeral,
            'nome'          => $policial->nome,
            'nome_guerra'   => $policial->nome_guerra,
            'matricula'     => $policial->matricula,
            'id_graduacao'  => $policial->id_graduacao,
            'data_nasc'     => $policial->data_nasc,
            'sexo'          => $policial->sexo,
        );

        $id = (int)$policial->id_policial;
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

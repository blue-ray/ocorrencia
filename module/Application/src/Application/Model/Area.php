<?php

namespace Application\Model;

class Area {
    private $id_area;
    private $descricao;
    private $municipio;

    function __construct($id_area=0, $descricao="", Municipio $m = null) {
        $this->id_area = $id_area;
        $this->descricao = $descricao;
        $this->municipio = $m;
    }
    
    public function exchangeArray($data) {
        $this->id_area      = (!empty($data['id_area'])) ? $data['id_area'] : null;
        $this->descricao    = (!empty($data['descricao'])) ? $data['descricao'] : null;
        $this->municipio    = (!empty($data['id_muni'])) ? new Municipio($data['id_muni'], $data['municipio']) : null;
       
    }
   
    public function getId_area() {
        return $this->id_area;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getMunicipio() {
        return $this->municipio;
    }

    public function setId_area($id_area) {
        $this->id_area = $id_area;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }


    
}

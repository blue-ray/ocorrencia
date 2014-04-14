<?php

namespace Application\Model;

class Municipio {

    private $id_muni;
    private $municipio;

    function __construct($id_muni=0, $muni="") {
        $this->id_muni = $id_muni;
        $this->municipio = $muni;
    }
    
    public function exchangeArray($data) {
        $this->id_muni = (!empty($data['id_muni'])) ? $data['id_muni'] : null;
        $this->municipio = (!empty($data['municipio'])) ? $data['municipio'] : null;
    }
    public function getId_muni() {
        return $this->id_muni;
    }

    public function getMunicipio() {
        return $this->municipio;
    }

    public function setId_muni($id_muni) {
        $this->id_muni = $id_muni;
    }

    public function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }


}

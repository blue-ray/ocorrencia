<?php

namespace Application\Model;

class Municipio {

    public $id_muni;
    public $municipio;

    public function exchangeArray($data) {
        $this->id_muni = (!empty($data['id_muni'])) ? $data['id_muni'] : null;
        $this->municipio = (!empty($data['municipio'])) ? $data['municipio'] : null;
    }

}

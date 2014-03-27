<?php

namespace Application\Model;

class Policial {

    public $id_policial;
    public $id_graduacao;
    public $numeral;
    public $nome;
    public $nome_guerra;
    public $matricula;
    public $data_nasc;
    public $sexo;

    public function exchangeArray($data) {
        $this->id_policial = (!empty($data['id_policial'])) ? $data['id_policial'] : null;
        $this->id_graduacao = (!empty($data['id_graduacao'])) ? $data['id_graduacao'] : null;
        $this->numeral = (!empty($data['numeral'])) ? $data['numeral'] : null;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : null;
        $this->nome_guerra = (!empty($data['nome_guerra'])) ? $data['nome_guerra'] : null;
        $this->matricula = (!empty($data['matricula'])) ? $data['matricula'] : null;
        $this->data_nasc = (!empty($data['data_nasc'])) ? $data['data_nasc'] : null;
        $this->sexo = (!empty($data['sexo'])) ? $data['sexo'] : null;
    }

}

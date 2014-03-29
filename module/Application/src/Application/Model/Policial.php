<?php

namespace Application\Model;

class Policial {

    private $id_policial;
    private $id_graduacao;
    private $numeral;
    private $nome;
    private $nome_guerra;
    private $matricula;
    private $data_nasc;
    private $sexo;

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
   
    public function getId_policial() {
        return $this->id_policial;
    }

    public function getId_graduacao() {
        return $this->id_graduacao;
    }

    public function getNumeral() {
        return $this->numeral;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getNome_guerra() {
        return $this->nome_guerra;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getData_nasc() {
        return $this->data_nasc;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setId_policial($id_policial) {
        $this->id_policial = $id_policial;
    }

    public function setId_graduacao($id_graduacao) {
        $this->id_graduacao = $id_graduacao;
    }

    public function setNumeral($numeral) {
        $this->numeral = $numeral;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setNome_guerra($nome_guerra) {
        $this->nome_guerra = $nome_guerra;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function setData_nasc($data_nasc) {
        $this->data_nasc = $data_nasc;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }



}

<?php
namespace Application\Model;
use Application\View\Helper\Util;

class Vitima {

    private $id_vitima;
    private $nome;
    private $telefone;
    private $data_nasc;
    private $sexo;
    private $id_end;
    

    public function exchangeArray($data) {
        //objeto Graduacao
        //$grad = new Graduacao($data['id_grad'], $data['graduacao']);
        
        $this->id_vitima = (!empty($data['id_vitima'])) ? $data['id_vitima'] : null;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : null;
        $this->telefone = (!empty($data['telefone'])) ? $data['telefone'] : null;
        $this->data_nasc = (!empty($data['data_nasc'])) ? $data['data_nasc'] : null;
        $this->sexo = (!empty($data['sexo'])) ? $data['sexo'] : null;
        $this->id_end = (!empty($data['id_end'])) ? $data['id_end'] : null;
        
    }
   
    public function getId_vitima() {
        return $this->id_vitima;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getData_nasc() {
        return $this->data_nasc;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getId_end() {
        return $this->id_end;
    }

    public function setId_vitima($id_vitima) {
        $this->id_vitima = $id_vitima;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setData_nasc($data_nasc) {
        $this->data_nasc = Util::toDateYMD($data_nasc);
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function setId_end($id_end) {
        $this->id_end = $id_end;
    }


}

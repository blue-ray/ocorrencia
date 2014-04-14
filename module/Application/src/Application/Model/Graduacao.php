<?php

namespace Application\Model;

class Graduacao {
    private $id_grad;
    private $graduacao;

    function __construct($id_grad=0, $graduacao=null) {
        $this->id_grad = $id_grad;
        $this->graduacao = $graduacao;
    }
    
    public function exchangeArray($data) {
        $this->id_grad = (!empty($data['id_grad'])) ? $data['id_grad'] : null;
        $this->graduacao = (!empty($data['graduacao'])) ? $data['graduacao'] : null;
       
    }
   
    public function getId_graduacao() {
        return $this->id_grad;
    }

    public function getNome_Graduacao() {
        return $this->graduacao;
    }
    
    
    public function setId_graduacao($id_graduacao) {
        $this->id_grad = $id_graduacao;
    }
    public function setNome_Graduacao($grad) {
        $this->graduacao = $grad;
    }
    
}

<?php
namespace Application\Model;
use Application\Model\Viatura;
use Application\Model\Area;
use Application\View\Helper\Util;

class Ocorrencia {

    private $id_ocorrencia;
    private $id_end;
    private $vtr;
    private $area;
    private $id_usuario;
    private $data;
    private $horario;
    private $narracao;

    public function exchangeArray($data) {
        //objeto Graduacao
        //$grad = new Graduacao($data['id_grad'], $data['graduacao']);
        
        $this->id_ocorrencia = (!empty($data['id_ocorrencia'])) ? $data['id_ocorrencia'] : null;
        $this->id_end = (!empty($data['id_end'])) ? $data['id_end'] : null;
        $this->vtr = (!empty($data['id_vtr'])) ? new Viatura($data['id_vtr'], $data['prefixo']) : null;
        $this->area = (!empty($data['id_area'])) ? new Area($data['id_area'], $data['descricao']) : null;
        $this->id_usuario = (!empty($data['id_usuario'])) ? $data['id_usuario'] : null;
        $this->data = (!empty($data['data'])) ? $data['data'] : null;
        $this->horario = (!empty($data['horario'])) ? $data['horario'] : null;
        $this->narracao = (!empty($data['narracao'])) ? $data['narracao'] : null;
        
        
    }
   
    public function getId_end() {
        return $this->id_end;
    }

    public function getVtr() {
        return $this->vtr;
    }

    public function getArea() {
        return $this->area;
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function getData() {
        return $this->data;
    }

    public function getHorario() {
        return $this->horario;
    }

    public function getNarracao() {
        return $this->narracao;
    }

    public function setId_end($id_end) {
        $this->id_end = $id_end;
    }

    public function setVtr($vtr) {
        $this->vtr = $vtr;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setData($data) {
        $this->data = Util::toDateYMD($data);
    }

    public function setHorario($horario) {
        $this->horario = $horario;
    }

    public function setNarracao($narracao) {
        $this->narracao = $narracao;
    }
    public function getId_ocorrencia() {
        return $this->id_ocorrencia;
    }

    public function setId_ocorrencia($id_ocorrencia) {
        $this->id_ocorrencia = $id_ocorrencia;
    }



}

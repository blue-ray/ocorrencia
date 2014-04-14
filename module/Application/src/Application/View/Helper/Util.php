<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\View\Helper;


use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;
use Zend\Db\Adapter\Adapter;

use Application\Model\GraduacaoTable;
use Application\Model\PolicialTable;
use Application\Model\ViaturaTable;
use Application\Model\AreaTable;

class Util extends AbstractHelper {
    /*
     * 	Converter data de (aa-mm-dd) para (dd/mm/aa)
     * 	@param $date
     * 	return date
     */
    
    public static  function getAdapter(){
        $adapter = new Adapter(array(
            'driver' => 'Pdo_Mysql',
            'database' => 'sgo',
            'username' => 'root',
            'password' => 'root'
         ));
        
        return $adapter;
    }

    static function toDateDMY($date) {
        
        if ($date != "") {
            list ($y, $m, $d) = explode('-', $date);
            $dataformatada = "$d/$m/$y";
            if ($dataformatada != "//") {
                return "$d/$m/$y";
            }
        }

        return "";
    }

//Fim do metodo toDateDMY 


    /*
     * 	Converter data de (dd/mm/aa) para (aa-mm-dd)
     * 	@param $date
     * 	return date
     */

    static function toDateYMD($date) {
        if ($date != "") {
            list ($d, $m, $y) = explode('/', $date);
            $dataformatada = "$d-$m-$y";
            if ($dataformatada != "--") {
                return "$y-$m-$d";
            }
        }

        return "";
    }
    //Fim do metodo toDateDMY
    
    
    static function comboGraduacao($chek = 0){
        
        $selected = "";
                
        $model = new GraduacaoTable(Util::getAdapter());
        
        $grads = $model->fetchAll();
        $select = "<select name= 'id_graduacao' id='id_graduacao' class='form-control' >";
        $select .= "<option value=''>Selecione</option>";
        foreach ($grads as $g) {
            if($g->getId_graduacao()== $chek){
                $selected = "selected";
            }
            
            $select .= "<option $selected value='".$g->getId_graduacao()."'>".$g->getNome_graduacao()."</option>";
            
            $selected = "";
        }
        
        $select .= "</select>";
        
        return $select;
    }
    
    static function comboPolicial($ids = null,$disabled = ""){
        $selected = "";      
        $model = new PolicialTable(Util::getAdapter());
        
        $pols = $model->fetchAll();
        $select = "<select multiple name= 'id_policial[]' id='id_policial' class='form-control' $disabled >";
        $select .= "<option value=''>Selecione</option>";
        foreach ($pols as $p) {
            
            if($ids != null && array_search($p->getId_policial(), $ids) !== false){
                $selected = "selected";
            }
            
            $select .= "<option $selected value='".$p->getId_policial()."'>".$p->getNumeral()." - ".$p->getNome_guerra()."</option>";
            
            $selected = "";
        }
        
        $select .= "</select>";
        
        return $select;
    }
    
    static function comboVtr($chek = 0){
        
        $selected = "";
                
        $model = new ViaturaTable(Util::getAdapter());
        
        $vtrs = $model->fetchAll();
        $select = "<select name= 'id_vtr' id='id_vtr' class='form-control' >";
        $select .= "<option value=''>Selecione</option>";
        foreach ($vtrs as $v) {
            if($v->getId_vtr()== $chek){
                $selected = "selected";
            }
            
            $select .= "<option $selected value='".$v->getId_vtr()."'>".$v->getPrefixo()." - ".$v->getArea()->getMunicipio()->getMunicipio()."</option>";
            
            $selected = "";
        }
        
        $select .= "</select>";
        
        return utf8_encode($select);
    }
    
    static function comboArea($chek = 0){
        
        $selected = "";
                
        $model = new AreaTable(Util::getAdapter());
        
        $areas = $model->fetchAll();
        $select = "<select name= 'id_area' id='id_area' class='form-control' >";
        $select .= "<option value=''>Selecione</option>";
        foreach ($areas as $a) {
            if($a->getId_area()== $chek){
                $selected = "selected";
            }
            
            $select .= "<option $selected value='".$a->getId_area()."'>".$a->getDescricao()." - ".$a->getMunicipio()->getMunicipio()."</option>";
            
            $selected = "";
        }
        
        $select .= "</select>";
        
        return utf8_encode($select);
    }


}

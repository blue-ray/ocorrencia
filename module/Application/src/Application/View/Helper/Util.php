<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class  Util extends AbstractHelper {
    /*
     * 	Converter data de (aa-mm-dd) para (dd/mm/aa)
     * 	@param $date
     * 	return date
     */

    function toDateDMY($date) {
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

    function toDateYMD($date) {

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
}

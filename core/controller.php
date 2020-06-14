<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author AVITORINO
 */
class controller {

    public function __construct() {
        global $config;
    }
 
    public function loadView($viewName, $viewData = array()) {
        extract($viewData);
        include 'views/'.$viewName.'.php';
    }

    public function loadTamplate($viewName, $viewData = array()) {
        include 'views/tamplate.php';
    }

    public function loadViewInTamplate($viewName, $viewData) {
        extract($viewData);
        include 'views/'.$viewName.'.php';
    }        

    public function loadLibary($lib) {
        if(file_exists('libaries/'.$lib.'.php')) {
            include 'libaries/'.$lib.'.php';
        }
    }
}

<?php
class subscribersController extends controller {
    
    public function __construct() {
        parent::__construct();

        $users = new Users();
        if ($users->isLogged() == false) {
        	header("Location: ".BASE_URL."/login");
        }
    }

    public function index() {
        $dados = array();
        
        $this->loadTamplate('subscribers', $dados);
    }
    
}

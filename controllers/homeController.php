<?php
class homeController extends controller {
    
    public function __construct() {
        parent::__construct();

        $users = new Users();
        if ($users->isLogged() == false) {
        	header("Location: ".BASE_URL."/login");
        }
    }

    public function index() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());
        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('dashboard')) {
            $dtinicial = date('Y-m-d', strtotime('-30 days'));
            $dtfinal = date('Y-m-d'); 

            $participants = new Participants;
            $data['products_sold'] = $participants->getCursosEfetuados($users->getSubscriber(), $dtinicial, $dtfinal);

            $data['revenue'] = 0;
            $data['expenses'] = 0;   

            $data['lastMonths'] = array();
            for($q=0; $q<12; $q++) {
                $data['lastMonths'][] = date('m/Y', strtotime('-'.$q.' month'));
            }
            
            $data['lastMonths'] = array_reverse($data['lastMonths']);
            $data['dataLastMonths'] = array_values($participants->getCursosEfetuadosLastMonths($users->getSubscriber(), 12));

            $data['nextMonths'] = array();
            for($q=0; $q<3; $q++) {
                $data['nextMonths'][] = date('m/Y', strtotime('+'.$q.' month'));
            }
            
            $data['nextMonths'] = array_reverse($data['nextMonths']);
            $data['dataNextMonths'] = array_values($participants->getQtdeCursosAVencerNextmonths($users->getSubscriber(), 3));

            $data['participants_list'] = $participants->getCursosAVencerNextmonths($users->getSubscriber(), 3);

            $this->loadTamplate('home', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }

    }
    
}

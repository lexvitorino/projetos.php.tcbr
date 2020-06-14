<?php
class ajaxController extends controller {
    
    public function __construct() {
        parent::__construct();

        $users = new Users();
        if ($users->isLogged() == false) {
        	header("Location: ".BASE_URL."/login");
        }
    }

    public function index() { }

    public function search_clients() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = addslashes($_GET['q']);
    
            $clients = new Clients();
            $clients = $clients->searchClients($users->getSubscriber(), $q);
    
            foreach ($clients as $c) {
                $data[] = array(
                    'id' => $c['id'],
                    'name' => $c['name'],
                    'link' => BASE_URL.'/clients/edit/'.$c['id']
                );
            }
        }

        echo json_encode($data);
    }

    public function search_companies() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();

        $companies = new Companies();

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = addslashes($_GET['q']);
            $companies = $companies->searchCompanies($users->getSubscriber(), $q);
            foreach ($companies as $c) {
                $data[] = array(
                    'id' => $c['id'],
                    'name' => $c['name'],
                    'link' => BASE_URL.'/companies/edit/'.$c['id']
                );
            }
        }

        echo json_encode($data);
    }
    
}

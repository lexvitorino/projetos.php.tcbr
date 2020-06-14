<?php
class clientsController extends controller {
    
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
        $data["has_clients_add"] = $users->hasPermission('clients_add');
        $data["has_clients_edit"] = $users->hasPermission('clients_edit');

        if ($users->hasPermission('clients')) {
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));

            $clients = new Clients();
            $data["clients_list"] = $clients->getList($users->getSubscriber(), $offiset);

            $data["clients_count"] = $clients->getCount($users->getSubscriber());
            $data["paginas_count"] = ceil( $data["clients_count"] / 10 );

            $this->loadTamplate('clients', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function add() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('clients') && $users->hasPermission('clients_add')) {
            $companies = new Companies();
            $data["companies_list"] = $companies->getList($users->getSubscriber(), -1);

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $cpf = addslashes($_POST['cpf']);
                $rg = addslashes($_POST['rg']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $stars = addslashes($_POST['stars']);
                $internal_obs = addslashes($_POST['internal_obs']);
                $address = addslashes($_POST['address']);
                $address_number = addslashes($_POST['address_number']);
                $address2 = addslashes($_POST['address2']);
                $address_zipcode = addslashes($_POST['address_zipcode']);
                $address_neighb = addslashes($_POST['address_neighb']);
                $address_city = addslashes($_POST['address_city']);
                $address_country = addslashes($_POST['address_country']);
                $internal_obs = addslashes($_POST['internal_obs']);
                
                $id_company = 'NULL';
                if (isset($_POST['id_company']) && !empty($_POST['id_company'])) {
                    $id_company = addslashes($_POST['id_company']);
                }
                
                $clients = new Clients();
                $id = $clients->add($users->getSubscriber(), 0, $name, $cpf, $rg, $email, $phone, $stars, $internal_obs, $address, $address_number, $address2, $address_zipcode, $address_neighb, $address_city, $address_country, $id_company);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/clients");
                } else {
                    $data['error'] = "Usuário já existe!";
                }
            }

            $this->loadTamplate('/clients/clients_add', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function edit($id) {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('clients') && $users->hasPermission('clients_edit')) {
            $clients = new Clients();
            $data['client'] = $clients->getClient($users->getSubscriber(), $id);
            
            $companies = new Companies();
            $data["companies_list"] = $companies->getList($users->getSubscriber(), -1);
            
            $participants = new Participants();
            $data["participants_list"] = $participants->getListByClient($users->getSubscriber(), $id);

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $cpf = addslashes($_POST['cpf']);
                $rg = addslashes($_POST['rg']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $stars = addslashes($_POST['stars']);
                $internal_obs = addslashes($_POST['internal_obs']);
                $address = addslashes($_POST['address']);
                $address_number = addslashes($_POST['address_number']);
                $address2 = addslashes($_POST['address2']);
                $address_zipcode = addslashes($_POST['address_zipcode']);
                $address_neighb = addslashes($_POST['address_neighb']);
                $address_city = addslashes($_POST['address_city']);
                $address_country = addslashes($_POST['address_country']);
                $internal_obs = addslashes($_POST['internal_obs']);
                
                $id_company = 'NULL';
                if (isset($_POST['id_company']) && !empty($_POST['id_company'])) {
                    $id_company = addslashes($_POST['id_company']);
                }
                
                $clients = new Clients();
                $id = $clients->add($users->getSubscriber(), $id, $name, $cpf, $rg, $email, $phone, $stars, $internal_obs, $address, $address_number, $address2, $address_zipcode, $address_neighb, $address_city, $address_country, $id_company);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/clients");
                } else {
                    $data['error'] = "Cliente já existe!";
                }
            }

            $this->loadTamplate('/clients/clients_edit', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($id) {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions') && $users->hasPermission('permissions_delete')) {
            $clients = new Clients();
            $clients->delete($users->getSubscriber(), $id);

            header("Location: ".BASE_URL."/clients");
        } else {
            header("Location: ".BASE_URL);
        }
    }

    
}

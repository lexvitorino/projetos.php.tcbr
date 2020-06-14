<?php
class companiesController extends controller {
    
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
        $data["has_companies_add"] = $users->hasPermission('companies_add');
        $data["has_companies_edit"] = $users->hasPermission('companies_edit');

        if ($users->hasPermission('companies')) {
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));

            $companies = new Companies();
            $data["companies_list"] = $companies->getList($users->getSubscriber(), $offiset);

            $data["companies_count"] = $companies->getCount($users->getSubscriber());
            $data["paginas_count"] = ceil( $data["companies_count"] / 10 );

            $this->loadTamplate('companies', $data);
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

        if ($users->hasPermission('companies') && $users->hasPermission('companies_add')) {
            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $cnpj = addslashes($_POST['cnpj']);
                $ie = addslashes($_POST['ie']);
                $im = addslashes($_POST['im']);
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
                $internal_obs = addslashes($_POST['internal_obs']);
                
                $companies = new Companies();
                $id = $companies->add($users->getSubscriber(), 0, $name, $cnpj, $ie, $im, $email, $phone, $stars, $internal_obs, $address, $address_number, $address2, $address_zipcode, $address_neighb, $address_city, $address_country);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/companies");
                } else {
                    $data['error'] = "Usuário já existe!";
                }
            }

            $this->loadTamplate('/companies/companies_add', $data);
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

        if ($users->hasPermission('companies') && $users->hasPermission('companies_edit')) {
            $companies = new Companies();
            $data['company'] = $companies->getCompany($users->getSubscriber(), $id);

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $cnpj = addslashes($_POST['cnpj']);
                $ie = addslashes($_POST['ie']);
                $im = addslashes($_POST['im']);
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
                $internal_obs = addslashes($_POST['internal_obs']);
                
                $companies = new Companies();
                $id = $companies->add($users->getSubscriber(), $id, $name, $cnpj, $ie, $im, $email, $phone, $stars, $internal_obs, $address, $address_number, $address2, $address_zipcode, $address_neighb, $address_city, $address_country);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/companies");
                } else {
                    $data['error'] = "Empresa já existe!";
                }
            }

            $this->loadTamplate('/companies/companies_edit', $data);
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
            $companies = new Companies();
            $companies->delete($users->getSubscriber(), $id);

            header("Location: ".BASE_URL."/companies");
        } else {
            header("Location: ".BASE_URL);
        }
    }

    
}

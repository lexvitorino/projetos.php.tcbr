<?php
class reportsController extends controller {
    
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

        if ($users->hasPermission('reports')) {
            $this->loadTamplate('reports', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function clients() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('clients_rep')) {
            $clients = new Clients();
            $data["companies_list"] = $clients->getList($users->getSubscriber(), -1);

            $this->loadTamplate('reports/clients_rep', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function companies() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('companies_rep')) {
            $companies = new Companies();
            $data["companies_list"] = $companies->getList($users->getSubscriber(), -1);

            $this->loadTamplate('reports/companies_rep', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function clients_pdf() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();

        if ($users->hasPermission('clients_rep')) {
            $companies = new Companies();
            
            $dtInicial = addslashes($_GET['dtInicial']);
            $dtFinal = addslashes($_GET['dtFinal']);
            $name = addslashes($_GET['name']);
            $id_company = addslashes($_GET['id_company']);
            $order = addslashes($_GET['order']);

            $data['filters'] = $_GET;
            if(!empty($id_company)) {
                $data['filters']['company'] = $companies->getCompany($users->getSubscriber(), $id_company)['name'];                
            }

            $clients = new Clients();
            $data['clients_list'] = $clients->getClientsForReport($users->getSubscriber(),$dtInicial,$dtFinal,$name,$id_company,$order);

            $this->loadLibary('mpdf60/mpdf');

            ob_start();
            $this->loadView('reports/clients_rep_pdf', $data);
            $html = ob_get_contents();
            ob_get_clean();

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->OutPut();
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function companies_pdf() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();

        if ($users->hasPermission('companies_rep')) {
            $companies = new Companies();
            
            $name = addslashes($_GET['name']);
            $order = addslashes($_GET['order']);
            $data['filters'] = $_GET;

            $companies = new Companies();
            $data['companies_list'] = $companies->getCompaniesForReport($users->getSubscriber(),$name,$order);

            $this->loadLibary('mpdf60/mpdf');

            ob_start();
            $this->loadView('reports/companies_rep_pdf', $data);
            $html = ob_get_contents();
            ob_get_clean();

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->OutPut();
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

}
